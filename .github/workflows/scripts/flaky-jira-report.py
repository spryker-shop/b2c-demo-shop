#!/usr/bin/env python3
"""Report a master run's flaky tests to Jira, one Bug per spec file.

Reads the flaky-details-*.json artifacts flaky-details.py wrote, groups their
entries by spec file and, for each spec file:

- no ticket yet: creates an unassigned Bug "Flaky test: <spec file>" with the
  label flaky-test, the failed tests, the run link and the stack traces;
- an open ticket: adds a comment with the failed tests and the run link;
- a closed ticket: adds the comment, moves it to Reopened and clears its assignee;
- only a Shipped ticket: creates a new ticket, since a shipped fix is not reopened.

Created and reopened tickets are announced as replies under the run's flaky
Slack message. When Jira cannot be reached, each spec file's reply carries the
ticket text that would have been created instead. Best effort: every failure
is a warning annotation plus a job-summary line, and the exit code is 0 unless
the arguments are wrong. Pure stdlib.

Environment: JIRA_BASE_URL (ticket links), JIRA_API_BASE_URL (REST calls,
defaults to JIRA_BASE_URL; a service account's token only works through
https://api.atlassian.com/ex/jira/<cloud id>), FLAKY_JIRA_EMAIL,
FLAKY_JIRA_API_TOKEN, SLACK_BOT_TOKEN, FLAKY_CI_SLACK_CHANNEL_ID.

Usage:
    flaky-jira-report.py --details-dir flaky-details --run-url <url> --thread-timestamp <timestamp>
"""

import argparse
import base64
import glob
import json
import os
import re
import sys
import urllib.error
import urllib.request

PROJECT_KEY = "CC"
ISSUE_TYPE = "Bug"
LABEL = "flaky-test"
SUMMARY_PREFIX = "Flaky test: "
CLOSED_STATUSES = ("Resolved", "Won't Do")
SHIPPED_STATUS = "Shipped"
REOPENED_STATUS = "Reopened"

FIELD_SEVERITY = "customfield_12500"
FIELD_BUG_CATEGORY = "customfield_12453"
FIELD_FOUND_IN = "customfield_12498"
FIELD_ENVIRONMENT = "customfield_12642"
FIELD_STEPS_TO_REPRODUCE = "customfield_11504"
FIELD_ACTUAL_BEHAVIOR = "customfield_11505"
FIELD_EXPECTED_BEHAVIOR = "customfield_11506"
OPTION_SEVERITY_NORMAL = "11073"
OPTION_FOUND_IN_MASTER = "11062"
OPTION_ENVIRONMENT_CI = "11527"
OPTION_BUG_CATEGORY_BY_FRAMEWORK = {"codeception": "10875", "cypress": "10874"}
FRAMEWORK_NAMES = {"codeception": "Codeception", "cypress": "Cypress"}

REQUEST_TIMEOUT_SECONDS = 30
SEARCH_RESULT_LIMIT = 50
HTTP_SERVER_ERROR = 500
STACK_TRACE_LINE_LIMIT = 50
SLACK_TEXT_CHARACTER_LIMIT = 40000


class JiraUnavailable(Exception):
    pass


class JiraRequestRejected(Exception):
    pass


class SlackDeliveryFailed(Exception):
    pass


class JiraClient:
    def __init__(self, base_url, api_base_url, email, api_token):
        self.base_url = (base_url or "").rstrip("/")
        self.api_base_url = (api_base_url or base_url or "").rstrip("/")
        self.email = email
        self.api_token = api_token
        self.credentials_accepted = False

    def browse_url(self, key):
        return f"{self.base_url}/browse/{key}"

    def search(self, jql):
        response = self._request(
            "POST",
            "/rest/api/3/search/jql",
            {"jql": jql, "fields": ["summary", "status", "created"], "maxResults": SEARCH_RESULT_LIMIT},
        )
        return [
            {
                "key": issue["key"],
                "summary": issue["fields"].get("summary") or "",
                "status": (issue["fields"].get("status") or {}).get("name") or "",
                "created": issue["fields"].get("created") or "",
            }
            for issue in response.get("issues") or []
        ]

    def create_issue(self, fields):
        return self._request("POST", "/rest/api/3/issue", {"fields": fields})["key"]

    def clear_assignee(self, key):
        self._request("PUT", f"/rest/api/3/issue/{key}/assignee", {"accountId": None})

    def add_comment(self, key, body):
        self._request("POST", f"/rest/api/3/issue/{key}/comment", {"body": body})

    def transitions(self, key):
        return self._request("GET", f"/rest/api/3/issue/{key}/transitions").get("transitions") or []

    def transition(self, key, transition_id):
        self._request("POST", f"/rest/api/3/issue/{key}/transitions", {"transition": {"id": transition_id}})

    def _request(self, method, path, body=None):
        if not (self.api_base_url and self.email and self.api_token):
            raise JiraUnavailable("Jira credentials are not configured")
        if not self.credentials_accepted:
            self._check_credentials()
        return self._send(method, path, body)

    def _check_credentials(self):
        # Jira treats credentials it does not accept as anonymous: a search finds nothing and a create fails with
        # "The target project doesn't exist". Reading the project fails up front and needs only read:jira-work.
        try:
            self._send("GET", f"/rest/api/3/project/{PROJECT_KEY}")
        except JiraRequestRejected as error:
            raise JiraUnavailable(
                f"Jira did not accept the credentials at {self.api_base_url} ({error}). "
                "A service account's API token only works through https://api.atlassian.com/ex/jira/<cloud id>, "
                f"needs the scopes read:jira-work and write:jira-work and Browse permission on {PROJECT_KEY}."
            ) from error
        self.credentials_accepted = True

    def _send(self, method, path, body=None):
        credentials = base64.b64encode(f"{self.email}:{self.api_token}".encode()).decode()
        request = urllib.request.Request(
            self.api_base_url + path,
            data=None if body is None else json.dumps(body).encode(),
            method=method,
            headers={
                "Authorization": f"Basic {credentials}",
                "Accept": "application/json",
                "Content-Type": "application/json",
            },
        )
        try:
            with urllib.request.urlopen(request, timeout=REQUEST_TIMEOUT_SECONDS) as response:
                content = response.read()
        except urllib.error.HTTPError as error:
            detail = error.read().decode(errors="replace")[:500]
            if error.code >= HTTP_SERVER_ERROR:
                raise JiraUnavailable(f"{method} {path} returned {error.code}") from error
            raise JiraRequestRejected(f"{method} {path} returned {error.code}: {detail}") from error
        except (urllib.error.URLError, TimeoutError, OSError) as error:
            raise JiraUnavailable(f"{method} {path} failed: {error}") from error
        return json.loads(content) if content else {}


class SlackClient:
    def __init__(self, token, channel):
        self.token = token
        self.channel = channel

    def post_reply(self, thread_timestamp, text):
        if not (self.token and self.channel):
            raise SlackDeliveryFailed("SLACK_BOT_TOKEN or FLAKY_CI_SLACK_CHANNEL_ID is not set")
        request = urllib.request.Request(
            "https://slack.com/api/chat.postMessage",
            data=json.dumps({"channel": self.channel, "thread_ts": thread_timestamp, "text": text}).encode(),
            method="POST",
            headers={"Authorization": f"Bearer {self.token}", "Content-Type": "application/json; charset=utf-8"},
        )
        try:
            with urllib.request.urlopen(request, timeout=REQUEST_TIMEOUT_SECONDS) as response:
                result = json.loads(response.read() or b"{}")
        except (urllib.error.URLError, TimeoutError, OSError, ValueError) as error:
            raise SlackDeliveryFailed(str(error)) from error
        if not result.get("ok"):
            raise SlackDeliveryFailed(result.get("error") or "unknown error")


class ActionsLog:
    def __init__(self, summary_path):
        self.summary_path = summary_path

    def warning(self, title, message):
        print(f"::warning title={title}::{message}")
        self.summary(f"⚠️ {title}: {message}")

    def summary(self, line):
        print(line)
        if self.summary_path:
            with open(self.summary_path, "a", encoding="utf-8") as handle:
                handle.write(line + "\n\n")


def link(text, href):
    return {"text": text, "href": href}


def ticket_content(spec_file, entries, run_url, with_stack_traces=True):
    """The ticket as blocks: ("paragraph", [str | link]), ("bullets", [str]) or ("code", str)."""
    framework = FRAMEWORK_NAMES[entries[0]["framework"]]
    blocks = [
        ("paragraph", [f"Framework: {framework}"]),
        ("paragraph", [f"Spec file: {spec_file}"]),
        ("paragraph", ["Failed tests:"]),
        ("bullets", [entry["test"] for entry in entries]),
        ("paragraph", ["Failed CI run: ", link(run_url, run_url)]),
    ]
    if not with_stack_traces:
        return blocks
    for entry in entries:
        blocks.append(("paragraph", [f"Stack trace of {entry['test']} (first {STACK_TRACE_LINE_LIMIT} lines):"]))
        blocks.append(("code", entry["stack_trace"]))
    return blocks


def expected_behavior_content():
    return [("paragraph", ["The test passes on its first attempt, without a rerun, in two CI runs."])]


def actual_behavior_content(run_url):
    return [("paragraph", ["The test failed and passed on a rerun in the CI run ", link(run_url, run_url)])]


def steps_to_reproduce_content(spec_file, run_url):
    return [
        ("paragraph", [f"1. Run the spec file {spec_file} in CI."]),
        ("paragraph", ["2. Compare with the failed CI run ", link(run_url, run_url)]),
    ]


def comment_content(entries, run_url):
    return [
        ("paragraph", ["Failed again on master and passed on a rerun:"]),
        ("bullets", [entry["test"] for entry in entries]),
        ("paragraph", ["CI run: ", link(run_url, run_url)]),
    ]


def to_document(blocks):
    def inline(part):
        if isinstance(part, dict):
            return {"type": "text", "text": part["text"], "marks": [{"type": "link", "attrs": {"href": part["href"]}}]}
        return {"type": "text", "text": part}

    content = []
    for kind, value in blocks:
        if kind == "paragraph":
            content.append({"type": "paragraph", "content": [inline(part) for part in value]})
        elif kind == "bullets":
            content.append(
                {
                    "type": "bulletList",
                    "content": [
                        {"type": "listItem", "content": [{"type": "paragraph", "content": [inline(item)]}]}
                        for item in value
                    ],
                }
            )
        else:
            content.append({"type": "codeBlock", "content": [{"type": "text", "text": value}]})
    return {"type": "doc", "version": 1, "content": content}


def to_slack_text(blocks):
    lines = []
    for kind, value in blocks:
        if kind == "paragraph":
            lines.append("".join(f"<{part['href']}|{part['text']}>" if isinstance(part, dict) else part for part in value))
        elif kind == "bullets":
            lines.extend(f"• {item}" for item in value)
        else:
            lines.append(f"```\n{value}\n```")
    return "\n".join(lines)


def group_by_spec_file(entries):
    groups = {}
    for entry in entries:
        groups.setdefault(entry["spec_file"], []).append(entry)
    return groups


def load_entries(details_dir, log):
    entries = []
    for path in sorted(glob.glob(os.path.join(details_dir, "**", "flaky-details-*.json"), recursive=True)):
        try:
            with open(path, encoding="utf-8") as handle:
                entries.extend(json.load(handle))
        except (OSError, ValueError) as error:
            log.warning("Flaky details unreadable", f"{path}: {error}")
    return entries


class FlakyJiraReporter:
    def __init__(self, jira, slack, log, run_url, thread_timestamp):
        self.jira = jira
        self.slack = slack
        self.log = log
        self.run_url = run_url
        self.thread_timestamp = thread_timestamp
        self.jira_unavailable = False

    def report(self, entries):
        for spec_file, spec_entries in group_by_spec_file(entries).items():
            if not self.jira_unavailable:
                try:
                    self.report_spec_file(spec_file, spec_entries)
                    continue
                except JiraRequestRejected as error:
                    self.log.warning("Flaky Jira report rejected", f"{spec_file}: {error}")
                    continue
                except JiraUnavailable as error:
                    self.jira_unavailable = True
                    self.log.warning("Jira unavailable", str(error))
            self.post_unavailable_reply(spec_file, spec_entries)

    def report_spec_file(self, spec_file, entries):
        ticket = self.find_ticket(spec_file)
        if ticket is None:
            key = self.create_ticket(spec_file, entries)
            self.log.summary(f"Created {key} for {spec_file}")
            self.post_reply(f"🐞 Created <{self.jira.browse_url(key)}|{key}> for the flaky spec file `{spec_file}`.")
            return
        if ticket["status"] in CLOSED_STATUSES:
            self.jira.add_comment(ticket["key"], to_document(comment_content(entries, self.run_url)))
            self.reopen(ticket["key"])
            self.log.summary(f"Reopened {ticket['key']} for {spec_file}")
            self.post_reply(
                f"🔁 Reopened <{self.jira.browse_url(ticket['key'])}|{ticket['key']}> for the flaky spec file `{spec_file}`."
            )
            return
        self.jira.add_comment(ticket["key"], to_document(comment_content(entries, self.run_url)))
        self.log.summary(f"Commented on {ticket['key']} for {spec_file}")

    def find_ticket(self, spec_file):
        # Jira splits the summary into words, so a phrase of the whole path never matches; the file name alone does.
        # `~` is not exact, so the candidates are compared exactly below.
        file_name = re.sub(r'["\\]', " ", os.path.basename(spec_file))
        candidates = self.jira.search(
            f'project = {PROJECT_KEY} AND labels = "{LABEL}" AND summary ~ "{file_name}" ORDER BY created DESC'
        )
        matches = [
            candidate
            for candidate in candidates
            if candidate["summary"] == SUMMARY_PREFIX + spec_file and candidate["status"] != SHIPPED_STATUS
        ]
        if not matches:
            return None
        # A duplicate closed by hand is newer than the ticket it duplicates; the open ticket is the one to keep.
        newest = max(matches, key=lambda candidate: (candidate["status"] not in CLOSED_STATUSES, candidate["created"]))
        if len(matches) > 1:
            keys = ", ".join(candidate["key"] for candidate in matches)
            self.log.warning("Several flaky tickets", f"{spec_file} has {keys}; using {newest['key']}")
        return newest

    def create_ticket(self, spec_file, entries):
        key = self.jira.create_issue(
            {
                "project": {"key": PROJECT_KEY},
                "issuetype": {"name": ISSUE_TYPE},
                "summary": SUMMARY_PREFIX + spec_file,
                "labels": [LABEL],
                "description": to_document(ticket_content(spec_file, entries, self.run_url)),
                FIELD_SEVERITY: {"id": OPTION_SEVERITY_NORMAL},
                FIELD_BUG_CATEGORY: {"id": OPTION_BUG_CATEGORY_BY_FRAMEWORK[entries[0]["framework"]]},
                FIELD_FOUND_IN: {"id": OPTION_FOUND_IN_MASTER},
                FIELD_ENVIRONMENT: {"id": OPTION_ENVIRONMENT_CI},
                FIELD_STEPS_TO_REPRODUCE: to_document(steps_to_reproduce_content(spec_file, self.run_url)),
                FIELD_ACTUAL_BEHAVIOR: to_document(actual_behavior_content(self.run_url)),
                FIELD_EXPECTED_BEHAVIOR: to_document(expected_behavior_content()),
            }
        )
        # The project may set a default assignee on create; a flaky ticket starts unowned.
        self.jira.clear_assignee(key)
        return key

    def reopen(self, key):
        for transition in self.jira.transitions(key):
            if (transition.get("to") or {}).get("name") == REOPENED_STATUS:
                self.jira.transition(key, transition["id"])
                self.jira.clear_assignee(key)
                return
        raise JiraRequestRejected(f"{key} has no transition to {REOPENED_STATUS}")

    def post_unavailable_reply(self, spec_file, entries):
        text = self.unavailable_reply_text(spec_file, entries, with_stack_traces=True)
        if len(text) >= SLACK_TEXT_CHARACTER_LIMIT:
            text = self.unavailable_reply_text(spec_file, entries, with_stack_traces=False)
        self.post_reply(text)

    def unavailable_reply_text(self, spec_file, entries, with_stack_traces):
        blocks = (
            [("paragraph", [f"*Summary:* {SUMMARY_PREFIX}{spec_file}"])]
            + ticket_content(spec_file, entries, self.run_url, with_stack_traces)
            + [("paragraph", ["*Expected Behavior:*"])]
            + expected_behavior_content()
            + [("paragraph", ["*Actual Behavior:*"])]
            + actual_behavior_content(self.run_url)
        )
        if not with_stack_traces:
            blocks.append(
                (
                    "paragraph",
                    [
                        "Stack traces left out: longer than a Slack message allows. They are in the CI run: ",
                        link(self.run_url, self.run_url),
                    ],
                )
            )
        return (
            f"⚠️ Jira was unavailable, so no ticket was created or updated for `{spec_file}`. "
            "This is the ticket that would have been created:\n" + to_slack_text(blocks)
        )

    def post_reply(self, text):
        if not self.thread_timestamp:
            self.log.summary("No flaky Slack message was sent, so no thread reply was posted.")
            return
        try:
            self.slack.post_reply(self.thread_timestamp, text)
        except SlackDeliveryFailed as error:
            self.log.warning("Flaky Slack reply failed", str(error))


def main(argv=None):
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument("--details-dir", required=True)
    parser.add_argument("--run-url", required=True)
    parser.add_argument("--thread-timestamp", default="")
    args = parser.parse_args(argv)

    log = ActionsLog(os.environ.get("GITHUB_STEP_SUMMARY"))
    entries = load_entries(args.details_dir, log)
    if not entries:
        log.summary("No flaky-test details to report to Jira.")
        return 0

    reporter = FlakyJiraReporter(
        JiraClient(
            os.environ.get("JIRA_BASE_URL"),
            os.environ.get("JIRA_API_BASE_URL"),
            os.environ.get("FLAKY_JIRA_EMAIL"),
            os.environ.get("FLAKY_JIRA_API_TOKEN"),
        ),
        SlackClient(os.environ.get("SLACK_BOT_TOKEN"), os.environ.get("FLAKY_CI_SLACK_CHANNEL_ID")),
        log,
        args.run_url,
        args.thread_timestamp,
    )
    reporter.report(entries)
    return 0


if __name__ == "__main__":
    sys.exit(main())

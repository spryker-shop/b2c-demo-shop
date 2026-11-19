#!/usr/bin/env python3
"""Log a failed check of a scheduled run to Jira as a Bug labelled scheduled-run-failure.

Built on flaky-jira-report.py: the same Jira client, project, issue type and
fields (severity, bug category, found in, environment, steps to reproduce,
actual and expected behavior), so the ticket reads like a flaky-test ticket.
The ticket starts unassigned; the assignee of the weekly triage ticket finds
it by its label. Best effort: a Jira failure is a warning annotation plus a
job-summary line and the exit code is 0 unless the arguments are wrong.

Environment: JIRA_BASE_URL, JIRA_API_BASE_URL, FLAKY_JIRA_EMAIL, FLAKY_JIRA_API_TOKEN
(the same as flaky-jira-report.py).

Usage:
    scheduled-bug-report.py --pipeline SN-SCHEDULED --check Evaluator --run-url <url>
"""

import argparse
import importlib.util
import os
import sys

LABEL = "scheduled-run-failure"
# A failed Evaluator or PHPStan check is a CI finding, not a frontend or backend test: Bug Category "Infrastructure".
OPTION_BUG_CATEGORY_INFRASTRUCTURE = "10878"
SUMMARY_TEMPLATE = "Scheduled run failure: {check} check of {pipeline}"


def _load_flaky_report():
    path = os.path.join(os.path.dirname(os.path.abspath(__file__)), "flaky-jira-report.py")
    spec = importlib.util.spec_from_file_location("flaky_jira_report", path)
    module = importlib.util.module_from_spec(spec)
    spec.loader.exec_module(module)
    return module


flaky = _load_flaky_report()


def description_content(pipeline, check, run_url):
    return [
        ("paragraph", [f"Pipeline: {pipeline}"]),
        ("paragraph", [f"Failed check: {check}"]),
        ("paragraph", ["Failed CI run: ", flaky.link(run_url, run_url)]),
    ]


def steps_to_reproduce_content(pipeline, check, run_url):
    return [
        ("paragraph", [f"1. Run the {check} check of the {pipeline} pipeline."]),
        ("paragraph", ["2. Compare with the failed CI run ", flaky.link(run_url, run_url)]),
    ]


def actual_behavior_content(check, run_url):
    return [("paragraph", [f"The {check} check failed in the weekly run ", flaky.link(run_url, run_url)])]


def expected_behavior_content(check):
    return [("paragraph", [f"The {check} check passes in the weekly run."])]


def comment_content(check, run_url):
    return [
        ("paragraph", [f"Failed again in the weekly run: the {check} check."]),
        ("paragraph", ["CI run: ", flaky.link(run_url, run_url)]),
    ]


class ScheduledBugReporter:
    def __init__(self, jira, log, run_url):
        self.jira = jira
        self.log = log
        self.run_url = run_url

    def report(self, pipeline, check):
        summary = SUMMARY_TEMPLATE.format(check=check, pipeline=pipeline)
        ticket = self.find_ticket(summary)
        if ticket is not None:
            self.jira.add_comment(ticket["key"], flaky.to_document(comment_content(check, self.run_url)))
            if ticket["status"] in flaky.CLOSED_STATUSES:
                self.reopen(ticket["key"])
                self.log.summary(f"Reopened {ticket['key']} for the {check} check of {pipeline}")
            else:
                self.log.summary(f"Commented on {ticket['key']} for the {check} check of {pipeline}")
            return ticket["key"]
        key = self.jira.create_issue(
            {
                "project": {"key": flaky.PROJECT_KEY},
                "issuetype": {"name": flaky.ISSUE_TYPE},
                "summary": summary,
                "labels": [LABEL],
                "description": flaky.to_document(description_content(pipeline, check, self.run_url)),
                flaky.FIELD_SEVERITY: {"id": flaky.OPTION_SEVERITY_NORMAL},
                flaky.FIELD_BUG_CATEGORY: {"id": OPTION_BUG_CATEGORY_INFRASTRUCTURE},
                flaky.FIELD_FOUND_IN: {"id": flaky.OPTION_FOUND_IN_MASTER},
                flaky.FIELD_ENVIRONMENT: {"id": flaky.OPTION_ENVIRONMENT_CI},
                flaky.FIELD_STEPS_TO_REPRODUCE: flaky.to_document(
                    steps_to_reproduce_content(pipeline, check, self.run_url)
                ),
                flaky.FIELD_ACTUAL_BEHAVIOR: flaky.to_document(actual_behavior_content(check, self.run_url)),
                flaky.FIELD_EXPECTED_BEHAVIOR: flaky.to_document(expected_behavior_content(check)),
            }
        )
        # The project may set a default assignee on create; the assignee retrieves these by label instead.
        self.jira.clear_assignee(key)
        self.log.summary(f"Created {key} for the {check} check of {pipeline}")
        return key

    def find_ticket(self, summary):
        # A phrase of several words never matches in Jira text search (see flaky-jira-report.py), and the
        # label leaves only a few summaries, so the candidates are compared exactly below.
        candidates = self.jira.search(
            f'project = {flaky.PROJECT_KEY} AND labels = "{LABEL}" AND status != "{flaky.SHIPPED_STATUS}" '
            "ORDER BY created DESC"
        )
        matches = [c for c in candidates if c["summary"] == summary and c["status"] != flaky.SHIPPED_STATUS]
        if not matches:
            return None
        return max(matches, key=lambda c: (c["status"] not in flaky.CLOSED_STATUSES, c["created"]))

    def reopen(self, key):
        for transition in self.jira.transitions(key):
            if (transition.get("to") or {}).get("name") == flaky.REOPENED_STATUS:
                self.jira.transition(key, transition["id"])
                self.jira.clear_assignee(key)
                return
        raise flaky.JiraRequestRejected(f"{key} has no transition to {flaky.REOPENED_STATUS}")


def main(argv=None):
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument("--pipeline", required=True)
    parser.add_argument("--check", required=True)
    parser.add_argument("--run-url", required=True)
    args = parser.parse_args(argv)

    log = flaky.ActionsLog(os.environ.get("GITHUB_STEP_SUMMARY"))
    jira = flaky.JiraClient(
        os.environ.get("JIRA_BASE_URL"),
        os.environ.get("JIRA_API_BASE_URL"),
        os.environ.get("FLAKY_JIRA_EMAIL"),
        os.environ.get("FLAKY_JIRA_API_TOKEN"),
    )
    try:
        ScheduledBugReporter(jira, log, args.run_url).report(args.pipeline, args.check)
    except (flaky.JiraUnavailable, flaky.JiraRequestRejected) as error:
        log.warning("Scheduled run bug not logged", f"{args.pipeline} {args.check}: {error}")
    return 0


if __name__ == "__main__":
    sys.exit(main())

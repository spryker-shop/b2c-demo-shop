#!/usr/bin/env python3
"""Characterisation tests for the scheduled workflow: a green run logs no Jira bug.

Static, network-free. Run with:
    python3 .github/workflows/scripts/test_scheduled_bug_logging.py
"""

import importlib.util
import os
import re
import unittest

import yaml

WORKFLOW = os.path.join(os.path.dirname(__file__), "..", "scheduled.yml")
BUG_LOGGING = re.compile(r"jira|scheduled-run-failure|issue/create", re.IGNORECASE)
# Bug Category "Infrastructure" in project CC (customfield_12453).
INFRASTRUCTURE_BUG_CATEGORY = "10878"
FAILURE_GATE = re.compile(r"failure\(\)|result\s*==\s*'failure'|result\s*!=\s*'success'")


def _load_script(file_name, module_name):
    spec = importlib.util.spec_from_file_location(module_name, os.path.join(os.path.dirname(__file__), file_name))
    module = importlib.util.module_from_spec(spec)
    spec.loader.exec_module(module)
    return module


class FakeJira:
    def __init__(self, existing=None):
        self.created = []
        self.cleared = []
        self.comments = []
        self.existing = existing or []

    def search(self, jql):
        return self.existing

    def create_issue(self, fields):
        self.created.append(fields)
        return "CC-1"

    def clear_assignee(self, key):
        self.cleared.append(key)

    def add_comment(self, key, body):
        self.comments.append((key, body))

    def browse_url(self, key):
        return key


class SilentLog:
    def warning(self, title, message):
        pass

    def summary(self, line):
        pass


def _load_jobs():
    with open(WORKFLOW, encoding="utf-8") as handle:
        return yaml.safe_load(handle)["jobs"]


def _bug_logging_units(jobs):
    """Yield (name, gate) for every job or step that talks to Jira."""
    for job_id, job in jobs.items():
        job_gate = str(job.get("if", ""))
        if BUG_LOGGING.search(yaml.safe_dump({k: v for k, v in job.items() if k != "steps"})):
            yield job_id, job_gate
        for step in job.get("steps", []):
            if BUG_LOGGING.search(yaml.safe_dump(step)):
                yield f"{job_id}/{step.get('name', step.get('uses', '?'))}", f"{job_gate} {step.get('if', '')}"


class ScheduledBugLoggingTest(unittest.TestCase):
    def testGivenPassingEvaluatorCheckWhenWeeklyRunFinishesThenNoBugIsLogged(self):
        # Arrange
        jobs = _load_jobs()

        # Act
        units = list(_bug_logging_units(jobs))

        # Assert
        ungated = [name for name, gate in units if not FAILURE_GATE.search(gate)]
        self.assertEqual([], ungated, "Bug logging must only run when a check failed")

    def testGivenFailedEvaluatorCheckWhenWeeklyRunFinishesThenBugJobRunsAfterEvaluatorOnlyOnFailure(self):
        # Arrange
        jobs = _load_jobs()

        # Act
        job = jobs.get("log-evaluator-bug")

        # Assert
        self.assertIsNotNone(job, "B2C-SCHEDULED needs a bug-logging job for the Evaluator check")
        self.assertIn("evaluator", job["needs"])
        self.assertIn("needs.evaluator.result == 'failure'", str(job["if"]))
        self.assertIn("github.event_name == 'schedule'", str(job["if"]))
        commands = " ".join(step.get("run", "") for step in job["steps"])
        self.assertIn("scheduled-bug-report.py", commands)
        self.assertIn("--pipeline B2C-SCHEDULED", commands)
        self.assertIn("--check Evaluator", commands)

    def testGivenNoOpenBugWhenEvaluatorCheckFailedThenBugWithLabelAndFlakyFieldsIsCreated(self):
        # Arrange
        flaky = _load_script("flaky-jira-report.py", "flaky_jira_report")
        report = _load_script("scheduled-bug-report.py", "scheduled_bug_report")
        jira = FakeJira()
        reporter = report.ScheduledBugReporter(jira, SilentLog(), "https://ci/run/1")

        # Act
        key = reporter.report("B2C-SCHEDULED", "Evaluator")

        # Assert
        self.assertEqual("CC-1", key)
        fields = jira.created[0]
        self.assertEqual(["scheduled-run-failure"], fields["labels"])
        self.assertEqual({"key": "CC"}, fields["project"])
        self.assertEqual({"name": "Bug"}, fields["issuetype"])
        self.assertIn("B2C-SCHEDULED", fields["summary"])
        self.assertIn("Evaluator", fields["summary"])
        for field in (
            flaky.FIELD_SEVERITY,
            flaky.FIELD_BUG_CATEGORY,
            flaky.FIELD_FOUND_IN,
            flaky.FIELD_ENVIRONMENT,
            flaky.FIELD_STEPS_TO_REPRODUCE,
            flaky.FIELD_ACTUAL_BEHAVIOR,
            flaky.FIELD_EXPECTED_BEHAVIOR,
            "description",
        ):
            self.assertIn(field, fields)
        self.assertEqual({"id": INFRASTRUCTURE_BUG_CATEGORY}, fields[flaky.FIELD_BUG_CATEGORY])
        self.assertIn("https://ci/run/1", str(fields["description"]))
        self.assertEqual(["CC-1"], jira.cleared)

    def testGivenOpenBugForSameCheckWhenCheckFailsAgainThenFailureIsCommentedAndNoBugIsCreated(self):
        # Arrange
        report = _load_script("scheduled-bug-report.py", "scheduled_bug_report")
        summary = "Scheduled run failure: Evaluator check of B2C-SCHEDULED"
        jira = FakeJira(existing=[{"key": "CC-7", "summary": summary, "status": "In Progress", "created": "2026-01-01"}])
        reporter = report.ScheduledBugReporter(jira, SilentLog(), "https://ci/run/3")

        # Act
        key = reporter.report("B2C-SCHEDULED", "Evaluator")

        # Assert
        self.assertEqual("CC-7", key)
        self.assertEqual([], jira.created)
        self.assertEqual("CC-7", jira.comments[0][0])
        self.assertIn("https://ci/run/3", str(jira.comments[0][1]))

    def testGivenOnlyClosedBugForSameCheckWhenCheckFailsAgainThenNewBugIsCreated(self):
        # Arrange
        report = _load_script("scheduled-bug-report.py", "scheduled_bug_report")
        summary = "Scheduled run failure: Evaluator check of B2C-SCHEDULED"
        jira = FakeJira(existing=[{"key": "CC-7", "summary": summary, "status": "Resolved", "created": "2026-01-01"}])
        reporter = report.ScheduledBugReporter(jira, SilentLog(), "https://ci/run/4")

        # Act
        key = reporter.report("B2C-SCHEDULED", "Evaluator")

        # Assert
        self.assertEqual("CC-1", key)
        self.assertEqual([], jira.comments)
        self.assertEqual(1, len(jira.created))


if __name__ == "__main__":
    unittest.main()

#!/usr/bin/env python3
"""Generate the Cypress shard matrix at runtime from recorded spec timings.

The installed `cypress-tests` package (composer-installed, gitignored) is the
single source of truth for which specs exist; this script lists them, balances
them across a FIXED number of shards by measured runtime, and prints the matrix
the `cypress` job consumes.

Pipeline
--------
1. List installed specs under ``<package-dir>/cypress/e2e/**/*.cy.ts``,
   excluding ``smoke/`` and any ``ssp*`` basename — the same filter the CI spec
   glob applies (SSP runs as its own standalone shard).
2. Load a timings file (``cypress-timings.json``: ``{spec: duration_ms}``) if
   present. New/untimed specs are assigned the mean of the known durations so
   a freshly added spec is placed sensibly instead of always landing in shard
   one.
3. LPT (longest-processing-time) bin-pack the specs by duration into a fixed
   ``N`` shards: sort longest first, drop each onto the currently-lightest
   shard. This is the standard greedy makespan heuristic — it keeps per-shard
   wall time close without needing an exact solver.
4. Self-check: assert the union of the shard spec lists equals the installed
   spec set (no drops, no dupes). A mismatch means a generator bug, so we
   ``exit 1`` (plain, no run-cancel) — the ONLY red path. Adding a spec cannot
   trigger it; the spec is absorbed into a shard automatically.

Fallback
--------
If the timings file is missing, empty, or corrupt, every spec is treated as
equal cost (count-based packing) and a GitHub ``::notice::`` is logged. Timing
data is advisory only: its absence or corruption degrades balance but never
fails the gate.

Output
------
Prints a JSON array to stdout: one entry per core shard plus a trailing SSP
entry, in the exact shape the ``cypress`` matrix already expects
(``label``/``shard``/``total``/``specs``/``mode``). The gate job captures
stdout into ``$GITHUB_OUTPUT``.

Usage
-----
    generate-cypress-shards.py [--package-dir DIR] [--timings FILE] [--shards N]
                               [--include-ssp]

Defaults: package-dir=tests/cypress-tests, timings=cypress-timings.json, N=5,
include-ssp=off. The SSP shard is opt-in: this shop runs no SSP lane, and emitting
one would execute a spec set that is not part of the baseline.
"""

from __future__ import annotations

import argparse
import glob
import json
import os
import sys
from pathlib import Path

DEFAULT_PACKAGE_DIR = "tests/cypress-tests"
DEFAULT_TIMINGS_FILE = "cypress-timings.json"
DEFAULT_SHARD_COUNT = 5
E2E_GLOB = "cypress/e2e/**/*.cy.ts"


def log_notice(message: str) -> None:
    """Emit a GitHub Actions notice (harmless plain line off CI)."""
    print(f"::notice::{message}", file=sys.stderr)


def list_installed_specs(package_dir: str) -> list[str]:
    """Return sorted core spec paths relative to the package root.

    Glob under the package, excluding any path containing ``/smoke/`` or whose
    basename starts with ``ssp`` (SSP runs as its own standalone shard).
    """
    specs: list[str] = []
    cwd = Path.cwd()
    os.chdir(package_dir)
    try:
        for p in glob.iglob(E2E_GLOB, recursive=True):
            if "/smoke/" in p or os.path.basename(p).startswith("ssp"):
                continue
            specs.append(p)
    finally:
        os.chdir(cwd)
    return sorted(specs)


def resolve_within_tree(path: str) -> Path | None:
    """Resolve ``path`` under the working tree, or None if it escapes it.

    Keeps a caller-supplied path from reaching outside the checkout, which is the
    only place this script has any business reading from.
    """
    root = Path.cwd().resolve()
    candidate = (root / path).resolve()
    return candidate if candidate == root or root in candidate.parents else None


def load_timings(timings_file: str) -> dict[str, float] | None:
    """Load ``{spec: duration_ms}``; return None on any missing/corrupt input.

    A None return is the caller's signal to fall back to count-based packing.
    """
    if not timings_file:
        return None
    resolved = resolve_within_tree(timings_file)
    if resolved is None or not resolved.is_file():
        return None
    try:
        with open(resolved) as f:
            data = json.load(f)
    except (json.JSONDecodeError, OSError):
        return None
    if not isinstance(data, dict) or not data:
        return None
    timings: dict[str, float] = {}
    for spec, duration in data.items():
        try:
            value = float(duration)
        except (TypeError, ValueError):
            continue
        if value > 0:
            timings[str(spec)] = value
    return timings or None


def spec_durations(
    specs: list[str], timings: dict[str, float] | None
) -> tuple[dict[str, float], bool]:
    """Map each spec to a duration; second value is True when count-based.

    With timings present, untimed specs get the mean of the known durations.
    With no usable timings, every spec is weighted equally (count-based).
    """
    if not timings:
        return {spec: 1.0 for spec in specs}, True

    known = [timings[spec] for spec in specs if spec in timings]
    mean = (sum(known) / len(known)) if known else 1.0
    return {spec: timings.get(spec, mean) for spec in specs}, False


def pack_shards(specs: list[str], durations: dict[str, float], shard_count: int) -> list[list[str]]:
    """LPT bin-pack specs into ``shard_count`` bins, balancing total duration.

    Sort longest-first (stable tie-break on spec name for determinism), then
    drop each spec onto the currently-lightest bin (lowest index breaks ties).
    """
    bins: list[list[str]] = [[] for _ in range(shard_count)]
    loads = [0.0] * shard_count
    ordered = sorted(specs, key=lambda s: (-durations[s], s))
    for spec in ordered:
        target = min(range(shard_count), key=lambda i: (loads[i], i))
        bins[target].append(spec)
        loads[target] += durations[spec]
    # Keep each bin's spec list stable/readable.
    for b in bins:
        b.sort()
    return bins


def build_matrix(bins: list[list[str]], include_ssp: bool = False) -> list[dict[str, str | int]]:
    """Render the bins as the matrix entries the ``cypress`` job consumes."""
    total = len(bins)
    matrix: list[dict[str, str | int]] = []
    for index, shard_specs in enumerate(bins, start=1):
        matrix.append(
            {
                "label": f"{index}/{total}",
                "shard": str(index),
                "total": total,
                "specs": ",".join(shard_specs),
                "mode": "core",
            }
        )
    # SSP folded into the matrix as its own shard: one less standalone
    # full-env bring-up; SSP coverage preserved. Handling is unchanged.
    # Opt-in, because shops with no SSP lane must not be handed an SSP shard —
    # it would run a spec set they never ran before.
    if include_ssp:
        matrix.append(
            {
                "label": "ssp",
                "shard": "ssp",
                "total": total,
                "specs": "",
                "mode": "ssp",
            }
        )
    return matrix


def self_check(installed: list[str], bins: list[list[str]]) -> None:
    """Fail red iff the packed specs don't exactly equal the installed set."""
    packed: list[str] = [spec for b in bins for spec in b]
    packed_set = set(packed)
    installed_set = set(installed)

    if len(packed) != len(packed_set):
        dupes = sorted({s for s in packed if packed.count(s) > 1})
        print("Cypress shard generation produced duplicate specs:", file=sys.stderr)
        for s in dupes:
            print(f"  ! {s}", file=sys.stderr)
        sys.exit(1)

    if packed_set != installed_set:
        missing = sorted(installed_set - packed_set)
        extra = sorted(packed_set - installed_set)
        print(
            "Cypress shard generation self-check FAILED "
            "(packed specs != installed specs):",
            file=sys.stderr,
        )
        for s in missing:
            print(f"  - {s} (installed but not packed)", file=sys.stderr)
        for s in extra:
            print(f"  + {s} (packed but not installed)", file=sys.stderr)
        print(
            "This is a generator bug — investigate the packing logic.",
            file=sys.stderr,
        )
        sys.exit(1)


def generate(
    package_dir: str, timings_file: str, shard_count: int, include_ssp: bool = False
) -> str:
    installed = list_installed_specs(package_dir)
    if not installed:
        print(
            f"No Cypress specs found under {package_dir}/{E2E_GLOB} "
            "(is the cypress-tests package installed?).",
            file=sys.stderr,
        )
        sys.exit(1)

    timings = load_timings(timings_file)
    durations, count_based = spec_durations(installed, timings)
    if count_based:
        log_notice(
            f"cypress-timings not available at '{timings_file}' — packing "
            f"{len(installed)} specs into {shard_count} shards by count. "
            "Balance is approximate until timings are recorded."
        )
    else:
        untimed = [s for s in installed if s not in timings]
        if untimed:
            log_notice(
                f"{len(untimed)} of {len(installed)} specs had no recorded "
                "timing; assigned the mean duration."
            )

    bins = pack_shards(installed, durations, shard_count)
    self_check(installed, bins)
    return json.dumps(build_matrix(bins, include_ssp))


def parse_args(argv: list[str]) -> argparse.Namespace:
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument("--package-dir", default=DEFAULT_PACKAGE_DIR)
    parser.add_argument("--timings", default=DEFAULT_TIMINGS_FILE)
    parser.add_argument("--shards", type=int, default=DEFAULT_SHARD_COUNT)
    parser.add_argument("--include-ssp", action="store_true", default=False)
    return parser.parse_args(argv)


def main(argv: list[str]) -> int:
    args = parse_args(argv)
    if args.shards < 1:
        print("--shards must be >= 1", file=sys.stderr)
        return 1
    print(generate(args.package_dir, args.timings, args.shards, args.include_ssp))
    return 0


if __name__ == "__main__":
    sys.exit(main(sys.argv[1:]))

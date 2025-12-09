# .github/PR_LABELS.md

## Purpose
High‑signal, automated **PR labels** for review routing and release hygiene—without introducing `type:*` labels.

## How labels are applied
1) **Paths → labels** via **`.github/labeler.yml`** (actions/labeler):  
   Examples: `area:ci`, `area:dependencies`, `area:block-editor`, `area:theme`, `area:integration`, `comp:theme-json`, `comp:block-templates`, `comp:block-patterns`, `lang:php`, `lang:javascript`, `lang:css`, `lang:md`.

2) **Branch prefixes → status** (on PR open):  
   `feat/`, `fix/`, `docs/`, `chore/` (and `build/`) → add **`status:needs-review`** by default.

> The workflow enforces **exactly one** `status:*` on PRs and seeds `status:needs-review` if none is present.

## Changelog hygiene
- On open, PRs that look **user‑visible** get **`meta:needs-changelog`**. Maintainers remove it after updating `CHANGELOG.md` / `readme.txt` (WP.org) or add an explicit `no-changelog` label for internal‐only changes.
- Paired rule in the labeler can **auto‑remove** `meta:needs-changelog` when a PR touches a changelog/readme file (`sync-labels: true`).

## Dependabot PRs
- Dependency updates are labelled by path (`area:dependencies`) so you can filter/batch them easily.

## Security note
- Using labeler on forks typically requires the **`pull_request_target`** event; follow GitHub’s security guidance when using it.

## Files powering this
- `.github/labeler.yml` — path & branch rules.
- `.github/workflows/labels-issues-prs.yml` — applies defaults, enforces status, nudges changelog.
- `.github/dependabot.yml` — opens dependency PRs that will pick up `area:dependencies` from the labeler.

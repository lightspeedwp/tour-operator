# .github/ISSUE_LABELS.md

## Purpose
Consistent, low‑friction **issue labelling** that complements the **Issue Type** Project field (Epic/Story/Task/Bug/etc.) without duplicating it.

> We **do not** use `type:*` labels. Classification lives in the **Issue Type** field in Projects.

## Label families (issues)
- **`status:*`** — lifecycle signal (**exactly one per issue**): `needs-triage`, `ready`, `in-progress`, `needs-review`, `needs-qa`, `blocked`, `in-discussion`, `needs-more-info`.
- **`priority:*`** — `critical`, `important`, `normal`, `minor`.
- **`area:*`** (broad domain) **or** **`comp:*`** (specific artefact, e.g. `comp:theme-json`, `comp:block-templates`, `comp:block-patterns`). *Prefer one primary; add the other only when it helps search/ownership.*
- Optional routing: **`lang:*`** (e.g. `lang:php`, `lang:js`, `lang:css`, `lang:md`), **`env:*`** (prototype/staging/live), **`compat:*`** (wordpress/php/woocommerce/rtl/gutenberg), **`cpt:*`** (custom post types), **`meta:*`** (hygiene: `meta:stale`, `meta:no-issue-activity`).

## Triage workflow (5 steps)
1. **Set Issue Type** (Epic/Story/Task/Bug/…); link **Parent Epic** where applicable.
2. Add **one** `priority:*`.
3. Add **one** of `area:*` **or** `comp:*`.
4. Set **`status:needs-triage`** (intake). When groomed, switch to **`status:ready`**. Keep **exactly one** status.
5. Add optional routing labels (`lang:*`, `env:*`, `compat:*`, `cpt:*`) only if they aid discovery/assignment.

## Automations affecting issues
- On open/reopen/transfer → add **`status:needs-triage`** if missing.
- Enforce **max one** `status:*` (will error if multiple present).
- If no `priority:*` is set → default to **`priority:normal`**.

> These behaviours are managed by **`.github/workflows/labels-issues-prs.yml`**.

## Saved searches (pin in Projects or repo)
- **Engineers’ queue:** `is:issue is:open label:"status:ready" -label:"status:blocked" sort:updated-desc`
- **QA sweep:** `is:issue is:open label:"status:needs-qa"`
- **Blocked:** `is:issue is:open label:"status:blocked"`

## Do & Don’t
- ✅ Keep labels **orthogonal** and minimal (1× status, 1× priority, 1× area/comp).
- ✅ Use `status:blocked` + a brief **Blocked reason** in the issue body instead of more labels.
- ❌ Don’t mirror Issue Type with labels (no `type:feature`, `type:bug`, etc.).

## Files powering this
- `.github/workflows/labels-issues-prs.yml`
- `.github/labels.yml` *(optional central list for colour/description sync)*

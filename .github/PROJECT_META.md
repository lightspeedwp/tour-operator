# .github/PROJECT_META.md

## Purpose
Automatically **add issues/PRs to the org Project** and keep Project **fields** in sync with labels and branch semantics.

## What the workflow does
- **Triggers** on issue & PR events.
- **Adds the item** to the org Project (`LS_PROJECT_URL`).
- **Derives fields**:
  - **Status** from `status:*` labels (`Ready`, `In progress`, `In review`, `In QA`, `Blocked`; closed/merged → `Done`; default `Triage`).
  - **Priority** from `priority:*` labels (`Critical`, `Important`, `Normal`, `Minor`).
  - **Type** from **PR head branch** prefix (`feat/`→`Feature`, `fix/`→`Bug`, `docs/`→`Documentation`, `chore/|build/`→`Task`). Issues still set **Type** manually.
- **Writes** these to Project fields: **Status**, **Priority**, **Type**.

## Setup requirements
- **Org/Repo variable:** `LS_PROJECT_URL` → e.g. `https://github.com/orgs/LightSpeed/projects/1`.
- **GitHub App (recommended) or PAT:** 
  - If using App, provide: `LS_APP_ID` (App ID) and `LS_APP_PRIVATE_KEY` (private key) as **secrets**; the workflow exchanges them for a token.
  - Ensure the App is installed on the org Project and repos.
- **Project fields:** Ensure your Project has **Status**, **Priority**, **Type** with those **exact names**.

## Notes & guardrails
- Labels remain **routing signals**; the Project is the **source of truth** for delivery state.
- Mapping from branch → **Type** is **advisory** for PRs; Issues choose Type explicitly.
- Keep **Status** lean; use labels for `needs-qa`, `needs-review`, `blocked` and let the workflow sync them to the Project field.

## Files powering this
- `.github/workflows/project-meta-sync.yml` — adds items to the Project and updates fields.
- `.github/workflows/labels-issues-prs.yml` — normalises labels that drive Status/Priority.
- `.github/repository.yml` — human‑readable repo metadata for maintainers and future automation.

## Troubleshooting
- **Item not added to Project?** Check `LS_PROJECT_URL`, App installation, and the step that adds to the Project.
- **Fields not updating?** Ensure the field names match exactly: `Status`, `Priority`, `Type`.
- **Type not set on PRs?** Confirm the branch prefixes: `feat/`, `fix/`, `docs/`, `chore/`, `build/`.

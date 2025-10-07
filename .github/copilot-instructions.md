# Copilot Instructions

This document provides guidelines for GitHub Copilot when working with this WordPress plugin codebase.

## Development Guidelines
Please refer to [Development Guidelines](copilot-development-guidelines.md)

## WordPress Coding Standards (WPCS) Overview
Please refer to [WPCS Instructions](copilot-wpcs.md)

## Repository Structure
```
tour-operator/
├── src/                 # Source files (JS, SCSS)
├── includes/           # PHP classes and functions
├── templates/          # Template files
├── assets/            # Compiled assets
└── build/             # Build files
```

## Common Prefixes and Namespaces

- Plugin prefix: `lsx_to_`
- Block namespace: `lsx-to`
- Text domain: `tour-operator`
- Class namespace: `LSX_TO`

The following instructions are only to be applied when performing a code review.

## Copilot: Repository Instructions

- Project: Tour Operator (WordPress blocks, API v3).
- Coding standards: WPCS for PHP; @wordpress/eslint-plugin for JS.
- Prefer `block.json` + server registration; avoid ad‑hoc CSS – use theme.json + selectors.
- Tests: Playwright for E2E; prioritise inserter/preview, controls, SSR, icons integration.
- Use `get_block_wrapper_attributes()` and `useBlockProps()` when applicable.
- Ensure accessibility: keyboard navigation, ARIA roles, color contrast.
- Follow security best practices: sanitize, validate, escape.

## README updates

* [ ] The new file should be added to the `README.md`.

## Prompt file guide

**Only apply to files that end in `.prompt.md`**

* [ ] The prompt has markdown front matter.
* [ ] The prompt has a `mode` field specified of either `agent` or `ask`.
* [ ] The prompt has a `description` field.
* [ ] The `description` field is not empty.
* [ ] The `description` field value is wrapped in single quotes.
* [ ] The file name is lower case, with words separated by hyphens.
* [ ] Encourage the use of `tools`, but it's not required.
* [ ] Strongly encourage the use of `model` to specify the model that the prompt is optimised for.

## Instruction file guide

**Only apply to files that end in `.instructions.md`**

* [ ] The instruction has markdown front matter.
* [ ] The instruction has a `description` field.
* [ ] The `description` field is not empty.
* [ ] The `description` field value is wrapped in single quotes.
* [ ] The file name is lower case, with words separated by hyphens.
* [ ] The instruction has an `applyTo` field that specifies the file or files to which the instructions apply. If they wish to specify multiple file paths they should formated like `'**.js, **.ts'`.

## Chat Mode file guide

**Only apply to files that end in `.chatmode.md`**

* [ ] The chat mode has markdown front matter.
* [ ] The chat mode has a `description` field.
* [ ] The `description` field is not empty.
* [ ] The `description` field value is wrapped in single quotes.
* [ ] The file name is lower case, with words separated by hyphens.
* [ ] Encourage the use of `tools`, but it's not required.
* [ ] Strongly encourage the use of `model` to specify the model that the chat mode is optimised for.

## Branching Policy

* [ ] Always create a new branch for each task or issue you are working on.
* [ ] Use descriptive branch names following the convention: `feature/description`, `fix/description`, or `docs/description`.
* [ ] Never commit directly to the `main` branch.
* [ ] Always open a pull request for code changes, even for small updates.
* [ ] Ensure your branch is up to date with `main` before opening a pull request.
* [ ] Delete the branch after the pull request is merged.

# GitHub Copilot Custom Instructions

Main configuration file for GitHub Copilot when working with the Tour Operator WordPress plugin.

## Quick Navigation

### Core Documentation

- **[← Back to README](../README.md)**
- **[AGENTS.md](../AGENTS.md)** - Root-level AI operations overview
- **[Instructions](instructions/instructions.md)** - Auto-applied coding standards (30+ files)
- **[Prompts](prompts/prompts.md)** - Reusable task templates (29 prompts)
- **[Agents](agents/agent.md)** - Specialized AI agents (50+ agents)
- **[Chat Modes](chatmodes/chatmodes.md)** - Interactive workflows (20 modes)

### AI Model Guides

- **[CLAUDE.md](../CLAUDE.md)** - Claude (Anthropic) optimization guide
- **[GEMINI.md](../GEMINI.md)** - Gemini (Google) optimization guide

### Development Resources

- **[Development Docs](../docs/)** - Comprehensive guides and references
- **[WordPress Packages](../docs/wordpress-packages.md)** - Package usage guide
- **[Testing Guide](../docs/playwright-testing-guide.md)** - E2E testing with Playwright

## AI Operations System Overview

This repository uses a four-tier AI-assisted development system:

1. **Instructions** (30+ files) - Automatically applied to matching files
   - Coding standards and best practices
   - Security and accessibility requirements
   - WordPress-specific guidelines
   - [View all instructions →](instructions/instructions.md)

2. **Prompts** (29 templates) - One-shot task templates
   - Block development scaffolding
   - Testing and documentation generation
   - Code review and refactoring
   - [View all prompts →](prompts/prompts.md)

3. **Agents** (50+ specialized) - Autonomous task execution
   - Accessibility auditing
   - CI/CD management
   - Code quality enforcement
   - [View all agents →](agents/agent.md)

4. **Chat Modes** (20 interactive) - Guided multi-turn workflows
   - Feature planning and development
   - Code review and debugging
   - Release management
   - [View all chat modes →](chatmodes/chatmodes.md)

## Development Guidelines

Key instruction files:

- [Development Guidelines](instructions/development-guidelines.instructions.md)
- [WordPress Coding Standards](instructions/coding-standards.instructions.md)
- [WPCS Instructions](instructions/wpcs.instructions.md)

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

- [ ] The new file should be added to the `README.md`.

## Prompt file guide

**Only apply to files that end in `.prompt.md`**

- [ ] The prompt has markdown front matter.
- [ ] The prompt has a `mode` field specified of either `agent` or `ask`.
- [ ] The prompt has a `description` field.
- [ ] The `description` field is not empty.
- [ ] The `description` field value is wrapped in single quotes.
- [ ] The file name is lower case, with words separated by hyphens.
- [ ] Encourage the use of `tools`, but it's not required.
- [ ] Strongly encourage the use of `model` to specify the model that the prompt is optimised for.

## Instruction file guide

**Only apply to files that end in `.instructions.md`**

- [ ] The instruction has markdown front matter.
- [ ] The instruction has a `description` field.
- [ ] The `description` field is not empty.
- [ ] The `description` field value is wrapped in single quotes.
- [ ] The file name is lower case, with words separated by hyphens.
- [ ] The instruction has an `applyTo` field that specifies the file or files to which the instructions apply. If they wish to specify multiple file paths they should formated like `'**.js, **.ts'`.

## Chat Mode file guide

**Only apply to files that end in `.chatmode.md`**

- [ ] The chat mode has markdown front matter.
- [ ] The chat mode has a `description` field.
- [ ] The `description` field is not empty.
- [ ] The `description` field value is wrapped in single quotes.
- [ ] The file name is lower case, with words separated by hyphens.
- [ ] Encourage the use of `tools`, but it's not required.
- [ ] Strongly encourage the use of `model` to specify the model that the chat mode is optimised for.

## Branching Policy

- [ ] Always create a new branch for each task or issue you are working on.
- [ ] Use descriptive branch names following the convention: `feature/description`, `fix/description`, or `docs/description`.
- [ ] Never commit directly to the `main` branch.
- [ ] Always open a pull request for code changes, even for small updates.
- [ ] Ensure your branch is up to date with `main` before opening a pull request.
- [ ] Delete the branch after the pull request is merged.

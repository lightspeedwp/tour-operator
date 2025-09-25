# WordPress Plugin

A WordPress plugin

## Description

A WordPress plugin

## Installation

1. Upload the plugin files to the `/wp-content/plugins/tour-operator` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Configure the plugin through the WordPress admin interface.

## Features

- WordPress integration
- Easy to use interface
- Customizable settings
- Developer-friendly hooks and filters

## Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher

## Development

This plugin follows WordPress coding standards and best practices.

### Linting & Coding Standards

PHP coding standards are enforced via [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) with the `10up/phpcs-composer` package providing the `10up-Default` ruleset plus WordPress Core, Docs, Extra and PHPCompatibility checks.

Two PHPCS configuration files are provided:

- `phpcs.xml.dist` – Project-specific rules (exclusions, prefixes, text domain).
- `.phpcs.xml.dist` – Minimal file to help IDE integrations (points directly to `10up-Default`).

Run linting locally with Composer:

```bash
composer run lint
```

Or run the full suite (JS, CSS, PHP):

```bash
npm run lint:all
```

Auto-fix PHP issues where possible:

```bash
composer phpcbf
```

Generate a machine-readable report (used in CI artifacts):

```bash
composer phpcs:report
```

Override the PHP compatibility test version (example: PHP 7.2+):

```bash
./vendor/bin/phpcs --runtime-set testVersion 7.2-
```

### Continuous Integration

PHPCS runs automatically on pushes to `2.1-trunk` and all pull requests via the GitHub Action workflow at `.github/workflows/phpcs.yml` using the version specified in that workflow file (currently `10up/wpcs-action@v2.0.0`—please keep this in sync with the workflow).

The workflow:

1. Installs Composer + Node dependencies.
2. Runs PHPCS with annotations on the PR (errors & warnings surfaced inline).
3. Uploads a report artifact when available.

### Project Management Automation

The dev dependency `@wordpress/project-management-automation` is available for future automation of project processes (labels, milestones, release tasks). See the package docs: https://developer.wordpress.org/block-editor/reference-guides/packages/packages-project-management-automation/

You can invoke scripts or node-based automation utilities that leverage this package within future workflows (e.g. triage, release preparation).

### PHPCS Baseline & Incremental Improvements

An initial PHPCS baseline (`phpcs-baseline.xml`) has been generated to snapshot existing legacy violations. Strategy:

- New/modified code should meet standards before merging.
- Large legacy directories can be refactored incrementally; regenerate the baseline after significant cleanups:

```bash
composer phpcs:baseline
```

To review only changed PHP files locally (example):

```bash
git diff --name-only origin/2.1-trunk... | grep -E '\\.php$' | xargs vendor/bin/phpcs -d memory_limit=512M
```

### Diff‑Only Lint in CI (Optional Pattern)

A future enhancement can add a workflow that:
1. Collects changed PHP files in the PR.
2. Runs PHPCS only on that subset.
3. Fails if new errors appear that are not in the historical baseline.

If you’d like this automated, request: “Add diff-only PHPCS CI”.

### Automation Workflows

Current relevant workflows:

- `phpcs.yml` – Full annotated PHPCS run (10up action).
- `project-automation.yml` – PR lifecycle automation (labels, milestone logic potential).

Planned / optional:

- `phpcs-diff.yml` – Scans only changed files (not yet added).
- Release prep automation leveraging `@wordpress/project-management-automation` hooks.

### Adding New Automation Tasks

Use the WordPress action directly in a workflow step:

```yaml
- uses: WordPress/gutenberg/packages/project-management-automation@trunk
    with:
        github_token: ${{ secrets.GITHUB_TOKEN }}
```

You can scope events (`pull_request`, `issues`) and extend with additional job steps (e.g. changelog validation, label enforcement).

### IDE Integration

If your IDE does not detect the `10up-Default` ruleset, it will fall back to `.phpcs.xml.dist`. Make sure your PHPCS extension/binary points to `vendor/bin/phpcs`.

Example manual invocation with explicit standard:

```bash
vendor/bin/phpcs --standard=phpcs.xml.dist
```

---

### GitHub Copilot Integration

This repository is configured with GitHub Copilot support including:
- Custom prompts in `.github/prompts/`
- Instructions in `.github/instructions/`
- Agents in `.github/agents/`
- Chat modes in `.github/chatmodes/`

# Tour Operator Docs & .github Kit

Curated documentation and GitHub configuration for **LSX Tour Operator** (blocks-first WordPress plugin).
This kit standardises coding conventions, block authoring, CI, and collaboration.

- **Docs** live in `/docs`.
- **GitHub configs** live in `/.github` (issue/PR templates, workflows, Copilot prompts).
- Based on WordPress Block API v3, block.json metadata, theme.json styling and Playwright E2E.
- Uses [@wordpress/scripts](https://developer.wordpress.org/block-editor/packages/packages-scripts/) for build, linting, and testing.

### File Structure

```
tour-operator/
├── plugin.php
├── README.md
├── .github/
│   ├── prompts/
│   ├── instructions/
│   ├── agents/
│   └── chatmodes/
└── .vscode/
    └── settings.json
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## Support

For support and questions, please use the GitHub Issues tab.

## License

This plugin is licensed under the GPL v2 or later.

## Changelog

### 1.0.0
- Initial release

---

**Author:** Author
**Version:** 1.0.0


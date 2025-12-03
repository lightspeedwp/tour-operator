# Tour Operator WordPress Plugin

A comprehensive WordPress plugin for tour operators, built with modern WordPress Block Editor (Gutenberg) and following WordPress Block API v3 standards.

## Description

Tour Operator is a blocks-first WordPress plugin designed for tour operators, travel agencies, and safari companies. It provides a complete solution for managing tours, destinations, accommodations, and travel content using modern WordPress block patterns and theme.json styling.

## Features

- **Modern Block Editor Integration**: Built with WordPress Block API v3
- **Block Patterns**: Pre-designed patterns for tours, destinations, and accommodations
- **Theme.json Styling**: Consistent design tokens and style variations
- **Accessibility First**: WCAG 2.2 AA compliant components
- **Performance Optimized**: Minimal CSS, efficient JavaScript, server-side rendering
- **Developer Friendly**: Comprehensive hooks, filters, and documentation
- **AI-Assisted Development**: GitHub Copilot integration with custom agents and prompts

## Requirements

- WordPress 6.0 or higher
- PHP 7.4 or higher
- Node.js 18+ (for development)
- npm 9+ (for development)

## Installation

1. Upload the plugin files to the `/wp-content/plugins/tour-operator` directory, or install through the WordPress plugins screen
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Configure the plugin settings through the WordPress admin interface
4. Start using Tour Operator blocks and patterns in the Block Editor

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

WPCS runs automatically on pushes to `2.1-trunk` and all pull requests via the GitHub Action workflow at `.github/workflows/phpcs.yml` using `10up/wpcs-action@stable` with local configuration.

The workflow:

1. Installs Composer + Node dependencies.
2. Runs WPCS with local config (`phpcs.xml.dist`) and annotations on the PR.
3. Checks only changed files for efficiency and enables warnings.
4. Uses the 10up-Default ruleset with project-specific customizations.

### Project Management Automation

The dev dependency `@wordpress/project-management-automation` is available for future automation of project processes (labels, milestones, release tasks). See the package docs: <https://developer.wordpress.org/block-editor/reference-guides/packages/packages-project-management-automation/>

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

### EditorConfig & Code Style

This plugin follows WordPress Coding Standards with consistent indentation enforced via `.editorconfig`:

- **PHP files**: Tabs (WordPress standard)
- **JavaScript/TypeScript**: 2 spaces
- **CSS/SCSS**: 2 spaces  
- **JSON/YAML**: 2 spaces
- **Markdown**: 2 spaces (preserves trailing whitespace)

Configuration references:

- [WordPress PHP Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/)
- [WordPress Core .editorconfig](https://core.trac.wordpress.org/browser/trunk/.editorconfig)

### IDE Integration

If your IDE does not detect the `10up-Default` ruleset, it will fall back to `.phpcs.xml.dist`. Make sure your PHPCS extension/binary points to `vendor/bin/phpcs`.

Example manual invocation with explicit standard:

```bash
vendor/bin/phpcs --standard=phpcs.xml.dist
```

## AI Operations Documentation

This repository features a comprehensive AI-assisted development system designed for GitHub Copilot and other AI coding assistants.

### Quick Reference

| Component | Count | Purpose | Usage | Activation |
|-----------|-------|---------|-------|------------|
| **[Instructions](.github/instructions/instructions.md)** | 30+ files | Auto-applied coding standards | Automatic - no action needed | File pattern match |
| **[Prompts](.github/prompts/prompts.md)** | 29 templates | One-shot task templates | `@workspace Use [prompt-name] prompt` | On-demand |
| **[Agents](.github/agents/agent.md)** | 6 agents | Automated workflows | `@workspace Use [agent-name] agent` | On-demand |
| **[Chat Modes](.github/chatmodes/chatmodes.md)** | 20 modes | Interactive workflows | `@workspace Switch to [mode-name] mode` | On-demand |

### Component Details by Category

#### Instructions (Auto-Applied)

| Category | Files | Applied To | Standards |
|----------|-------|------------|-----------|
| **Coding Standards** | 3 | All code files | WPCS, General |
| **Language-Specific** | 4 | PHP, JS, TS, React | Language rules |
| **WordPress** | 4+ | Blocks, themes, patterns | Block API v3 |
| **Quality** | 5 | All files | WCAG AA, Security, i18n |
| **Process** | 5 | Docs, tests, PRs | Documentation |
| **CI/CD** | 5 | Workflows, releases | GitHub Actions |

[View all instructions →](.github/instructions/instructions.md)

#### Prompts (One-Shot Templates)

| Category | Templates | Purpose | Best Model |
|----------|-----------|---------|------------|
| **Accessibility** | 2 | WCAG audits, fixes | Claude |
| **Block Development** | 3 | Scaffolding, patterns | Gemini |
| **Code Quality** | 3 | Reviews, audits | Claude |
| **Refactoring** | 4 | Code modernization | Claude |
| **Testing** | 3 | Unit, E2E tests | Gemini |
| **Theme & Styling** | 4 | Theme.json, styling | Claude |
| **Workflow** | 8 | CI/CD, planning | Gemini |

[View all prompts →](.github/prompts/prompts.md)

#### Agents (Automated Workflows)

| Category | Agents | Complexity | Best Model |
|----------|--------|------------|------------|
| **Accessibility** | 3 | Simple-Complex | Claude |
| **Block Development** | 4 | Medium-Complex | Claude |
| **CI/CD & Quality** | 2 | Medium | Gemini |

[View all agents →](.github/agents/agent.md)

#### Chat Modes (Interactive Workflows)

| Category | Modes | Workflow Type | Best Model |
|----------|-------|---------------|------------|
| **Accessibility** | 2 | Linear, Interactive | Claude |
| **Block & Theme** | 4 | Step-by-step | Claude, Gemini |
| **Code Quality** | 3 | Checklist, Deep dive | Claude |
| **Documentation** | 3 | Linear, Interactive | Claude, Gemini |
| **CI/CD & Release** | 3 | Diagnostic, Guided | Gemini, Claude |
| **Testing & Support** | 4 | Tutorial, Q&A | Gemini, Claude |
| **WooCommerce** | 1 | Step-by-step | Claude |

[View all chat modes →](.github/chatmodes/chatmodes.md)

### Core Documentation

- **[AGENTS.md](AGENTS.md)** - Root-level AI operations overview and system architecture
- **[Custom Instructions](.github/custom-instructions.md)** - Main GitHub Copilot configuration
- **[Instructions](.github/instructions/instructions.md)** - Auto-applied coding standards (30+ files)
- **[Prompts](.github/prompts/prompts.md)** - Reusable task templates (29 prompts)
- **[Agents](.github/agents/agent.md)** - Specialized AI agents (50+ agents)
- **[Chat Modes](.github/chatmodes/chatmodes.md)** - Interactive workflows (20 modes)

### AI Model-Specific Guides

- **[CLAUDE.md](CLAUDE.md)** - Anthropic Claude optimization guide
  - Best for: Architecture, refactoring, accessibility, code reviews
  - Context: 200K tokens
  - Strengths: Accuracy, deep analysis, structured reasoning
  
- **[GEMINI.md](GEMINI.md)** - Google Gemini optimization guide
  - Best for: Scaffolding, prototypes, testing, quick iterations
  - Context: 1M tokens
  - Strengths: Speed, massive context, multimodal capabilities

### Development Documentation

- **[docs/](docs/)** - Comprehensive development guides and references
  - [WordPress Packages Setup](docs/WORDPRESS-PACKAGES-SETUP.md)
  - [WordPress Packages Guide](docs/wordpress-packages.md)
  - [Playwright Testing Guide](docs/playwright-testing-guide.md)
  - [Block Development](docs/block-development/)
  - [Coding Standards](docs/coding-standards/)

### Configuration Files

All configuration files use `.cjs` extension for explicit CommonJS module format:

- `.babel.config.cjs` - Babel transpilation with WordPress preset
- `.jest.config.cjs` - Jest unit testing configuration
- `webpack.config.js` - Webpack build configuration
- `.stylelint.config.cjs` - CSS/SCSS linting with WordPress standards
- `.playwright.config.cjs` - End-to-end testing configuration
- `.prettierrc.cjs` - Code formatting with WordPress preset
- `.eslintrc` - JavaScript linting with @wordpress/eslint-plugin
- `phpcs.xml.dist` - PHP_CodeSniffer configuration

### Repository Structure

```
tour-operator/
├── src/                    # Source files (JS, SCSS, blocks)
│   ├── blocks/            # Gutenberg blocks
│   ├── css/               # SCSS stylesheets
│   └── js/                # JavaScript modules
├── includes/              # PHP classes and functions
│   ├── classes/           # Core plugin classes
│   ├── metaboxes/         # CMB2 metabox configurations
│   ├── patterns/          # Block pattern definitions
│   └── template-tags/     # Template helper functions
├── templates/             # Block theme templates
├── build/                 # Compiled assets (generated)
├── tests/                 # Test suites
│   ├── php/              # PHPUnit tests
│   ├── js/               # Jest unit tests
│   └── e2e/              # Playwright E2E tests
├── .github/               # GitHub configuration
│   ├── agents/           # AI agents (50+)
│   ├── chatmodes/        # Chat modes (20)
│   ├── instructions/     # Coding standards (30+)
│   ├── prompts/          # Task templates (29)
│   ├── scripts/          # Automation scripts
│   └── workflows/        # CI/CD workflows
├── docs/                  # Documentation
└── vendor/                # Composer dependencies
```

## Development Workflow

### Getting Started

1. **Clone the repository**

   ```bash
   git clone https://github.com/lightspeedwp/tour-operator.git
   cd tour-operator
   ```

2. **Install dependencies**

   ```bash
   npm install
   composer install
   ```

3. **Start development**

   ```bash
   npm run start
   ```

4. **Run tests**

   ```bash
   npm run test:unit        # Jest unit tests
   npm run test:e2e         # Playwright E2E tests
   npm run test:php         # PHPUnit tests
   ```

5. **Lint and format**

   ```bash
   npm run lint:all         # All linters
   npm run format           # Format code
   ```

### Available Scripts

#### Building

- `npm run build` - Production build
- `npm run start` - Development build with watch mode
- `npm run build-pot` - Generate translation file

#### Testing

- `npm run test` - Run PHP and E2E tests
- `npm run test:unit` - Jest unit tests
- `npm run test:unit:watch` - Jest in watch mode
- `npm run test:unit:coverage` - Jest with coverage
- `npm run test:e2e` - Playwright E2E tests
- `npm run test:e2e:ui` - Playwright with UI
- `npm run test:e2e:debug` - Playwright debug mode
- `npm run test:php` - PHPUnit tests

#### Linting

- `npm run lint:all` - Run all linters
- `npm run lint:js` - ESLint for JavaScript
- `npm run lint:js:fix` - ESLint with auto-fix
- `npm run lint:css` - Stylelint for CSS/SCSS
- `npm run lint:css:fix` - Stylelint with auto-fix
- `npm run lint:php` - PHPCS for PHP
- `npm run lint:php:fix` - PHPCBF auto-fix
- `npm run lint:pkg-json` - Validate package.json

#### Formatting

- `npm run format` - Format PHP and JS
- `npm run format:js` - Prettier for JavaScript

### Using AI Operations

#### For Quick Tasks

Use **prompts** for one-shot tasks:

```
@workspace Use the create-gutenberg-block prompt to scaffold a new tour-card block
```

#### For Complex Workflows  

Use **agents** for automated execution:

```
@workspace Use the accessibility-auditor agent to check WCAG 2.2 AA compliance
```

#### For Interactive Development

Use **chat modes** for guided workflows:

```
@workspace Switch to pattern-wizard mode to create a new block pattern
```

#### Automatic Standards

**Instructions** are automatically applied based on file type - no action needed!

### Code Review Checklist

Before submitting a PR, ensure:

- [ ] Code follows [WordPress Coding Standards](docs/coding-standards/)
- [ ] All tests pass (`npm run test`)
- [ ] Linters pass (`npm run lint:all`)
- [ ] Code is properly formatted (`npm run format`)
- [ ] Accessibility tested (WCAG 2.2 AA)
- [ ] Security best practices followed
- [ ] Documentation updated
- [ ] Changelog entry added

See [Custom Instructions](.github/custom-instructions.md#code-review-guide) for complete checklist.

## Contributing

We welcome contributions! Please follow these steps:

1. **Fork the repository**
2. **Create a feature branch**

   ```bash
   git checkout -b feature/your-feature-name
   ```

3. **Make your changes**
   - Follow coding standards
   - Add tests for new features
   - Update documentation

4. **Test thoroughly**

   ```bash
   npm run lint:all
   npm run test
   ```

5. **Commit with clear messages**

   ```bash
   git commit -m "feat: add tour card block"
   ```

6. **Push and create PR**

   ```bash
   git push origin feature/your-feature-name
   ```

See [Branching Policy](.github/custom-instructions.md#branching-policy) for details.

## Support

- **Issues**: [GitHub Issues](https://github.com/lightspeedwp/tour-operator/issues)
- **Documentation**: [docs/](docs/)
- **WordPress Support**: [WordPress.org Forums](https://wordpress.org/support/plugin/tour-operator)

## License

This plugin is licensed under the GPL v2 or later.

## Changelog

See [changelog.md](changelog.md) for detailed version history.

## Credits

### Core Team

- **LightSpeed** - Development and maintenance

### WordPress Packages

Built with [@wordpress/scripts](https://developer.wordpress.org/block-editor/packages/packages-scripts/) and WordPress development tools.

### Open Source

This plugin uses the following open source packages:

- CMB2 - Custom metaboxes
- Playwright - E2E testing
- Jest - Unit testing
- Babel - JavaScript compilation
- Webpack - Asset bundling

---

**Version:** 2.1.0  
**Requires WordPress:** 6.0+  
**Requires PHP:** 7.4+  
**License:** GPL v2 or later  
**Text Domain:** tour-operator

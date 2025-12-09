# Tour Operator Development Instructions

Automatically applied coding standards and development guidelines.

## Quick Navigation

### Main Documentation

- **[← Back to README](../../README.md)**
- **[AGENTS.md](../../AGENTS.md)** - Root-level AI operations overview
- **[Custom Instructions](../custom-instructions.md)** - Main Copilot configuration

### AI Operations Components

- **[Prompts](../prompts/prompts.md)** - Task templates (29 prompts)
- **[Agents](../agents/agent.md)** - Specialized agents (50+ agents)
- **[Chat Modes](../chatmodes/chatmodes.md)** - Interactive workflows (20 modes)

### AI Model Guides

- **[CLAUDE.md](../../CLAUDE.md)** - Claude optimization and best practices
- **[GEMINI.md](../../GEMINI.md)** - Gemini optimization and best practices

### Development Resources

- **[WordPress Packages](../../docs/wordpress-packages.md)** - Complete package reference
- **[Testing Guide](../../docs/playwright-testing-guide.md)** - E2E testing with Playwright
- **[Coding Standards](../../docs/coding-standards/)** - Style guides and conventions

## About Instructions

Instructions are automatically applied to relevant files based on the `applyTo` pattern. They ensure:

- Consistent coding standards
- Best practice enforcement
- Security and accessibility compliance
- WordPress compatibility

## Core Standards

### Coding Standards

General coding standards and WordPress-specific guidelines.

| Instruction | Applies To | Purpose | Priority |
|-------------|------------|---------|----------|
| **coding-standards** | `**/*.php, **/*.js, **/*.css` | General coding standards | High |
| **wpcs** | `**/*.php` | WordPress Coding Standards | High |
| **development-guidelines** | `**/*` | Development best practices | High |

### Language-Specific

Language-specific coding standards and patterns.

| Instruction | Applies To | Language | Frameworks |
|-------------|------------|----------|------------|
| **php** | `**/*.php` | PHP 7.4+ | WordPress |
| **php-wordpress** | `**/*.php` | PHP | WordPress APIs |
| **js-ts** | `**/*.js, **/*.ts` | JavaScript/TypeScript | ES6+ |
| **javascript-react** | `**/*.jsx, **/*.tsx` | React | @wordpress/element |

### WordPress Standards

WordPress-specific standards for blocks, themes, and patterns.

| Instruction | Applies To | Purpose | Block API |
|-------------|------------|---------|----------|
| **block-json** | `**/block.json` | Block.json specifications | v3 |
| **block-theme-structure** | `templates/**, patterns/**` | Block theme structure | v3 |
| **patterns** | `includes/patterns/**` | Block pattern standards | v3 |
| **pattern-*** | Specific patterns | Pattern-specific guidelines | v3 |

### Quality & Compliance

Accessibility, security, performance, and internationalization standards.

| Instruction | Applies To | Standard | Level |
|-------------|------------|----------|-------|
| **accessibility** | `**/*.php, **/*.js` | WCAG 2.2 | AA |
| **security** | `**/*.php` | Security best practices | OWASP |
| **wp-security** | `**/*.php` | WordPress-specific security | Core |
| **performance** | `**/*.php, **/*.js` | Performance optimization | High |
| **i18n** | `**/*.php, **/*.js` | Internationalization | Required |

### Process & Documentation

Documentation, testing, and code review standards.

| Instruction | Applies To | Purpose | Format |
|-------------|------------|---------|--------|
| **docs** | `**/*.md` | Documentation standards | Markdown |
| **testing** | `tests/**` | Testing requirements | PHPUnit, Jest, Playwright |
| **review** | All files | Code review guidelines | Checklist |
| **reviews** | All files | Review checklist | Process |
| **pr-writing** | Pull requests | PR description standards | Template |

### CI/CD & Governance

Continuous integration, deployment, and project governance.

| Instruction | Applies To | Purpose | Platform |
|-------------|------------|---------|----------|
| **ci** | `.github/workflows/**` | Continuous integration | GitHub Actions |
| **ci-cd** | `.github/workflows/**` | CI/CD pipelines | GitHub Actions |
| **gitops** | `.github/**` | GitOps workflows | GitHub |
| **governance** | All files | Project governance | Standards |
| **release** | All files | Release process | Semantic Versioning |

## Instruction Format

```markdown
---
description: 'Brief instruction description'
applyTo: '**/*.php, **/*.js'
---

# Instruction Title

## Rules
- Rule 1
- Rule 2
```

## How Instructions Work

Instructions are automatically applied when:

1. File matches the `applyTo` pattern
2. GitHub Copilot processes the file
3. Instructions guide code generation

## Related Resources

### Understanding Instructions

- **[AGENTS.md](../../AGENTS.md)** - How instructions auto-apply
- **[Custom Instructions](../custom-instructions.md)** - System configuration
- **[CLAUDE.md](../../CLAUDE.md)** - Claude with auto-instructions
- **[GEMINI.md](../../GEMINI.md)** - Gemini with auto-instructions

### Active Development Tools

- **[Prompts](../prompts/prompts.md)** - Task templates using these standards
- **[Agents](../agents/agent.md)** - Automated workflows enforcing standards
- **[Chat Modes](../chatmodes/chatmodes.md)** - Interactive guided development

### Development Resources

- **[WordPress Packages](../../docs/wordpress-packages.md)** - Package reference
- **[Testing Guide](../../docs/playwright-testing-guide.md)** - E2E testing standards
- **[Coding Standards](../../docs/coding-standards/)** - Detailed style guides

### Instruction Categories

**Core Standards**: coding-standards, wpcs, development-guidelines  
**Languages**: php, php-wordpress, js-ts, javascript-react  
**WordPress**: block-json, block-theme-structure, patterns, pattern-*  
**Quality**: accessibility, security, wp-security, performance, i18n  
**Process**: docs, testing, review, reviews, pr-writing  
**CI/CD**: ci, ci-cd, gitops, governance, release

For complete instruction list, see sections below.

# Tour Operator Prompt Library

Reusable prompt templates for common development tasks.

## Quick Navigation

### Main Documentation

- **[← Back to README](../../README.md)**
- **[AGENTS.md](../../AGENTS.md)** - Root-level AI operations overview
- **[Custom Instructions](../custom-instructions.md)** - Main Copilot configuration

### AI Operations Components

- **[Instructions](../instructions/instructions.md)** - Auto-applied coding standards (30+ files)
- **[Agents](../agents/agent.md)** - Specialized agents (50+ agents)
- **[Chat Modes](../chatmodes/chatmodes.md)** - Interactive workflows (20 modes)

### AI Model Guides

- **[CLAUDE.md](../../CLAUDE.md)** - Claude optimization and best practices
- **[GEMINI.md](../../GEMINI.md)** - Gemini optimization and best practices

### Development Resources

- **[WordPress Packages](../../docs/wordpress-packages.md)** - Complete package reference
- **[Testing Guide](../../docs/playwright-testing-guide.md)** - E2E testing with Playwright
- **[Coding Standards](../../docs/coding-standards/)** - Style guides and conventions

## About Prompts

Prompts are task-specific templates that provide:

- Clear task descriptions
- Expected outputs
- Best practices
- Usage examples

Unlike chat modes (multi-turn) or agents (automated), prompts are one-shot templates.

## Available Prompts

### Accessibility

One-shot prompts for accessibility auditing and improvements.

| Prompt | Purpose | Input Required | Output | Best Model |
|--------|---------|----------------|--------|------------|
| **accessibility-audit** | WCAG 2.2 AA audits | File/component path | Audit report | Claude |
| **update-pattern-for-a11y** | Pattern accessibility improvements | Pattern file | Fixed pattern | Claude |

### Block Development

Prompts for scaffolding and generating WordPress blocks.

| Prompt | Purpose | Input Required | Output | Complexity |
|--------|---------|----------------|--------|------------|
| **create-gutenberg-block** | Complete block scaffolding | Block specs | Full block structure | Medium |
| **create-block-patterns** | Block pattern creation | Pattern specs | Pattern files | Simple |
| **block-json** | Block.json generation | Block metadata | block.json | Simple |

### Code Quality

Prompts for code review, analysis, and optimization.

| Prompt | Purpose | Input Required | Output | Best Model |
|--------|---------|----------------|--------|------------|
| **code-review** | Code review checklist | Code/PR | Review report | Claude |
| **bugfix-risk** | Risk analysis | Bug description | Risk assessment | Claude |
| **performance-audit** | Performance optimization | File/component | Optimization report | Claude |

### Documentation

Prompts for generating documentation.

| Prompt | Purpose | Input Required | Output | Format |
|--------|---------|----------------|--------|--------|
| **docs-writeup** | Documentation generation | Code/feature | Markdown docs | Markdown |

### Refactoring

Prompts for code refactoring and modernization.

| Prompt | Purpose | Input Required | Output | Best Model |
|--------|---------|----------------|--------|------------|
| **refactor-pattern** | Pattern refactoring | Pattern file | Refactored pattern | Claude |
| **refactor-plan** | Refactoring strategy | Codebase section | Refactor plan | Claude |
| **refactor-theme-json** | Theme.json refactoring | theme.json | Optimized theme.json | Claude |
| **refactor-to-sync-block** | Block synchronization | Block files | Synced blocks | Claude |

### Testing

Prompts for test generation and setup.

| Prompt | Purpose | Input Required | Output | Test Type |
|--------|---------|----------------|--------|----------|
| **playwright-e2e** | E2E test creation | Feature specs | Playwright tests | E2E |
| **write-phpunit-tests** | PHP unit tests | PHP class/function | PHPUnit tests | Unit |
| **phpunit-test** | PHPUnit test templates | Test requirements | Test template | Unit |

### Theme & Styling

Prompts for theme development and styling.

| Prompt | Purpose | Input Required | Output | Scope |
|--------|---------|----------------|--------|-------|
| **configure-theme-json** | Theme.json setup | Theme requirements | theme.json | Full |
| **add-theme-json-token** | Design token addition | Token specs | Updated theme.json | Single |
| **scaffold-block-theme** | Block theme scaffolding | Theme specs | Theme files | Full |
| **scaffold-hero** | Hero pattern creation | Hero specs | Hero pattern | Pattern |

### Workflow & Planning

Prompts for workflow automation and project planning.

| Prompt | Purpose | Input Required | Output | Best Model |
|--------|---------|----------------|--------|------------|
| **pattern-authoring** | Pattern authoring guide | Pattern type | Authoring guide | Claude |
| **ci-workflow** | CI/CD workflow setup | Project specs | Workflow YAML | Gemini |
| **generate-changelog** | Changelog generation | Commits/PRs | CHANGELOG.md | Gemini |
| **generate-pr-description** | PR description template | PR changes | PR description | Gemini |
| **query-loop-grid** | Query loop patterns | Query specs | Query pattern | Gemini |
| **php-render-callback** | Render callbacks | Block specs | Render callback | Claude |
| **starter-page** | Page templates | Page specs | Template files | Gemini |
| **wordpress-hooks** | WordPress hooks | Hook requirements | Hook implementation | Claude |

## Prompt Structure

```markdown
---
description: 'Prompt description'
mode: 'ask'
tools: ['tool1', 'tool2']
model: 'preferred-model'
---

# Prompt Title

## Objective
Clear task description

## Requirements
- Requirement 1
- Requirement 2

## Output
Expected deliverable
```

## Usage

1. Choose the appropriate prompt
2. Provide required context
3. Receive complete solution

## Best Practices

- Include all relevant context
- Specify requirements clearly
- Review generated output
- Customize for your needs

## Related Resources

### Using Prompts Effectively

- **[AGENTS.md](../../AGENTS.md)** - When to use prompts vs agents
- **[Custom Instructions](../custom-instructions.md)** - Prompt activation
- **[CLAUDE.md](../../CLAUDE.md)** - Claude-optimized prompts
- **[GEMINI.md](../../GEMINI.md)** - Gemini-optimized prompts

### Complementary Tools

- **[Chat Modes](../chatmodes/chatmodes.md)** - Multi-turn interactive workflows
- **[Agents](../agents/agent.md)** - Automated execution of complex tasks
- **[Instructions](../instructions/instructions.md)** - Standards applied to prompt output

### Development Resources

- **[WordPress Packages](../../docs/wordpress-packages.md)** - Package usage in prompts
- **[Testing Guide](../../docs/playwright-testing-guide.md)** - Testing prompts
- **[Coding Standards](../../docs/coding-standards/)** - Standards for generated code

### Prompt Categories

**Accessibility**: accessibility-audit, update-pattern-for-a11y  
**Block Development**: create-gutenberg-block, create-block-patterns, block-json  
**Code Quality**: code-review, bugfix-risk, performance-audit  
**Documentation**: docs-writeup  
**Refactoring**: refactor-pattern, refactor-plan, refactor-theme-json, refactor-to-sync-block  
**Testing**: playwright-e2e, write-phpunit-tests, phpunit-test  
**Theme & Styling**: configure-theme-json, add-theme-json-token, scaffold-block-theme, scaffold-hero  
**Workflow**: pattern-authoring, ci-workflow, generate-changelog, generate-pr-description

For complete prompt descriptions, see sections below.

# Tour Operator Chat Modes

Interactive chat modes for guided development workflows.

## Quick Navigation

### Main Documentation

- **[← Back to README](../../README.md)**
- **[AGENTS.md](../../AGENTS.md)** - Root-level AI operations overview
- **[Custom Instructions](../custom-instructions.md)** - Main Copilot configuration

### AI Operations Components

- **[Instructions](../instructions/instructions.md)** - Auto-applied coding standards (30+ files)
- **[Prompts](../prompts/prompts.md)** - Task templates (29 prompts)
- **[Agents](../agents/agent.md)** - Specialized agents (50+ agents)

### AI Model Guides

- **[CLAUDE.md](../../CLAUDE.md)** - Claude optimization and best practices
- **[GEMINI.md](../../GEMINI.md)** - Gemini optimization and best practices

### Development Resources

- **[WordPress Packages](../../docs/wordpress-packages.md)** - Complete package reference
- **[Testing Guide](../../docs/playwright-testing-guide.md)** - E2E testing with Playwright
- **[Coding Standards](../../docs/coding-standards/)** - Style guides and conventions

## About Chat Modes

Chat modes provide guided, multi-turn conversations for complex development tasks. Each mode:

- Follows a specific workflow
- Asks clarifying questions
- Provides contextual guidance
- Generates complete solutions

## Available Chat Modes

### Accessibility

Interactive modes for accessibility compliance and testing.

| Chat Mode | Purpose | Workflow Type | Best Model | Turns |
|-----------|---------|---------------|------------|-------|
| **a11y** | Quick accessibility workflow | Linear | Claude | 3-5 |
| **accessibility-expert** | Expert accessibility guidance | Interactive | Claude | 5-10 |

### Block & Theme Development

Guided workflows for WordPress block and theme development.

| Chat Mode | Purpose | Workflow Type | Best Model | Output |
|-----------|---------|---------------|------------|--------|
| **block-plugin-developer** | Block plugin development | Step-by-step | Claude, Gemini | Complete plugin |
| **block-theme-developer** | Block theme development | Step-by-step | Claude | Theme files |
| **pattern-studio** | Pattern creation studio | Interactive | Gemini | Block patterns |
| **pattern-wizard** | Pattern wizard workflow | Guided | Claude | Pattern files |

### Code Quality & Review

Interactive code review and refactoring workflows.

| Chat Mode | Purpose | Workflow Type | Best Model | Focus |
|-----------|---------|---------------|------------|-------|
| **review** | Code review workflow | Checklist | Claude | PR review |
| **reviewer** | Comprehensive review mode | Deep dive | Claude | Quality |
| **refactor** | Code refactoring guidance | Interactive | Claude | Architecture |

### Documentation & Planning

Modes for documentation generation and project planning.

| Chat Mode | Purpose | Workflow Type | Best Model | Output |
|-----------|---------|---------------|------------|--------|
| **docs** | Documentation workflow | Linear | Claude, Gemini | Markdown docs |
| **planner** | Project planning mode | Interactive | Claude | Project plan |
| **scaffold** | Project scaffolding | Step-by-step | Gemini | File structure |

### CI/CD & Release

Workflows for continuous integration and release management.

| Chat Mode | Purpose | Workflow Type | Best Model | Integrations |
|-----------|---------|---------------|------------|-------------|
| **fix-ci** | CI troubleshooting | Diagnostic | Gemini | GitHub Actions |
| **pr-copilot** | Pull request assistance | Guided | Claude | GitHub PR |
| **release-copilot** | Release management | Checklist | Claude | Changelog |

### Testing & Support

Interactive modes for testing and learning.

| Chat Mode | Purpose | Workflow Type | Best Model | Focus |
|-----------|---------|---------------|------------|-------|
| **testing** | Testing workflow | Step-by-step | Gemini | Test suites |
| **test-coach** | Test writing guidance | Tutorial | Claude | TDD practices |
| **support** | Support mode | Q&A | Gemini | Quick help |
| **teacher** | Learning mode | Educational | Claude | Concepts |

### WooCommerce

Specialized mode for WooCommerce integration.

| Chat Mode | Purpose | Workflow Type | Best Model | Focus |
|-----------|---------|---------------|------------|-------|
| **woo** | WooCommerce integration | Step-by-step | Claude | E-commerce |

## Chat Mode Structure

```markdown
---
description: 'Chat mode description'
mode: 'ask'
tools: ['tool1', 'tool2']
model: 'claude-3.5-sonnet'
---

# Chat Mode Name

## Workflow
1. Step 1
2. Step 2
3. Step 3
```

## Usage

To activate a chat mode:

1. Reference the mode in chat
2. Follow the guided workflow
3. Provide requested information

## Related Resources

### Using Chat Modes Effectively

- **[AGENTS.md](../../AGENTS.md)** - When to use chat modes vs agents
- **[Custom Instructions](../custom-instructions.md)** - Chat mode activation
- **[CLAUDE.md](../../CLAUDE.md)** - Claude-optimized chat workflows
- **[GEMINI.md](../../GEMINI.md)** - Gemini-optimized chat workflows

### Complementary Tools

- **[Agents](../agents/agent.md)** - Automated specialized workflows
- **[Prompts](../prompts/prompts.md)** - One-shot prompt templates
- **[Instructions](../instructions/instructions.md)** - Auto-applied standards

### Development Resources

- **[WordPress Packages](../../docs/wordpress-packages.md)** - Package reference
- **[Testing Guide](../../docs/playwright-testing-guide.md)** - E2E testing
- **[Coding Standards](../../docs/coding-standards/)** - Style guides

### Chat Mode Categories

**Accessibility**: a11y, accessibility-expert  
**Block Development**: block-plugin-developer, block-theme-developer, pattern-studio, pattern-wizard  
**Code Quality**: review, reviewer, refactor  
**Documentation**: docs, planner, scaffold  
**CI/CD**: fix-ci, pr-copilot, release-copilot  
**Testing**: testing, test-coach  
**Other**: support, teacher, woo

For complete mode descriptions, see sections below.

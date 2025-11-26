# Tour Operator AI Agents

Specialized AI agents for automated development workflows.

## Quick Navigation

### Main Documentation
- **[← Back to README](../../README.md)**
- **[AGENTS.md](../../AGENTS.md)** - Root-level AI operations overview
- **[Custom Instructions](../custom-instructions.md)** - Main Copilot configuration

### AI Operations Components
- **[Instructions](../instructions/instructions.md)** - Auto-applied coding standards (30+ files)
- **[Prompts](../prompts/prompts.md)** - Task templates (29 prompts)
- **[Chat Modes](../chatmodes/chatmodes.md)** - Interactive workflows (20 modes)

### AI Model Guides
- **[CLAUDE.md](../../CLAUDE.md)** - Claude optimization and best practices
- **[GEMINI.md](../../GEMINI.md)** - Gemini optimization and best practices

### Development Resources
- **[WordPress Packages](../../docs/wordpress-packages.md)** - Complete package reference
- **[Testing Guide](../../docs/playwright-testing-guide.md)** - E2E testing with Playwright
- **[Coding Standards](../../docs/coding-standards/)** - Style guides and conventions

## About Agents

Agents are specialized AI assistants designed for specific development tasks. They combine:
- Domain expertise and context
- Predefined workflows and best practices
- Automated task execution capabilities

## Available Agents

### Accessibility Agents

Agents focused on WCAG 2.2 AA compliance and accessibility best practices.

| Agent | Purpose | Best Used With | Complexity |
|-------|---------|----------------|------------|
| **a11y-checker** | Automated accessibility scanning | Claude, Gemini | Simple |
| **a11y-reviewer** | Manual accessibility review workflows | Claude | Medium |
| **accessibility-auditor** | Comprehensive WCAG 2.2 AA audits | Claude | Complex |

### Block Development Agents

Agents for WordPress block development, architecture, and validation.

| Agent | Purpose | Best Used With | Output Type |
|-------|---------|----------------|-------------|
| **block-architect** | Block architecture design and planning | Claude | Architecture docs |
| **block-pattern-validator** | Validate block patterns for compliance | Gemini | Validation report |
| **block-patterns-planner** | Plan block pattern strategy | Claude | Planning docs |
| **block_audit** | Audit block code quality | Claude, Gemini | Audit report |

### CI/CD & Quality Agents

Agents for continuous integration, deployment, and code quality enforcement.

| Agent | Purpose | Best Used With | Integrations |
|-------|---------|----------------|-------------|
| **cicd-engineer** | CI/CD pipeline management | Gemini | GitHub Actions |
| **code-governor** | Code quality enforcement and governance | Claude | PHPCS, ESLint |

## Usage

Agents are automatically discovered by GitHub Copilot when:
1. Files use the `.agent.md` extension
2. Located in `.github/agents/` directory
3. Follow the agent format structure

## Agent Structure

```markdown
---
description: 'Brief agent description'
mode: 'agent'
---

# Agent Name

## Role
Agent's purpose and specialization.

## Core Responsibilities
- Task 1
- Task 2

## Implementation Guidelines
- Best practices
- Code patterns
```

## Related Resources

### Using Agents Effectively
- **[AGENTS.md](../../AGENTS.md)** - Complete usage guide with examples
- **[Custom Instructions](../custom-instructions.md)** - When agents auto-apply
- **[CLAUDE.md](../../CLAUDE.md)** - Claude-optimized agent workflows
- **[GEMINI.md](../../GEMINI.md)** - Gemini-optimized agent workflows

### Complementary Tools
- **[Chat Modes](../chatmodes/chatmodes.md)** - Interactive guided workflows
- **[Prompts](../prompts/prompts.md)** - Quick one-shot task templates
- **[Instructions](../instructions/instructions.md)** - Auto-applied coding standards

### Development Resources
- **[WordPress Packages](../../docs/wordpress-packages.md)** - Package reference
- **[Testing Guide](../../docs/playwright-testing-guide.md)** - E2E testing
- **[Coding Standards](../../docs/coding-standards/)** - Style guides

### Agent Categories

**Accessibility**: a11y-checker, a11y-reviewer, accessibility-auditor
**Block Development**: block-architect, block-pattern-validator, block-patterns-planner, block_audit
**CI/CD**: cicd-engineer
**Code Quality**: code-governor

For complete agent list with descriptions, see sections below.

# Claude AI Guidelines for Tour Operator

Comprehensive guide for using Claude (Anthropic) with the Tour Operator WordPress plugin.

## Quick Navigation

### Main Documentation

- **[← Back to README](README.md)**
- **[AGENTS.md](AGENTS.md)** - AI operations system overview
- **[Custom Instructions](.github/custom-instructions.md)** - Copilot configuration

### AI Operations Components  

- **[Instructions](.github/instructions/instructions.md)** - Coding standards (30+ files)
- **[Prompts](.github/prompts/prompts.md)** - Task templates (29 prompts)
- **[Agents](.github/agents/agent.md)** - Specialized agents (50+ agents)
- **[Chat Modes](.github/chatmodes/chatmodes.md)** - Interactive workflows (20 modes)

### Related Guides

- **[GEMINI.md](GEMINI.md)** - Gemini (Google) optimization guide
- **[WordPress Packages](docs/wordpress-packages.md)** - Package usage guide
- **[Testing Guide](docs/playwright-testing-guide.md)** - E2E testing guide

## About This Guide

This document provides Claude-specific optimization strategies, prompt patterns, and best practices for Tour Operator development. Claude excels at complex refactoring, detailed analysis, and comprehensive documentation.

## Claude-Optimized Workflows

Claude excels at:

- Long-form documentation generation
- Complex code refactoring
- Detailed accessibility audits
- Architectural planning
- Multi-file code analysis

## Recommended Models

### Claude Sonnet 4.5 (GA - Recommended)

- **Best for**: General-purpose coding and agent tasks, complex problem-solving
- **Context window**: 200K tokens
- **Premium multiplier**: 1x
- **Capabilities**: Agent mode
- **Use cases**:
  - Block development
  - Large-scale refactoring
  - Comprehensive code reviews
  - Pattern creation and validation

### Claude Sonnet 4 (GA)

- **Best for**: Deep reasoning and debugging, balanced coding workflows
- **Context window**: 200K tokens
- **Premium multiplier**: 1x
- **Capabilities**: Agent mode, Vision
- **Use cases**:
  - Complex debugging
  - Architecture decisions
  - Visual UI analysis

### Claude Opus 4.5 (Preview)

- **Best for**: Most sophisticated reasoning and complex tasks
- **Context window**: 200K tokens
- **Premium multiplier**: 1x (3x after Dec 5, 2025)
- **Status**: Public Preview
- **Use cases**:
  - Critical production code
  - Complex architectural decisions
  - Mission-critical features

### Claude Opus 4.1 (GA)

- **Best for**: Anthropic's most powerful model for complex challenges
- **Context window**: 200K tokens
- **Premium multiplier**: 10x
- **Capabilities**: Reasoning, Vision
- **Use cases**:
  - Security audits
  - Accessibility compliance reviews
  - Production-critical code

### Claude Haiku 4.5 (GA)

- **Best for**: Fast help with simple or repetitive tasks
- **Context window**: 200K tokens
- **Premium multiplier**: 0.33x
- **Capabilities**: Agent mode
- **Use cases**:
  - Quick bug fixes
  - Simple documentation
  - Lightweight code explanations

## Claude-Optimized Prompts

Prompts that work exceptionally well with Claude's deep analysis capabilities.

### Recommended Prompts Table

| Prompt | Category | Complexity | Time | Why Claude |
|--------|----------|------------|------|------------|
| **accessibility-audit** | Accessibility | High | 5-10 min | Deep WCAG analysis |
| **update-pattern-for-a11y** | Accessibility | Medium | 3-5 min | Detailed fixes |
| **code-review** | Code Quality | High | 5-8 min | Comprehensive review |
| **bugfix-risk** | Code Quality | Medium | 2-4 min | Risk analysis |
| **performance-audit** | Code Quality | High | 5-7 min | Detailed optimization |
| **create-gutenberg-block** | Block Dev | Medium | 3-5 min | Complete structure |
| **create-block-patterns** | Block Dev | Medium | 3-4 min | Pattern creation |
| **block-json** | Block Dev | Low | 1-2 min | JSON generation |
| **refactor-plan** | Refactoring | High | 7-10 min | Strategic planning |
| **refactor-pattern** | Refactoring | High | 5-8 min | Pattern refactoring |
| **refactor-theme-json** | Refactoring | Medium | 3-5 min | Theme optimization |
| **docs-writeup** | Documentation | Medium | 4-6 min | Long-form docs |
| **generate-pr-description** | Workflow | Low | 1-2 min | PR descriptions |
| **php-render-callback** | Workflow | Medium | 3-4 min | Complex logic |
| **wordpress-hooks** | Workflow | Medium | 3-4 min | Hook implementation |

### Prompt Selection Guide

**Use Claude for prompts requiring:**

- Deep analysis and reasoning
- Comprehensive code reviews
- Strategic refactoring plans
- Detailed accessibility audits
- Long-form documentation
- Complex architecture decisions

[View all prompts →](.github/prompts/prompts.md)

## Claude-Optimized Agents

Agents that leverage Claude's strengths in accuracy and deep analysis.

### Recommended Agents Table

| Agent | Category | Why Claude | Complexity | Output Quality |
|-------|----------|------------|------------|----------------|
| **accessibility-auditor** | Accessibility | Comprehensive WCAG analysis | High | Excellent |
| **a11y-reviewer** | Accessibility | Manual review workflows | Medium | Excellent |
| **block-architect** | Block Dev | Architecture design | High | Excellent |
| **block-patterns-planner** | Block Dev | Strategic planning | Medium | Excellent |
| **code-governor** | Quality | Code quality enforcement | Medium | Excellent |
| **block_audit** | Block Dev | Quality auditing | Medium | Very Good |

### Agent Selection Guide

**Use Claude for agents requiring:**

- Highest accuracy and precision
- Complex architectural decisions
- Comprehensive audits and reviews
- Strategic planning and analysis
- Production-critical operations

[View all agents →](.github/agents/agent.md)

## Claude-Optimized Chat Modes

Chat modes that benefit from Claude's conversational and analytical abilities.

### Recommended Chat Modes Table

| Chat Mode | Category | Workflow Type | Turns | Why Claude |
|-----------|----------|---------------|-------|------------|
| **accessibility-expert** | Accessibility | Interactive | 5-10 | Expert guidance |
| **block-plugin-developer** | Block Dev | Step-by-step | 8-12 | Complete plugin |
| **pattern-wizard** | Block Dev | Guided | 6-10 | Strategic patterns |
| **theme-developer** | Block Dev | Step-by-step | 8-12 | Complex themes |
| **review** | Code Quality | Checklist | 4-6 | Thorough review |
| **reviewer** | Code Quality | Deep dive | 8-12 | Comprehensive |
| **refactor** | Code Quality | Interactive | 6-10 | Complex refactoring |
| **docs** | Documentation | Linear | 4-6 | Quality docs |
| **teacher** | Documentation | Educational | 5-8 | Clear explanations |
| **pr-copilot** | CI/CD | Guided | 4-6 | Quality PRs |
| **release-copilot** | CI/CD | Checklist | 6-8 | Thorough release |

### Chat Mode Selection Guide

**Use Claude for chat modes requiring:**

- Deep conversational context
- Complex multi-step workflows
- Educational explanations
- Comprehensive planning
- Quality-focused outcomes

[View all chat modes →](.github/chatmodes/chatmodes.md)

## Best Practices

### 1. Leverage Long Context

```
Include multiple related files in a single prompt:
- src/blocks/tour-card/index.js
- src/blocks/tour-card/edit.js
- src/blocks/tour-card/block.json
```

### 2. Request Detailed Explanations

```
Explain the refactoring approach and provide:
1. Current issues
2. Proposed solution
3. Migration steps
4. Testing strategy
```

### 3. Use Structured Output

```
Provide the response in this format:
## Analysis
## Recommendations  
## Implementation
## Testing
```

### 4. Iterative Refinement

Claude works well with follow-up questions:

```
1. Initial: "Review this block for accessibility"
2. Follow-up: "Focus on keyboard navigation issues"
3. Final: "Provide the complete fixed code"
```

## Task-Specific Guidelines

### Accessibility Audits

```
Audit [file] for WCAG 2.2 AA compliance:
- Check semantic HTML structure
- Verify ARIA usage
- Test color contrast
- Validate keyboard navigation
- Assess screen reader compatibility

Provide:
1. Issues found (with severity)
2. Code snippets showing problems
3. Corrected implementations
4. Testing checklist
```

### Block Development

```
Create a new Gutenberg block:
- Name: [block name]
- Purpose: [description]
- Attributes: [list]
- Inner blocks: [yes/no]
- Dynamic rendering: [yes/no]

Include:
- Complete block.json
- Edit component with useBlockProps
- Save component or render callback
- Styles (editor.scss, style.scss)
- PHPUnit tests
- Playwright E2E tests
```

### Code Refactoring

```
Refactor [file/component] to:
- Follow WordPress coding standards
- Improve accessibility
- Optimize performance
- Use theme.json tokens
- Add proper documentation

Provide:
1. Current code analysis
2. Refactoring strategy
3. Complete refactored code
4. Migration notes
5. Breaking changes (if any)
```

## Integration with VS Code

### Copilot Chat

Use Claude through GitHub Copilot Chat:

```
@workspace /explain this block pattern
@workspace /fix accessibility issues in this component
@workspace /tests generate Playwright tests for this block
```

### Inline Suggestions

Claude powers contextual code suggestions based on:

- Current file content
- Project instructions
- Coding standards
- Recent changes

## Prompt Engineering Tips

### Be Specific

❌ Bad: "Make this better"
✅ Good: "Refactor this block to use theme.json tokens and improve accessibility"

### Provide Context

❌ Bad: "Fix the bug"
✅ Good: "Fix the JavaScript error in maps.js line 45 where coordinates are undefined"

### Request Complete Solutions

❌ Bad: "How do I do this?"
✅ Good: "Provide complete working code with tests and documentation"

### Use Checklists

```
Review this PR for:
- [ ] WordPress coding standards
- [ ] WCAG 2.2 AA compliance
- [ ] Security best practices
- [ ] Performance optimization
- [ ] Test coverage
- [ ] Documentation
```

## Common Workflows

### 1. New Feature Development

```
1. Use block-architect agent for planning
2. Use create-gutenberg-block prompt for scaffolding
3. Use accessibility-auditor for compliance
4. Use code-review prompt for quality check
```

### 2. Bug Fix

```
1. Use bugfix-risk prompt for analysis
2. Request fix with test cases
3. Use code-review for validation
```

### 3. Refactoring

```
1. Use refactor-plan prompt for strategy
2. Use refactor-pattern for implementation
3. Use write-phpunit-tests for validation
```

## Limitations & Considerations

### Token Limits

- Response length: ~4000 tokens
- Break large tasks into smaller steps
- Request specific files when needed

### Code Generation

- Always review generated code
- Test thoroughly before committing
- Verify WordPress coding standards
- Check for security vulnerabilities

### Context Awareness

- Claude uses repository instructions automatically
- Reference specific files for better context
- Provide error messages for debugging

## Resources

- [Anthropic Documentation](https://docs.anthropic.com/)
- [Claude Best Practices](https://docs.anthropic.com/claude/docs/prompt-engineering)
- [GitHub Copilot with Claude](https://docs.github.com/copilot)
- [Tour Operator Docs](docs/)
- [WordPress Block Editor](https://developer.wordpress.org/block-editor/)

## Comparison: Claude vs Gemini

### Use Claude When You Need

✅ **Highest Accuracy**

- Critical production code
- Security-sensitive features
- Complex refactoring

✅ **Deep Analysis**

- Comprehensive code reviews
- Architectural planning
- Detailed accessibility audits

✅ **Structured Output**

- Long-form documentation
- Step-by-step guides
- Detailed explanations

✅ **Best For**

- Block architecture design
- Complex pattern refactoring
- WCAG compliance reviews
- Production-critical features

### Use Gemini When You Need

✅ **Massive Context**

- Full repository analysis (1-2M tokens)
- Multi-file operations
- Large-scale refactoring

✅ **Speed**

- Rapid prototyping
- Quick iterations
- Fast responses

✅ **Multimodal**

- Design mockup analysis
- Visual bug reports
- Screenshot-based tasks

✅ **Best For**

- Fast block scaffolding
- Quick bug fixes
- Prototype development
- Visual content tasks

### Recommendation

**For Tour Operator Development:**

- **Use Claude Sonnet 4.5 for**: Architecture, refactoring, accessibility, reviews
- **Use Gemini 2.5 Pro for**: Scaffolding, prototypes, testing, documentation
- **Use both**: Complex features benefit from both - Claude for planning, Gemini for implementation

See [GEMINI.md](GEMINI.md) for Gemini-specific guidance.

## Getting Help

If Claude's responses aren't meeting expectations:

1. **Refine your prompt**: Be more specific about requirements
2. **Provide more context**: Include related files and dependencies
3. **Break down the task**: Split complex tasks into smaller steps
4. **Use appropriate agents**: Leverage specialized agents for complex workflows
5. **Try different models**: Switch between Sonnet/Opus/Haiku based on task complexity
6. **Reference instructions**: Point to specific [instruction files](../.github/instructions/instructions.md)
7. **Check examples**: Review [prompt templates](../.github/prompts/prompts.md) for patterns

### Common Issues

**"Code doesn't follow WordPress standards"**
→ Reference [coding-standards.instructions.md](../.github/instructions/coding-standards.instructions.md)

**"Missing accessibility features"**
→ Use [accessibility-auditor.agent.md](../.github/agents/accessibility-auditor.agent.md)

**"Need better structure"**
→ Use [block-architect.agent.md](../.github/agents/block-architect.agent.md)

**"Complex refactoring needed"**
→ Use [refactor.chatmode.md](../.github/chatmodes/refactor.chatmode.md)

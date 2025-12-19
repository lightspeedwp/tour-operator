# GPT-5 / GPT-5.1 Guidelines for Tour Operator

Comprehensive guide for using OpenAI GPT-5 series models with the Tour Operator WordPress plugin.

## Quick Navigation

### Main Documentation

- **[← Back to README](README.md)**
- **[AGENTS.md](AGENTS.md)** - AI operations system overview
- **[Custom Instructions](.github/custom-instructions.md)** - Copilot configuration

### AI Operations Components

- **[Instructions](.github/instructions/instructions.md)** - Coding standards
- **[Prompts](.github/prompts/prompts.md)** - Task templates
- **[Agents](.github/agents/agent.md)** - Specialized agents
- **[Chat Modes](.github/chatmodes/chatmodes.md)** - Interactive workflows

### Related Guides

- **[CLAUDE.md](CLAUDE.md)** - Claude (Anthropic) optimization
- **[GEMINI.md](GEMINI.md)** - Gemini (Google) optimization
- **[WordPress Packages](docs/wordpress-packages.md)** - Package reference

## About This Guide

This document provides GPT-5 series optimization strategies for Tour Operator development. GPT-5 excels at complex reasoning, multi-step planning, and architectural decisions.

## Model Comparison

### GPT-5.1 (Preview - Cutting Edge)

- **Best for**: Deep reasoning, multi-step problem solving, architecture-level analysis
- **Context window**: 128K tokens
- **Premium multiplier**: 1x
- **Capabilities**: Agent mode
- **Status**: Public Preview
- **Use cases**:
  - Complex architectural decisions
  - Performance optimization
  - Security audits
  - Multi-file refactoring

### GPT-5 (GA - Recommended for Deep Reasoning)

- **Best for**: Complex reasoning, code analysis, technical decision-making
- **Context window**: 128K tokens  
- **Premium multiplier**: 1x
- **Capabilities**: Reasoning
- **Use cases**:
  - Complex multi-step problem solving
  - Complex algorithm design
  - Strategic refactoring plans
  - Performance optimization strategies

### GPT-5 mini (GA - Recommended for Speed)

- **Best for**: Fast, accurate code completions and explanations
- **Context window**: 128K tokens
- **Premium multiplier**: 0x (included)
- **Capabilities**: Agent mode, Reasoning, Vision
- **Use cases**:
  - Quick bug fixes
  - Simple code generation
  - Inline suggestions

## GPT-Optimized Workflows

### 1. Complex Block Architecture

**Use GPT-5 for planning:**

```
Design the architecture for a booking system that includes:
- Tour selection with date picker
- Pricing calculation with seasonal rates
- Multi-step booking form
- Payment integration
- Booking confirmation

Provide:
1. Component breakdown
2. Data flow architecture
3. State management strategy
4. Integration points
5. Testing strategy
```

**Use GPT-5-Codex for implementation:**

```
Based on the architecture, implement the booking-form block:
- Use @wordpress/components
- Integrate with tour pricing API
- Handle validation
- Support theme.json styling
- Include accessibility features
```

### 2. Performance Optimization

**Use o1 for analysis:**

```
Analyze tour listing performance issues:
- Current load time: 3.2s
- Database queries: 47 per page
- Largest contentful paint: 2.8s

Provide:
1. Performance bottleneck analysis
2. Optimization strategy
3. Implementation priorities
4. Expected improvements
```

**Use GPT-5-Codex for implementation:**

```
Implement caching strategy for tour listings:
- Use WordPress transient API
- Cache taxonomy queries
- Optimize meta queries
- Implement lazy loading
```

### 3. Multi-File Refactoring

**Use GPT-5-Codex with full context:**

```
Refactor tour booking system across:
- includes/classes/class-tour-booking.php
- includes/classes/class-tour-pricing.php
- includes/classes/class-booking-validation.php
- src/blocks/booking-form/index.js

Goals:
- Consolidate duplicate code
- Improve error handling
- Add comprehensive validation
- Enhance accessibility
```

## GPT-Optimized Prompts

### Recommended Prompts

| Prompt | Model | Why GPT | Complexity |
|--------|-------|---------|------------|
| **block-architect** | GPT-5 | Strategic architecture | Very High |
| **refactor-plan** | GPT-5 | Multi-step planning | High |
| **performance-audit** | GPT-5-Codex | Deep analysis | High |
| **security-audit** | GPT-5-Codex | Critical accuracy | High |
| **code-review** | GPT-5-Codex | Comprehensive review | Medium |
| **bugfix-risk** | GPT-5-Codex | Risk analysis | Medium |

[View all prompts →](.github/prompts/prompts.md)

## GPT-Optimized Agents

### Recommended Agents

| Agent | Model | Why GPT | Output |
|-------|-------|---------|--------|
| **block-architect** | GPT-5 | Complex architecture | Architecture docs |
| **code-governor** | GPT-5-Codex | Quality enforcement | Quality report |
| **block_audit** | GPT-5-Codex | Comprehensive audit | Audit report |

[View all agents →](.github/agents/agent.md)

## GPT-Optimized Chat Modes

### Recommended Chat Modes

| Mode | Model | Why GPT | Workflow |
|------|-------|---------|----------|
| **block-plugin-developer** | GPT-5-Codex | Complete plugin dev | 8-12 turns |
| **refactor** | GPT-5 | Complex refactoring | 6-10 turns |
| **review** | GPT-5-Codex | Thorough review | 4-6 turns |
| **reviewer** | GPT-5-Codex | Deep dive | 8-12 turns |

[View all chat modes →](.github/chatmodes/chatmodes.md)

## Best Practices

### 1. Leverage Deep Reasoning (GPT-5)

```
For architectural decisions:
1. Explain the problem completely
2. Include constraints and requirements
3. Request step-by-step reasoning
4. Ask for alternatives with trade-offs
```

### 2. Use Structured Prompts (GPT-5-Codex)

```
Provide response in this format:

## Problem Analysis
[Analysis of current state]

## Proposed Solution
[Detailed solution]

## Implementation Steps
1. Step 1
2. Step 2

## Testing Strategy
[How to validate]

## Potential Issues
[Edge cases and risks]
```

### 3. Multi-File Context

```
Include all related files in context:

Context files:
- src/blocks/tour-card/index.js
- src/blocks/tour-card/edit.js
- src/blocks/tour-card/block.json
- includes/blocks/class-tour-card.php

Task: Refactor for performance
```

### 4. Iterative Refinement

```
1. Initial: "Design booking form architecture"
2. Refine: "Add payment gateway integration"
3. Optimize: "Improve validation error handling"
4. Finalize: "Add comprehensive tests"
```

## Task-Specific Guidelines

### Block Architecture

```
Use GPT-5 for planning:

Design a tour search block with:
- Location-based filtering
- Date range picker
- Price range slider
- Tour type taxonomies
- Real-time search results

Requirements:
- Server-side rendering for SEO
- Client-side filtering for UX
- Accessible keyboard navigation
- Mobile-responsive design
- Performance: <100ms filter updates

Provide:
1. Component architecture
2. State management approach
3. API integration strategy
4. Accessibility considerations
5. Performance optimization plan
```

### Security Audit

```
Use GPT-5-Codex for analysis:

Audit booking system security:
- Payment processing
- User data handling
- Admin capabilities
- AJAX endpoints
- Nonce verification

Check for:
- SQL injection vulnerabilities
- XSS vulnerabilities
- CSRF protection
- Data sanitization
- Authorization checks

Provide:
1. Security issues found (with severity)
2. Exploitation scenarios
3. Fix recommendations
4. Testing checklist
```

### Performance Optimization

```
Use GPT-5 for strategy:

Optimize tour listing performance:

Current metrics:
- Load time: 3.2s
- TTFB: 800ms
- Database queries: 47
- Memory usage: 125MB

Goal metrics:
- Load time: <1.5s
- TTFB: <200ms
- Database queries: <15
- Memory usage: <64MB

Provide:
1. Performance analysis
2. Optimization strategy
3. Implementation priorities
4. Expected improvements
5. Monitoring approach
```

## Integration with VS Code

### GitHub Copilot

```
# Use GPT-5 mini for inline suggestions
# Copilot automatically uses GPT models for:
- Code completion
- Inline chat
- Quick fixes

# Specify model for complex tasks
@workspace /gpt-5 Refactor this booking system
```

### Copilot Chat

```
# Architecture planning with GPT-5
@workspace /gpt-5 Design the booking system architecture

# Implementation with GPT-5-Codex  
@workspace /gpt Implement the booking form component

# Quick fixes with Mini
@workspace /gpt-5-mini Fix this validation error
```

## Prompt Engineering Tips

### For GPT-5/GPT-5.1 (Reasoning Models)

✅ **Do:**

- Provide complete context upfront
- Ask for step-by-step reasoning
- Request alternatives and trade-offs
- Include constraints and requirements

❌ **Don't:**

- Rush the response (deep reasoning takes time)
- Provide partial context
- Ask for quick iterations

### For GPT-5-Codex (Code Production Model)

✅ **Do:**

- Use structured output formats
- Request code with comments
- Ask for complete implementations
- Include test requirements

❌ **Don't:**

- Assume context from previous unrelated chats
- Request creative variations (use GPT-5)
- Expect deep reasoning (use GPT-5)

### For GPT-5 mini (Fast Model)

✅ **Do:**

- Use for quick bug fixes
- Request simple code snippets
- Ask for straightforward explanations

❌ **Don't:**

- Use for complex architecture
- Expect comprehensive analysis
- Request multi-file refactoring

## Common Workflows

### 1. New Feature Development

```
Phase 1: Architecture (GPT-5)
- Design system architecture
- Plan component structure
- Define API contracts

Phase 2: Implementation (GPT-5-Codex)
- Scaffold components
- Implement business logic
- Add error handling

Phase 3: Optimization (GPT-5-Codex)
- Performance tuning
- Security hardening
- Accessibility improvements

Phase 4: Testing (GPT-5 mini)
- Generate unit tests
- Create E2E tests
- Write test documentation
```

### 2. Bug Investigation

```
Step 1: Analysis (GPT-5-Codex)
@workspace /gpt Analyze this bug:
- Error message: [paste error]
- Relevant code: [paste code]
- Steps to reproduce: [list steps]

Step 2: Root Cause (GPT-5 for complex bugs)
@workspace /gpt-5 Determine root cause considering:
- Database state
- User permissions
- Cache interactions
- Third-party integrations

Step 3: Fix Implementation (GPT-5-Codex)
@workspace /gpt Implement fix with:
- Code changes
- Tests
- Documentation
```

### 3. Code Review

```
Step 1: Automated Review (GPT-5-Codex)
@workspace /gpt Review this PR for:
- Code quality
- Security issues
- Performance concerns
- Accessibility compliance

Step 2: Architectural Review (GPT-5 for complex changes)
@workspace /gpt-5 Review architectural implications:
- System design impact
- Scalability concerns
- Maintenance burden
- Migration strategy
```

## Optimization Tips

### Faster Responses

- Use GPT-5 mini for simple tasks
- Provide focused context (not entire codebase)
- Use specific prompts
- Request code-only responses when appropriate

### Better Accuracy

- Use GPT-5 for complex reasoning
- Use GPT-5-Codex for production code
- Provide complete context
- Include relevant files
- Reference WordPress standards
- Validate with tests

### Cost Optimization

- Use GPT-5 mini for development iterations (0x multiplier)
- Use GPT-5-Codex for production code
- Use o1 only for complex planning
- Cache common responses
- Minimize context size

## Limitations & Considerations

### Model-Specific Limitations

**GPT-5.1 (Preview):**

- Slower responses (deep reasoning takes time)
- Best for planning, not rapid implementation
- 1x premium multiplier

**GPT-5:**

- Context limit: 128K tokens
- Best for complex reasoning and debugging
- Doesn't support Agent mode

**GPT-5-Codex:**

- Optimized for code, may be less creative
- 1x premium multiplier
- Great for complex engineering tasks

**GPT-5 mini:**

- Less capable with complex tasks
- May produce simpler solutions
- Best for straightforward problems
- 0x multiplier (free!)

### Code Quality

- Always review generated code
- Test thoroughly before committing
- Verify WordPress standards compliance
- Check security implications
- Validate accessibility

## Resources

- [OpenAI Platform](https://platform.openai.com/)
- [GPT-5 Documentation](https://platform.openai.com/docs/models)
- [GitHub Copilot AI Models](https://docs.github.com/en/copilot/reference/ai-models/supported-models)
- [AI Model Comparison](https://docs.github.com/en/copilot/reference/ai-models/model-comparison)
- [Tour Operator Docs](docs/)
- [WordPress Block Editor](https://developer.wordpress.org/block-editor/)

## Comparison Matrix

| Feature | GPT-5.1 | GPT-5 | GPT-5 mini | Gemini 2.5 Pro | Claude Sonnet 4.5 |
|---------|---------|-------|------------|----------------|-------------------|
| **Reasoning** | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐ | ⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ |
| **Speed** | ⭐⭐⭐ | ⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ | ⭐⭐⭐ |
| **Context** | 128K | 128K | 128K | 1M | 200K |
| **Multiplier** | 1x | 1x | 0x | 1x | 1x |
| **Code Quality** | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐ | ⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ |
| **Architecture** | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ | ⭐⭐⭐ | ⭐⭐⭐ | ⭐⭐⭐⭐ |
| **Scaffolding** | ⭐⭐⭐⭐ | ⭐⭐⭐⭐ | ⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ | ⭐⭐⭐ |
| **Agent Mode** | ✅ | ❌ | ✅ | ❌ | ✅ |
| **Vision** | ❌ | ❌ | ✅ | ✅ | ❌ |

### Use GPT When You Need

✅ **Complex Reasoning (GPT-5/5.1)**

- Architectural decisions
- Strategic planning
- Algorithm design
- System design

✅ **Production Code (GPT-5-Codex)**

- Complete implementations
- Security-critical features
- Performance optimization
- Multi-file refactoring

✅ **Quick Tasks (GPT-5 mini)**

- Bug fixes
- Simple features
- Code formatting
- Documentation updates

### Use Gemini When You Need

✅ **Speed & Context**

- Massive context (1-2M tokens)
- Rapid prototyping
- Batch operations
- Quick scaffolding

### Use Claude When You Need

✅ **Accuracy & Analysis**

- Accessibility audits
- Detailed reviews
- Code quality analysis
- Long-form documentation

## Getting Help

### Model Selection Confusion?

**Start here:**

1. Simple task → GPT-5 mini (0x multiplier!)
2. Standard implementation → GPT-5
3. Complex planning → GPT-5.1
4. Code-optimized → GPT-5-Codex
5. Need speed → Gemini 2.5 Pro
6. Need accuracy → Claude Sonnet 4.5

### Common Issues

**"GPT-5 is too slow"**
→ Use GPT-5 mini for implementation tasks

**"Need more complete code"**
→ Request explicit completeness, or use GPT-5-Codex

**"Need larger context"**
→ Use Gemini 2.5 Pro (1M tokens) or Gemini 3 Pro (2M tokens)

**"Need better accessibility analysis"**
→ Use Claude Sonnet 4.5 or Opus 4.1

**"Need faster iterations"**
→ Use Gemini 2.5 Pro or Claude Haiku 4.5

### Performance Tips

**Maximize Speed:**

- Use GPT-5 mini for development (0x multiplier)
- Use GPT-5-Codex for production
- Minimize context size
- Request code-only responses

**Maximize Quality:**

- Use GPT-5.1 for planning
- Use GPT-5-Codex for implementation
- Provide complete context
- Include test requirements
- Reference WordPress standards

**Balance Cost:**

- Use GPT-5 mini when possible (0x multiplier)
- Use GPT-5-Codex for most tasks (1x)
- Reserve GPT-5.1 for complex decisions
- Cache common responses

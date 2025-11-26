# Gemini AI Guidelines for Tour Operator

Comprehensive guide for using Google Gemini with the Tour Operator WordPress plugin.

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

- **[CLAUDE.md](CLAUDE.md)** - Claude (Anthropic) optimization guide
- **[WordPress Packages](docs/wordpress-packages.md)** - Package usage guide
- **[Testing Guide](docs/playwright-testing-guide.md)** - E2E testing guide

## About This Guide

This document provides Gemini-specific optimization strategies, prompt patterns, and best practices for Tour Operator development. Gemini excels at rapid prototyping, massive context windows (1M tokens), and multimodal tasks.

## Gemini-Optimized Workflows

Gemini excels at:

- Code generation with multiple languages
- Real-time code suggestions
- Visual content understanding (when using Gemini Vision)
- Quick iterations and prototyping
- Multi-modal tasks (code + screenshots)

## Recommended Models

### Gemini 2.5 Pro (GA - Recommended)

- **Best for**: Deep reasoning, complex code generation, debugging, research workflows
- **Context window**: 1M tokens
- **Premium multiplier**: 1x
- **Capabilities**: Reasoning, Vision
- **Use cases**:
  - Complex code analysis and debugging
  - Full repository analysis
  - Large-scale refactoring
  - Multi-file operations
  - Comprehensive documentation

### Gemini 3 Pro (Preview)

- **Best for**: Next-generation code generation and analysis
- **Context window**: 2M tokens
- **Premium multiplier**: 1x
- **Status**: Public Preview
- **Use cases**:
  - Next-gen code generation
  - Simple code generation
  - Fast prototyping
  - Inline suggestions

### Model Selection Tips

- **Gemini 2.5 Pro**: Use for most tasks - excellent balance of speed and capability
- **Gemini 3 Pro**: Use for cutting-edge features (Preview)
  - Complex architectural decisions
  - Advanced optimization

## Gemini-Optimized Prompts

Prompts that leverage Gemini's speed, massive context window (1M tokens), and rapid iteration.

### Recommended Prompts Table

| Prompt | Category | Speed | Context | Why Gemini |
|--------|----------|-------|---------|------------|
| **create-gutenberg-block** | Block Dev | Fast | Medium | Quick scaffolding |
| **create-block-patterns** | Block Dev | Fast | Medium | Pattern generation |
| **scaffold-hero** | Block Dev | Fast | Low | Hero patterns |
| **scaffold-footer** | Block Dev | Fast | Low | Footer patterns |
| **query-loop-grid** | Block Dev | Fast | Medium | Query patterns |
| **playwright-e2e** | Testing | Fast | High | Test generation |
| **write-phpunit-tests** | Testing | Fast | Medium | Unit tests |
| **write-jest-tests** | Testing | Fast | Medium | JS tests |
| **configure-theme-json** | Theme | Medium | High | Config generation |
| **update-pattern-for-a11y** | Accessibility | Fast | Medium | Quick a11y fixes |
| **generate-pr-description** | Workflow | Very Fast | Low | PR docs |
| **generate-changelog** | Workflow | Fast | High | Changelog |
| **create-custom-taxonomy** | Workflow | Fast | Low | Taxonomy scaffold |
| **create-custom-post-type** | Workflow | Fast | Low | CPT scaffold |
| **wordpress-hooks** | Workflow | Fast | Low | Hook implementation |

### Prompt Selection Guide

**Use Gemini for prompts requiring:**

- Fast code generation
- Quick scaffolding and prototyping
- Multi-file operations (1M token context)
- Test generation
- Rapid iteration and refinement
- Batch operations

[View all prompts →](.github/prompts/prompts.md)

## Gemini-Optimized Agents

Agents that benefit from Gemini's massive context window and rapid processing.

### Recommended Agents Table

| Agent | Category | Why Gemini | Speed | Context Size |
|-------|----------|------------|-------|-------------|
| **block-architect** | Block Dev | Full repo analysis | Medium | Very Large |
| **block-pattern-validator** | Block Dev | Batch validation | Fast | Large |
| **block-patterns-planner** | Block Dev | Multi-pattern planning | Medium | Large |
| **a11y-checker** | Accessibility | Quick scans | Fast | Medium |
| **block_audit** | Quality | Rapid auditing | Fast | Medium |
| **cicd-engineer** | CI/CD | Multi-file workflows | Medium | Large |

### Agent Selection Guide

**Use Gemini for agents requiring:**

- Processing entire repositories
- Batch operations across files
- Quick scans and validation
- High-volume processing
- Real-time feedback
- Cost-effective operations

[View all agents →](.github/agents/agent.md)

## Gemini-Optimized Chat Modes

Chat modes that leverage Gemini's rapid iteration and large context window.

### Recommended Chat Modes Table

| Chat Mode | Category | Workflow Type | Turns | Why Gemini |
|-----------|----------|---------------|-------|------------|
| **scaffold** | Block Dev | Quick | 3-5 | Fast scaffolding |
| **block-plugin-developer** | Block Dev | Step-by-step | 8-12 | Rapid development |
| **pattern-wizard** | Block Dev | Guided | 6-10 | Quick patterns |
| **testing** | Testing | Interactive | 5-8 | Fast test creation |
| **test-coach** | Testing | Educational | 4-6 | Quick guidance |
| **planner** | Documentation | Structured | 6-8 | Fast planning |
| **support** | Support | Q&A | 3-5 | Quick answers |
| **debugger** | Support | Problem-solving | 4-6 | Fast debugging |
| **fix-bug** | Support | Direct | 2-4 | Quick fixes |
| **cicd-release** | CI/CD | Checklist | 4-6 | Fast releases |
| **woocommerce-guru** | WooCommerce | Expert | 5-8 | Quick solutions |

### Chat Mode Selection Guide

**Use Gemini for chat modes requiring:**

- Quick iterations and responses
- Fast prototyping workflows
- High-volume interactions
- Real-time feedback loops
- Cost-effective operations
- Batch processing

[View all chat modes →](.github/chatmodes/chatmodes.md)

## Best Practices

### 1. Leverage Large Context Window

```
Gemini can process entire codebases:
- Include all related files
- Provide full context
- Reference multiple patterns simultaneously
```

### 2. Use Iterative Prompting

```
1. Start with high-level request
2. Refine based on output
3. Add specific requirements
4. Get final implementation
```

### 3. Multimodal Capabilities

```
When using Gemini Vision:
- Include screenshots of designs
- Reference visual examples
- Describe visual bugs with images
```

### 4. Code-First Responses

```
Request code directly:
"Generate the complete implementation with minimal explanation"
```

## Task-Specific Guidelines

### Rapid Prototyping

```
Create a quick prototype for:
- Feature: [description]
- Tech: WordPress blocks, React
- Style: theme.json tokens

Generate:
1. Working code (even if not perfect)
2. Basic styling
3. Simple test
```

### Block Development

```
Scaffold a Gutenberg block:
- Name: [name]
- Type: [static/dynamic]
- Features: [list]

Generate complete working code including:
- block.json with all metadata
- Edit component
- Save/render
- Styles
```

### Test Generation

```
Generate Playwright tests for [component]:
- Test user interactions
- Test edge cases
- Test accessibility
- Include assertions

Provide runnable test code.
```

### Documentation

```
Generate documentation for [feature]:
- User guide
- Developer notes
- Code examples
- Screenshots placeholders
```

## Integration with IDEs

### VS Code

Gemini integration through:

- Google Cloud Code extension
- GitHub Copilot (when supported)
- Custom integrations

### Google AI Studio

Use for:

- Prompt testing
- Model experimentation
- Fine-tuning prompts
- Batch processing

## Prompt Engineering Tips

### Start Broad, Then Narrow

```
1. "Create a tour listing block"
2. "Add filtering capabilities"
3. "Optimize for performance"
4. "Add accessibility features"
```

### Use Examples

```
Create a block similar to:
[paste example code]

But with these changes:
- [change 1]
- [change 2]
```

### Request Specific Formats

```
Provide output as:
- JSON for configuration
- PHP for server-side
- JSX for components
- SCSS for styles
```

### Be Explicit About Standards

```
Follow these standards:
- WordPress Coding Standards
- WCAG 2.2 AA
- ESLint rules
- Theme.json patterns
```

## Common Workflows

### 1. Feature Development

```
Gemini Flow:
1. Describe feature requirements
2. Get initial implementation
3. Iterate with specific improvements
4. Generate tests
5. Generate documentation
```

### 2. Debugging

```
Gemini Debugging:
1. Paste error message
2. Include relevant code
3. Get explanation + fix
4. Test solution
```

### 3. Code Review

```
Gemini Review:
1. Paste code/diff
2. Ask for review
3. Get suggestions
4. Apply improvements
```

## Advanced Features

### Function Calling

Gemini can call functions to:

- Run tests
- Check code style
- Validate accessibility
- Generate reports

### Code Execution

Gemini can execute code to:

- Verify solutions
- Test edge cases
- Validate output
- Debug issues

### Grounding with Google Search

Use for:

- Latest WordPress documentation
- Current best practices
- New API features
- Library updates

## Optimization Tips

### Faster Responses

- Use Gemini Flash for simple tasks
- Request code without explanations
- Batch similar requests
- Cache common prompts

### Better Accuracy

- Provide complete context
- Use specific examples
- Reference documentation
- Validate with tests

### Cost Optimization

- Use appropriate model size
- Reuse context when possible
- Minimize unnecessary context
- Cache responses

## Limitations & Considerations

### Code Quality

- Always review generated code
- Test thoroughly
- Verify WordPress standards
- Check security implications

### Context Management

- Even with 1M tokens, be selective
- Include only relevant files
- Clear context between tasks
- Structure prompts logically

### Multimodal Limitations

- Image analysis may vary
- Design interpretation is approximate
- Always verify visual output

## Resources

- [Google AI Studio](https://aistudio.google.com/)
- [Gemini API Documentation](https://ai.google.dev/)
- [Gemini Best Practices](https://ai.google.dev/docs/prompt_best_practices)
- [Google Cloud Code](https://cloud.google.com/code)
- [Tour Operator Docs](docs/)
- [WordPress Block Editor](https://developer.wordpress.org/block-editor/)

## Comparison: Gemini vs Claude

### Use Gemini When You Need

✅ **Massive Context**

- Full repository analysis (1-2M tokens)
- Multi-file operations
- Large-scale refactoring
- Processing entire codebases

✅ **Speed & Iteration**

- Rapid prototyping
- Quick iterations
- Fast responses
- Real-time suggestions

✅ **Multimodal Capabilities**

- Design mockup analysis
- Visual bug reports
- Screenshot-based development
- Image understanding

✅ **Cost Efficiency**

- 1x premium multiplier
- High-volume tasks
- Repeated operations
- Batch processing

✅ **Best For**

- Fast block scaffolding
- Quick bug fixes
- Prototype development
- Visual content tasks
- Test generation

### Use Claude When You Need

✅ **Highest Accuracy**

- Critical production code
- Security-sensitive features
- Complex refactoring
- Mission-critical features

✅ **Deep Analysis**

- Comprehensive code reviews
- Architectural planning
- Detailed accessibility audits
- Complex problem solving

✅ **Structured Reasoning**

- Long-form documentation
- Step-by-step guides
- Detailed explanations
- Technical writing

✅ **Best For**

- Block architecture design
- Complex pattern refactoring
- WCAG compliance reviews
- Production-critical features

### Recommendation

**For Tour Operator Development:**

- **Use Gemini 2.5 Pro for**: Scaffolding, prototypes, testing, quick iterations
- **Use Claude Sonnet 4.5 for**: Architecture, refactoring, accessibility, reviews
- **Use both**: Complex features benefit from both - Gemini for rapid development, Claude for refinement

See [CLAUDE.md](CLAUDE.md) for Claude-specific guidance.

## Getting Help

If Gemini's responses need improvement:

1. **Add more context**: Include related files and full repository context
2. **Be more specific**: Clarify exact requirements and expected output
3. **Provide examples**: Show desired output or similar code
4. **Try different model**: Switch between Gemini 2.5 Pro ↔ Gemini 3 Pro based on complexity
5. **Break down task**: Split large requests into smaller, focused tasks
6. **Use grounding**: Enable Google Search for latest information
7. **Reference docs**: Point to [WordPress packages](docs/wordpress-packages.md)
8. **Check instructions**: Review [coding standards](.github/instructions/instructions.md)

### Common Issues

**"Code is incomplete"**
→ Request complete implementation explicitly, use more context

**"Doesn't follow WordPress standards"**
→ Reference [coding-standards.instructions.md](.github/instructions/coding-standards.instructions.md)

**"Need faster responses"**
→ Use Gemini 2.5 Pro for most tasks

**"Complex architecture needed"**
→ Consider using [Claude Sonnet 4.5](CLAUDE.md) or [GPT-5](GPT.md)

**"Visual design interpretation"**
→ Use Gemini 2.5 Pro with screenshots (Vision capability)

### Performance Tips

**Maximize Speed**

- Use Gemini 2.5 Pro for most tasks
- Request code-only responses
- Minimize explanation text
- Batch similar requests

**Improve Accuracy**

- Use Gemini 3 Pro for cutting-edge features
- Provide complete context
- Include specific examples
- Reference documentation
- Validate with tests

**Optimize Costs**

- Both Gemini models have 1x multiplier
- Reuse context efficiently
- Cache common responses
- Minimize token usage

## Example Prompts

### Quick Block Creation

```
Create a tour-card block with:
- Tour title (editable)
- Featured image
- Price display  
- Book now button
- Uses theme.json colors

Generate complete working code.
```

### Bug Fix

```
Error in maps.js line 45:
[paste error]

Relevant code:
[paste code]

Fix and explain.
```

### Pattern Conversion

```
Convert this HTML to a block pattern:
[paste HTML]

Ensure:
- Proper block markup
- Accessibility
- Theme.json tokens
- i18n ready
```

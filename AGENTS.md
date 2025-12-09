# Tour Operator AI Operations Guide

Comprehensive guide to AI-assisted development for the Tour Operator WordPress plugin.

## Quick Navigation

### Tour Operator Documentation

- **[← Back to README](README.md)**
- **[Custom Instructions](.github/custom-instructions.md)** - Plugin-specific configuration
- **[Development Docs](docs/)** - Technical documentation

### Centralized AI Resources

- **[LightSpeed .github Repository](https://github.com/lightspeedwp/.github/tree/develop/.github)** - Shared AI operations
  - [Base Instructions](https://github.com/lightspeedwp/.github/tree/develop/.github/instructions/) - WordPress standards
  - [Base Prompts](https://github.com/lightspeedwp/.github/tree/develop/.github/prompts/) - Common task templates
  - [Base Agents](https://github.com/lightspeedwp/.github/tree/develop/.github/agents/) - Reusable workflows
  - [Base Chat Modes](https://github.com/lightspeedwp/.github/tree/develop/.github/chatmodes/) - Standard conversations

### Tour Operator Specific

- **[Plugin Instructions](.github/instructions/instructions.md)** - Tour Operator coding standards
- **[Plugin Prompts](.github/prompts/prompts.md)** - Tour-specific templates
- **[Plugin Agents](.github/agents/agent.md)** - Tour-specific workflows
- **[Plugin Chat Modes](.github/chatmodes/chatmodes.md)** - Tour-specific conversations

### AI Model Guides

- **[CLAUDE.md](CLAUDE.md)** - Claude optimization for Tour Operator
- **[GEMINI.md](GEMINI.md)** - Gemini optimization for Tour Operator
- **[GPT.md](GPT.md)** - GPT/o1 optimization for Tour Operator

## AI Operations System

Tour Operator uses a **two-tier AI system**:

### 1. Centralized Base Layer

Shared across all LightSpeed WordPress projects from [`lightspeedwp/.github`](https://github.com/lightspeedwp/.github):

- **Base Instructions**: WordPress coding standards, testing, security, gitops
- **Base Prompts**: Generic scaffolding, testing, documentation templates  
- **Base Agents**: Accessibility auditing, block validation, CI/CD management
- **Base Chat Modes**: Code review, refactoring, planning workflows

### 2. Plugin-Specific Layer

Tour Operator-specific resources in this repository:

- **Custom Instructions**: Tour post types, taxonomy handling, booking flows
- **Custom Prompts**: Tour card blocks, itinerary patterns, booking forms
- **Custom Agents**: Tour data validation, booking integration, pricing audits
- **Custom Chat Modes**: Tour feature development, accommodation setup

## Model Selection Guide

### Recommended Models by Task

#### GPT-5 / GPT-5.1 (OpenAI)

**Best for complex reasoning and multi-step planning**

✅ **Use for:**

- Block architecture design across tour/accommodation/destination
- Complex refactoring of legacy tour operator code
- Performance optimization for tour listing queries
- Security audits of booking and payment flows
- Multi-file analysis of tour data structures

❌ **Avoid for:**

- Quick bug fixes (use GPT-5 mini)
- Simple scaffolding tasks
- Rapid prototyping

**Context**: 128K tokens  
**Premium multiplier**: 1x  
**Models**: GPT-5 (reasoning), GPT-5.1 (preview), GPT-5-Codex (code-optimized)

#### Claude Sonnet 4.5 / Opus 4.1 (Anthropic)  

**Best for accuracy and detailed analysis**

✅ **Use for:**

- WCAG 2.2 AA accessibility audits
- Code quality reviews for tour blocks
- Pattern refactoring with explanations
- WordPress coding standards compliance
- Detailed documentation generation

❌ **Avoid for:**

- Large repository analysis (use Gemini)
- Speed-critical tasks (use Claude Haiku 4.5)

**Context**: 200K tokens  
**Premium multiplier**: 1x (Sonnet), 10x (Opus 4.1)  
**Models**: Claude Sonnet 4.5 (general), Claude Sonnet 4 (vision), Claude Opus 4.1/4.5 (complex)

#### Gemini 2.5 Pro / Gemini 3 Pro (Google)

**Best for speed and massive context**

✅ **Use for:**

- Rapid tour block scaffolding
- Quick bug fixes in booking flows
- PHPUnit/Playwright test generation
- Batch validation of tour patterns
- Full repository analysis (1-2M token context)
- Multi-pattern operations
- Complex debugging and research workflows

❌ **Avoid for:**

- Mission-critical security code (use GPT-5 or Claude Opus)

**Context**: 1M tokens (2.5 Pro), 2M tokens (3 Pro)  
**Premium multiplier**: 1x  
**Models**: Gemini 2.5 Pro (GA), Gemini 3 Pro (Preview)

### Task-Specific Recommendations

| Task | Primary Model | Fallback | Why |
|------|--------------|----------|-----|
| **Block Architecture** | GPT-5 | Claude Sonnet 4.5 | Multi-step reasoning |
| **Tour Card Block** | Gemini 2.5 Pro | GPT-5 mini | Fast scaffolding |
| **Accessibility Audit** | Claude Sonnet 4.5 | Claude Opus 4.1 | Detailed WCAG analysis |
| **Booking Flow Bug** | Gemini 2.5 Pro | GPT-5 mini | Quick diagnosis |
| **Performance Optimization** | GPT-5 | Claude Sonnet 4 | Deep analysis |
| **Test Generation** | Gemini 2.5 Pro | Claude Haiku 4.5 | Rapid test creation |
| **Security Review** | Claude Opus 4.1 | GPT-5 | Critical accuracy |
| **Pattern Refactoring** | Claude Sonnet 4.5 | GPT-5 | Detailed explanations |
| **Repository Analysis** | Gemini 2.5 Pro | Gemini 3 Pro | Massive context window |

## System Architecture

```
┌─────────────────────────────────────────────────────────────┐
│           Tour Operator AI Operations System                 │
├─────────────────────────────────────────────────────────────┤
│                                                               │
│  BASE LAYER (lightspeedwp/.github) - Always Active          │
│  ┌───────────────────────────────────────────────────────┐  │
│  │ • WordPress Coding Standards (WPCS)                   │  │
│  │ • Testing Standards (PHPUnit, Playwright, Jest)       │  │
│  │ • Security & Accessibility (WCAG 2.2 AA)             │  │
│  │ • GitOps & CI/CD (GitHub Actions)                     │  │
│  │ • Block API v3 Standards                              │  │
│  └───────────────────────────────────────────────────────┘  │
│                                                               │
│  PLUGIN LAYER (tour-operator) - Context-Specific            │
│  ┌───────────────────────────────────────────────────────┐  │
│  │ • Tour/Accommodation/Destination post types           │  │
│  │ • Booking & pricing systems                           │  │
│  │ • Itinerary & gallery patterns                       │  │
│  │ • Tour operator-specific blocks                       │  │
│  └───────────────────────────────────────────────────────┘  │
│                                                               │
└─────────────────────────────────────────────────────────────┘
```

## When to Use Each Resource

### Use Base Layer (lightspeedwp/.github) When

✅ Working with **standard WordPress patterns**:

- Generic block scaffolding
- Standard accessibility audits
- PHPCS/WPCS compliance
- CI/CD pipeline setup
- General code reviews

**Examples:**

```
@workspace Use create-gutenberg-block prompt from base
@workspace Use accessibility-auditor agent from base
@workspace Use wpcs instructions from base
```

### Use Plugin Layer (tour-operator) When

✅ Working with **tour operator-specific features**:

- Tour/accommodation custom post types
- Booking form implementations
- Itinerary block variations
- Tour pricing logic
- Destination hierarchies

**Examples:**

```
@workspace Use tour-card-block prompt
@workspace Use booking-flow-validator agent
@workspace Switch to tour-feature-planner mode
```

## Quick Reference

### Most Common Workflows

#### 1. Create New Tour Block

```
Model: Gemini 2.5 Pro
1. Use base create-gutenberg-block prompt
2. Apply tour-operator block instructions
3. Validate with block-pattern-validator agent
4. Test with Playwright
```

#### 2. Accessibility Audit

```

Model: Claude Sonnet 4.5

1. Use base accessibility-auditor agent
2. Apply tour-operator a11y standards
3. Review with accessibility-expert mode
4. Fix with update-pattern-for-a11y prompt

```

#### 3. Bug Fix in Booking Flow

```

Model: Gemini 2.5 Pro (fast) or GPT-5 (complex)

1. Use debugger chat mode
2. Apply tour-operator security instructions
3. Test with write-phpunit-tests prompt
4. Review with code-governor agent

```

#### 4. Refactor Legacy Tour Code

```

Model: GPT-5 (complex) or Claude Sonnet 4.5 (clarity)

1. Use refactor-plan prompt (base)
2. Apply tour-operator coding standards
3. Validate with code-governor agent
4. Document with docs-writeup prompt

```

## Integration Best Practices

### 1. Layer Inheritance

Plugin-specific resources **inherit and extend** base layer:

```markdown
# Base (lightspeedwp/.github)
wpcs.instructions.md → Applied to all WordPress projects

# Plugin Override (tour-operator)
tour-operator-wpcs.instructions.md → Adds tour-specific standards
```

### 2. Explicit References

Always specify which layer when ambiguous:

```
# Clear
@workspace Use base accessibility-auditor agent

# Ambiguous (might match both)
@workspace Use accessibility-auditor agent
```

### 3. Model Selection

Choose model based on task complexity and speed requirements:

```
# Fast scaffolding → Gemini 2.5 Pro
@workspace /gemini Use create-gutenberg-block for tour-card

# Complex architecture → GPT-5
@workspace /gpt Use block-architect agent for booking system

# Detailed review → Claude Sonnet 4.5
@workspace /claude Review this pattern for accessibility
```

## Getting Started

### For New Developers

1. **Familiarize with base layer**:
   - Read [base AGENTS.md](https://github.com/lightspeedwp/.github/blob/develop/AGENTS.md)
   - Review [base instructions](https://github.com/lightspeedwp/.github/tree/develop/.github/instructions/)

2. **Learn plugin-specific patterns**:
   - Read [tour-operator instructions](.github/instructions/instructions.md)
   - Review [existing tour blocks](src/blocks/)

3. **Choose your AI model**:
   - Read [model selection guide](#model-selection-guide) above
   - Review [GEMINI.md](GEMINI.md), [CLAUDE.md](CLAUDE.md), [GPT.md](GPT.md)

### For Contributors

1. **Check if resource should be base or plugin**:
   - Generic WordPress → Contribute to `lightspeedwp/.github`
   - Tour Operator-specific → Contribute to this repo

2. **Follow appropriate standards**:
   - Base: [base custom-instructions.md](https://github.com/lightspeedwp/.github/blob/develop/.github/custom-instructions.md)
   - Plugin: [custom-instructions.md](.github/custom-instructions.md)

## Resources

### Base Resources (lightspeedwp/.github)

- [Base AGENTS.md](https://github.com/lightspeedwp/.github/blob/develop/AGENTS.md)
- [Base Instructions](https://github.com/lightspeedwp/.github/tree/develop/.github/instructions/)
- [Base Prompts](https://github.com/lightspeedwp/.github/tree/develop/.github/prompts/)
- [Base Custom Instructions](https://github.com/lightspeedwp/.github/blob/develop/.github/custom-instructions.md)

### Plugin Resources (tour-operator)

- [Plugin Instructions](.github/instructions/instructions.md)
- [Plugin Prompts](.github/prompts/prompts.md)
- [Plugin Agents](.github/agents/agent.md)
- [WordPress Packages](docs/wordpress-packages.md)
- [Testing Guide](docs/playwright-testing-guide.md)

### Model-Specific Guides

- [Gemini 2.5/3 Guide](GEMINI.md) - Speed & massive context
- [Claude 4.x Guide](CLAUDE.md) - Accuracy & detailed analysis
- [GPT-5.x Guide](GPT.md) - Complex reasoning & planning

## Further Information

For tour operator-specific details:

- **[Custom Instructions](.github/custom-instructions.md)** - Plugin configuration
- **[Development Docs](docs/)** - Technical guides
- **[Coding Standards](docs/coding-standards/)** - Style guides

For general WordPress development:

- **[LightSpeed .github](https://github.com/lightspeedwp/.github)** - Shared resources
- **[WordPress Block Editor](https://developer.wordpress.org/block-editor/)** - Official docs

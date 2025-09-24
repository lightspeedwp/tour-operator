# Tour Operator Agents

This document outlines the custom GitHub Copilot agents available in this repository.

## Available Agents

### Core WordPress Agents

Located in `.github/agents/` folder, these agents provide specialized assistance for Tour Operator plugin development.

## Usage

Agents are automatically discovered by GitHub Copilot Chat when:

1. Files are saved with `.agent.md` extension
2. Located in the `.github/agents/` directory
3. Follow the proper agent format structure

## Agent Structure

Each agent should follow this format:

```markdown
# Agent Name

## Role
Brief description of the agent's purpose and specialization.

## Core Responsibilities
- List of main tasks the agent handles
- Specific domain expertise areas
- Integration points with other systems

## Implementation Guidelines
- Code patterns and best practices
- Security considerations
- Performance optimization tips
```

## Creating New Agents

To create a new agent:

1. Create a new file in `.github/agents/`
2. Use the `.agent.md` extension
3. Follow the agent structure guidelines above
4. Test the agent through GitHub Copilot Chat

For more information on agent development, see the workspace documentation.


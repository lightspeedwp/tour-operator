# CLAUDE.md — Tour Operator

WordPress plugin (LSX Tour Operator). Block-based; WCAG 2.2 AA is a release requirement.

## Standards

- WordPress Coding Standards for PHP; ESLint/Prettier for JS. Escape all output, sanitise all input,
  nonce + capability check on every state-changing action.
- Use `theme.json` tokens rather than hard-coded values; prefer native blocks over custom JS.
- New blocks ship with `block.json`, an edit component using `useBlockProps`, save or render
  callback, editor and front-end styles, PHPUnit tests and Playwright E2E tests.
- Enqueue editor-only assets in the editor only, never on the front end.

## Reference

- [AGENTS.md](AGENTS.md) — AI operations overview
- [.github/instructions/instructions.md](.github/instructions/instructions.md) — coding standards
- [.github/prompts/prompts.md](.github/prompts/prompts.md) · [.github/agents/agent.md](.github/agents/agent.md) · [.github/chatmodes/chatmodes.md](.github/chatmodes/chatmodes.md)
- [docs/wordpress-packages.md](docs/wordpress-packages.md) · [docs/playwright-testing-guide.md](docs/playwright-testing-guide.md)

> Prior versions of this file carried generic prompt-engineering advice and a model-comparison table
> that went stale. Both are in git history; keep this file to project facts only.

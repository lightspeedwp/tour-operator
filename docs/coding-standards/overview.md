# Coding Standards Overview

- **Blocks-first**: every UI feature should be a block or a variation.
- **Metadata-first**: `block.json` is the source of truth (API v3).
- **Server-registered**: register blocks with PHP (for supports, theme.json, REST exposure).
- **CSS ➜ JSON**: prefer theme.json + Block Selectors over bespoke CSS.
- **Tests**: write Playwright E2E per block (inserter, controls, SSR).
- **Accessibility**: comply with WCAG 2.1 AA (focus indicators, roles, alt text).

---
name: "Block Audit: <block-slug>"
about: "Standardise metadata, registration, styling, previews, tests"
labels: ["blocks", "audit"]
---

## Overview
- **Block name/slug**: `<namespace>/<block-slug>`
- **Type**: Static / Dynamic
- **InnerBlocks**: Yes/No; template/allowedBlocks
- **Templates/Patterns using this block**: list
- **Icon usage**: Replace small PNG/SVG with new `icons` block where applicable
- **Dependencies**: data stores, REST, post types, taxonomies

## Block.json (target, API v3)
Provide a proposed `block.json` specimen tailored to this block:

```json
{}
```

> Include: `apiVersion:3`, `title`, `description`, `keywords`, `icon`, `category`, `version`, `textdomain`, `attributes` (with types), `selectors` (root/feature/subfeature), `supports` (color, typography, spacing, border, background), `example`, `style`/`viewStyle`/`editorStyle`, `render` (dynamic), `usesContext`/`providesContext` where needed.

## Registration
- Register on **server** with `register_block_type( __DIR__ . '/build/blocks/<block-slug>' )`.
- Ensure wrapper attributes are output (`get_block_wrapper_attributes()` for dynamic).

## Styling migration (CSS ➜ theme.json/selectors)
- Map legacy CSS to `selectors` + theme styles.
- Remove bespoke CSS where possible; keep minimal component styles only.
- Document any required `theme.json` block settings.

## Inserter Preview
- Provide `example` data and style variation previews.

## Playwright Acceptance Tests (suggested)
Write E2E tests that:
- Insert block from inserter and assert preview renders.
- Toggle key controls (sidebar + toolbar) and assert front‑end HTML/CSS via SSR or preview.
- If **InnerBlocks**: assert template creation, allowedBlocks enforcement, appender.
- If **Query Loop** variant: assert namespace attribute activates variation and filters CPT/tax terms.
- If **Dynamic**: save post and check server HTML matches expectations.
- If **Icons** integration: verify icon is rendered via the `icons` block, not inline SVG/PNG.
- Visual regression: take screenshot in default + one variation.

## Block Locking (optional)
- Identify parts to lock (move/remove/edit/content‑only) for patterns/templates.

## SlotFills (if applicable)
- Note any editor UI extension points required.

## Done When
- [ ] `block.json` approved
- [ ] PHP registration complete
- [ ] Styling migrated
- [ ] Inserter preview added
- [ ] Playwright tests merged
- [ ] Templates/patterns updated if needed

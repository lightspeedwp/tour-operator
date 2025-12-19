# Icons Migration (Image → Icons Block)

Several blocks embed iconography via **`core/image`** inner blocks pointing at plugin assets. Replace these with the **custom `icons` block** where feasible to enable theme.json styling, tinting and RTL-safe rendering.

**Candidates** (from `build/blocks/*/index.js`):
- accommodation-type
- duration
- number-of-rooms
- suggested-visitor-types
- rating
- travel-styles
- departs-from
- facts-country-wrapper
- facts-regions-wrapper
- gallery (placeholders)

**Approach**
1. Replace inner `core/image` with `lsx-tour-operator/icons` (or your icons block) and pass an icon slug (e.g. `duration`, `map`, `rating`).
2. Add `supports: { color, spacing, border, shadow }` to allow theming.
3. Add `example` in block.json to show icon + sample text in Inserter.
4. Provide a fallback to `core/image` when the icon slug is not found.

# Query Loop Variations in Tour Operator

This plugin **does not define a custom query-loop block**; instead it modifies and augments **`core/query`** via PHP filters and wrapper classes. Key entry points:

- `render_block_data` → saves flags (e.g., `on-sale`, `parents-only`) from `className` on `core/query` blocks.
- `posts_pre_query` → replaces results with Featured sets when present.
- `query_loop_block_query_vars` → injects or alters args (meta_query, post_parent, post__in) for variations such as related items.
- `render_block` → conditionally hide wrapper sections when data is missing.

**Wrappers that present query-driven content**
- `facts-country-wrapper`, `facts-regions-wrapper` – show parent/child relationships.
- `units` + `unit-rooms` – output rooms/units.
- `itinerary` + `day-by-day` – pattern-based, rendering itinerary lists.
- `featured-accommodation` – dedicated feature slot.

## Variation keys & flags

The PHP class detects a *key* from wrapper CSS classes like `facts-*-wrapper` or `lsx-*-wrapper`, then maps to query args:

- `on-sale` (class on `core/query`) ⇒ adds `meta_query` to require `sale_price`.
- `parents-only` ⇒ sets `post_parent = 0`.
- Related lookups:
  - `tour-related-accommodation`, `accommodation-related-accommodation` ⇒ uses connection meta to build `post__in`.
  - Destination-driven relations ⇒ merges connected items from destination meta.

## What to ship for 2.1

- Keep using `core/query` with **block variations** and **patterns** for UX.
- Document CSS-class flags in editor help.
- Provide curated Query Loop patterns: “Featured Tours”, “Parent Regions”, “Related Accommodation”.
- Add unit tests for query arg filters (PHP) and editor smoke tests for patterns.

# Playwright Testing Guide

## What to test per block
- Inserter: block appears with correct title/keywords and preview.
- Controls: toggling key controls updates markup/styles.
- InnerBlocks: template inserted; allowedBlocks enforced.
- Dynamic blocks: front-end HTML via SSR matches expectation.
- Query Loop variations: namespace activates defaults; filters CPT.
- Icons integration: icon rendered via icons block, not inline.

## Tips
- Use role/label assertions over brittle selectors.
- Add visual baseline images where useful.

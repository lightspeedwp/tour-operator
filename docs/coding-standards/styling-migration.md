# Styling Migration Plan (CSS ➜ JSON)

1) Inventory legacy CSS per block.
2) Move colors/typography/spacing/border/background to **supports** and **selectors**.
3) Use theme.json presets for tokens.
4) Keep only structural CSS that cannot be expressed in JSON.
5) Validate with visual snapshots.

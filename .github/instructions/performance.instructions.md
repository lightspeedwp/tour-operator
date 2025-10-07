# Instruction: Performance

- Minimise DOM depth; prefer CSS utilities/presets over custom CSS.
- Defer non-critical JS; avoid synchronous blocking.
- Use **`wp_enqueue_block_style`** and `wp_register_style` with dependencies.
- Avoid large images in patterns; recommend responsive sizes and lazy loading.

# PHP (WordPress) Standards

- WPCS via PHPCS; no short array syntax issues; escape, sanitise, nonce.
- Translation: `esc_html__`, `esc_attr__`, `wp_kses_post` as appropriate.
- Register blocks with `register_block_type` and metadata path in `/build/blocks/<slug>`.

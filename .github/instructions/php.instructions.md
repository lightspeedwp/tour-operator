# PHP Guidelines

- Use actions/filters judiciously. Keep theme logic thin; prefer companion plugin for business logic.
- Escape early (`esc_html`, `esc_attr`, `wp_kses_post`); internationalise (`__`, `_x`, `_n`).
- Provide PHPUnit tests for helpers/filters.

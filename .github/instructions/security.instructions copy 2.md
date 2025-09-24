# Instructions: Security

- Escape output (`esc_html()`, `esc_attr()`, `wp_kses_post()`).
- Sanitise input; use nonces + capability checks for mutations.
- `$wpdb->prepare()` for queries; safe redirects/uploads.

**Acceptance:** No raw output; all mutations protected.

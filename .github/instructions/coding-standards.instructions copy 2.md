# Coding Standards

- **PHP**: WordPress coding standards; PHPCS (WordPress‑Extra) clean; PHPStan level per repo.
- **JS/TS**: ESLint + Prettier; modern JS; avoid jQuery unless required.
- **CSS**: Use tokens from `theme.json`; avoid hardcoded colours; respect `prefers-reduced-motion`.
- **Security**: Escape output, sanitise input, nonces/capabilities in admin.
- **Performance**: Avoid N+1 queries; lazy‑load media; keep bundles small.

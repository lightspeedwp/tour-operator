# Instructions: CI

- PR + main: checkout → setup-node LTS → cache → `npm ci` → `npm run lint` → `npm run build` → optional tests.
- Main: zip artifact; gated deploy via environments.

**Acceptance:** YAML valid; secrets via `${{ secrets.* }}`.

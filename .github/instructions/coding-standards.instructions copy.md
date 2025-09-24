# Coding Standards Instructions

## PHP & JS
- **PHP**: WordPress PHPCS rules; escape/sanitize; avoid direct DB where API exists.
- **JS/TS**: ESLint (WP config), Prettier; avoid global state; prefer `wp.data`/React state.

## Blocks & Styles
- Organise by feature: `blocks/<block-name>/` with `block.json`, index, edit, save, styles.
- **CSS**: Keep minimal; prefer `theme.json` tokens; avoid `!important`.
- **Naming**: kebab-case for files; PascalCase for components.

## Commits & PRs
- Conventional commits (feat/fix/perf/docs/chore).
- Small PRs; include screenshots/screencasts for UI changes; link issues.

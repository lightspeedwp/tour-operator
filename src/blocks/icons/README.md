# Icons Block

## Build & Generate Icons

1. Add your SVG files to the `source-icons/` directory, organized by type (e.g., `source-icons/outline/`, `source-icons/solid/`).
2. Generate the React icons file:
   ```
   node generate-icons.js
   ```
   This scans `source-icons/` and creates `src/icons.react.js`.
3. Build the plugin assets from the parent folder:
   ```
   npm run build
   ```

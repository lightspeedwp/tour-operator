### PHP Coding Standards

1. **Naming Conventions**
   - Class names should use `PascalCase`
   - Method and function names should use `snake_case`
   - Constants should be in `UPPERCASE_WITH_UNDERSCORES`
   - Hooks and filters should be prefixed with the plugin prefix: `lsx_to_`

2. **File Structure**
   - One class per file
   - File names should match the class name: `class-example.php` for `Example` class
   - Template files should be prefixed with `template-`

3. **Spacing and Formatting**
   - Use tabs for indentation, not spaces
   - No trailing whitespace
   - Lines should be no longer than 100 characters
   - Add spaces after commas in arrays
   - Add spaces around operators (`=`, `+`, `-`, etc.)

4. **Documentation**
   - Use PHPDoc blocks for classes, methods, and functions
   - Include `@since` tags with version numbers
   - Document hooks with `@hook` tags
   - Document filters with `@filter` tags

### JavaScript Coding Standards

1. **ES6+ Features**
   - Use `const` and `let` instead of `var`
   - Use arrow functions when possible
   - Use template literals for string interpolation
   - Use destructuring where appropriate

2. **WordPress JavaScript Guidelines**
   - Use `wp.` namespace for WordPress core features
   - Follow WordPress hook naming conventions
   - Use `wp.i18n` for internationalization
   - Use `wp.data` store for state management

3. **Block Editor (Gutenberg) Standards**
   - Register blocks with unique namespaces
   - Use block.json for block registration
   - Follow block attributes naming conventions
   - Implement proper block validation

### CSS/SCSS Standards

1. **Naming Conventions**
   - Use BEM methodology for class names
   - Prefix classes with `lsx-to-` (LSX Tour Operator)
   - Use lowercase with hyphens for class names

2. **Organization**
   - Group related styles together
   - Use comments to separate sections
   - Follow mobile-first approach
   - Use WordPress breakpoint variables

## Repository Structure

```
tour-operator/
├── src/                 # Source files (JS, SCSS)
├── includes/           # PHP classes and functions
├── templates/          # Template files
├── assets/            # Compiled assets
└── build/             # Build files
```

## Common Prefixes and Namespaces

- Plugin prefix: `lsx_to_`
- Block namespace: `lsx-to`
- Text domain: `tour-operator`
- Class namespace: `LSX_TO`

## Development Guidelines

1. **Version Control**
   - Follow semantic versioning
   - Update changelog.md for all changes
   - Include proper commit messages

2. **Testing**
   - Test with WordPress coding standards
   - Verify block editor compatibility
   - Check mobile responsiveness
   - Test with different PHP versions

3. **Security**
   - Sanitize inputs
   - Escape outputs
   - Use nonces for forms
   - Check capabilities before actions

4. **Performance**
   - Optimize database queries
   - Load assets only when needed
   - Use WordPress core functions when available
   - Cache expensive operations

5. **Accessibility**
   - Follow WCAG 2.1 guidelines
   - Use proper ARIA attributes
   - Ensure keyboard navigation
   - Maintain proper color contrast
# Copilot Instructions

This document provides guidelines for GitHub Copilot when working with this WordPress plugin codebase.

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

## WordPress Coding Standards (WPCS) Overview
Please refer to [WPCS Instructions](.github/instructions-wpcs.md)

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
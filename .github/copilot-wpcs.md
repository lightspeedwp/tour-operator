# WPCS Instructions

This file provides instructions for GitHub Copilot in the context of developing WordPress plugins, enforcing the official WordPress Coding Standards (WPCS) across PHP, HTML, JavaScript, CSS, docs, Markdown, JSON, accessibility (WCAG), and fluid spacing/typography.

---

## 0. General Principles

- **Consistency:** All code should appear as if written by a single developer.
- **Naming:**  
  - Functions/variables: `snake_case`  
  - Classes: `UpperCamelCase`  
  - CSS/HTML selectors: lowercase-hyphenated  
  - JS variables: `camelCase`, Classes: `UpperCamelCase`
- **Indentation:** Tabs for indentation. Use spaces only for alignment.
- **Comments/Docs:**  
  - Use clear, concise DocBlocks for functions, classes, hooks, and files.
  - Inline comments are encouraged for complex logic.
- **Whitespace:**  
  - No trailing spaces.  
  - Blank lines used sparingly for clarity.
- **References:**  
  - [WPCS Docs](https://github.com/WordPress/wpcs-docs/blob/master/wordpress-coding-standards.md)

---

## 1. Accessibility (WCAG 2.2)

- All UI must meet WCAG 2.2 AA standards.
- Use semantic HTML, proper ARIA, and manage focus.
- Refer to [WordPress Accessibility Guide](https://developer.wordpress.org/block-editor/how-to-guides/accessibility/).

---

## 2. PHP

- **Indentation:** Tabs only.
- **Naming:** Functions/vars: `snake_case`; Classes: `UpperCamelCase`.
- **Spacing:** One blank line before `return`.
- **Structure:**  
  - Namespace and declare statements at top.
  - Braces always used for control structures.
  - Space around operators.
- **Database:** Use `$wpdb->prepare()` for queries.
- **Best Practices:**  
  - Avoid singletons; prefer dependency injection.
  - No shorthand PHP tags.
  - Secure all output with proper escaping.
- **Docs:**  
  - File/class/function DocBlocks with `@since`, `@param`, `@return`.
  - No HTML or Markdown in summaries.
- **References:**  
  - [PHP Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/)

---

## 3. HTML

- **Validation:** Use [W3C validator](https://validator.w3.org/).
- **Indentation:** Tabs only.
- **Naming:** Lowercase, hyphenated for class/id.
- **Attributes:** Double quotes, one per line if multiline.
- **Self-closing:** `<img />`, `<br />` (space before slash).
- **References:**  
  - [HTML Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/html/)

---

## 4. JavaScript

- **Indentation:** Tabs only.
- **Semicolons:** Always required.
- **Naming:**  
  - Variables: `camelCase`
  - Classes: `UpperCamelCase`
- **Equality:** Always use `===`.
- **Strings:** Use single quotes.
- **Chained Methods:** One per line.
- **Globals:** Minimize; prefer `const`/`let`.
- **Switch:** Always use `break`.
- **Docs:**  
  - JSDoc with `@since`, `@param`, `@return`.
  - File/class/function DocBlocks required.
- **References:**  
  - [JS Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/javascript/)

---

## 5. CSS

- **Indentation:** Tabs.
- **Selectors:** Lowercase, hyphenated.
- **Units:** Always specify units except for `0`.
- **Ordering:** Logical grouping: display, position, box model, colors/typography, other.
- **Media Queries:** After relevant rules or at section end.
- **Avoid:** `!important`.
- **Comments:**  
  - Liberally used.  
  - Section headers and inline comments follow PHPDoc style.
- **References:**  
  - [CSS Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/css/)

---

## 6. Inline Documentation

### PHP

- Functions, classes, hooks, and files must have DocBlocks.
- Short summaries, detailed descriptions, `@since` (3-digit), `@param`, `@return`.
- No HTML/Markdown in summaries.

### JavaScript

- Use [JSDoc 3](http://jsdoc.app/).
- Functions, classes, events, file headers must be documented.
- Summaries use third-person singular ("Does something.")
- Wrap DocBlock text at 80 characters.

---

## 7. Markdown & JSON

- **Markdown:**  
  - Use heading styles, fenced code blocks, and proper list formatting.
  - Reference: [Markdown Style Guide](docs/coding-standards/styleguide.md)
- **JSON:**  
  - Use lowercase/hyphenated keys for block/theme metadata.
  - Validate against [WordPress JSON schemas](https://developer.wordpress.org/block-editor/reference-guides/block-api/block-metadata/).

---

## 8. Additional Guidelines

- **Fluid Spacing/Typo:**  
  - Use theme.json for spacing/typography presets.
- **Security:**  
  - Escape all output, validate all input.
- **Third-party Libraries:**  
  - Exempt from WPCS, but prefer compliance for custom code.
- **References:**  
  - [Accessibility](docs/coding-standards/wordpress-coding-standards/accessibility.md)
  - [Idiomatic CSS](docs/coding-standards/idiomatic-css.md)

---

## 9. Resources

- [WPCS Docs](https://github.com/WordPress/wpcs-docs)
- [WordPress Developer Handbook](https://developer.wordpress.org/)
- [WCAG 2.2 Quick Reference](https://www.w3.org/WAI/WCAG22/quickref/)
- [PHP_CodeSniffer for WPCS](https://github.com/WordPress/WordPress-Coding-Standards)
- [JSHint](https://jshint.com/)
- [Project PHPCS Config](../.phpcs.xml)

---

## 10. Enforcement

- Copilot should:
  - Reject code that does not conform to style and standards above.
  - Add missing DocBlocks, fix spacing, and enforce naming conventions.
  - Warn when accessibility, security, or best practices are not followed.

---

_This file is intended for use in the development of WordPress plugins to ensure all code generated by Copilot is compliant with official WordPress Coding Standards (WPCS)._
# 🧠 GitHub Copilot Repository Instructions

These are repository-specific instructions to guide GitHub Copilot’s behavior when generating or editing code within this project. They apply to Copilot Chat, Copilot Coding Agent, and Copilot Code Review.

---

## 🔍 Project Overview

This repository is a WordPress plugin (Tour Operator) project. It is built using PHP, leverages WordPress blocks for custom functionality, and strictly follows the WordPress Coding Standards (WPCS). The codebase is structured as a WordPress plugin and may include PHP files, block registration, and other WordPress-specific patterns.

---

## 🛠️ Technologies and Tooling

- **Languages:** PHP 8.0+, JavaScript (ES2022+), SCSS
- **CMS:** WordPress 6.7+ (Gutenberg block-based architecture)
- **Runtime:** Node.js (build tools only)
- **Package Manager:** npm
- **Build Tools:** Gulp (task runner), @wordpress/scripts (for blocks)
- **Linting:** PHP_CodeSniffer (PHPCS) for WordPress Coding Standards, JSHint
- **Testing:** Manual testing with WordPress environment
- **Frameworks:** WordPress core APIs, Gutenberg/Block Editor

---

## 🧩 Project Structure

```
.github/                    # GitHub configuration and workflows
includes/                   # Core PHP classes and functionality
├── blocks/                 # WordPress Gutenberg block definitions
├── classes/                # PHP class files (admin, legacy, taxonomies)
│   ├── admin/              # Admin-specific functionality
│   ├── blocks/             # Block-related classes
│   └── legacy/             # Legacy code and schema
├── constants/              # PHP constants definitions
├── metaboxes/              # Custom metabox definitions
├── partials/               # Reusable PHP template partials
├── patterns/               # WordPress block patterns
├── taxonomies/             # Custom taxonomy definitions
└── template-tags/          # WordPress template tag functions
templates/                  # WordPress template files for custom post types
├── archive-*.html          # Archive page templates
└── single-*.html           # Single post type templates
assets/                     # Static assets and compiled files
├── css/                    # Stylesheets (SCSS source and compiled CSS)
├── js/                     # JavaScript files
├── img/                    # Images and icons
└── flags/                  # Country flag SVG files
post-types/                 # JSON definitions for custom post types
languages/                  # Translation files (.pot, .po, .mo)
tour-operator.php           # Main plugin file
tour-operator-bootstrap.php # Plugin bootstrap/initialization
```

This is a WordPress plugin following standard WordPress plugin architecture with Gutenberg block support.

---

## 💡 Coding Conventions

### PHP
- Follow [WordPress Coding Standards (WPCS)](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/)
- Use WordPress core functions and APIs (never reinvent core functionality)
- Properly escape output with `esc_html()`, `esc_attr()`, `esc_url()`, etc.
- Sanitize input with `sanitize_text_field()`, `sanitize_email()`, etc.
- Use WordPress nonces for security verification
- Document functions with PHPDoc following [WordPress inline documentation standards](https://developer.wordpress.org/coding-standards/inline-documentation-standards/)
- Prefix all functions, classes, and global variables with `lsx_to_` or `LSX_TO_`

### JavaScript
- Follow [WordPress JavaScript Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/javascript/)
- Use modern ES6+ syntax where appropriate
- Prefer WordPress block editor APIs for Gutenberg blocks
- Keep logic modular—each file should have a single clear responsibility

### CSS/SCSS
- Follow [WordPress CSS Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/css/)
- Use SCSS for styles (compiled via Gulp)
- Support RTL (Right-to-Left) languages with automatic RTL stylesheet generation

---

## 📦 Build & Run Commands

* **Build WordPress Blocks**
  ```bash
  npm run build
  ```
  Builds Gutenberg blocks using @wordpress/scripts

* **Watch Mode for Block Development**
  ```bash
  npm run start
  ```
  Starts watch mode for live block development

* **Generate Translation Files**
  ```bash
  npm run build-pot
  ```
  Creates .pot file for translations
  
  ```bash
  npm run build-mopo
  ```
  Generates .mo files from .po files

* **SCSS/CSS Compilation**
  Use Gulp tasks for CSS compilation (configured in gulpfile.js)

* **PHP Linting**
  ```bash
  vendor/bin/phpcs
  ```
  Run PHP_CodeSniffer to check WordPress Coding Standards (configured in .phpcs.xml)

---

## ⛔ Avoid These Patterns

* Do not modify WordPress core files or bypass WordPress APIs
* Do not use direct database queries—use WordPress database abstraction (`$wpdb`, `WP_Query`, etc.)
* Do not create security vulnerabilities by forgetting to escape output or sanitize input
* Do not hardcode text strings—use translation functions (`__()`, `_e()`, `esc_html__()`, etc.)
* Do not add inline styles or scripts—enqueue them properly with `wp_enqueue_style()` and `wp_enqueue_script()`
* Do not create duplicate functionality that WordPress already provides
* Do not use PHP short tags (`<?`) or deprecated WordPress functions
* Avoid creating new custom database tables unless absolutely necessary

---

## ✅ Agent-Specific Prompts

When asked to:

* "Create a new block" → Place it in `includes/blocks/[block-name]/`, follow WordPress block registration patterns, include block.json
* "Add a custom post type" → Define it in `post-types/` as JSON, register in appropriate PHP class
* "Create a template" → Place it in `templates/` following WordPress template hierarchy naming conventions
* "Add a metabox" → Create in `includes/metaboxes/`, use WordPress metabox APIs
* "Create a custom taxonomy" → Define in `includes/taxonomies/`, follow WordPress taxonomy registration
* "Add a REST API endpoint" → Use `register_rest_route()` in appropriate class file in `includes/classes/`
* "Add translation support" → Use `__()`, `_e()`, `esc_html__()` functions, rebuild .pot file with `npm run build-pot`
* "Add admin functionality" → Place in `includes/classes/admin/`
* "Refactor" → Follow WordPress coding standards, improve modularity, clarify naming, remove dead code

---

## 🔒 Content Exclusion (Optional but Recommended)

If supported by your GitHub plan, exclude these directories in settings:

```
vendor/          # Composer dependencies
node_modules/    # npm dependencies (in .gitignore)
languages/*.mo   # Compiled translation files
assets/flags/    # Large collection of country flag SVG files
.wordpress-org/  # WordPress.org assets
```

---

## 📣 Feedback

We’re actively refining how we use GitHub Copilot. When in doubt, ask the team before suggesting code related to frameworks or languages not in use.

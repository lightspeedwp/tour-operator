# Tour Operator - Linting Configuration

This directory contains standardized linting and formatting configurations for the Tour Operator plugin that follow WordPress coding standards and LightSpeed development practices.

## Files Overview

### 📋 Core Configuration Files

- **`.eslintrc.json`** - JavaScript/TypeScript linting rules using @wordpress/eslint-plugin
- **`stylelint.config.js`** - CSS/SCSS linting rules using @wordpress/stylelint-config  
- **`.prettierrc.js`** - Code formatting rules compatible with WordPress standards
- **`.editorconfig`** - Editor formatting rules for consistent code style
- **`phpcs.xml`** - PHP CodeSniffer rules for WordPress coding standards
- **`.npmrc`** - NPM configuration for consistent package management

### 🔄 How Root Files Reference These Configurations

The root configuration files extend from these standardized configurations:

```javascript
// Root .eslintrc
{
  "root": true,
  "extends": ["./.github/linting/.eslintrc.json"]
}

// Root stylelint.config.js  
module.exports = require('./.github/linting/stylelint.config.js');

// Root .prettierrc.js
module.exports = require('./.github/linting/.prettierrc.js');
```

## 🛠️ Available Linting Commands

Run these commands from the plugin root directory:

```bash
# JavaScript/TypeScript linting
npm run lint:js

# CSS/SCSS linting  
npm run lint:css

# PHP linting
npm run lint:php

# Fix PHP linting issues
npm run lint:php:fix

# Run all linters
npm run lint:all

# Format code
npm run format
```

## 📊 CI/CD Integration

These configurations are automatically used by:

- **GitHub Actions CI** (`.github/workflows/ci.yml`)
- **Pre-commit hooks** (if configured)
- **VS Code extensions** (ESLint, Stylelint, Prettier)
- **Local development** via npm scripts

## 🎯 Plugin-Specific Rules

### JavaScript/TypeScript

- WordPress coding standards via `@wordpress/eslint-plugin`
- Global variables: `wp`, `jQuery`, `$`, `ajaxurl`, `tour_operator`
- Allows unsafe WP APIs for plugin development

### CSS/SCSS

- WordPress stylelint config with BEM naming conventions
- Prefix requirements: `tour-operator-`, `lsx-`, `to-`
- Vendor prefixes allowed for browser compatibility

### PHP

- WordPress Core, Extra, and Docs standards
- PHP 8.0+ compatibility checking
- Tour Operator text domain enforcement
- Security and accessibility rules enabled

## 🔧 Customizing Rules

To modify linting rules:

1. **For project-wide changes**: Edit files in this directory
2. **For specific overrides**: Add rules to root configuration files
3. **For temporary disables**: Use inline comments in source files

## 📝 Editor Integration

These configurations work automatically with:

- **VS Code**: Install ESLint, Stylelint, and Prettier extensions
- **PHPStorm**: Enable WordPress coding standards
- **Vim/Neovim**: Use appropriate linting plugins
- **Sublime Text**: Install SublimeLinter packages

## 🧪 Testing Configuration

Test the linting setup:

```bash
# Test specific file types
npx eslint src/admin/js/
npx stylelint assets/css/
vendor/bin/phpcs includes/

# Run full test suite
npm run lint:all
```

---

**Note**: These configurations are designed to be consistent across all LightSpeed WordPress plugins while allowing for plugin-specific customizations.


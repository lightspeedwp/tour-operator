# WordPress Packages & Tools Configuration

This document outlines all WordPress packages and related tools configured for the Tour Operator plugin.

## Installed WordPress Packages

### Build & Development

#### @wordpress/babel-preset-default

- **Purpose**: Babel preset for WordPress development
- **Usage**: Automatic transpilation of modern JavaScript
- **Configuration**: `.babel.config.cjs`
- **Docs**: <https://developer.wordpress.org/block-editor/reference-guides/packages/packages-babel-preset-default/>

#### @wordpress/scripts

- **Purpose**: Collection of reusable scripts for WordPress development
- **Usage**: Build, start, test, lint, and format scripts
- **Scripts**: `npm start`, `npm run build`
- **Docs**: <https://developer.wordpress.org/block-editor/reference-guides/packages/packages-scripts/>

### Testing

#### @wordpress/jest-preset-default

- **Purpose**: Jest preset for WordPress JavaScript testing
- **Usage**: Unit testing for blocks and components
- **Configuration**: `.jest.config.cjs`
- **Scripts**: `npm run test:unit`, `npm run test:unit:coverage`
- **Docs**: <https://developer.wordpress.org/block-editor/reference-guides/packages/packages-jest-preset-default/>

#### @wordpress/e2e-test-utils-playwright

- **Purpose**: End-to-end testing utilities for Playwright
- **Usage**: Testing WordPress block editor functionality
- **Configuration**: `.playwright.config.cjs`
- **Scripts**: `npm run test:e2e`, `npm run test:e2e:ui`
- **Docs**: <https://developer.wordpress.org/block-editor/reference-guides/packages/packages-e2e-test-utils-playwright/>

### Code Quality

#### @wordpress/eslint-plugin

- **Purpose**: ESLint plugin with WordPress coding standards
- **Usage**: JavaScript/TypeScript linting
- **Configuration**: `.eslintrc`
- **Scripts**: `npm run lint:js`, `npm run lint:js:fix`
- **Docs**: <https://developer.wordpress.org/block-editor/reference-guides/packages/packages-eslint-plugin/>

#### @wordpress/stylelint-config

- **Purpose**: Stylelint configuration for WordPress
- **Usage**: CSS/SCSS linting
- **Configuration**: `.stylelint.config.cjs`
- **Scripts**: `npm run lint:css`, `npm run lint:css:fix`
- **Docs**: <https://developer.wordpress.org/block-editor/reference-guides/packages/packages-stylelint-config/>

#### @wordpress/prettier-config

- **Purpose**: Prettier configuration for WordPress
- **Usage**: Code formatting
- **Configuration**: `.prettierrc.cjs`
- **Scripts**: `npm run format:js`
- **Docs**: <https://developer.wordpress.org/block-editor/reference-guides/packages/packages-prettier-config/>

#### @wordpress/npm-package-json-lint-config

- **Purpose**: Package.json linting configuration
- **Usage**: Ensure package.json follows WordPress standards
- **Configuration**: `.npmpackagejsonlintrc.json`
- **Scripts**: `npm run lint:pkg-json`
- **Docs**: <https://developer.wordpress.org/block-editor/reference-guides/packages/packages-npm-package-json-lint-config/>

### Utilities

#### @wordpress/a11y

- **Purpose**: Accessibility utilities for announcements
- **Usage**: Screen reader announcements in JavaScript
- **Import**: `import { speak } from '@wordpress/a11y';`
- **Docs**: <https://developer.wordpress.org/block-editor/reference-guides/packages/packages-a11y/>

#### @wordpress/i18n

- **Purpose**: Internationalization functions
- **Usage**: Translation functions for JavaScript
- **Import**: `import { __, _x, _n, sprintf } from '@wordpress/i18n';`
- **Docs**: <https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/>

## Additional Tools

### Babel

- **Package**: `@babel/core`, `@babel/cli`
- **Purpose**: JavaScript compiler
- **Configuration**: `.babel.config.cjs`

### Jest

- **Package**: `jest`
- **Purpose**: JavaScript testing framework
- **Configuration**: `.jest.config.cjs`
- **Test files**: `tests/js/**/*.test.js`

### Playwright

- **Package**: `@playwright/test`
- **Purpose**: End-to-end testing framework
- **Configuration**: `.playwright.config.cjs`
- **Test files**: `tests/e2e/**/*.spec.js`

### ESLint

- **Package**: `eslint`
- **Purpose**: JavaScript linting
- **Configuration**: `.eslintrc`

### Stylelint

- **Package**: `stylelint`
- **Purpose**: CSS/SCSS linting
- **Configuration**: `.stylelint.config.cjs`

### Prettier

- **Package**: `prettier`
- **Purpose**: Code formatting
- **Configuration**: `.prettierrc.cjs`

### npm-package-json-lint

- **Package**: `npm-package-json-lint`
- **Purpose**: Package.json validation
- **Configuration**: `.npmpackagejsonlintrc.json`

## Available Scripts

### Testing

```bash
npm test                 # Run all tests (PHP + E2E)
npm run test:unit        # Run Jest unit tests
npm run test:unit:watch  # Run Jest in watch mode
npm run test:unit:coverage # Run Jest with coverage report
npm run test:e2e         # Run Playwright E2E tests
npm run test:e2e:ui      # Run Playwright with UI
npm run test:e2e:debug   # Run Playwright in debug mode
```

### Linting

```bash
npm run lint:all         # Run all linters
npm run lint:js          # Lint JavaScript files
npm run lint:js:fix      # Lint and fix JavaScript files
npm run lint:css         # Lint CSS/SCSS files
npm run lint:css:fix     # Lint and fix CSS/SCSS files
npm run lint:php         # Lint PHP files
npm run lint:php:fix     # Lint and fix PHP files
npm run lint:pkg-json    # Lint package.json
```

### Formatting

```bash
npm run format           # Format PHP and JavaScript
npm run format:js        # Format JavaScript files with Prettier
```

### Development

```bash
npm start                # Start development mode with watch
npm run build            # Build for production
```

## Configuration Files

### .babel.config.cjs

Configures Babel transpilation using WordPress defaults:

- ES6+ to ES5 conversion
- JSX transformation
- Plugin system support

### .jest.config.cjs

Configures Jest testing:

- WordPress preset
- Test environment setup
- Coverage thresholds
- Module mapping

### .playwright.config.cjs

Configures Playwright E2E testing:

- Browser configurations
- Test timeouts
- Screenshot settings
- Parallel execution

### .eslintrc

Configures ESLint:

- WordPress recommended rules
- Custom project rules
- Global variables
- Ignore patterns

### .stylelint.config.cjs

Configures Stylelint:

- WordPress recommended rules
- BEM naming conventions
- Custom property patterns
- Ignore patterns

### .prettierrc.cjs

Configures Prettier:

- WordPress code style
- Custom formatting rules
- Line width and indentation

### .npmpackagejsonlintrc.json

Configures package.json linting:

- Required fields validation
- Dependency ordering
- License validation

## Usage Examples

### Using @wordpress/i18n

```javascript
import { __, _x, sprintf } from '@wordpress/i18n';

// Simple translation
const title = __('Tour Details', 'tour-operator');

// Translation with context
const label = _x('Date', 'tour booking date', 'tour-operator');

// Translation with placeholder
const message = sprintf(
    __('Found %d tours', 'tour-operator'),
    count
);
```

### Using @wordpress/a11y

```javascript
import { speak } from '@wordpress/a11y';

// Announce to screen readers
function updateResults(count) {
    speak(
        sprintf(__('Found %d tours', 'tour-operator'), count),
        'polite'
    );
}
```

### Writing Unit Tests

```javascript
import { render } from '@testing-library/react';
import TourCard from '../TourCard';

describe('TourCard', () => {
    it('renders tour title', () => {
        const { getByText } = render(
            <TourCard title="Safari Adventure" />
        );
        expect(getByText('Safari Adventure')).toBeInTheDocument();
    });
});
```

### Writing E2E Tests

```javascript
import { test, expect } from '@wordpress/e2e-test-utils-playwright';

test.describe('Tour Block', () => {
    test('should insert tour block', async ({ admin, editor }) => {
        await admin.createNewPost();
        await editor.insertBlock({ name: 'tour-operator/tour-card' });
        
        const block = editor.canvas.getByRole('document', {
            name: /Tour Card/i,
        });
        await expect(block).toBeVisible();
    });
});
```

## Best Practices

1. **Always use WordPress packages** when available instead of alternatives
2. **Run linters before committing** to ensure code quality
3. **Write tests** for new features and bug fixes
4. **Use translation functions** for all user-facing strings
5. **Follow WordPress coding standards** enforced by linters
6. **Keep dependencies updated** with `npm update`
7. **Review configuration** when WordPress packages are updated

## Troubleshooting

### Jest tests failing

- Check `tests/js/setup.js` for proper WordPress mocks
- Ensure test files match the pattern in `.jest.config.cjs`
- Run `npm run test:unit -- --verbose` for detailed output

### Playwright tests failing

- Verify WordPress is running at the configured base URL
- Check browser installation: `npx playwright install`
- Run in UI mode for debugging: `npm run test:e2e:ui`

### Linting errors

- Run fixers first: `npm run lint:js:fix`, `npm run lint:css:fix`
- Check `.eslintrc` and `.stylelint.config.cjs` for project-specific rules
- Verify files aren't in ignore patterns

### Build issues

- Clear build cache: `rm -rf build node_modules && npm install`
- Check `.babel.config.cjs` for proper preset configuration
- Verify `.webpack.config.cjs` extends WordPress defaults

## Resources

- [WordPress Block Editor Handbook](https://developer.wordpress.org/block-editor/)
- [WordPress Packages Documentation](https://developer.wordpress.org/block-editor/reference-guides/packages/)
- [@wordpress/scripts Documentation](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-scripts/)
- [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/)

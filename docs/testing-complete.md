# Testing Guide

Comprehensive testing guide for the Tour Operator WordPress plugin.

## Table of Contents

- [Overview](#overview)
- [Test Types](#test-types)
- [Running Tests](#running-tests)
- [PHPUnit Tests](#phpunit-tests)
- [Jest Tests](#jest-tests)
- [Playwright E2E Tests](#playwright-e2e-tests)
- [YAML Linting](#yaml-linting)
- [Continuous Integration](#continuous-integration)

## Overview

The Tour Operator plugin uses a multi-layered testing strategy:

- **PHPUnit** - Unit tests for PHP backend logic
- **Jest** - Unit tests for JavaScript/React components
- **Playwright** - End-to-end browser tests
- **yamllint** - Workflow and configuration validation

## Test Types

### 1. PHPUnit Tests (Backend)

Located in `tests/php/`, these tests verify:

- Custom Post Types registration
- Taxonomy registration
- Block Pattern registration
- Custom Fields logic (Bindings)
- WordPress hooks and filters

### 2. Jest Tests (Frontend)

Located in `tests/js/`, these tests verify:

- JavaScript utility functions
- Conditional block registration logic
- React component behavior
- Block editor extensions

### 3. Playwright E2E Tests (Integration)

Located in `tests/e2e/`, these tests verify:

- Plugin activation and admin menu presence
- Post type creation workflows
- Block editor integration
- Taxonomy management interfaces

### 4. YAML Linting (Configuration)

Validates GitHub Actions workflows and YAML configuration files for syntax and best practices.

## Running Tests

### Quick Start

```bash
# Run all tests
npm test

# Run comprehensive test suite
npm run test:all
```

### Individual Test Suites

#### PHPUnit Tests

```bash
# Run all PHPUnit tests
npm run test:php:all

# Run specific test file
npm run test:php:registration

# Run with PHPUnit directly
./vendor/bin/phpunit

# Run specific test class
./vendor/bin/phpunit tests/php/TestRegistration.php

# Run specific test method
./vendor/bin/phpunit --filter test_post_types_registered
```

#### Jest Tests

```bash
# Run all Jest tests
npm run test:unit

# Watch mode (re-runs on file changes)
npm run test:unit:watch

# With coverage report
npm run test:unit:coverage

# Run specific test file
npm run test:unit -- conditional-registration.test.js
```

#### Playwright E2E Tests

```bash
# Run all E2E tests (headless)
npm run test:e2e

# Run with UI (interactive)
npm run test:e2e:ui

# Debug mode (step through tests)
npm run test:e2e:debug

# Run specific test file
npm run test:e2e:plugin
```

#### YAML Linting

```bash
# Lint all YAML files
npm run lint:yaml

# Lint only GitHub workflows
npm run lint:yaml:workflows

# Direct yamllint usage
yamllint .
yamllint .github/workflows/
```

## PHPUnit Tests

### Configuration

PHPUnit configuration is in `phpunit.xml` at the project root.

### Test Structure

```php
<?php
/**
 * Example test file
 */
class TestExample extends Tour_Operator_Test_Case {
    
    public function test_something() {
        $this->assertTrue(true);
    }
}
```

### Available Test Utilities

The base class `Tour_Operator_Test_Case` provides:

- `create_tour($args)` - Create test tour posts
- `create_accommodation($args)` - Create test accommodation posts
- `create_destination($args)` - Create test destination posts
- `create_tour_with_relations($args)` - Create tour with linked posts
- `assertPostExists($id, $type, $status)` - Verify post existence
- `assertPostMetaEquals($id, $key, $value)` - Check post meta
- `assertHookRegistered($hook, $function)` - Verify WordPress hooks

### Writing New PHPUnit Tests

1. Create file in `tests/php/`
2. Extend `Tour_Operator_Test_Case`
3. Prefix test methods with `test_`
4. Use descriptive test names

Example:

```php
<?php
class TestMyFeature extends Tour_Operator_Test_Case {
    
    public function test_feature_works_correctly() {
        $tour_id = $this->create_tour(['post_title' => 'Test Tour']);
        
        $this->assertPostExists($tour_id, 'tour', 'publish');
        $this->assertGreaterThan(0, $tour_id);
    }
}
```

## Jest Tests

### Configuration

Jest configuration is handled by `@wordpress/scripts` in `package.json`.

### Test Structure

```javascript
import { myFunction } from '../src/js/my-module';

describe('My Module', () => {
    it('should do something', () => {
        expect(myFunction()).toBe(true);
    });
});
```

### Writing New Jest Tests

1. Create file with `.test.js` suffix in `tests/js/`
2. Import functions to test
3. Use `describe` for test suites
4. Use `it` or `test` for individual tests

Example:

```javascript
import { createConditionalRegistration } from '../../src/js/conditional-block-registration';

describe('Conditional Registration', () => {
    it('should export function', () => {
        expect(typeof createConditionalRegistration).toBe('function');
    });
});
```

## Playwright E2E Tests

### Prerequisites

Playwright E2E tests require:

- WordPress test environment
- Playwright browsers installed
- Admin credentials configured

### Configuration

Playwright configuration should be in `playwright.config.js` (create if needed).

### Test Structure

```javascript
import { test, expect } from '@wordpress/e2e-test-utils-playwright';

test.describe('Feature Test', () => {
    test('should do something', async ({ admin, page }) => {
        await admin.visitAdminPage('/');
        // Test assertions
    });
});
```

### Writing New E2E Tests

1. Create file with `.spec.js` suffix in `tests/e2e/`
2. Import from `@wordpress/e2e-test-utils-playwright`
3. Use `test.describe` for test groups
4. Use `test` for individual tests
5. Use async/await for page interactions

Example:

```javascript
import { test, expect } from '@wordpress/e2e-test-utils-playwright';

test('should create new tour', async ({ admin, page }) => {
    await admin.visitAdminPage('post-new.php?post_type=tour');
    
    const titleField = page.getByRole('textbox', { name: /add title/i });
    await expect(titleField).toBeVisible();
});
```

## YAML Linting

### Setup

Install yamllint (requires Python):

```bash
# macOS
brew install yamllint

# Linux (Ubuntu/Debian)
sudo apt-get install yamllint

# Using pip
pip install yamllint
```

### Configuration

YAML linting rules are in `.yamllint` at the project root.

### Manual Validation

```bash
# Lint all YAML
yamllint .

# Lint specific directory
yamllint .github/workflows/

# Lint specific file
yamllint .github/workflows/ci.yml
```

### Common Issues

- **Line too long**: Break long lines or adjust `.yamllint` config
- **Truthy values**: Use explicit `true`/`false` instead of `yes`/`no`
- **Indentation**: Use 2 spaces consistently
- **Trailing spaces**: Remove whitespace at line ends

## Continuous Integration

### GitHub Actions

All tests run automatically on:

- Push to `develop`, `main`, `2.*-trunk` branches
- Pull requests
- Manual workflow dispatch

### CI Workflows

- **`ci.yml`** - Main CI pipeline (PHPUnit, Jest, Linting)
- **`yaml-lint.yml`** - YAML validation
- **`push-deploy.yml`** - Deployment pipeline

### Local CI Simulation

Run the same checks as CI locally:

```bash
# All linting
npm run lint:all

# All tests
npm run test:all
```

## Best Practices

### General

- Write tests before fixing bugs (TDD)
- Keep tests focused and isolated
- Use descriptive test names
- Clean up test data in `tearDown`/`afterEach`
- Mock external dependencies

### PHPUnit

- Extend `Tour_Operator_Test_Case` for plugin-specific utilities
- Use data providers for parameterized tests
- Group related tests in one class
- Test both success and failure cases

### Jest

- Mock WordPress globals in `setup.js`
- Use `jest.fn()` for spies and mocks
- Test component rendering and interactions
- Verify prop types and default values

### Playwright

- Use built-in WordPress utilities (`admin`, `editor`)
- Wait for elements with `waitForLoadState`, `waitForSelector`
- Use semantic selectors (`getByRole`, `getByLabel`)
- Group related tests in `describe` blocks
- Clean up test data after each test

## Troubleshooting

### PHPUnit Issues

**WordPress test library not found:**

```bash
# Set WP_TESTS_DIR environment variable
export WP_TESTS_DIR=/tmp/wordpress-tests-lib

# Or run setup script
bash bin/install-wp-tests.sh wordpress_test root '' localhost latest
```

**Database connection errors:**

- Verify MySQL is running
- Check credentials in test bootstrap
- Ensure test database exists

### Jest Issues

**Module not found:**

```bash
# Clear Jest cache
npm run test:unit -- --clearCache

# Reinstall dependencies
rm -rf node_modules package-lock.json
npm install
```

### Playwright Issues

**Browsers not installed:**

```bash
npx playwright install
```

**WordPress environment not accessible:**

- Verify WordPress is running
- Check `playwright.config.js` base URL
- Ensure admin credentials are configured

### YAML Linting Issues

**yamllint not found:**

```bash
# Install yamllint
pip install yamllint

# Or use brew (macOS)
brew install yamllint
```

## Additional Resources

- [PHPUnit Documentation](https://phpunit.de/documentation.html)
- [Jest Documentation](https://jestjs.io/docs/getting-started)
- [Playwright Documentation](https://playwright.dev/docs/intro)
- [WordPress Handbook: Plugin Tests](https://developer.wordpress.org/plugins/testing/automated-testing/)
- [GitHub Actions Documentation](https://docs.github.com/en/actions)

## Contributing

When adding new features:

1. Write tests first (TDD approach)
2. Ensure all tests pass locally
3. Add test documentation if needed
4. Submit PR with test coverage

For test-related issues, see [CONTRIBUTING.md](../CONTRIBUTING.md).

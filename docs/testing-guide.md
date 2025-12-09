# Tour Operator Plugin - Testing Setup

This document explains how to set up and run tests for the Tour Operator Plugin.

## Test Structure

The plugin includes two types of tests:

### 1. Simple Unit Tests (No WordPress Required)
- Located in: `tests/php/TestSimpleFunctions.php`
- These tests verify basic PHP functionality and plugin logic without requiring WordPress
- Can be run immediately after installing Composer dependencies

### 2. WordPress Integration Tests (Requires WordPress Test Environment)
- Located in: `tests/php/test-basic.php` and `tests/php/utils/`
- These tests require a full WordPress testing environment
- Test plugin functionality within WordPress context

## Quick Start

### Install Dependencies
```bash
composer install
```

### Run Simple Tests
```bash
# Run basic tests (no WordPress environment needed)
composer test:simple
# OR directly:
./vendor/bin/phpunit --no-configuration tests/php/TestSimpleFunctions.php
```

### Run WordPress Integration Tests
First, set up the environment:
```bash
# Set up WordPress test environment (one-time setup)
./bin/install-wp-tests.sh

# Set environment variables
export WP_TESTS_DIR='/tmp/wordpress-tests-lib'
export WP_CORE_DIR='/tmp/wordpress/'
export WP_TESTS_DB_NAME='tour_operator_test'
export WP_TESTS_DB_USER='root'
export WP_TESTS_DB_PASSWORD=''
export WP_TESTS_DB_HOST='localhost'

# Run WordPress integration tests
composer test:wp
```

## Test Commands

The following NPM and Composer scripts are available:

```bash
# PHP Tests
npm run test:php              # Run PHP tests (simple by default)
composer test                 # Run simple tests
composer test:simple          # Run tests that don't need WordPress
composer test:wp              # Run WordPress integration tests (requires setup)
composer test:coverage        # Run tests with coverage report

# E2E Tests
npm run test:e2e              # Run Playwright E2E tests
npm run test:e2e:ui           # Run E2E tests with UI
npm run test:e2e:debug        # Run E2E tests in debug mode

# All Tests
npm test                      # Run both PHP and E2E tests
```

## WordPress Test Environment Setup (Optional)

To run the full WordPress integration tests, you need to set up the WordPress test environment:

### 1. Install WordPress Test Suite
```bash
# Create a directory for WordPress tests
mkdir -p /tmp/wordpress-tests-lib

# Download and set up WordPress test suite
# (This is a simplified example - actual setup may vary)
svn co https://develop.svn.wordpress.org/trunk/tests/phpunit/includes/ /tmp/wordpress-tests-lib/includes
svn co https://develop.svn.wordpress.org/trunk/tests/phpunit/data/ /tmp/wordpress-tests-lib/data
```

### 2. Set Environment Variables
```bash
export WP_TESTS_DIR="/tmp/wordpress-tests-lib"
export WP_TESTS_DB_NAME="tour_operator_test"
export WP_TESTS_DB_USER="root"
export WP_TESTS_DB_PASSWORD=""
export WP_TESTS_DB_HOST="localhost"
```

### 3. Create Test Database
```bash
mysql -u root -p -e "CREATE DATABASE tour_operator_test;"
```

### 4. Run WordPress Integration Tests
```bash
composer test:wp
```

## Test Files

### Configuration Files
- `phpunit.xml` - Full WordPress integration test configuration
- `phpunit-simple.xml` - Simple tests configuration (no WordPress)
- `tests/php/bootstrap.php` - WordPress test environment bootstrap

### Test Files
- `tests/php/TestSimpleFunctions.php` - Simple unit tests
- `tests/php/test-basic.php` - WordPress integration tests
- `tests/php/utils/` - Test utilities and helper classes
- `tests/e2e/` - Playwright E2E tests

### Test Utilities
- `Tour_Operator_Test_Case` - Base test case with helper methods
- `Tour_Operator_Factory` - Factory for creating test data

## Coverage Reports

Coverage reports are generated in the `tests/coverage/` directory when running:
```bash
composer test:coverage
```

## Continuous Integration

The test suite is designed to work with GitHub Actions and other CI systems. The E2E tests require a running WordPress environment, while the simple unit tests can run in any PHP environment.

## Troubleshooting

### "Could not find WordPress test suite" Error
This error occurs when trying to run WordPress integration tests without the proper environment setup. Either:
1. Set up the WordPress test environment as described above, or
2. Run only the simple tests: `composer test:simple`

### "No tests executed" Error
This usually means PHPUnit couldn't find the test files. Ensure:
1. Test files are named correctly (e.g., `TestSimpleFunctions.php`)
2. Test classes extend `PHPUnit\Framework\TestCase` or `Tour_Operator_Test_Case`
3. Test methods are named with `test_` prefix

### "Class cannot be found" Error
Make sure the class name matches the filename and follows PSR-4 naming conventions.

## Contributing

When adding new tests:
1. Simple functionality tests should go in separate files like `TestSimpleFunctions.php`
2. WordPress integration tests should extend `Tour_Operator_Test_Case`
3. E2E tests should be added to the `tests/e2e/` directory
4. Always run the test suite before submitting changes

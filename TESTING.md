# Tour Operator Test Suite

Complete testing infrastructure for the Tour Operator WordPress plugin.

## Quick Start

```bash
# Install dependencies
npm install
composer install

# Run all tests
npm test

# Run specific test suites
npm run test:php:all      # PHPUnit (all tests)
npm run test:unit         # Jest (JavaScript)
npm run test:e2e          # Playwright (E2E)
npm run lint:yaml         # YAML validation
```

## Test Coverage

### ✅ PHPUnit Tests (Backend)

**Location:** `tests/php/`

- **TestRegistration.php** - Verifies core WordPress component registration:
  - Custom Post Types (tour, accommodation, destination)
  - Taxonomies (travel-style, accommodation-type, etc.)
  - Block Pattern categories and patterns
  - Custom Fields bindings (lsx/post-connection, lsx/post-meta)

**Run:**

```bash
npm run test:php:all
npm run test:php:registration
```

### ✅ Jest Tests (Frontend)

**Location:** `tests/js/`

- **conditional-registration.test.js** - Tests conditional block registration utilities:
  - `createConditionalRegistration()` function
  - Post type conditional registration
  - Template slug matching
  - Helper functions (registerForPostTypes, registerForTemplates)

**Run:**

```bash
npm run test:unit
npm run test:unit:watch   # Watch mode
npm run test:unit:coverage # With coverage
```

### ✅ Playwright E2E Tests (Integration)

**Location:** `tests/e2e/`

- **plugin-activation.spec.js** - Verifies plugin integration:
  - Admin menu items visibility (Tours, Accommodations, Destinations)
  - Submenu structure and links
  - Post type creation workflows
  - Block Editor integration
  - Pattern availability
  - Taxonomy management interfaces
  - Plugin settings pages

**Run:**

```bash
npm run test:e2e
npm run test:e2e:ui       # Interactive UI
npm run test:e2e:debug    # Debug mode
npm run test:e2e:plugin   # Specific test
```

### ✅ YAML Linting (Configuration)

**Location:** `.github/workflows/`

Validates:

- GitHub Actions workflow syntax
- YAML structure and formatting
- Best practices compliance

**Run:**

```bash
npm run lint:yaml
npm run lint:yaml:workflows  # Workflows only
```

## Setup Instructions

### 1. PHPUnit Setup

**Prerequisites:**

- PHP 7.4+
- Composer
- MySQL/MariaDB

**Installation:**

```bash
# Install Composer dependencies
composer install

# Set up WordPress test environment
bash bin/install-wp-tests.sh wordpress_test root '' localhost latest

# Or set environment variables
export WP_TESTS_DIR=/tmp/wordpress-tests-lib
export WP_CORE_DIR=/tmp/wordpress
```

**Configuration:**

Create `.env` from `.env.example`:

```bash
cp .env.example .env
```

Edit `.env`:

```env
WP_TESTS_DIR=/tmp/wordpress-tests-lib
WP_CORE_DIR=/tmp/wordpress
DB_NAME=wordpress_test
DB_USER=root
DB_PASS=
DB_HOST=localhost
```

### 2. Jest Setup

**Prerequisites:**

- Node.js 18+
- npm

**Installation:**

```bash
npm install
```

**No additional configuration needed** - Jest uses WordPress preset from `@wordpress/scripts`.

### 3. Playwright Setup

**Prerequisites:**

- Node.js 18+
- WordPress test environment running
- Admin credentials

**Installation:**

```bash
# Install Playwright
npm install

# Install browser binaries
npx playwright install
```

**Configuration:**

Update `.env` with your WordPress environment:

```env
WP_BASE_URL=http://localhost:8888
WP_ADMIN_USER=admin
WP_ADMIN_PASS=password
```

Or set environment variables:

```bash
export WP_BASE_URL=http://localhost:8888
export WP_ADMIN_USER=admin
export WP_ADMIN_PASS=password
```

### 4. YAML Lint Setup

**Prerequisites:**

- Python 3.x
- pip

**Installation:**

```bash
# macOS
brew install yamllint

# Linux (Ubuntu/Debian)
sudo apt-get install yamllint

# Using pip
pip install yamllint
```

**Configuration:**

YAML rules are in `.yamllint` - no additional setup needed.

## Test Scripts Reference

### Complete Test Suites

```bash
npm test            # PHPUnit + Jest + Playwright
npm run test:all    # All PHPUnit tests + Jest + Playwright
```

### PHPUnit (PHP Backend)

```bash
npm run test:php              # Single test file
npm run test:php:all          # All PHPUnit tests
npm run test:php:registration # Registration tests only

# Direct PHPUnit usage
./vendor/bin/phpunit
./vendor/bin/phpunit tests/php/TestRegistration.php
./vendor/bin/phpunit --filter test_post_types_registered
```

### Jest (JavaScript)

```bash
npm run test:unit            # Run once
npm run test:unit:watch      # Watch mode
npm run test:unit:coverage   # With coverage report

# Run specific test file
npm run test:unit -- conditional-registration.test.js
```

### Playwright (E2E)

```bash
npm run test:e2e         # Headless mode
npm run test:e2e:ui      # Interactive UI
npm run test:e2e:debug   # Debug mode (step through)
npm run test:e2e:plugin  # Plugin activation tests only

# Direct Playwright usage
npx playwright test
npx playwright test tests/e2e/plugin-activation.spec.js
npx playwright test --headed  # Show browser
```

### YAML Linting

```bash
npm run lint:yaml           # All YAML files
npm run lint:yaml:workflows # GitHub workflows only

# Direct yamllint usage
yamllint .
yamllint .github/workflows/
yamllint .github/workflows/ci.yml
```

### All Linting

```bash
npm run lint:all  # PHP, JS, CSS, JSON, YAML
```

## Continuous Integration

### GitHub Actions Workflows

**Automated testing runs on:**

- Push to `develop`, `main`, `2.*-trunk`
- Pull requests
- Manual workflow dispatch

**Workflows:**

1. **ci.yml** - Main CI pipeline
   - PHPUnit tests
   - Jest unit tests
   - Code linting (PHP, JS, CSS)

2. **yaml-lint.yml** - YAML validation
   - GitHub Actions workflows
   - Configuration files

3. **push-deploy.yml** - Deployment (post-merge)

### Local CI Simulation

Run the same checks as CI:

```bash
# All linting
npm run lint:all

# All tests
npm run test:all
```

## Writing New Tests

### PHPUnit Test Template

```php
<?php
/**
 * Test Description
 *
 * @package Tour_Operator
 * @subpackage Tests
 */

class TestMyFeature extends Tour_Operator_Test_Case {

    public function test_feature_works() {
        $tour_id = $this->create_tour([
            'post_title' => 'Test Tour',
        ]);
        
        $this->assertPostExists($tour_id, 'tour', 'publish');
    }
}
```

### Jest Test Template

```javascript
import { myFunction } from '../../src/js/my-module';

describe('My Module', () => {
    it('should do something', () => {
        const result = myFunction();
        expect(result).toBe(true);
    });
});
```

### Playwright Test Template

```javascript
import { test, expect } from '@wordpress/e2e-test-utils-playwright';

test.describe('My Feature', () => {
    test('should work correctly', async ({ admin, page }) => {
        await admin.visitAdminPage('/');
        
        const element = page.locator('#my-element');
        await expect(element).toBeVisible();
    });
});
```

## Troubleshooting

### PHPUnit Issues

**WordPress test library not found:**

```bash
export WP_TESTS_DIR=/tmp/wordpress-tests-lib
bash bin/install-wp-tests.sh wordpress_test root '' localhost latest
```

**Database errors:**

- Verify MySQL is running
- Check database credentials in `.env`
- Ensure test database exists

### Jest Issues

**Module not found:**

```bash
npm run test:unit -- --clearCache
rm -rf node_modules package-lock.json
npm install
```

### Playwright Issues

**Browsers not installed:**

```bash
npx playwright install
```

**WordPress not accessible:**

- Verify WordPress is running at `WP_BASE_URL`
- Check admin credentials in `.env`
- Test manually at `http://localhost:8888/wp-admin`

### YAML Lint Issues

**yamllint not found:**

```bash
pip install yamllint
# or
brew install yamllint
```

## Documentation

- **[Complete Testing Guide](docs/testing-complete.md)** - Detailed documentation
- **[Playwright Testing Guide](docs/playwright-testing-guide.md)** - E2E testing
- **[Test Spec Templates](docs/test-spec-templates.md)** - Test templates
- **[Testing Guide](docs/testing-guide.md)** - General testing practices

## Resources

- [PHPUnit Documentation](https://phpunit.de/documentation.html)
- [Jest Documentation](https://jestjs.io/docs/getting-started)
- [Playwright Documentation](https://playwright.dev/docs/intro)
- [WordPress Testing Handbook](https://developer.wordpress.org/plugins/testing/automated-testing/)
- [yamllint Documentation](https://yamllint.readthedocs.io/)

## Contributing

When adding new features:

1. ✅ Write tests first (TDD)
2. ✅ Ensure all tests pass locally
3. ✅ Run linting (`npm run lint:all`)
4. ✅ Submit PR with test coverage

---

**Questions?** See [docs/testing-complete.md](docs/testing-complete.md) for comprehensive documentation.

# Development Guide

## Getting Started

### Prerequisites

- Node.js 18+ and npm
- PHP 8.0+
- WordPress 6.7+
- Composer

### Setup

1. Clone the repository
2. Install dependencies:
   ```bash
   npm install
   composer install
   ```
3. Build the project:
   ```bash
   npm run build
   ```

## Development Workflow

### Code Standards

This project follows WordPress coding standards:

- **PHP**: WordPress PHP Coding Standards
- **JavaScript**: WordPress JavaScript Coding Standards
- **CSS/SCSS**: WordPress CSS Coding Standards

### Linting

Run linting before committing:

```bash
npm run lint:all
```

Fix issues automatically where possible:

```bash
npm run format
```

### Building

Development build with watch:
```bash
npm start
```

Production build:
```bash
npm run build
```

## Architecture

### Singleton Pattern

All main classes use the Singleton pattern for consistency:

```php
class Example_Class {
    private static $instance;
    
    private function __construct() {
        // Initialize
    }
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
```

### Block System

Blocks are created as variations of core blocks when possible:

```javascript
wp.blocks.registerBlockVariation('core/group', {
    name: 'lsx-tour-operator/custom-block',
    title: 'Custom Block',
    // ... configuration
});
```

### Template Tags

Helper functions follow this naming convention:

```php
function lsx_to_function_name($param = false) {
    // Implementation
}
```

## File Structure

```
tour-operator/
├── includes/
│   ├── classes/           # PHP classes
│   ├── template-tags/     # Template helper functions
│   ├── patterns/          # Block patterns
│   └── taxonomies/        # Taxonomy configurations
├── src/
│   ├── blocks/           # Block variations
│   ├── js/               # JavaScript files
│   └── css/              # SCSS files
├── templates/            # Block templates
├── docs/                 # Documentation (excluded from distribution)
└── build/                # Compiled assets
```

## Testing

Currently, the plugin uses manual testing. Automated testing is planned for future releases.

## Deployment

The plugin uses GitHub Actions for automated deployment to WordPress.org.

Files excluded from distribution are listed in `.distignore`.

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes following the coding standards
4. Test your changes
5. Submit a pull request

### Commit Messages

Use conventional commit messages:

- `feat:` New features
- `fix:` Bug fixes
- `docs:` Documentation changes
- `style:` Code style changes
- `refactor:` Code refactoring
- `test:` Test additions/changes
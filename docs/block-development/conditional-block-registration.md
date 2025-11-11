# Conditional Block Registration Utility

## Overview

The Conditional Block Registration utility provides a standardized way to conditionally register WordPress block variations based on the current post type and template context. This utility was created to replace repetitive conditional registration logic across multiple block files.

## Features

- **Post Type Detection**: Register blocks only for specific post types
- **Template Context Support**: Register blocks for templates with specific slug patterns
- **Flexible Matching**: Support for string matching and regex patterns
- **Error Handling**: Built-in error handling and logging
- **Performance Optimized**: Efficient subscription management and cleanup
- **Easy Migration**: Simple API that replaces existing conditional logic

## API Reference

### Main Functions

#### `createConditionalRegistration(config)`

The core function that creates a conditional registration handler.

**Parameters:**
- `config.postTypes` (Array): Array of post types that support the block
- `config.templateSlugs` (Array): Array of template slug patterns to match (strings or RegExp)
- `config.registerFunction` (Function): Function to call when conditions are met
- `config.timeout` (Number, optional): Initial timeout before checking registration (default: 100ms)

**Returns:** Function that handles the conditional registration logic

#### `registerForPostTypes(postTypes, registerFunction, options)`

Simplified registration for blocks that only support specific post types.

**Parameters:**
- `postTypes` (Array): Array of supported post types
- `registerFunction` (Function): Function to call for registration
- `options` (Object, optional): Additional options

**Returns:** Registration handler function

#### `registerForTemplates(templateSlugs, registerFunction, options)`

Simplified registration for blocks that support templates with specific slug patterns.

**Parameters:**
- `templateSlugs` (Array): Array of template slug patterns
- `registerFunction` (Function): Function to call for registration
- `options` (Object, optional): Additional options

**Returns:** Registration handler function

#### `registerForPostTypesAndTemplates(postTypes, templateSlugs, registerFunction, options)`

Registration for blocks that support both post types and template patterns.

**Parameters:**
- `postTypes` (Array): Array of supported post types
- `templateSlugs` (Array): Array of template slug patterns
- `registerFunction` (Function): Function to call for registration
- `options` (Object, optional): Additional options

**Returns:** Registration handler function

## Usage Examples

### Basic Post Type Registration

```javascript
import { registerForPostTypes } from '@utils/conditional-block-registration.js';

const registerMyBlock = () => {
    wp.blocks.registerBlockVariation('core/paragraph', {
        // ... block configuration
    });
};

// Register only for 'tour' post type
const conditionalRegister = registerForPostTypes(['tour'], registerMyBlock);
conditionalRegister();
```

### Template-Based Registration

```javascript
import { registerForTemplates } from '@utils/conditional-block-registration.js';

const registerTemplateBlock = () => {
    wp.blocks.registerBlockVariation('core/group', {
        // ... block configuration
    });
};

// Register for templates containing 'tour' in the slug
const conditionalRegister = registerForTemplates(['tour'], registerTemplateBlock);
conditionalRegister();
```

### Combined Registration

```javascript
import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';

const registerFlexibleBlock = () => {
    wp.blocks.registerBlockVariation('core/group', {
        // ... block configuration
    });
};

// Register for tour post type AND tour-related templates
const conditionalRegister = registerForPostTypesAndTemplates(
    ['tour'], // Supported post types
    ['tour'], // Template slug patterns
    registerFlexibleBlock
);
conditionalRegister();
```

### Advanced Configuration

```javascript
import { createConditionalRegistration } from '@utils/conditional-block-registration.js';

const registerAdvancedBlock = () => {
    // ... registration logic
};

const conditionalRegister = createConditionalRegistration({
    postTypes: ['destination'],
    templateSlugs: [
        'destination',
        'country', 
        'region',
        /^archive-destination.*/ // Regex pattern
    ],
    registerFunction: registerAdvancedBlock,
    timeout: 200 // Custom timeout
});

conditionalRegister();
```

## Migration Guide

### Before (Old Pattern)

```javascript
wp.domReady(() => {
    const { select } = wp.data;
    const supportedPostTypes = ['tour'];
    let registered = false;
    let checking = false;

    const checkAndRegister = () => {
        if (registered || checking) {
            return registered;
        }
        checking = true;
        // ... complex registration logic
    };

    // ... subscription and timeout logic
});
```

### After (New Pattern)

```javascript
import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';

wp.domReady(() => {
    const registerMyVariation = () => {
        wp.blocks.registerBlockVariation(/* ... */);
    };

    const conditionalRegister = registerForPostTypesAndTemplates(
        ['tour'], // Post types
        ['tour'], // Template slugs
        registerMyVariation
    );

    conditionalRegister();
});
```

## Template Slug Patterns

The utility supports both string matching and regex patterns for template slugs:

- **String matching**: `'tour'` matches any slug containing "tour"
- **Regex patterns**: `/^single-tour/` matches slugs starting with "single-tour"
- **Multiple patterns**: `['tour', 'accommodation', /^archive-.*/]`

## Error Handling

The utility includes built-in error handling:

- Registration errors are logged to the console
- Invalid configurations throw helpful error messages
- Graceful fallback when editor APIs are not available

## Performance Considerations

- **Lazy registration**: Blocks are only registered when needed
- **Subscription cleanup**: Automatically unsubscribes when registration succeeds
- **Timeout management**: Prevents infinite checking loops
- **Minimal overhead**: Only active when conditions might be met

## Troubleshooting

### Block Not Registering

1. Check browser console for error messages
2. Verify post types and template slugs are correct
3. Ensure the registration function is valid
4. Check that wp.blocks is available

### Registration Happens Too Early/Late

- Adjust the `timeout` parameter
- Verify the registration function doesn't have dependencies that aren't ready

### Template Patterns Not Matching

- Use browser dev tools to check the actual template slug
- Test with regex patterns for more complex matching
- Consider case sensitivity in slug patterns

## Testing

To test block registration:

1. Create/edit posts of the specified post types
2. Edit templates that match the slug patterns
3. Verify blocks appear in the inserter
4. Check browser console for any errors

## File Location

The utility is located at: `src/utils/conditional-block-registration.js`

## Contributing

When modifying the utility:

1. Follow WordPress coding standards
2. Add JSDoc comments for new functions
3. Update examples and documentation
4. Test with various post types and templates
5. Maintain backward compatibility

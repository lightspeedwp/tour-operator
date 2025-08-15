# Anchored Navigation System

## Overview

The Anchored Navigation system provides sticky navigation with smooth scrolling for single tour, destination, and accommodation pages. On mobile devices, the content sections become collapsible for better user experience.

## Features

- **Sticky Navigation**: Navigation stays at the top when scrolling
- **Smooth Scrolling**: Animated scroll to sections
- **Active State**: Highlights current section in navigation
- **Mobile Collapsible**: Sections collapse on mobile for space efficiency
- **Responsive Design**: Adapts to different screen sizes

## Block Variation

The anchored navigation is implemented as a block variation of the core Navigation block:

```javascript
wp.blocks.registerBlockVariation('core/navigation', {
    name: 'lsx-tour-operator/anchored-navigation',
    title: 'Anchored Navigation',
    className: 'lsx-anchored-navigation',
    // ... configuration
});
```

## Usage in Templates

Add the anchored navigation block to your templates:

```html
<!-- wp:navigation {"className":"lsx-anchored-navigation"} -->
<!-- Navigation items with anchor links -->
<!-- /wp:navigation -->
```

## Section Structure

Sections should use the `.anchored-section` class and have proper IDs:

```html
<!-- wp:group {"metadata":{"name":"Overview"},"className":"anchored-section","anchor":"overview"} -->
<div id="overview" class="wp-block-group anchored-section">
    <!-- Section content -->
</div>
<!-- /wp:group -->
```

## Available Anchor Links

Default navigation includes these sections:

- `#overview` - Overview/Description
- `#itinerary` - Itinerary details
- `#accommodation` - Accommodation information
- `#inclusions` - Inclusions and exclusions
- `#map` - Map and location
- `#gallery` - Photo gallery

## Mobile Behavior

On screens smaller than 768px:

1. Navigation becomes non-sticky
2. Sections automatically convert to collapsible format
3. Section headers are added with expand/collapse functionality
4. First section remains open by default

## Customization

### CSS Custom Properties

The system uses CSS custom properties for theming:

```scss
--wp--preset--color--primary-900
--wp--preset--color--primary-200
--wp--preset--color--base
--wp--preset--spacing--x-small
```

### JavaScript Events

The system fires custom events that can be listened to:

```javascript
document.addEventListener('lsx-navigation-section-change', function(e) {
    console.log('Active section:', e.detail.sectionId);
});
```

### Adding Custom Sections

To add custom sections, update the JavaScript configuration:

```javascript
const titleMap = {
    'custom-section': 'Custom Section Title',
    // ... other sections
};
```

## Browser Support

- Modern browsers (Chrome, Firefox, Safari, Edge)
- Internet Explorer 11+ (with polyfills)
- Mobile Safari and Chrome

## Performance

- Uses throttled scroll events for performance
- Minimal DOM manipulation
- CSS transitions for smooth animations
# Tour Operator Plugin Documentation

## Overview

The Tour Operator plugin provides a comprehensive system for managing tours, accommodations, and destinations on WordPress websites. This documentation covers the plugin's architecture, features, and development practices.

## Table of Contents

1. [Installation & Setup](installation.md)
2. [Architecture Overview](architecture.md)
3. [Block System](blocks.md)
4. [Template System](templates.md)
5. [Anchored Navigation](anchored-navigation.md)
6. [Custom Post Types](post-types.md)
7. [Taxonomies](taxonomies.md)
8. [Template Tags](template-tags.md)
9. [Block Patterns](patterns.md)
10. [Development Guide](development.md)
11. [API Reference](api.md)
12. [Customization](customization.md)

## Quick Start

### Installation

1. Upload the plugin files to `/wp-content/plugins/tour-operator/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure the plugin settings under 'Tour Operator' in the admin menu

### Basic Usage

1. Create destinations under `Destinations > Add New`
2. Create accommodations under `Accommodations > Add New`
3. Create tours under `Tours > Add New`
4. Use the block editor to build rich content layouts

## Key Features

- **Custom Post Types**: Tours, Destinations, Accommodations
- **Block-based Templates**: Modern WordPress block templates
- **Anchored Navigation**: Sticky navigation with smooth scrolling
- **Mobile Responsive**: Collapsible sections on mobile devices
- **Map Integration**: Google Maps integration with custom markers
- **Gallery System**: Image galleries with lightbox functionality
- **Pricing System**: Flexible pricing options and displays
- **Itinerary System**: Day-by-day itinerary planning

## Development

This plugin follows WordPress coding standards and uses modern development practices:

- **Singleton Pattern**: All main classes use the Singleton pattern
- **Block System**: Built on WordPress Gutenberg blocks
- **SCSS Compilation**: Modern CSS with SCSS preprocessing
- **JavaScript Modules**: ES6+ JavaScript with webpack compilation
- **Template Tags**: Helper functions for theme integration

## Contributing

Please refer to the [Development Guide](development.md) for information on contributing to this plugin.

## Support

For support and documentation, visit [touroperator.solutions](https://touroperator.solutions/)
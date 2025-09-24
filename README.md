# WordPress Plugin

A WordPress plugin

## Description

A WordPress plugin

## Installation

1. Upload the plugin files to the `/wp-content/plugins/tour-operator` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Configure the plugin through the WordPress admin interface.

## Features

- WordPress integration
- Easy to use interface
- Customizable settings
- Developer-friendly hooks and filters

## Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher

## Development

This plugin follows WordPress coding standards and best practices.

### GitHub Copilot Integration

This repository is configured with GitHub Copilot support including:
- Custom prompts in `.github/prompts/`
- Instructions in `.github/instructions/`
- Agents in `.github/agents/`
- Chat modes in `.github/chatmodes/`

# Tour Operator Docs & .github Kit

Curated documentation and GitHub configuration for **LSX Tour Operator** (blocks-first WordPress plugin).
This kit standardises coding conventions, block authoring, CI, and collaboration.

- **Docs** live in `/docs`.
- **GitHub configs** live in `/.github` (issue/PR templates, workflows, Copilot prompts).
- Based on WordPress Block API v3, block.json metadata, theme.json styling and Playwright E2E.
- Uses [@wordpress/scripts](https://developer.wordpress.org/block-editor/packages/packages-scripts/) for build, linting, and testing.

### File Structure

```
tour-operator/
├── plugin.php
├── README.md
├── .github/
│   ├── prompts/
│   ├── instructions/
│   ├── agents/
│   └── chatmodes/
└── .vscode/
    └── settings.json
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## Support

For support and questions, please use the GitHub Issues tab.

## License

This plugin is licensed under the GPL v2 or later.

## Changelog

### 1.0.0
- Initial release

---

**Author:** Author
**Version:** 1.0.0


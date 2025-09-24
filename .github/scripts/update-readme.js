#!/usr/bin/env node

/**
 * WordPress Plugin README Generator
 * Generates README.md files based on plugin metadata and collections
 */

const fs = require("fs");
const path = require("path");
const { parseCollectionYaml } = require("./yaml-parser");

// Get plugin information from main plugin file
function getPluginInfo() {
  const pluginFiles = fs.readdirSync('.').filter(file => file.endsWith('.php') && !file.startsWith('index'));

  for (const file of pluginFiles) {
    const content = fs.readFileSync(file, 'utf8');
    const headerMatch = content.match(/\/\*\*([\s\S]*?)\*\//);

    if (headerMatch && headerMatch[1].includes('Plugin Name')) {
      const header = headerMatch[1];
      const pluginName = header.match(/Plugin Name:\s*(.+)/)?.[1]?.trim();
      const description = header.match(/Description:\s*(.+)/)?.[1]?.trim();
      const version = header.match(/Version:\s*(.+)/)?.[1]?.trim();
      const author = header.match(/Author:\s*(.+)/)?.[1]?.trim();
      const pluginUri = header.match(/Plugin URI:\s*(.+)/)?.[1]?.trim();

      return {
        name: pluginName || 'WordPress Plugin',
        description: description || 'A WordPress plugin',
        version: version || '1.0.0',
        author: author || 'Author',
        uri: pluginUri || '',
        file: file
      };
    }
  }

  return {
    name: 'WordPress Plugin',
    description: 'A WordPress plugin',
    version: '1.0.0',
    author: 'Author',
    uri: '',
    file: 'plugin.php'
  };
}

// Generate README content
function generateReadmeContent(pluginInfo, collections = []) {
  const content = `# ${pluginInfo.name}

${pluginInfo.description}

## Description

${pluginInfo.description}

## Installation

1. Upload the plugin files to the \`/wp-content/plugins/${path.basename(process.cwd())}\` directory, or install the plugin through the WordPress plugins screen directly.
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
- Custom prompts in \`.github/prompts/\`
- Instructions in \`.github/instructions/\`
- Agents in \`.github/agents/\`
- Chat modes in \`.github/chatmodes/\`

### File Structure

\`\`\`
${path.basename(process.cwd())}/
├── ${pluginInfo.file}
├── README.md
├── .github/
│   ├── prompts/
│   ├── instructions/
│   ├── agents/
│   └── chatmodes/
└── .vscode/
    └── settings.json
\`\`\`

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

### ${pluginInfo.version}
- Initial release

---

**Author:** ${pluginInfo.author}
**Version:** ${pluginInfo.version}
${pluginInfo.uri ? `**Plugin URI:** ${pluginInfo.uri}` : ''}
`;

  return content;
}

// Main execution
function main() {
  try {
    console.log('Generating README for WordPress plugin...');

    const pluginInfo = getPluginInfo();
    console.log(`Found plugin: ${pluginInfo.name} v${pluginInfo.version}`);

    // Check for collections (optional)
    let collections = [];
    const collectionsDir = './collections';
    if (fs.existsSync(collectionsDir)) {
      const collectionFiles = fs.readdirSync(collectionsDir)
        .filter(file => file.endsWith('.yml') || file.endsWith('.yaml'));

      collections = collectionFiles.map(file => {
        const filePath = path.join(collectionsDir, file);
        return parseCollectionYaml(filePath);
      });
    }

    const readmeContent = generateReadmeContent(pluginInfo, collections);

    fs.writeFileSync('README.md', readmeContent);
    console.log('README.md generated successfully!');

  } catch (error) {
    console.error('Error generating README:', error.message);
    process.exit(1);
  }
}

if (require.main === module) {
  main();
}

module.exports = { generateReadmeContent, getPluginInfo };

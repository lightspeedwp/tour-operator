#!/usr/bin/env node

/**
 * WordPress Plugin Collection Creator
 * Creates new collection files based on templates
 */

const fs = require("fs");
const path = require("path");
const { parseYamlFrontmatter } = require("./yaml-parser");

// Default collection template
const DEFAULT_COLLECTION_TEMPLATE = `---
name: "{{name}}"
description: "{{description}}"
version: "1.0.0"
author: "{{author}}"
license: "GPL-2.0-or-later"
tags: ["wordpress", "plugin"]
homepage: "{{homepage}}"
---

# {{name}}

{{description}}

## Features

- Feature 1
- Feature 2
- Feature 3

## Installation

1. Installation step 1
2. Installation step 2
3. Installation step 3

## Usage

Instructions for using this collection.

## Configuration

Configuration details for the collection.

## Development

Development notes and guidelines.
`;

// Get plugin information for defaults
function getPluginDefaults() {
  const pluginFiles = fs.readdirSync('.').filter(file =>
    file.endsWith('.php') && !file.startsWith('index')
  );

  if (pluginFiles.length > 0) {
    const content = fs.readFileSync(pluginFiles[0], 'utf8');
    const headerMatch = content.match(/\/\*\*([\s\S]*?)\*\//);

    if (headerMatch) {
      const header = headerMatch[1];
      const pluginName = header.match(/Plugin Name:\s*(.+)/)?.[1]?.trim();
      const description = header.match(/Description:\s*(.+)/)?.[1]?.trim();
      const author = header.match(/Author:\s*(.+)/)?.[1]?.trim();
      const pluginUri = header.match(/Plugin URI:\s*(.+)/)?.[1]?.trim();

      return {
        name: pluginName || 'WordPress Plugin Collection',
        description: description || 'A WordPress plugin collection',
        author: author || 'Author Name',
        homepage: pluginUri || ''
      };
    }
  }

  return {
    name: 'WordPress Plugin Collection',
    description: 'A WordPress plugin collection',
    author: 'Author Name',
    homepage: ''
  };
}

// Create collection directory if it doesn't exist
function ensureCollectionsDirectory() {
  const collectionsDir = './collections';
  if (!fs.existsSync(collectionsDir)) {
    fs.mkdirSync(collectionsDir, { recursive: true });
    console.log('📁 Created collections directory');
  }
  return collectionsDir;
}

// Generate collection content from template
function generateCollectionContent(collectionId, options = {}) {
  const defaults = getPluginDefaults();
  const templateVars = {
    name: options.name || `${defaults.name} - ${collectionId}`,
    description: options.description || `${collectionId} collection for ${defaults.name}`,
    author: options.author || defaults.author,
    homepage: options.homepage || defaults.homepage,
    ...options
  };

  let content = DEFAULT_COLLECTION_TEMPLATE;

  // Replace template variables
  Object.keys(templateVars).forEach(key => {
    const regex = new RegExp(`{{${key}}}`, 'g');
    content = content.replace(regex, templateVars[key] || '');
  });

  return content;
}

// Create a new collection
function createCollection(collectionId, options = {}) {
  if (!collectionId) {
    throw new Error('Collection ID is required');
  }

  // Validate collection ID
  if (!/^[a-z0-9-]+$/.test(collectionId)) {
    throw new Error('Collection ID must contain only lowercase letters, numbers, and hyphens');
  }

  const collectionsDir = ensureCollectionsDirectory();
  const collectionFile = path.join(collectionsDir, `${collectionId}.yml`);

  if (fs.existsSync(collectionFile)) {
    throw new Error(`Collection already exists: ${collectionFile}`);
  }

  const content = generateCollectionContent(collectionId, options);

  fs.writeFileSync(collectionFile, content);
  console.log(`✅ Created collection: ${collectionFile}`);

  return collectionFile;
}

// List existing collections
function listCollections() {
  const collectionsDir = './collections';

  if (!fs.existsSync(collectionsDir)) {
    console.log('📁 No collections directory found');
    return [];
  }

  const collectionFiles = fs.readdirSync(collectionsDir)
    .filter(file => file.endsWith('.yml') || file.endsWith('.yaml'))
    .map(file => {
      const filePath = path.join(collectionsDir, file);
      const content = fs.readFileSync(filePath, 'utf8');
      const { data } = parseYamlFrontmatter(content);

      return {
        id: path.basename(file, path.extname(file)),
        file: file,
        name: data.name || 'Unnamed Collection',
        description: data.description || 'No description',
        version: data.version || '1.0.0'
      };
    });

  return collectionFiles;
}

// CLI interface
function main() {
  const args = process.argv.slice(2);
  const command = args[0];

  if (!command) {
    console.log('Usage:');
    console.log('  node create-collection.js create <collection-id> [options]');
    console.log('  node create-collection.js list');
    console.log('');
    console.log('Examples:');
    console.log('  node create-collection.js create my-collection');
    console.log('  node create-collection.js create hooks --name "WordPress Hooks" --description "Custom hooks collection"');
    console.log('  node create-collection.js list');
    process.exit(0);
  }

  try {
    switch (command) {
      case 'create':
        const collectionId = args[1];
        if (!collectionId) {
          throw new Error('Collection ID is required for create command');
        }

        // Parse options
        const options = {};
        for (let i = 2; i < args.length; i += 2) {
          const option = args[i];
          const value = args[i + 1];

          if (option.startsWith('--') && value) {
            const optionName = option.slice(2);
            options[optionName] = value;
          }
        }

        createCollection(collectionId, options);
        break;

      case 'list':
        const collections = listCollections();
        if (collections.length === 0) {
          console.log('📄 No collections found');
        } else {
          console.log('📚 Found collections:');
          collections.forEach(collection => {
            console.log(`   ${collection.id} - ${collection.name} (v${collection.version})`);
            console.log(`     ${collection.description}`);
            console.log();
          });
        }
        break;

      default:
        throw new Error(`Unknown command: ${command}`);
    }

  } catch (error) {
    console.error(`❌ Error: ${error.message}`);
    process.exit(1);
  }
}

if (require.main === module) {
  main();
}

module.exports = {
  createCollection,
  listCollections,
  generateCollectionContent,
  getPluginDefaults
};

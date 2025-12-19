/**
 * YAML Parser for WordPress Plugin Collections
 * Handles parsing of YAML frontmatter and collection data
 */

const fs = require("fs");
const path = require("path");

/**
 * Parse YAML frontmatter from markdown content
 * @param {string} content - The markdown content with YAML frontmatter
 * @returns {object} Parsed YAML data
 */
function parseYamlFrontmatter(content) {
  const lines = content.split('\n');
  const yamlLines = [];
  let inFrontmatter = false;
  let frontmatterEnd = -1;

  for (let i = 0; i < lines.length; i++) {
    const line = lines[i].trim();

    if (i === 0 && line === '---') {
      inFrontmatter = true;
      continue;
    }

    if (inFrontmatter && line === '---') {
      frontmatterEnd = i;
      break;
    }

    if (inFrontmatter) {
      yamlLines.push(lines[i]);
    }
  }

  if (frontmatterEnd === -1) {
    return { data: {}, content: content };
  }

  const yamlContent = yamlLines.join('\n');
  const markdownContent = lines.slice(frontmatterEnd + 1).join('\n');

  try {
    const data = parseSimpleYaml(yamlContent);
    return { data, content: markdownContent };
  } catch (error) {
    console.error('Error parsing YAML:', error.message);
    return { data: {}, content: content };
  }
}

/**
 * Simple YAML parser for basic key-value pairs and arrays
 * @param {string} yaml - YAML content to parse
 * @returns {object} Parsed data
 */
function parseSimpleYaml(yaml) {
  const result = {};
  const lines = yaml.split('\n');

  for (const line of lines) {
    const trimmed = line.trim();
    if (!trimmed || trimmed.startsWith('#')) continue;

    if (trimmed.includes(':')) {
      const [key, ...valueParts] = trimmed.split(':');
      const value = valueParts.join(':').trim();

      if (value.startsWith('[') && value.endsWith(']')) {
        // Parse array
        const arrayContent = value.slice(1, -1);
        result[key.trim()] = arrayContent.split(',').map(item => item.trim().replace(/['"]/g, ''));
      } else if (value.startsWith('"') && value.endsWith('"')) {
        // Parse quoted string
        result[key.trim()] = value.slice(1, -1);
      } else if (value === 'true') {
        result[key.trim()] = true;
      } else if (value === 'false') {
        result[key.trim()] = false;
      } else if (!isNaN(value) && value !== '') {
        result[key.trim()] = Number(value);
      } else {
        result[key.trim()] = value;
      }
    }
  }

  return result;
}

/**
 * Parse collection YAML file
 * @param {string} filePath - Path to the collection YAML file
 * @returns {object} Collection data
 */
function parseCollectionYaml(filePath) {
  try {
    if (!fs.existsSync(filePath)) {
      throw new Error(`Collection file not found: ${filePath}`);
    }

    const content = fs.readFileSync(filePath, 'utf8');
    const { data } = parseYamlFrontmatter(content);

    return data;
  } catch (error) {
    console.error(`Error reading collection file ${filePath}:`, error.message);
    return {};
  }
}

module.exports = {
  parseYamlFrontmatter,
  parseSimpleYaml,
  parseCollectionYaml
};

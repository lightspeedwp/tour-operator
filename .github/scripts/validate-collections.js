#!/usr/bin/env node

/**
 * WordPress Plugin Collection Validator
 * Validates collection files and plugin metadata
 */

const fs = require("fs");
const path = require("path");
const { parseCollectionYaml, parseYamlFrontmatter } = require("./yaml-parser");

// Required collection fields
const REQUIRED_COLLECTION_FIELDS = ['name', 'description', 'version'];
const OPTIONAL_COLLECTION_FIELDS = ['author', 'homepage', 'tags', 'license'];

// Validate collection structure
function validateCollection(collectionPath) {
  const errors = [];
  const warnings = [];

  try {
    if (!fs.existsSync(collectionPath)) {
      errors.push(`Collection file does not exist: ${collectionPath}`);
      return { errors, warnings };
    }

    const collection = parseCollectionYaml(collectionPath);

    // Check required fields
    REQUIRED_COLLECTION_FIELDS.forEach(field => {
      if (!collection[field]) {
        errors.push(`Missing required field: ${field}`);
      }
    });

    // Validate field types
    if (collection.name && typeof collection.name !== 'string') {
      errors.push('Field "name" must be a string');
    }

    if (collection.description && typeof collection.description !== 'string') {
      errors.push('Field "description" must be a string');
    }

    if (collection.version && typeof collection.version !== 'string') {
      errors.push('Field "version" must be a string');
    }

    if (collection.tags && !Array.isArray(collection.tags)) {
      errors.push('Field "tags" must be an array');
    }

    // Check for unknown fields
    Object.keys(collection).forEach(field => {
      if (!REQUIRED_COLLECTION_FIELDS.includes(field) && !OPTIONAL_COLLECTION_FIELDS.includes(field)) {
        warnings.push(`Unknown field: ${field}`);
      }
    });

  } catch (error) {
    errors.push(`Error parsing collection: ${error.message}`);
  }

  return { errors, warnings };
}

// Validate plugin files
function validatePlugin() {
  const errors = [];
  const warnings = [];

  // Check for main plugin file
  const pluginFiles = fs.readdirSync('.').filter(file =>
    file.endsWith('.php') && !file.startsWith('index')
  );

  if (pluginFiles.length === 0) {
    errors.push('No main plugin file found (*.php)');
    return { errors, warnings };
  }

  if (pluginFiles.length > 1) {
    warnings.push(`Multiple plugin files found: ${pluginFiles.join(', ')}`);
  }

  // Validate main plugin file
  const mainFile = pluginFiles[0];
  const content = fs.readFileSync(mainFile, 'utf8');

  // Check for required plugin headers
  const requiredHeaders = ['Plugin Name', 'Description', 'Version'];
  requiredHeaders.forEach(header => {
    const regex = new RegExp(`${header}:\\s*(.+)`, 'i');
    if (!regex.test(content)) {
      errors.push(`Missing required plugin header: ${header}`);
    }
  });

  // Check for WordPress security best practices
  if (!content.includes('defined(') && !content.includes('ABSPATH')) {
    warnings.push('Consider adding WordPress security check (ABSPATH or defined check)');
  }

  return { errors, warnings };
}

// Validate GitHub Copilot structure
function validateCopilotStructure() {
  const errors = [];
  const warnings = [];

  const expectedDirs = [
    '.github/prompts',
    '.github/instructions',
    '.github/agents',
    '.github/chatmodes'
  ];

  expectedDirs.forEach(dir => {
    if (!fs.existsSync(dir)) {
      warnings.push(`GitHub Copilot directory missing: ${dir}`);
    }
  });

  // Check VS Code settings
  if (!fs.existsSync('.vscode/settings.json')) {
    warnings.push('VS Code settings.json not found');
  } else {
    try {
      const settings = JSON.parse(fs.readFileSync('.vscode/settings.json', 'utf8'));
      const requiredSettings = [
        'chat.agentFilesLocations',
        'chat.promptFilesLocations',
        'chat.instructionsFilesLocations',
        'chat.modeFilesLocations'
      ];

      requiredSettings.forEach(setting => {
        if (!settings[setting]) {
          warnings.push(`VS Code setting missing: ${setting}`);
        }
      });
    } catch (error) {
      errors.push(`Error parsing VS Code settings: ${error.message}`);
    }
  }

  return { errors, warnings };
}

// Main validation function
function validateAll(collectionId = null) {
  console.log('🔍 Validating WordPress plugin...\n');

  let totalErrors = 0;
  let totalWarnings = 0;

  // Validate plugin
  console.log('📦 Validating plugin structure...');
  const pluginValidation = validatePlugin();
  if (pluginValidation.errors.length > 0) {
    console.log('❌ Plugin errors:');
    pluginValidation.errors.forEach(error => console.log(`   - ${error}`));
    totalErrors += pluginValidation.errors.length;
  }
  if (pluginValidation.warnings.length > 0) {
    console.log('⚠️  Plugin warnings:');
    pluginValidation.warnings.forEach(warning => console.log(`   - ${warning}`));
    totalWarnings += pluginValidation.warnings.length;
  }
  if (pluginValidation.errors.length === 0 && pluginValidation.warnings.length === 0) {
    console.log('✅ Plugin structure is valid');
  }
  console.log();

  // Validate collections if they exist
  const collectionsDir = './collections';
  if (fs.existsSync(collectionsDir)) {
    console.log('📚 Validating collections...');
    const collectionFiles = fs.readdirSync(collectionsDir)
      .filter(file => file.endsWith('.yml') || file.endsWith('.yaml'));

    if (collectionId) {
      const specificFile = collectionFiles.find(file => file.startsWith(collectionId));
      if (specificFile) {
        const validation = validateCollection(path.join(collectionsDir, specificFile));
        console.log(`Collection: ${specificFile}`);
        if (validation.errors.length > 0) {
          console.log('❌ Errors:');
          validation.errors.forEach(error => console.log(`   - ${error}`));
          totalErrors += validation.errors.length;
        }
        if (validation.warnings.length > 0) {
          console.log('⚠️  Warnings:');
          validation.warnings.forEach(warning => console.log(`   - ${warning}`));
          totalWarnings += validation.warnings.length;
        }
        if (validation.errors.length === 0 && validation.warnings.length === 0) {
          console.log('✅ Collection is valid');
        }
      } else {
        console.log(`❌ Collection not found: ${collectionId}`);
        totalErrors++;
      }
    } else {
      collectionFiles.forEach(file => {
        const validation = validateCollection(path.join(collectionsDir, file));
        console.log(`Collection: ${file}`);
        if (validation.errors.length > 0) {
          console.log('❌ Errors:');
          validation.errors.forEach(error => console.log(`   - ${error}`));
          totalErrors += validation.errors.length;
        }
        if (validation.warnings.length > 0) {
          console.log('⚠️  Warnings:');
          validation.warnings.forEach(warning => console.log(`   - ${warning}`));
          totalWarnings += validation.warnings.length;
        }
        if (validation.errors.length === 0 && validation.warnings.length === 0) {
          console.log('✅ Collection is valid');
        }
        console.log();
      });
    }
  }

  // Validate GitHub Copilot structure
  console.log('🤖 Validating GitHub Copilot structure...');
  const copilotValidation = validateCopilotStructure();
  if (copilotValidation.errors.length > 0) {
    console.log('❌ Copilot errors:');
    copilotValidation.errors.forEach(error => console.log(`   - ${error}`));
    totalErrors += copilotValidation.errors.length;
  }
  if (copilotValidation.warnings.length > 0) {
    console.log('⚠️  Copilot warnings:');
    copilotValidation.warnings.forEach(warning => console.log(`   - ${warning}`));
    totalWarnings += copilotValidation.warnings.length;
  }
  if (copilotValidation.errors.length === 0 && copilotValidation.warnings.length === 0) {
    console.log('✅ GitHub Copilot structure is valid');
  }

  // Summary
  console.log('\n📊 Validation Summary:');
  console.log(`   Errors: ${totalErrors}`);
  console.log(`   Warnings: ${totalWarnings}`);

  if (totalErrors > 0) {
    console.log('\n❌ Validation failed with errors');
    process.exit(1);
  } else if (totalWarnings > 0) {
    console.log('\n⚠️  Validation completed with warnings');
  } else {
    console.log('\n✅ All validations passed!');
  }
}

// CLI interface
if (require.main === module) {
  const collectionId = process.argv[2];
  validateAll(collectionId);
}

module.exports = {
  validateCollection,
  validatePlugin,
  validateCopilotStructure,
  validateAll
};

/**
 * Prettier configuration for Tour Operator plugin
 * Extends WordPress default config with project-specific overrides
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-prettier-config/
 */
const wordpressConfig = require('@wordpress/prettier-config');

module.exports = {
  ...wordpressConfig,
  // Project-specific overrides
  tabWidth: 4,
  useTabs: false,
  printWidth: 80,
};

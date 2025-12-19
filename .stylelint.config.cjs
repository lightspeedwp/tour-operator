module.exports = {
  extends: ['@wordpress/stylelint-config'],
  rules: {
    // Tour Operator specific overrides
    'selector-class-pattern': [
      '^[a-z]([a-z0-9-]+)?(__([a-z0-9]+-?)+)?(--([a-z0-9]+-?)+){0,2}$|^(tour-operator|lsx|to)-[a-z0-9-]+$',
      {
        message: 'Expected class selector to follow BEM naming or use tour-operator/lsx/to prefix',
      },
    ],
    'custom-property-pattern': [
      '^(tour-operator|lsx|to)-[a-z0-9-]+$',
      {
        message: 'Expected custom property to use tour-operator/lsx/to prefix',
      },
    ],
    // Allow vendor prefixes for better browser support
    'property-no-vendor-prefix': null,
    'value-no-vendor-prefix': null,
    // More flexible color values for WordPress themes
    'color-named': null,
    // Allow empty stylesheets (common in WordPress development)
    'no-empty-source': null,
  },
  ignoreFiles: [
    'build/**/*.css',
    'node_modules/**/*.css',
    'vendor/**/*.css',
    '**/*.min.css',
  ],
};

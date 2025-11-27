/**
 * Babel configuration for Tour Operator plugin
 * Uses WordPress default preset for consistent build process
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-babel-preset-default/
 */
module.exports = {
	presets: [
		'@wordpress/babel-preset-default',
	],
	env: {
		production: {
			plugins: [
				[
					'@wordpress/babel-plugin-makepot',
					{
						output: 'languages/tour-operator.pot',
					},
				],
			],
		},
	},
};

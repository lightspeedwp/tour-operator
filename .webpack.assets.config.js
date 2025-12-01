const path = require( 'path' );
const MiniCssExtractPlugin = require( 'mini-css-extract-plugin' );

// Custom plugin to generate .asset.php files like wp-scripts
class AssetPhpPlugin {
	apply( compiler ) {
		compiler.hooks.compilation.tap( 'AssetPhpPlugin', ( compilation ) => {
			compilation.hooks.processAssets.tap(
				{
					name: 'AssetPhpPlugin',
					stage: compilation.constructor.PROCESS_ASSETS_STAGE_ADDITIONAL,
				},
				( assets ) => {
					// Get the package.json version for the asset files
					const packageJson = require( './package.json' );
					const version = packageJson.version || '1.0.0';

					// Generate .asset.php for each JS entry point
					for ( const [entryName, entrypoint] of compilation.entrypoints ) {
						// Only generate asset.php for entries that produce JS files
						if ( assets[ entryName + '.js' ] ) {
							// Collect dependencies (this is a simplified version)
							const dependencies = [];
							
							// Add common WordPress dependencies based on file type
							if ( entryName.includes( 'admin' ) ) {
								dependencies.push( 'wp-element', 'wp-components', 'wp-i18n' );
							}
							if ( entryName.includes( 'block' ) || entryName.includes( 'editor' ) ) {
								dependencies.push( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components' );
							}
							
							// Default dependencies for all JS files
							dependencies.push( 'wp-polyfill' );

							// Generate the PHP content in WordPress format
							const assetContent = `<?php return array('dependencies' => array(${dependencies.map(dep => `'${dep}'`).join(', ')}), 'version' => '${version}');`;
							
							// Add the .asset.php file to compilation assets
							compilation.emitAsset( entryName + '.asset.php', {
								source: () => assetContent,
								size: () => assetContent.length
							});
						}
					}
				}
			);
		});
	}
}

module.exports = {
	mode: process.env.NODE_ENV || 'production',
	entry: {
		// CSS entries
		'metaboxes': './src/css/metaboxes.scss',
		'style': './src/css/index.scss',
		'admin': './src/css/admin.scss',

		// JS entries
		'admin-script': './src/js/admin.js',
		'custom': './src/js/custom.js',
		'maps': './src/js/maps.js',
		'modals': './src/js/modals.js',
		'scporder': './src/js/scporder.js',
		'metabox-structure': './src/js/metabox-structure.js',

		// Additional JS files (not actual blocks with index.js)
		'general': './src/js/blocks/general.js',
		'linked-cover': './src/js/blocks/linked-cover.js',
		'slider-query': './src/js/blocks/slider-query.js',
		'slotfills': './src/js/blocks/slotfills.js',
	},
	output: {
		path: path.resolve( __dirname, 'build' ),
		filename: '[name].js',
	},
	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: /node_modules/,
				use: {
					loader: 'babel-loader',
					options: {
						presets: [ '@babel/preset-env' ],
					},
				},
			},
			{
				test: /\.s?css$/,
				use: [
					MiniCssExtractPlugin.loader,
					'css-loader',
					'postcss-loader',
					'sass-loader',
				],
			},
		],
	},
	plugins: [
		new MiniCssExtractPlugin( {
			filename: '[name].css',
		} ),
		new AssetPhpPlugin(),
	],
	resolve: {
		alias: {
			'@utils': path.resolve( __dirname, 'src/js/utils' ),
		},
	},
};
const path = require( 'path' );
const MiniCssExtractPlugin = require( 'mini-css-extract-plugin' );

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
	],
	resolve: {
		alias: {
			'@utils': path.resolve( __dirname, 'src/js/utils' ),
		},
	},
};
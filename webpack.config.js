
/**
 * External dependencies
 */
const RemoveEmptyScriptsPlugin = require( 'webpack-remove-empty-scripts' );
const path = require( 'path' );
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );

module.exports = {
	...defaultConfig,
	entry: {
		...defaultConfig.entry(),
		'metaboxes': path.resolve( process.cwd(), 'src/css/metaboxes.scss' ),
		'style': path.resolve( process.cwd(), 'src/css/index.scss' ),
		'admin': path.resolve( process.cwd(), 'src/css/admin.scss' ),

		'admin-script': path.resolve( process.cwd(), 'src/js/admin.js' ),
		'custom': path.resolve( process.cwd(), 'src/js/custom.js' ),
		'maps': path.resolve( process.cwd(), 'src/js/maps.js' ),
		'modals': path.resolve( process.cwd(), 'src/js/modals.js' ),
		'scporder': path.resolve( process.cwd(), 'src/js/scporder.js' ),
		'metabox-structure': path.resolve( process.cwd(), 'src/js/metabox-structure.js' ),

		// blocks
		'general': path.resolve( process.cwd(), 'src/js/blocks/general.js' ),
		'linked-cover': path.resolve( process.cwd(), 'src/js/blocks/linked-cover.js' ),
		'slider-query': path.resolve( process.cwd(), 'src/js/blocks/slider-query.js' ),
		'slotfills': path.resolve( process.cwd(), 'src/js/blocks/slotfills.js' ),
	},

	plugins: [
		...defaultConfig.plugins,
		new RemoveEmptyScriptsPlugin(),
	]
};

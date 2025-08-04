wp.domReady(() => {

wp.blocks.registerBlockVariation('core/button', {
        name: 'lsx-tour-operator/permalink-button',
	title: 'Permalink',
		icon: 'admin-links',
		description: 'Add a button with a link to the current item.',
		category: "lsx-tour-operator",
		attributes: {
			className: 'lsx-to-link permalink',
			metadata: {
				name: 'Permalink'
			},
			text: 'View More',
			url: '#permalink',
		},
		supports: {
			renaming: false
		}
    });

});
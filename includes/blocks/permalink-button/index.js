wp.domReady(() => {

wp.blocks.registerBlockVariation('core/button', {
        name: 'lsx-tour-operator/permalink-button',
        title: 'Permalink',
		description: 'Add a button with a link to the current item.',
		category: "lsx-tour-operator",
		attributes: {
			className: 'lsx-to-link permalink',
			metadata: {
				name: 'Permalink'
			},
			style: {
				border: {
					radius: {
						topLeft: '0px 8px 8px 0px',
						topRight: '0px 8px 8px 0px',
						bottomLeft: '8px',
						bottomRight: '8px'
					}
				}
			},
			backgroundColor: 'primary',
			width: 100,
			text: 'View More',
			url: '#permalink',
		},
		supports: {
			renaming: false
		}
    });

});
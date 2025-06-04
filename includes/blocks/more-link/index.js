wp.domReady(() => {

wp.blocks.registerBlockVariation('core/button', {
        name: 'lsx-tour-operator/more-link',
        title: 'More Button',
		icon: 'insert-after',
		name: 'core/button',
		category: "lsx-tour-operator",
		attributes: {
			className: 'lsx-to-more-link more-link',
			metadata: {
				name: 'More Button'
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
		},
		supports: {
			renaming: false
		}
    });

});
wp.domReady(() => {

wp.blocks.registerBlockVariation('core/video', {
	name: 'lsx-tour-operator/video',
	title: 'Tour Video',
	icon: wp.element.createElement(
		"svg",
		{ xmlns: "http://www.w3.org/2000/svg", width: 20, height: 20, viewBox: "0 0 20 20", fill: "none" },
		wp.element.createElement("path", {
			d: "M3 4C2.44772 4 2 4.44772 2 5V15C2 15.5523 2.44772 16 3 16H17C17.5523 16 18 15.5523 18 15V5C18 4.44772 17.5523 4 17 4H3ZM8 7L13 10L8 13V7Z",
			fill: "currentColor"
		})
	),
	category: 'lsx-tour-operator',
	attributes: {
		metadata: {
			name: 'Tour Video',
		},
		className: 'lsx-video-wrapper',
		controls: true,
		playsInline: true,
		preload: 'metadata'
	},
	supports: {
		renaming: false,
		anchor: true,
		spacing: {
			margin: true,
			padding: true
		}
	},
	isActive: (blockAttributes, variationAttributes) => {
		return blockAttributes.className && 
			blockAttributes.className.includes('lsx-video-wrapper');
	}
});

// Register a video gallery block variation
wp.blocks.registerBlockVariation('core/group', {
	name: 'lsx-tour-operator/video-gallery',
	title: 'Video Gallery',
	icon: wp.element.createElement(
		"svg",
		{ xmlns: "http://www.w3.org/2000/svg", width: 20, height: 20, viewBox: "0 0 20 20", fill: "none" },
		wp.element.createElement("path", {
			d: "M2 3C1.44772 3 1 3.44772 1 4V16C1 16.5523 1.44772 17 2 17H9V15H3V5H17V8H19V4C19 3.44772 18.5523 3 18 3H2Z",
			fill: "currentColor"
		}),
		wp.element.createElement("path", {
			d: "M12 10C11.4477 10 11 10.4477 11 11V17C11 17.5523 11.4477 18 12 18H18C18.5523 18 19 17.5523 19 17V11C19 10.4477 18.5523 10 18 10H12ZM14 12L17 14.5L14 17V12Z",
			fill: "currentColor"
		})
	),
	category: 'lsx-tour-operator',
	attributes: {
		metadata: {
			name: 'Video Gallery',
		},
		className: 'lsx-video-gallery-wrapper',
		layout: {
			type: 'constrained'
		}
	},
	innerBlocks: [
		['core/heading', {
			level: 3,
			content: 'Videos'
		}],
		['core/group', {
			className: 'lsx-video-gallery-grid',
			layout: {
				type: 'grid',
				columnCount: 2,
				minimumColumnWidth: '250px'
			}
		}, [
			['lsx-tour-operator/video', {
				className: 'lsx-video-item'
			}],
			['lsx-tour-operator/video', {
				className: 'lsx-video-item'
			}]
		]]
	],
	supports: {
		renaming: false,
		anchor: true
	}
});

});
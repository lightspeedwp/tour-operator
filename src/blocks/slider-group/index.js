import { registerBlockType } from '@wordpress/blocks';
import { InnerBlocks, InspectorControls, useBlockProps, useInnerBlocksProps, BlockControls } from '@wordpress/block-editor';
import { PanelBody, ToggleControl, RangeControl, __experimentalNumberControl as NumberControl, ToolbarGroup, ToolbarButton } from '@wordpress/components';
import { useEffect, useRef, useState } from '@wordpress/element';
import { useSelect, useDispatch } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

import { initializeSlider } from './slider';

// Import styles
import './style.scss';
import './editor.scss';

const SliderIcon = () => (
	<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
		<path d="M3 7h4v10H3V7zm6 0h4v10H9V7zm6 0h4v10h-4V7z" />
		<path d="M2 5h20v2H2V5zm0 12h20v2H2v-2z" />
	</svg>
);

const ChevronLeft = () => (
	<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
		<polyline points="15,18 9,12 15,6"></polyline>
	</svg>
);

const ChevronRight = () => (
	<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
		<polyline points="9,18 15,12 9,6"></polyline>
	</svg>
);

const Edit = ({ attributes, setAttributes, clientId }) => {
	const {
		maxSlides = 1,
		infinite = true,
		itemMinWidth = 250,
		itemMaxWidth = 580,
		maxSlidesMobile = 1,
		showArrows = true,
		showDots = true,
		slidesToScroll = 1
	} = attributes;

	const sliderRef = useRef(null);
	const [currentSlide, setCurrentSlide] = useState(0);

	const { innerBlocks } = useSelect(
		(select) => ({
			innerBlocks: select('core/block-editor').getBlocks(clientId),
		}),
		[clientId]
	);

	const { selectBlock } = useDispatch('core/block-editor');

	// Function to add a new slide
	const addNewSlide = () => {
		const slideNumber = innerBlocks.length + 1;
		const newSlide = wp.blocks.createBlock('core/group', {
			className: 'slider-slide',
			layout: { type: 'constrained' },
		}, [
			wp.blocks.createBlock('core/paragraph', {
				placeholder: `Add your content here for slide ${slideNumber}`
			})
		]);

		// Use replaceInnerBlocks to add the new slide to the existing innerBlocks
		const { replaceInnerBlocks } = wp.data.dispatch('core/block-editor');
		const updatedBlocks = [...innerBlocks, newSlide];
		replaceInnerBlocks(clientId, updatedBlocks);

		setCurrentSlide(innerBlocks.length);
		// Select the new slide block
		setTimeout(() => {
			selectBlock(newSlide.clientId);
		}, 50);
	};

	// Navigation functions for editor
	const goToPreviousSlide = () => {
		if (innerBlocks.length === 0) return;

		const prevIndex = infinite
			? (currentSlide === 0 ? innerBlocks.length - 1 : currentSlide - 1)
			: Math.max(currentSlide - 1, 0);

		setCurrentSlide(prevIndex);

		if (innerBlocks[prevIndex]) {
			try {
				selectBlock(innerBlocks[prevIndex].clientId);
			} catch (error) {
				console.warn('Error selecting block:', error);
			}
		}
	};

	const goToNextSlide = () => {
		if (innerBlocks.length === 0) return;

		const nextIndex = infinite
			? (currentSlide + 1) % innerBlocks.length
			: Math.min(currentSlide + 1, innerBlocks.length - 1);

		setCurrentSlide(nextIndex);

		// Select the slide block but don't manipulate DOM in editor
		if (innerBlocks[nextIndex]) {
			try {
				selectBlock(innerBlocks[nextIndex].clientId);
			} catch (error) {
				console.warn('Error selecting block:', error);
			}
		}
	};

	// Block props with data attributes for frontend
	const blockProps = useBlockProps({
		className: 'wp-block-lsx-tour-operator-slider',
		ref: sliderRef,
		'data-max-slides': maxSlides,
		'data-infinite': infinite,
		'data-item-min-width': itemMinWidth,
		'data-item-max-width': itemMaxWidth,
		'data-max-slides-mobile': maxSlidesMobile,
		'data-show-arrows': showArrows,
		'data-show-dots': showDots,
		'data-slides-to-scroll': slidesToScroll,
		'data-is-editor': 'true' // Add this to identify editor context
	});

	const innerBlocksProps = useInnerBlocksProps({
		className: 'slider-wrapper',
		style: {
			width: `${itemMaxWidth}px`,
			maxWidth: `100%`,
			margin: '20px auto'
		}
	}, {
		template: [
			['core/group', {
				className: 'slider-slide',
				layout: { type: 'constrained' },
				templateLock: false
			}, [
				['core/paragraph', { placeholder: 'Add your content here for slide 1' }]
			]],
			['core/group', {
				className: 'slider-slide',
				layout: { type: 'constrained' },
				templateLock: false
			}, [
				['core/paragraph', { placeholder: 'Add your content here for slide 2' }]
			]],
		],
		templateLock: false,
		__experimentalLayout: {
			type: 'flex',
			orientation: 'horizontal'
		}
	});

	useEffect(() => {
		if (currentSlide >= innerBlocks.length && innerBlocks.length > 0) {
			setCurrentSlide(Math.max(0, innerBlocks.length - 1));
		}

		// Move WordPress layout classes from .slider-wrapper to .slider-slides-wrapper
		if (sliderRef.current) {
			const sliderWrapper = sliderRef.current.querySelector('.slider-wrapper');
			const slidesWrapper = sliderRef.current.querySelector('.slider-slides-wrapper');

			if (sliderWrapper && slidesWrapper) {
				// Find any WordPress layout container classes
				const layoutClasses = Array.from(sliderWrapper.classList).filter(className =>
					className.includes('wp-container-') && className.includes('-is-layout-')
				);

				// Move layout classes to the slides wrapper
				layoutClasses.forEach(className => {
					sliderWrapper.classList.remove(className);
					slidesWrapper.classList.add(className);
				});
			}
		}

		// Apply editor-only slider effect with CSS transforms
		if (sliderRef.current && innerBlocks.length > 0) {
			const slides = sliderRef.current.querySelectorAll('.wp-block-group.slider-slide');
			slides.forEach((slide, index) => {
				if (index === currentSlide) {
					slide.style.display = 'block';
					slide.style.opacity = '1';
					slide.style.transform = 'translateX(0)';
				} else {
					slide.style.display = 'none';
					slide.style.opacity = '0';
				}
			});
		}
	}, [innerBlocks.length, currentSlide]);

	return (
		<>
			<BlockControls>
				<ToolbarGroup>
					<ToolbarButton
						icon={<ChevronLeft />}
						label={__('Previous slide', 'tour-operator')}
						onClick={goToPreviousSlide}
						disabled={!infinite && currentSlide === 0}
					/>
					<ToolbarButton
						icon={<ChevronRight />}
						label={__('Next slide', 'tour-operator')}
						onClick={goToNextSlide}
						disabled={!infinite && currentSlide === innerBlocks.length - 1}
					/>
				</ToolbarGroup>
			</BlockControls>

			<InspectorControls>
				<PanelBody title={__('Slider Settings', 'tour-operator')} initialOpen={true}>
					<RangeControl
						label={__('Max Slides (Desktop)', 'tour-operator')}
						value={maxSlides}
						onChange={(value) => setAttributes({ maxSlides: value })}
						min={1}
						max={6}
						step={1}
					/>
					<RangeControl
						label={__('Max Slides (Mobile)', 'tour-operator')}
						value={maxSlidesMobile}
						onChange={(value) => setAttributes({ maxSlidesMobile: value })}
						min={1}
						max={3}
						step={1}
					/>
					<NumberControl
						label={__('Min Slide Width (px)', 'tour-operator')}
						value={itemMinWidth}
						onChange={(value) => setAttributes({ itemMinWidth: parseInt(value) || 250 })}
						min={100}
						max={800}
					/>
					<NumberControl
						label={__('Max Slide Width (px)', 'tour-operator')}
						value={itemMaxWidth}
						onChange={(value) => setAttributes({ itemMaxWidth: parseInt(value) || 1000 })}
						min={200}
						max={1000}
					/>
					<ToggleControl
						label={__('Infinite Loop', 'tour-operator')}
						checked={infinite}
						onChange={(value) => setAttributes({ infinite: value })}
					/>
					<ToggleControl
						label={__('Show Arrows', 'tour-operator')}
						checked={showArrows}
						onChange={(value) => setAttributes({ showArrows: value })}
					/>
					<ToggleControl
						label={__('Show Dots', 'tour-operator')}
						checked={showDots}
						onChange={(value) => setAttributes({ showDots: value })}
					/>
					<NumberControl
						label={__('Slides to Scroll', 'tour-operator')}
						value={slidesToScroll}
						onChange={(value) => setAttributes({ slidesToScroll: parseInt(value) || 1 })}
						min={1}
						max={maxSlides}
					/>
				</PanelBody>
			</InspectorControls>

			<div {...blockProps}>
				<div className="slider-group-container">
					{innerBlocks.length > 1 && (
						<div className="inner-block-slider-controls">
							<button
								className="inner-block-slider-control inner-block-slider-control--previous"
								onClick={goToPreviousSlide}
								disabled={!infinite && currentSlide === 0}
								type="button"
								aria-label={__('Previous slide', 'tour-operator')}
							>
								←
							</button>

							<span className="inner-block-slider-control__label">
								{currentSlide + 1} / {innerBlocks.length}
							</span>

							<button
								className="inner-block-slider-control inner-block-slider-control--next"
								onClick={goToNextSlide}
								disabled={!infinite && currentSlide === innerBlocks.length - 1}
								type="button"
								aria-label={__('Next slide', 'tour-operator')}
							>
								→
							</button>

							<button
								className="inner-block-slider-control inner-block-slider-control--add"
								onClick={addNewSlide}
								type="button"
								aria-label={__('Add new slide', 'tour-operator')}
							>
								+
							</button>
						</div>
					)}

					<div className="inner-block-slider">
						<div {...innerBlocksProps} />
					</div>
				</div>
			</div>
		</>
	);
};

const Save = ({ attributes }) => {
	const {
		maxSlides = 1,
		infinite = true,
		itemMinWidth = 250,
		itemMaxWidth = 1000,
		maxSlidesMobile = 1,
		showArrows = true,
		showDots = true
	} = attributes || {};

	const blockProps = useBlockProps.save({
		className: 'wp-block-lsx-tour-operator-slider',
		'data-max-slides': maxSlides,
		'data-infinite': infinite,
		'data-item-min-width': itemMinWidth,
		'data-item-max-width': itemMaxWidth,
		'data-max-slides-mobile': maxSlidesMobile,
		'data-show-arrows': showArrows,
		'data-show-dots': showDots
	});

	return (
		<div {...blockProps}>
			<div className="slider-group-container">
				<div className="inner-block-slider">
					<div className="slider-wrapper">
						<InnerBlocks.Content />
					</div>
				</div>
			</div>
		</div>
	);
};

// Register the standalone slider block
registerBlockType('lsx-tour-operator/slider-group', {
	icon: SliderIcon,
	edit: Edit,
	save: Save,
});

document.addEventListener('DOMContentLoaded', () => {
	const sliderElements = document.querySelectorAll('.wp-block-lsx-tour-operator-slider');
	sliderElements.forEach(element => {
		if (element.dataset.isEditor === 'true') {
			return;
		}

		const options = {
			maxSlides: parseInt(element.dataset.maxSlides) || 1,
			infinite: element.dataset.infinite !== 'false',
			itemMinWidth: parseInt(element.dataset.itemMinWidth) || 250,
			itemMaxWidth: parseInt(element.dataset.itemMaxWidth) || 1000,
			maxSlidesMobile: parseInt(element.dataset.maxSlidesMobile) || 1,
			showArrows: element.dataset.showArrows !== 'false',
			showDots: element.dataset.showDots !== 'false',
			slidesToScroll: parseInt(element.dataset.slidesToScroll) || 1
		};
		initializeSlider(element, options);
	});
});

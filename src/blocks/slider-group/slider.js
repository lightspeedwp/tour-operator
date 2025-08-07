/**
 * Slider functionality for both editor and frontend
 */

class SliderGroup {
	constructor(element, options = {}) {
		this.element = element;
		this.options = {
			maxSlides: 1,
			infinite: true,
			itemMinWidth: 250,
			itemMaxWidth: 1000,
			maxSlidesMobile: 1,
			showArrows: true,
			showDots: true,
			onSlideChange: null,
			isEditor: false,
			slidesToScroll: 1, // NEW OPTION
			...options
		};

		this.currentSlide = 0;
		this.slides = [];
		this.slidesContainer = null;
		this.arrowLeft = null;
		this.arrowRight = null;
		this.dotsContainer = null;
		this.isDragging = false;
		this.startX = 0;
		this.startY = 0;
		this.dragThreshold = 50;

		this.init();
	}

	init() {
		this.setupSlider();
		this.createNavigation();
		this.bindEvents();
		this.updateSlider();
	}

	setupSlider() {
		// Find or create slides container
		this.slidesContainer = this.element.querySelector('.slider-wrapper') ||
			this.element.querySelector('.wp-block-group__inner-container') ||
			this.element;

		// Get all slide elements (group blocks) - exclude any existing wrapper
		this.slides = Array.from(this.slidesContainer.children).filter(child =>
			(child.classList.contains('wp-block-group') ||
				child.classList.contains('slider-slide') ||
				child.getAttribute('data-type') === 'core/group' ||
				child.querySelector('[data-type="core/group"]')) &&
			!child.classList.contains('slider-slides-wrapper') && // Exclude existing wrapper
			!child.classList.contains('slider-slide-appender') // Exclude appender
		);

		// Add slider classes
		this.element.classList.add('slider-group-active');

		// For editor, don't manipulate DOM - just work with existing structure
		if (this.options.isEditor) {
			this.slidesWrapper = this.slidesContainer;
		} else {
			// Only create wrapper on frontend if we don't already have one and we have slides
			const existingWrapper = this.slidesContainer.querySelector('.slider-slides-wrapper');
			if (this.slides.length > 0 && !existingWrapper) {
				const slidesWrapper = document.createElement('div');
				slidesWrapper.className = 'slider-slides-wrapper';

				// Move slides to wrapper (frontend only)
				this.slides.forEach(slide => {
					slidesWrapper.appendChild(slide);
				});

				this.slidesContainer.appendChild(slidesWrapper);
				this.slidesWrapper = slidesWrapper;
			} else {
				this.slidesWrapper = existingWrapper || this.slidesContainer;
				if (existingWrapper) {
					this.slides = Array.from(this.slidesWrapper.children).filter(child =>
						!child.classList.contains('slider-slide-appender')
					);
				}
			}
		}

		// Mark slides and set up initial positioning
		this.slides.forEach((slide, index) => {
			slide.classList.add('slider-slide');
			slide.setAttribute('data-slide-index', index);
		});
	}

	createNavigation() {
		// Remove existing navigation
		const existingNav = this.element.querySelectorAll('.slider-nav, .slider-dots');
		existingNav.forEach(nav => nav.remove());

		// Create arrows (only on frontend, not in editor)
		if (this.options.showArrows && this.slides.length > 1 && !this.options.isEditor) {
			this.createArrows();
		}

		// Create dots (only on frontend, not in editor)
		if (this.options.showDots && this.slides.length > 1 && !this.options.isEditor) {
			this.createDots();
		}
	}

	createArrows() {
		const navContainer = document.createElement('div');
		navContainer.className = 'slider-nav';

		this.arrowLeft = document.createElement('button');
		this.arrowLeft.className = 'slider-arrow slider-arrow-left';
		this.arrowLeft.innerHTML = `
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
				<polyline points="15,18 9,12 15,6"></polyline>
			</svg>
		`;
		this.arrowLeft.setAttribute('aria-label', 'Previous slide');
		this.arrowLeft.type = 'button';

		this.arrowRight = document.createElement('button');
		this.arrowRight.className = 'slider-arrow slider-arrow-right';
		this.arrowRight.innerHTML = `
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
				<polyline points="9,18 15,12 9,6"></polyline>
			</svg>
		`;
		this.arrowRight.setAttribute('aria-label', 'Next slide');
		this.arrowRight.type = 'button';

		navContainer.appendChild(this.arrowLeft);
		navContainer.appendChild(this.arrowRight);

		// Safely insert navigation - use the main element and find a safe insertion point
		const sliderGroupContainer = this.element.querySelector('.slider-group-container');
		if (sliderGroupContainer) {
			sliderGroupContainer.appendChild(navContainer);
		} else {
			this.element.appendChild(navContainer);
		}
	}

	createDots() {
		this.dotsContainer = document.createElement('div');
		this.dotsContainer.className = 'slider-dots';

		const isMobile = window.innerWidth < 768;
		const visibleSlides = isMobile ? this.options.maxSlidesMobile : this.options.maxSlides;
		const slidesToScroll = this.options.slidesToScroll || 1;
		const dotCount = Math.max(1, Math.ceil((this.slides.length - visibleSlides) / slidesToScroll) + 1);

		for (let i = 0; i < dotCount; i++) {
			const dot = document.createElement('button');
			dot.className = 'slider-dot';
			dot.setAttribute('data-slide', i * slidesToScroll);
			dot.setAttribute('aria-label', `Go to slide ${i * slidesToScroll + 1}`);
			dot.type = 'button';

			// Mark dot as active if it matches the current slide group
			const start = i * slidesToScroll;
			const end = start + slidesToScroll;
			if (this.currentSlide >= start && this.currentSlide < end) {
				dot.classList.add('active');
			}

			this.dotsContainer.appendChild(dot);
		}

		this.element.appendChild(this.dotsContainer);
	}

	bindEvents() {
		// Arrow navigation
		if (this.arrowLeft) {
			this.arrowLeft.addEventListener('click', (e) => {
				e.preventDefault();
				e.stopPropagation();
				this.previousSlide();
			});
		}

		if (this.arrowRight) {
			this.arrowRight.addEventListener('click', (e) => {
				e.preventDefault();
				e.stopPropagation();
				this.nextSlide();
			});
		}

		// Dot navigation
		if (this.dotsContainer) {
			this.dotsContainer.addEventListener('click', (e) => {
				if (e.target.classList.contains('slider-dot')) {
					e.preventDefault();
					e.stopPropagation();
					const slideIndex = parseInt(e.target.getAttribute('data-slide'));
					this.goToSlide(slideIndex);
				}
			});
		}

		// Touch/swipe support
		this.bindTouchEvents();

		// Resize handling
		this.resizeHandler = this.debounce(() => {
			this.updateSlider();
		}, 250);
		window.addEventListener('resize', this.resizeHandler);
	}

	bindTouchEvents() {
		if (!this.slidesWrapper) return;

		// Touch start
		this.slidesWrapper.addEventListener('touchstart', (e) => {
			this.startX = e.touches[0].clientX;
			this.startY = e.touches[0].clientY;
			this.isDragging = true;
		}, { passive: true });

		// Touch move
		this.slidesWrapper.addEventListener('touchmove', (e) => {
			if (!this.isDragging) return;

			const currentX = e.touches[0].clientX;
			const currentY = e.touches[0].clientY;
			const diffX = this.startX - currentX;
			const diffY = this.startY - currentY;

			// If vertical scroll is more significant, don't interfere
			if (Math.abs(diffY) > Math.abs(diffX)) {
				return;
			}

			// Prevent default to stop page scrolling during horizontal swipe
			e.preventDefault();
		}, { passive: false });

		// Touch end
		this.slidesWrapper.addEventListener('touchend', (e) => {
			if (!this.isDragging) return;

			const endX = e.changedTouches[0].clientX;
			const endY = e.changedTouches[0].clientY;
			const diffX = this.startX - endX;
			const diffY = this.startY - endY;

			// Reset dragging state
			this.isDragging = false;

			// Check if it's a horizontal swipe (more horizontal than vertical)
			if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > this.dragThreshold) {
				if (diffX > 0) {
					// Swiped left, go to next slide
					this.nextSlide();
				} else {
					// Swiped right, go to previous slide
					this.previousSlide();
				}
			}
		}, { passive: true });

		// Mouse events for desktop drag support
		this.slidesWrapper.addEventListener('mousedown', (e) => {
			this.startX = e.clientX;
			this.startY = e.clientY;
			this.isDragging = true;
			e.preventDefault();
		});

		this.slidesWrapper.addEventListener('mousemove', (e) => {
			if (!this.isDragging) return;
			e.preventDefault();
		});

		this.slidesWrapper.addEventListener('mouseup', (e) => {
			if (!this.isDragging) return;

			const endX = e.clientX;
			const diffX = this.startX - endX;

			this.isDragging = false;

			if (Math.abs(diffX) > this.dragThreshold) {
				if (diffX > 0) {
					this.nextSlide();
				} else {
					this.previousSlide();
				}
			}
		});

		// Handle mouse leave to stop dragging
		this.slidesWrapper.addEventListener('mouseleave', () => {
			this.isDragging = false;
		});
	}

	nextSlide() {
		const isMobile = window.innerWidth < 768;
		const visibleSlides = isMobile ? this.options.maxSlidesMobile : this.options.maxSlides;
		const slidesToScroll = this.options.slidesToScroll || 1;
		if (this.options.infinite) {
			this.currentSlide = (this.currentSlide + slidesToScroll) % this.slides.length;
			// Prevent showing empty space if not enough slides left
			if (this.currentSlide > this.slides.length - visibleSlides) {
				this.currentSlide = 0;
			}
		} else {
			this.currentSlide = Math.min(this.currentSlide + slidesToScroll, this.slides.length - visibleSlides);
		}
		this.updateSlider();
	}

	previousSlide() {
		const isMobile = window.innerWidth < 768;
		const visibleSlides = isMobile ? this.options.maxSlidesMobile : this.options.maxSlides;
		const slidesToScroll = this.options.slidesToScroll || 1;
		if (this.options.infinite) {
			this.currentSlide = (this.currentSlide - slidesToScroll + this.slides.length) % this.slides.length;
			if (this.currentSlide < 0) {
				this.currentSlide = this.slides.length - visibleSlides;
			}
		} else {
			this.currentSlide = Math.max(this.currentSlide - slidesToScroll, 0);
		}
		this.updateSlider();
	}

	goToSlide(index) {
		if (index >= 0 && index < this.slides.length) {
			this.currentSlide = index;
			this.updateSlider();
		}
	}

	updateSlider() {
		if (this.slides.length === 0) return;

		const isMobile = window.innerWidth < 768;
		const visibleSlides = isMobile ? this.options.maxSlidesMobile : this.options.maxSlides;
		const slideWidth = 100 / visibleSlides;

		// Setup the slides wrapper (the actual container that moves)
		if (this.slidesWrapper) {
			this.slidesWrapper.style.display = 'flex';
			this.slidesWrapper.style.transition = 'transform 0.3s ease';
			this.slidesWrapper.style.width = `${(this.slides.length) * 100}%`;

			this.slidesWrapper.style.minWidth = `${this.options.itemMinWidth}px`;
			this.slidesWrapper.style.maxWidth = `${this.options.itemMaxWidth}px`;
			this.slidesWrapper.style.margin = '20px auto';
		}

		// Update slide positions and visibility
		this.slides.forEach((slide, index) => {
			slide.style.width = `${slideWidth}%`;
			slide.style.minWidth = `${this.options.itemMinWidth}px`;
			slide.style.maxWidth = `${this.options.itemMaxWidth}px`;
			slide.style.flex = '0 0 auto';
			slide.style.boxSizing = 'border-box';
			slide.style.padding = '0 8px';

			// Animate opacity
			slide.style.transition = 'opacity 0.4s ease';

			// Mark active slide
			if (index === this.currentSlide) {
				slide.classList.add('active-slide');
			} else {
				slide.classList.remove('active-slide');
			}

			// Hide slides that are not in view using opacity
			if (index >= this.currentSlide && index < this.currentSlide + visibleSlides) {
				slide.style.opacity = '1';
				slide.style.pointerEvents = '';
			} else {
				slide.style.opacity = '0';
				slide.style.pointerEvents = 'none';
			}
		});

		// Move wrapper to show current slide
		const translateX = -(this.currentSlide * slideWidth);
		if (this.slidesWrapper) {
			this.slidesWrapper.style.transform = `translateX(${translateX}%)`;
		}

		// Update navigation states
		this.updateNavigationStates();

		// Update dots
		this.updateDots();

		// Trigger callback
		if (this.options.onSlideChange) {
			this.options.onSlideChange(this.currentSlide);
		}
	}

	updateNavigationStates() {
		if (!this.options.infinite) {
			if (this.arrowLeft) {
				this.arrowLeft.disabled = this.currentSlide === 0;
			}
			if (this.arrowRight) {
				this.arrowRight.disabled = this.currentSlide === this.slides.length - 1;
			}
		}
	}

	updateDots() {
		if (this.dotsContainer) {
			const isMobile = window.innerWidth < 768;
			const visibleSlides = isMobile ? this.options.maxSlidesMobile : this.options.maxSlides;
			const slidesToScroll = this.options.slidesToScroll || 1;
			const dotCount = Math.max(1, Math.ceil((this.slides.length - visibleSlides) / slidesToScroll) + 1);
			const currentDot = Math.floor(this.currentSlide / slidesToScroll);
			const dots = this.dotsContainer.querySelectorAll('.slider-dot');
			dots.forEach((dot, index) => {
				if (index === currentDot) {
					dot.classList.add('active');
				} else {
					dot.classList.remove('active');
				}
			});
		}
	}

	destroy() {
		// Remove event listeners
		if (this.resizeHandler) {
			window.removeEventListener('resize', this.resizeHandler);
		}

		// Remove navigation
		const navElements = this.element.querySelectorAll('.slider-nav, .slider-dots');
		navElements.forEach(nav => nav.remove());

		// Reset styles
		this.slides.forEach(slide => {
			slide.style.transform = '';
			slide.style.width = '';
			slide.style.minWidth = '';
			slide.style.maxWidth = '';
			slide.style.flex = '';
			slide.style.position = '';
			slide.style.flexShrink = '';
			slide.style.boxSizing = '';
			slide.style.padding = '';
			slide.classList.remove('slider-slide', 'active-slide');
		});

		if (this.slidesContainer) {
			this.slidesContainer.style.display = '';
			this.slidesContainer.style.transition = '';
			this.slidesContainer.style.width = '';
			this.slidesContainer.style.transform = '';
		}

		// Remove slider classes
		this.element.classList.remove('slider-group-active');
		if (this.slidesContainer) {
			this.slidesContainer.classList.remove('slider-container', 'slider-slides-wrapper');
		}
	}

	debounce(func, wait) {
		let timeout;
		return function executedFunction(...args) {
			const later = () => {
				clearTimeout(timeout);
				func(...args);
			};
			clearTimeout(timeout);
			timeout = setTimeout(later, wait);
		};
	}
}

// Export functions for use in the block
export function initializeSlider(element, options) {
	console.log('Initializing slider with options:', options);
	return new SliderGroup(element, options);
}

export function destroySlider(sliderInstance) {
	if (sliderInstance && sliderInstance.destroy) {
		sliderInstance.destroy();
	}
}

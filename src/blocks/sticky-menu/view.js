/**
 * Sticky Menu Scripts
 *
 * @package Tour_Operator
 * @subpackage scripts
 */

// Extend the lsx_to object with sticky menu functionality
if (typeof lsx_to === 'undefined') {
    window.lsx_to = Object.create(null);
}

// Sticky menu state
lsx_to.sticky_menu = {
    current_section: '',
    menu_items: [],
    is_mobile: false,
    observer: null
};

/**
 * Scroll to section functionality.
 *
 * @param {string} section_id - The ID of the section to scroll to
 * @package Tour_Operator
 * @subpackage scripts
 */
lsx_to.scroll_to_section = function(section_id) {
    const section = document.getElementById(section_id);

    if (section) {
        // Calculate offset for admin bar and fixed headers
        let top = section.offsetTop;

        top -= document.querySelector('#wpadminbar') ?
            document.querySelector('#wpadminbar').offsetHeight : 0;
        top -= document.querySelector('.top-menu-fixed #masthead') ?
            document.querySelector('.top-menu-fixed #masthead').offsetHeight : 0;
        top -= document.querySelector('.lsx-to-navigation') ?
            document.querySelector('.lsx-to-navigation').offsetHeight : 0;

        // Check user's motion preference
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        // Smooth scroll to section (respect motion preferences)
        window.scrollTo({
            top: top,
            behavior: prefersReducedMotion ? 'auto' : 'smooth'
        });

        // Update current section
        lsx_to.sticky_menu.current_section = section_id;
        lsx_to.update_active_menu_item(section_id);

        // Announce section change to screen readers
        lsx_to.announce_section_change(section_id);

        // Focus management: Set focus to the section for keyboard users
        setTimeout(() => {
            // Make section focusable temporarily if not already
            const originalTabIndex = section.getAttribute('tabindex');
            if (!originalTabIndex) {
                section.setAttribute('tabindex', '-1');
            }

            // Focus the section
            section.focus();

            // Remove temporary tabindex if we added it
            if (!originalTabIndex) {
                section.removeAttribute('tabindex');
            }
        }, prefersReducedMotion ? 0 : 500);
    }
};

/**
 * Toggle mobile section visibility.
 *
 * @param {Element} element - The section element or wrapper to toggle
 * @package Tour_Operator
 * @subpackage scripts
 */
lsx_to.toggle_mobile_section = function(element) {
	if (!element) return;

	// Find the wrapper (could be the element itself or its parent)
	let wrapper = element;
	if (element.classList.contains('sticky-menu-section-wrapper')) {
		wrapper = element;
	} else if (element.closest('.sticky-menu-section-wrapper')) {
		wrapper = element.closest('.sticky-menu-section-wrapper');
	} else if (element.hasAttribute('data-sticky-menu-section')) {
		// Legacy support for sections without wrapper
		wrapper = element;
	} else {
		console.warn('Could not find sticky menu section wrapper');
		return;
	}

	const is_expanded = wrapper.getAttribute('aria-expanded') === 'true';
	const new_expanded_state = !is_expanded;

	// Update wrapper aria-expanded
	wrapper.setAttribute('aria-expanded', new_expanded_state.toString());

	// Toggle the collapsed class
	if (new_expanded_state) {
		wrapper.classList.remove('collapsed');
	} else {
		wrapper.classList.add('collapsed');
	}

	// Update header button state
	const header_button = wrapper.querySelector('.section-header');
	if (header_button) {
		header_button.setAttribute('aria-expanded', new_expanded_state.toString());
	}
};

/**
 * Add mobile header to section.
 *
 * @param {Element} section - The section element
 * @param {Object} context - Section context data
 * @package Tour_Operator
 * @subpackage scripts
 */
lsx_to.add_mobile_header = function(section, context) {
	// Find the wrapper containing this section
	let wrapper = section.closest('.sticky-menu-section-wrapper');
	if (!wrapper) {
		// Legacy support: section itself might be the target
		wrapper = section;
	}

	// Check if header already exists (added by PHP)
	const existing_header = wrapper.querySelector('.section-header');
	if (!existing_header) {
		return;
	}


	// Get colors from sticky menu block and apply to header
	const sticky_menu = document.querySelector('.wp-block-lsx-tour-operator-sticky-menu');

  console.log(sticky_menu.classList);
	if (sticky_menu) {
    console.log('Applying sticky menu colors to mobile header');
		const color_classes = Array.from(sticky_menu.classList).filter(className =>
			className.startsWith('has-') && (
				className.includes('-color') ||
				className.includes('-background-color') ||
				className.includes('-background')
			)
		);

    const computedStyles = window.getComputedStyle(sticky_menu);
    existing_header.style.backgroundColor = computedStyles.backgroundColor;
    existing_header.style.color = computedStyles.color;
    existing_header.style.fontSize = computedStyles.fontSize;
    existing_header.style.padding = computedStyles.padding;
    existing_header.style.margin = computedStyles.margin;

		if (color_classes.length > 0) {
			existing_header.classList.add(...color_classes);
		}
	}

  // check if header button already has click listener
  const hasClickListener = existing_header.getAttribute('data-has-click-listener');
  if (hasClickListener === 'true') {
    return;
  }
  // Mark that we've added a click listener
  existing_header.setAttribute('data-has-click-listener', 'true');

	// Add click event listener to existing header
	existing_header.addEventListener('click', function(event) {
		event.preventDefault();
		lsx_to.toggle_mobile_section(wrapper);
	});

	// Add keyboard event listener for Enter, Space, and Escape keys
	existing_header.addEventListener('keydown', function(event) {
		switch(event.key) {
			case 'Enter':
			case ' ':
				event.preventDefault();
				lsx_to.toggle_mobile_section(wrapper);
				break;
			case 'Escape':
				event.preventDefault();
				// Always collapse on Escape if expanded
				const is_expanded = wrapper.getAttribute('aria-expanded') === 'true';
				if (is_expanded) {
					lsx_to.toggle_mobile_section(wrapper);
				}
				break;
		}
	});
};

/**
 * Update active menu item based on current section.
 *
 * @param {string} section_id - The ID of the active section
 * @package Tour_Operator
 * @subpackage scripts
 */
lsx_to.update_active_menu_item = function(section_id) {
    // Remove active class and aria-current from all menu buttons
    const menu_buttons = document.querySelectorAll('.wp-block-lsx-tour-operator-sticky-menu .sticky-menu-button');
    menu_buttons.forEach(button => {
        button.classList.remove('active');
        button.setAttribute('aria-current', 'false');
    });

    // Add active class and aria-current to current menu button
    const active_button = document.querySelector(`.wp-block-lsx-tour-operator-sticky-menu .sticky-menu-button[data-section-id="${section_id}"]`);
    if (active_button) {
        active_button.classList.add('active');
        active_button.setAttribute('aria-current', 'location');
    }
};

/**
 * Find the currently active section based on scroll position.
 *
 * @returns {string|null} - The ID of the active section
 * @package Tour_Operator
 * @subpackage scripts
 */
lsx_to.get_active_section_on_scroll = function() {
    const sections = document.querySelectorAll('[data-sticky-menu-section]');
    if (sections.length === 0) return null;

    // Calculate offset for admin bar and fixed headers
    let offset = 10; // Base offset
    const adminBar = document.querySelector('#wpadminbar');
    const masthead = document.querySelector('.top-menu-fixed #masthead');
    const stickyMenu = document.querySelector('.lsx-to-navigation');

    if (adminBar) offset += adminBar.offsetHeight;
    if (masthead) offset += masthead.offsetHeight;
    if (stickyMenu) offset += stickyMenu.offsetHeight;

    const scrollPos = window.scrollY + offset;
    let activeSection = null;

    // Find the section that is currently in view
    for (let i = sections.length - 1; i >= 0; i--) {
        const section = sections[i];
        const sectionTop = section.offsetTop;

        if (scrollPos >= sectionTop) {
            activeSection = section.id;
            break;
        }
    }

    // If no section is found above scroll position, use the first section
    if (!activeSection && sections.length > 0) {
        activeSection = sections[0].id;
    }

    return activeSection;
};

/**
 * Handle scroll events for scroll spy functionality.
 *
 * @package Tour_Operator
 * @subpackage scripts
 */
lsx_to.handle_scroll_spy = function() {
    if (lsx_to.sticky_menu.is_mobile) return;

    const activeSection = lsx_to.get_active_section_on_scroll();

    if (activeSection && lsx_to.sticky_menu.current_section !== activeSection) {
        lsx_to.sticky_menu.current_section = activeSection;
        lsx_to.update_active_menu_item(activeSection);
    }
};

/**
 * Initialize scroll spy functionality.
 *
 * @package Tour_Operator
 * @subpackage scripts
 */
lsx_to.initialize_scroll_spy = function() {
    // Check if mobile
    const check_mobile = function() {
        lsx_to.sticky_menu.is_mobile = window.innerWidth < 768;

        // Initialize mobile sections if on mobile
        if (lsx_to.sticky_menu.is_mobile) {
            lsx_to.initialize_mobile_sections();
            // Remove scroll listener on mobile
            window.removeEventListener('scroll', lsx_to.handle_scroll_spy);
        } else {
            lsx_to.cleanup_mobile_sections();
            // Add scroll listener for desktop
            window.addEventListener('scroll', lsx_to.handle_scroll_spy, { passive: true });
            // Initial check
            lsx_to.handle_scroll_spy();
        }
    };

    check_mobile();
    window.addEventListener('resize', check_mobile);

    // Initialize Intersection Observer for scroll spy (desktop only)
    if (!lsx_to.sticky_menu.is_mobile) {
        const sections = document.querySelectorAll('[data-sticky-menu-section]');

        // Only set up observer if sections exist
        if (sections.length > 0) {
            // Calculate offset for sticky headers
            let offset = 0;
            const adminBar = document.querySelector('#wpadminbar');
            const masthead = document.querySelector('.top-menu-fixed #masthead');
            const stickyMenu = document.querySelector('.lsx-to-navigation');

            if (adminBar) offset += adminBar.offsetHeight;
            if (masthead) offset += masthead.offsetHeight;
            if (stickyMenu) offset += stickyMenu.offsetHeight;

            // Convert offset to percentage for rootMargin
            const offsetPercentage = Math.min(50, Math.max(10, (offset / window.innerHeight) * 100));

            const observer_options = {
                root: null,
                rootMargin: `-${offsetPercentage}% 0px -${100 - offsetPercentage}% 0px`,
                threshold: [0, 0.1, 0.25, 0.5, 0.75, 1.0]
            };

            lsx_to.sticky_menu.observer = new IntersectionObserver(function(entries) {
                // Sort entries by their position in the viewport
                const visibleSections = entries
                    .filter(entry => entry.isIntersecting)
                    .sort((a, b) => a.boundingClientRect.top - b.boundingClientRect.top);

                if (visibleSections.length > 0) {
                    // Get the topmost visible section
                    const topSection = visibleSections[0];
                    const sectionId = topSection.target.id;

                    if (sectionId && lsx_to.sticky_menu.current_section !== sectionId) {
                        lsx_to.sticky_menu.current_section = sectionId;
                        lsx_to.update_active_menu_item(sectionId);
                    }
                }
            }, observer_options);

            // Observe all sections that are part of the sticky menu
            sections.forEach(function(section) {
                lsx_to.sticky_menu.observer.observe(section);
            });

            // Initial check for active section on page load
            setTimeout(() => {
                const firstVisibleSection = Array.from(sections).find(section => {
                    const rect = section.getBoundingClientRect();
                    return rect.top <= offset + 50 && rect.bottom >= offset;
                });

                if (firstVisibleSection) {
                    lsx_to.sticky_menu.current_section = firstVisibleSection.id;
                    lsx_to.update_active_menu_item(firstVisibleSection.id);
                }
            }, 100);
        } else {
            console.log('No sections found for scroll spy initialization');
        }
    }

    // Update menu items from DOM
    lsx_to.update_menu_items();
    lsx_to.setup_menu_click_handlers();
};/**
 * Update menu items array from DOM.
 *
 * @package Tour_Operator
 * @subpackage scripts
 */
lsx_to.update_menu_items = function() {
    const sections = document.querySelectorAll('[data-sticky-menu-section]');

    // Check if sections exist before processing
    if (sections.length === 0) {
        lsx_to.sticky_menu.menu_items = [];
        return;
    }

    lsx_to.sticky_menu.menu_items = Array.from(sections).map(function(section) {
        return {
            id: section.id,
            title: section.getAttribute('data-section-title') || section.id
        };
    });
};

/**
 * Setup click handlers for menu items.
 *
 * @package Tour_Operator
 * @subpackage scripts
 */
lsx_to.setup_menu_click_handlers = function() {
    const menu_items = document.querySelectorAll('.wp-block-lsx-tour-operator-sticky-menu .menu-item');

    // Check if menu items exist before setting up handlers
    if (menu_items.length === 0) {
        return;
    }

    menu_items.forEach(function(item) {
        // Enhance button accessibility
        const button = item.querySelector('.sticky-menu-button');
        if (button) {
            const section_id = item.getAttribute('data-section-id');
            const section_title = button.textContent.trim();

            // Add descriptive aria-label
            button.setAttribute('aria-label', `Navigate to ${section_title} section`);

            // Add role and aria-current for active state
            button.setAttribute('role', 'tab');
            button.setAttribute('aria-current', 'false');
        }

        item.addEventListener('click', function(event) {
            event.preventDefault();
            const section_id = this.getAttribute('data-section-id');
            if (section_id) {
                lsx_to.scroll_to_section(section_id);
            }
        });

        // Add keyboard support for menu items
        item.addEventListener('keydown', function(event) {
            const section_id = this.getAttribute('data-section-id');
            if (section_id && (event.key === 'Enter' || event.key === ' ')) {
                event.preventDefault();
                lsx_to.scroll_to_section(section_id);
            }
        });
    });
};

/**
 * Initialize mobile sections with collapsible functionality.
 *
 * @package Tour_Operator
 * @subpackage scripts
 */
lsx_to.initialize_mobile_sections = function() {
	const sections = document.querySelectorAll('[data-sticky-menu-section]');

	// Check if sections exist before processing
	if (sections.length === 0) {
		return;
	}

	sections.forEach(function(section) {
		const section_title = section.getAttribute('data-section-title') || section.id;
		const context = {
			section_id: section.id,
			section_title: section_title,
			is_collapsed: true
		};

		// Find the wrapper (new structure) or use section (legacy)
		let wrapper = section.closest('.sticky-menu-section-wrapper');
		if (!wrapper) {
			wrapper = section; // Legacy support
		}

		// Add collapsed class by default to wrapper
		wrapper.classList.add('collapsed');
		wrapper.setAttribute('aria-expanded', 'false');

		// Setup mobile header (PHP already added it, we just need to add functionality)
		lsx_to.add_mobile_header(section, context);
	});
};

/**
 * Cleanup mobile sections when switching to desktop.
 *
 * @package Tour_Operator
 * @subpackage scripts
 */
lsx_to.cleanup_mobile_sections = function() {
	const sections = document.querySelectorAll('[data-sticky-menu-section]');

	sections.forEach(function(section) {
		// Find the wrapper (new structure) or use section (legacy)
		let wrapper = section.closest('.sticky-menu-section-wrapper');
		if (!wrapper) {
			wrapper = section; // Legacy support
		}

		// Remove mobile classes and attributes from wrapper
		wrapper.classList.remove('collapsed');
		wrapper.removeAttribute('aria-expanded');

		// Reset header state but don't remove it (it's added by PHP)
		const header = wrapper.querySelector('.section-header');
		if (header) {
			header.setAttribute('aria-expanded', 'false');
		}
	});
};

/**
 * Cleanup sticky menu functionality.
 *
 * @package Tour_Operator
 * @subpackage scripts
 */
lsx_to.cleanup_sticky_menu = function() {
    // Remove scroll event listener
    window.removeEventListener('scroll', lsx_to.handle_scroll_spy);

    // Disconnect Intersection Observer
    if (lsx_to.sticky_menu.observer) {
        lsx_to.sticky_menu.observer.disconnect();
        lsx_to.sticky_menu.observer = null;
    }

    // Reset state
    lsx_to.sticky_menu.current_section = '';
    lsx_to.sticky_menu.menu_items = [];
};

/**
 * Announce section changes to screen readers.
 *
 * @param {string} section_id - The ID of the active section
 * @package Tour_Operator
 * @subpackage scripts
 */
lsx_to.announce_section_change = function(section_id) {
    // Get or create aria-live region
    let announcer = document.getElementById('sticky-menu-announcer');
    if (!announcer) {
        announcer = document.createElement('div');
        announcer.id = 'sticky-menu-announcer';
        announcer.setAttribute('aria-live', 'polite');
        announcer.setAttribute('aria-atomic', 'true');
        announcer.className = 'sr-only';
        document.body.appendChild(announcer);
    }

    // Get section title for announcement
    const section = document.getElementById(section_id);
    const section_title = section ?
        (section.getAttribute('data-section-title') || section_id) :
        section_id;

    // Announce the change
    announcer.textContent = `Navigated to ${section_title} section`;

    // Clear the announcement after a short delay
    setTimeout(() => {
        announcer.textContent = '';
    }, 1000);
};

/**
 * Initialize sticky menu functionality.
 *
 * @package Tour_Operator
 * @subpackage scripts
 */
lsx_to.initialize_sticky_menu = function() {
    // Only initialize if sticky menu block exists
    const sticky_menu_block = document.querySelector('.wp-block-lsx-tour-operator-sticky-menu');
    if (!sticky_menu_block) {
        return;
    }

    // Check if any sections exist before proceeding
    const sections = document.querySelectorAll('[data-sticky-menu-section]');
    if (sections.length === 0) {
        return;
    } else {
      for (const menuItem of sticky_menu_block.querySelectorAll('.menu-item')) {
          const sectionId = menuItem.getAttribute('data-section-id');
          const correspondingSection = document.getElementById(sectionId);

          if (correspondingSection) {
              menuItem.style.display = 'block';
          } else {
              menuItem.style.display = 'none';
          }
      }

      // change the opacity of the sticky menu to 1
      sticky_menu_block.style.opacity = '1';
    }

    // Small delay to ensure all blocks are rendered
    setTimeout(function() {
        lsx_to.initialize_scroll_spy();
    }, 100);
};

/**
 * Initialize when DOM is ready.
 */
document.addEventListener('DOMContentLoaded', function() {
    lsx_to.initialize_sticky_menu();
});

/**
 * Cleanup when page is unloaded.
 */
window.addEventListener('beforeunload', function() {
    lsx_to.cleanup_sticky_menu();
});

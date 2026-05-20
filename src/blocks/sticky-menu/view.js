/**
 * Sticky Menu Scripts - Frontend Functionality
 *
 * Provides interactive functionality for the sticky menu block including
 * scroll spy, mobile collapsible sections, and smooth scrolling navigation.
 *
 * @package Tour_Operator
 * @subpackage Blocks
 * @since 2.1.0
 */

/**
 * Initialize the lsx_to global namespace if it doesn't exist.
 *
 * @since 2.1.0
 */
if (typeof lsx_to === 'undefined') {
    window.lsx_to = Object.create(null);
}

/**
 * Sticky menu state object.
 *
 * Maintains the current state of the sticky menu functionality
 * including active sections, menu items, and mobile state.
 *
 * @since 2.1.0
 * @type {Object}
 * @property {string} current_section Currently active section ID.
 * @property {Array} menu_items Array of menu item objects.
 * @property {boolean} is_mobile Whether the interface is in mobile mode.
 * @property {IntersectionObserver|null} observer Intersection observer instance.
 */
lsx_to.sticky_menu = {
    current_section: '',
    menu_items: [],
    is_mobile: false,
    observer: null
};

/**
 * Get the total extra offset from any externally-registered sticky headers.
 *
 * Reads the CSS selector stored in the block's data-sticky-offset-selector
 * attribute and measures that element's height. Also checks
 * window.lsx_to_sticky_offset_selectors (array of selector strings) so
 * themes or plugins can register additional headers programmatically.
 *
 * @since 2.2.0
 * @return {number} Total pixel height to add to the offset.
 */
lsx_to.get_extra_sticky_offset = function () {
    let extra = 0;

    // Selectors registered programmatically by themes / plugins.
    const global_selectors = Array.isArray(window.lsx_to_sticky_offset_selectors)
        ? window.lsx_to_sticky_offset_selectors
        : [];

    // Selector stored on the block element itself via the block attribute.
    const block_selector_el = document.querySelector(
        '.wp-block-lsx-tour-operator-sticky-menu[data-sticky-offset-selector]'
    );
    const block_selector = block_selector_el
        ? block_selector_el.getAttribute('data-sticky-offset-selector')
        : '';

    const all_selectors = block_selector
        ? [...global_selectors, block_selector]
        : global_selectors;

    all_selectors.forEach(function (selector) {
        if (!selector) return;
        const el = document.querySelector(selector);
        if (el) {
            extra += el.offsetHeight;
        }
    });

    return extra;
};

/**
 * Apply sticky top offset to the menu element.
 *
 * Combines admin bar height and user-configured sticky header offsets,
 * then applies the final pixel value to the sticky menu's top position.
 *
 * @since 2.2.0
 * @return {number} The applied pixel offset.
 */
lsx_to.apply_sticky_menu_offset = function () {
    const sticky_menu_block = document.querySelector('.wp-block-lsx-tour-operator-sticky-menu');
    if (!sticky_menu_block) {
        return 0;
    }

    let offset = 0;
    const admin_bar = document.querySelector('#wpadminbar');

    if (admin_bar) {
        offset += admin_bar.offsetHeight;
    }

    offset += lsx_to.get_extra_sticky_offset();

    sticky_menu_block.style.top = `${offset}px`;

    // Keep legacy selector support aligned if present in older markup.
    const legacy_sticky_menu = sticky_menu_block.querySelector('.lsx-to-sticky-menu');
    if (legacy_sticky_menu) {
        legacy_sticky_menu.style.top = `${offset}px`;
    }

    return offset;
};

/**
 * Scroll to a specific section with smooth animation.
 *
 * Calculates proper offset for fixed headers and admin bar,
 * then scrolls to the target section with accessibility support.
 *
 * @since 2.1.0
 * @param {string} section_id The ID of the section to scroll to.
 */
lsx_to.scroll_to_section = function (section_id) {
    const section = document.getElementById(section_id);

    if (section) {
        // Calculate offset for admin bar and fixed headers
        let offset = 0;
        offset += document.querySelector('#wpadminbar') ?
            document.querySelector('#wpadminbar').offsetHeight : 0;
        offset += document.querySelector('.top-menu-fixed #masthead') ?
            document.querySelector('.top-menu-fixed #masthead').offsetHeight : 0;
        offset += document.querySelector('.lsx-to-navigation') ?
            document.querySelector('.lsx-to-navigation').offsetHeight : 0;
        offset += lsx_to.get_extra_sticky_offset();

        // Use getBoundingClientRect for accurate position relative to viewport
        const rect = section.getBoundingClientRect();
        const top = window.pageYOffset + rect.top - offset + 5;

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

            // Focus the section without scrolling (preventScroll prevents interference)
            section.focus({ preventScroll: true });

            // Remove temporary tabindex if we added it
            if (!originalTabIndex) {
                section.removeAttribute('tabindex');
            }
        }, prefersReducedMotion ? 0 : 500);
    }
};

/**
 * Toggle mobile section visibility with accessibility support.
 *
 * Toggles the expanded/collapsed state of mobile sections and updates
 * ARIA attributes for screen reader accessibility.
 *
 * @since 2.1.0
 * @param {Element} element The section element or wrapper to toggle.
 */
lsx_to.toggle_mobile_section = function (element) {
    if (!element) return;

    // Find the wrapper (could be the element itself or its parent)
    let wrapper = element;
    if (element.classList.contains('lsx-to-sticky-menu-section-wrapper')) {
        wrapper = element;
    } else if (element.closest('.lsx-to-sticky-menu-section-wrapper')) {
        wrapper = element.closest('.lsx-to-sticky-menu-section-wrapper');
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
    const header_button = wrapper.querySelector('.lsx-to-section-header');
    if (header_button) {
        header_button.setAttribute('aria-expanded', new_expanded_state.toString());
    }
};

/**
 * Add mobile header functionality to a section.
 *
 * Sets up mobile header buttons with click and keyboard event handlers,
 * applies styling from the sticky menu block, and manages accessibility.
 *
 * @since 2.1.0
 * @param {Element} section The section element.
 * @param {Object} context Section context data including ID and title.
 */
lsx_to.add_mobile_header = function (section, context) {
    // Find the wrapper containing this section
    let wrapper = section.closest('.lsx-to-sticky-menu-section-wrapper');
    if (!wrapper) {
        // Legacy support: section itself might be the target
        wrapper = section;
    }

    // Check if header already exists (added by PHP)
    const existing_header = wrapper.querySelector('.lsx-to-section-header');
    if (!existing_header) {
        return;
    }


    // Get colors from sticky menu block and apply to header
    const sticky_menu = document.querySelector('.wp-block-lsx-tour-operator-sticky-menu');
    const sticky_menu_buttons = sticky_menu ? sticky_menu.querySelectorAll('.lsx-to-sticky-menu-button') : null;

    if (sticky_menu) {
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

        // get padding from the buttons
        if (sticky_menu_buttons && sticky_menu_buttons.length > 0) {
            const buttonStyles = window.getComputedStyle(sticky_menu_buttons[0]);
            existing_header.style.padding = buttonStyles.padding;
        }

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
    existing_header.addEventListener('click', function (event) {
        event.preventDefault();
        lsx_to.toggle_mobile_section(wrapper);
    });

    // Add keyboard event listener for Enter, Space, and Escape keys
    existing_header.addEventListener('keydown', function (event) {
        switch (event.key) {
            case 'Enter':
            case ' ':
                event.preventDefault();
                lsx_to.toggle_mobile_section(wrapper);
                break;
            case 'Escape':
                {
                    event.preventDefault();
                    // Always collapse on Escape if expanded
                    const is_expanded = wrapper.getAttribute('aria-expanded') === 'true';
                    if (is_expanded) {
                        lsx_to.toggle_mobile_section(wrapper);
                    }
                    break;
                }
            default:
                break;
        }
    });
};

/**
 * Update active menu item based on current section.
 *
 * Removes active state from all menu buttons and applies it to the
 * button corresponding to the currently active section.
 *
 * @since 2.1.0
 * @param {string} section_id The ID of the active section.
 */
lsx_to.update_active_menu_item = function (section_id) {
    // Remove active class and aria-current from all menu buttons
    const menu_buttons = document.querySelectorAll('.wp-block-lsx-tour-operator-sticky-menu .lsx-to-sticky-menu-button');
    menu_buttons.forEach(button => {
        button.classList.remove('active');
        button.setAttribute('aria-current', 'false');
    });

    // Add active class and aria-current to current menu button
    const active_button = document.querySelector(`.wp-block-lsx-tour-operator-sticky-menu .lsx-to-sticky-menu-button[data-section-id="${section_id}"]`);
    if (active_button) {
        active_button.classList.add('active');
        active_button.setAttribute('aria-current', 'location');
    }
};

/**
 * Find the currently active section based on scroll position.
 *
 * Calculates which section is currently visible in the viewport,
 * accounting for fixed headers and admin bar offsets.
 *
 * @since 2.1.0
 * @return {string|null} The ID of the active section, or null if none found.
 */
lsx_to.get_active_section_on_scroll = function () {
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
    offset += lsx_to.get_extra_sticky_offset();

    let activeSection = null;
    let closestDistance = Infinity;

    // Find the section that is currently in view
    // The section whose top is closest to (but not below) the offset line is active
    Array.from(sections).forEach(section => {
        const rect = section.getBoundingClientRect();
        const sectionTop = rect.top;
        
        // Check if section top is above or at the offset line
        if (sectionTop <= offset) {
            const distance = offset - sectionTop;
            // This section is above the line - check if it's the closest one
            if (distance < closestDistance) {
                closestDistance = distance;
                activeSection = section.id;
            }
        }
    });

    // If no section is found above scroll position, use the first section
    if (!activeSection && sections.length > 0) {
        activeSection = sections[0].id;
    }

    return activeSection;
};

/**
 * Handle scroll events for scroll spy functionality.
 *
 * Monitors scroll position and updates the active menu item accordingly.
 * Only active on desktop; mobile uses collapsible sections instead.
 *
 * @since 2.1.0
 */
lsx_to.handle_scroll_spy = function () {
    if (lsx_to.sticky_menu.is_mobile) return;

    const activeSection = lsx_to.get_active_section_on_scroll();

    if (activeSection && lsx_to.sticky_menu.current_section !== activeSection) {
        lsx_to.sticky_menu.current_section = activeSection;
        lsx_to.update_active_menu_item(activeSection);
    }
};

/**
 * Initialize scroll spy functionality with responsive behavior.
 *
 * Sets up scroll spy for desktop and mobile section collapsing for mobile.
 * Uses Intersection Observer for better performance on desktop.
 *
 * @since 2.1.0
 */
lsx_to.initialize_scroll_spy = function () {
    // Check if mobile
    const check_mobile = function () {
        lsx_to.apply_sticky_menu_offset();
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
            offset += lsx_to.get_extra_sticky_offset();

            // Convert offset to percentage for rootMargin
            const offsetPercentage = Math.min(50, Math.max(10, (offset / window.innerHeight) * 100));

            const observer_options = {
                root: null,
                rootMargin: `-${offsetPercentage}% 0px -${100 - offsetPercentage}% 0px`,
                threshold: [0, 0.1, 0.25, 0.5, 0.75, 1.0]
            };

            lsx_to.sticky_menu.observer = new IntersectionObserver(function (entries) {
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
            sections.forEach(function (section) {
                lsx_to.sticky_menu.observer.observe(section);
            });

            // Initial check for active section on page load
            setTimeout(() => {
                // Find all visible sections
                const visibleSections = Array.from(sections)
                    .filter(section => {
                        const rect = section.getBoundingClientRect();
                        return rect.top <= offset + 50 && rect.bottom >= offset;
                    })
                    .sort((a, b) => {
                        // Sort by position - topmost first
                        return a.getBoundingClientRect().top - b.getBoundingClientRect().top;
                    });

                // Use the topmost visible section, or the first section if none are visible
                const activeSection = visibleSections.length > 0 ? visibleSections[0] : sections[0];
                
                if (activeSection) {
                    lsx_to.sticky_menu.current_section = activeSection.id;
                    lsx_to.update_active_menu_item(activeSection.id);
                }
            }, 100);
        }
    }

    // Update menu items from DOM
    lsx_to.update_menu_items();
    lsx_to.setup_menu_click_handlers();
};

/**
 * Update menu items array from DOM elements.
 *
 * Scans the page for sections with sticky menu attributes and builds
 * an array of menu item objects for internal tracking.
 *
 * @since 2.1.0
 */
lsx_to.update_menu_items = function () {
    const sections = document.querySelectorAll('[data-sticky-menu-section]');

    // Check if sections exist before processing
    if (sections.length === 0) {
        lsx_to.sticky_menu.menu_items = [];
        return;
    }

    lsx_to.sticky_menu.menu_items = Array.from(sections).map(function (section) {
        return {
            id: section.id,
            title: section.getAttribute('data-section-title') || section.id
        };
    });
};

/**
 * Setup click handlers for menu items with accessibility support.
 *
 * Adds click and keyboard event handlers to menu items for navigation
 * and enhances accessibility with proper ARIA attributes.
 *
 * @since 2.1.0
 */
lsx_to.setup_menu_click_handlers = function () {
    const menu_items = document.querySelectorAll('.wp-block-lsx-tour-operator-sticky-menu .lsx-to-sticky-menu-item');

    // Check if menu items exist before setting up handlers
    if (menu_items.length === 0) {
        return;
    }

    menu_items.forEach(function (item) {
        // Enhance button accessibility
        const button = item.querySelector('.lsx-to-sticky-menu-button');
        if (button) {
            const section_id = item.getAttribute('data-section-id');
            const section_title = button.textContent.trim();

            // Add descriptive aria-label
            button.setAttribute('aria-label', `Navigate to ${section_title} section`);

            // Add role and aria-current for active state
            button.setAttribute('role', 'tab');
            button.setAttribute('aria-current', 'false');
        }

        item.addEventListener('click', function (event) {
            event.preventDefault();
            const section_id = this.getAttribute('data-section-id');
            if (section_id) {
                lsx_to.scroll_to_section(section_id);
            }
        });

        // Add keyboard support for menu items
        item.addEventListener('keydown', function (event) {
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
 * Sets up mobile-specific behavior for sticky menu sections,
 * including collapsible headers and touch-friendly interactions.
 *
 * @since 2.1.0
 */
lsx_to.initialize_mobile_sections = function () {
    const sections = document.querySelectorAll('[data-sticky-menu-section]');

    // Check if sections exist before processing
    if (sections.length === 0) {
        return;
    }

    sections.forEach(function (section, index) {
        const section_title = section.getAttribute('data-section-title') || section.id;
        const is_first_section = index === 0;
        const context = {
            section_id: section.id,
            section_title: section_title,
            is_collapsed: !is_first_section
        };

        // Find the wrapper (new structure) or use section (legacy)
        let wrapper = section.closest('.lsx-to-sticky-menu-section-wrapper');
        if (!wrapper) {
            wrapper = section; // Legacy support
        }

        // First section is open by default on mobile, others are collapsed
        if (is_first_section) {
            wrapper.classList.remove('collapsed');
            wrapper.setAttribute('aria-expanded', 'true');
        } else {
            wrapper.classList.add('collapsed');
            wrapper.setAttribute('aria-expanded', 'false');
        }

        // Setup mobile header (PHP already added it, we just need to add functionality)
        lsx_to.add_mobile_header(section, context);
    });
};

/**
 * Cleanup mobile sections when switching to desktop.
 *
 * Removes mobile-specific classes and attributes when the interface
 * switches from mobile to desktop mode.
 *
 * @since 2.1.0
 */
lsx_to.cleanup_mobile_sections = function () {
    const sections = document.querySelectorAll('[data-sticky-menu-section]');

    sections.forEach(function (section) {
        // Find the wrapper (new structure) or use section (legacy)
        let wrapper = section.closest('.lsx-to-sticky-menu-section-wrapper');
        if (!wrapper) {
            wrapper = section; // Legacy support
        }

        // Remove mobile classes and attributes from wrapper
        wrapper.classList.remove('collapsed');
        wrapper.removeAttribute('aria-expanded');

        // Reset header state but don't remove it (it's added by PHP)
        const header = wrapper.querySelector('.lsx-to-section-header');
        if (header) {
            header.setAttribute('aria-expanded', 'false');
        }
    });
};

/**
 * Cleanup sticky menu functionality on page unload.
 *
 * Removes event listeners, disconnects observers, and resets state
 * to prevent memory leaks and conflicts.
 *
 * @since 2.1.0
 */
lsx_to.cleanup_sticky_menu = function () {
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
 * Creates or updates an ARIA live region to announce section changes
 * to users of assistive technologies.
 *
 * @since 2.1.0
 * @param {string} section_id The ID of the active section.
 */
lsx_to.announce_section_change = function (section_id) {
    // Get or create aria-live region
    let announcer = document.getElementById('lsx-to-sticky-menu-announcer');
    if (!announcer) {
        announcer = document.createElement('div');
        announcer.id = 'lsx-to-sticky-menu-announcer';
        announcer.setAttribute('aria-live', 'polite');
        announcer.setAttribute('aria-atomic', 'true');
        announcer.className = 'lsx-to-sr-only';
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
 * Initialize sticky menu functionality on page load.
 *
 * Main initialization function that sets up the sticky menu system,
 * checks for required elements, and starts the appropriate functionality.
 *
 * @since 2.1.0
 */
lsx_to.initialize_sticky_menu = function () {
    // Only initialize if sticky menu block exists
    const sticky_menu_block = document.querySelector('.wp-block-lsx-tour-operator-sticky-menu');
    if (!sticky_menu_block) {
        return;
    }

    lsx_to.apply_sticky_menu_offset();

    // Check if any sections exist before proceeding
    const sections = document.querySelectorAll('[data-sticky-menu-section]');
    if (sections.length === 0) {
        return;
    } else {
        for (const menuItem of sticky_menu_block.querySelectorAll('.lsx-to-sticky-menu-button')) {
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
    setTimeout(function () {
        lsx_to.initialize_scroll_spy();
    }, 100);
};

/**
 * Initialize when DOM is ready.
 *
 * Waits for the DOM to be fully loaded before initializing
 * the sticky menu functionality.
 *
 * @since 2.1.0
 */
document.addEventListener('DOMContentLoaded', function () {
    lsx_to.initialize_sticky_menu();
});

/**
 * Cleanup when page is unloaded.
 *
 * Performs cleanup operations before the page unloads
 * to prevent memory leaks and conflicts.
 *
 * @since 2.1.0
 */
window.addEventListener('beforeunload', function () {
    lsx_to.cleanup_sticky_menu();
});

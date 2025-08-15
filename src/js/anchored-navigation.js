/**
 * Anchored Navigation functionality
 */
document.addEventListener('DOMContentLoaded', function() {
	
	// Initialize anchored navigation
	initAnchoredNavigation();
	
	// Initialize mobile collapsible sections
	initMobileCollapsibleSections();
	
	/**
	 * Initialize anchored navigation behavior
	 */
	function initAnchoredNavigation() {
		const navigation = document.querySelector('.lsx-anchored-navigation');
		if (!navigation) return;
		
		const links = navigation.querySelectorAll('a[href^="#"]');
		const sections = document.querySelectorAll('.anchored-section');
		
		// Smooth scroll behavior
		links.forEach(link => {
			link.addEventListener('click', function(e) {
				e.preventDefault();
				
				const targetId = this.getAttribute('href').substring(1);
				const targetSection = document.getElementById(targetId);
				
				if (targetSection) {
					targetSection.scrollIntoView({
						behavior: 'smooth',
						block: 'start'
					});
					
					// Update active state
					updateActiveNavLink(this);
				}
			});
		});
		
		// Update active navigation link on scroll
		if (sections.length > 0) {
			window.addEventListener('scroll', throttle(updateActiveNavOnScroll, 100));
		}
	}
	
	/**
	 * Update active navigation link on scroll
	 */
	function updateActiveNavOnScroll() {
		const navigation = document.querySelector('.lsx-anchored-navigation');
		if (!navigation) return;
		
		const sections = document.querySelectorAll('.anchored-section');
		const scrollPosition = window.scrollY + 100; // Offset for sticky nav
		
		let currentSection = '';
		
		sections.forEach(section => {
			const sectionTop = section.offsetTop;
			const sectionHeight = section.offsetHeight;
			
			if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
				currentSection = section.id;
			}
		});
		
		// Update active link
		const links = navigation.querySelectorAll('a[href^="#"]');
		links.forEach(link => {
			link.classList.remove('active');
			if (link.getAttribute('href') === '#' + currentSection) {
				link.classList.add('active');
			}
		});
	}
	
	/**
	 * Update active navigation link
	 */
	function updateActiveNavLink(activeLink) {
		const navigation = document.querySelector('.lsx-anchored-navigation');
		if (!navigation) return;
		
		const links = navigation.querySelectorAll('a[href^="#"]');
		links.forEach(link => link.classList.remove('active'));
		activeLink.classList.add('active');
	}
	
	/**
	 * Initialize mobile collapsible sections
	 */
	function initMobileCollapsibleSections() {
		if (window.innerWidth > 768) return;
		
		const isSinglePage = document.body.classList.contains('single-tour') ||
							 document.body.classList.contains('single-destination') ||
							 document.body.classList.contains('single-accommodation');
		
		if (!isSinglePage) return;
		
		const sections = document.querySelectorAll('.anchored-section');
		
		sections.forEach((section, index) => {
			convertToCollapsibleSection(section, index === 0); // First section open by default
		});
	}
	
	/**
	 * Convert section to collapsible format
	 */
	function convertToCollapsibleSection(section, isOpenByDefault = false) {
		const sectionId = section.id;
		const sectionTitle = getSectionTitle(sectionId);
		
		// Create header
		const header = document.createElement('div');
		header.className = 'section-header';
		header.innerHTML = `
			<span class="section-title">${sectionTitle}</span>
			<svg class="toggle-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
				<path d="M7 10l5 5 5-5z"/>
			</svg>
		`;
		
		// Wrap existing content
		const content = document.createElement('div');
		content.className = 'section-content';
		
		// Move all children to content wrapper
		while (section.firstChild) {
			content.appendChild(section.firstChild);
		}
		
		// Add header and content to section
		section.appendChild(header);
		section.appendChild(content);
		
		// Set initial state
		if (!isOpenByDefault) {
			section.classList.add('collapsed');
		}
		
		// Add click handler
		header.addEventListener('click', function() {
			section.classList.toggle('collapsed');
		});
	}
	
	/**
	 * Get section title from ID
	 */
	function getSectionTitle(sectionId) {
		const titleMap = {
			'overview': 'Overview',
			'itinerary': 'Itinerary',
			'accommodation': 'Accommodation',
			'inclusions': 'Inclusions & Exclusions',
			'map': 'Map & Location',
			'gallery': 'Gallery',
			'details': 'Details',
			'price': 'Pricing',
			'booking': 'Booking Information'
		};
		
		return titleMap[sectionId] || sectionId.replace('-', ' ').replace(/\b\w/g, l => l.toUpperCase());
	}
	
	/**
	 * Throttle function for scroll events
	 */
	function throttle(func, limit) {
		let inThrottle;
		return function() {
			const args = arguments;
			const context = this;
			if (!inThrottle) {
				func.apply(context, args);
				inThrottle = true;
				setTimeout(() => inThrottle = false, limit);
			}
		}
	}
	
	// Re-initialize on window resize
	window.addEventListener('resize', function() {
		// Reinitialize mobile collapsible sections if needed
		setTimeout(initMobileCollapsibleSections, 100);
	});
	
});
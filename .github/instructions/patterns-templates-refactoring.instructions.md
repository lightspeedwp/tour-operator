# Tour Operator Plugin - Patterns & Templates Refactoring Guide

## Overview

This document provides comprehensive instructions for refactoring the Tour Operator plugin's patterns and templates structure to align with WordPress block theme best practices for **plugins**.

**Key Plugin Considerations:**
- Patterns require manual PHP registration (unlike themes where `/patterns/` auto-registers)
- Must work with any theme - use CSS variable fallbacks
- Use `LSX_TO_URL` and `LSX_TO_PATH` for asset paths
- Text domain is always `'tour-operator'`

---

## Current Structure

```
tour-operator/
├── includes/patterns/                          # Hidden, non-standard location
│   ├── accommodation-card.php                  # Card pattern for accommodation in grids
│   ├── destination-card.php                    # Card pattern for destination in grids
│   ├── gallery.php                             # Gallery section with lightbox
│   ├── itinerary-list.php                      # Itinerary item repeater
│   ├── room-card.php                           # Room/unit card
│   ├── tour-card.php                           # Card pattern for tours in grids
│   └── travel-information.php                  # Travel info grid
│
├── includes/classes/blocks/
│   └── class-patterns.php                      # Pattern registration class
│
├── templates/                                  # Block templates (OK location)
│   ├── archive-accommodation.html
│   ├── archive-destination.html
│   ├── archive-review.html
│   ├── archive-tour.html
│   ├── archive-travel-style.html
│   ├── search-results.html
│   ├── single-accommodation.html
│   ├── single-country.html
│   ├── single-destination.html
│   ├── single-region.html
│   ├── single-review.html
│   └── single-tour.html
│
└── parts/                                      # (Does not exist yet)
```

---

## Proposed Structure

```
tour-operator/
│
├── patterns/                                   # Root level (WordPress standard)
│   │
│   │── # Cards (Categories: lsx-to-cards + post type)
│   ├── accommodation-card.php
│   ├── destination-card.php
│   ├── review-card.php
│   ├── room-card.php
│   └── tour-card.php
│   │
│   │── # Hero (Category: lsx-to-hero)
│   ├── hero-cover.php                          # Cover with featured image
│   └── hero-archive.php                        # Archive header
│   │
│   │── # Sections (Category: lsx-to-featured)
│   ├── section-heading.php                     # Heading with separators
│   ├── gallery-section.php                     # Gallery lightbox
│   ├── map-section.php                         # Map embed
│   ├── videos-section.php                      # Video embeds
│   └── enquire-button.php                      # CTA button
│   │
│   │── # Related Content (Categories: lsx-to-featured + post type)
│   ├── related-tours.php
│   ├── related-accommodation.php
│   └── related-destinations.php
│   │
│   │── # Tours (Category: lsx-to-tours)
│   ├── sidebar-tour.php                        # Fast facts sidebar
│   ├── itinerary-section.php                   # Itinerary wrapper
│   ├── itinerary-list.php                      # Itinerary item repeater
│   └── include-exclude.php                     # Price includes/excludes
│   │
│   │── # Accommodation (Category: lsx-to-accommodation)
│   ├── sidebar-accommodation.php               # Fast facts sidebar
│   ├── units-section.php                       # Units wrapper
│   └── units-list.php                          # Unit item repeater
│   │
│   │── # Destinations (Category: lsx-to-destinations)
│   ├── sidebar-destination.php                 # Fast facts sidebar
│   ├── travel-information.php                  # Travel info grid
│   └── regions-list.php                        # Child regions
│   │
│   │── # Modals (Category: post type specific)
│   ├── modal-accommodation.php
│   ├── modal-destination.php
│   └── modal-tour.php
│   │
│   │── # Archives (Category: lsx-to-archives)
│   ├── archive-query-tours.php
│   ├── archive-query-accommodation.php
│   ├── archive-query-destinations.php
│   └── archive-query-reviews.php
│   │
│   │── # Pricing (Category: lsx-to-pricing)
│   └── price-display.php
│
├── parts/                                      # Template parts (structural only)
│   ├── breadcrumbs.html                        # Yoast breadcrumbs
│   └── query-pagination.html                   # Pagination
│
├── templates/                                  # Block templates (unchanged)
│   ├── archive-*.html
│   └── single-*.html
│
└── includes/classes/blocks/
    ├── class-patterns.php                      # Updated for new location
    └── class-template-parts.php                # NEW: Register template parts
```

---

## Pattern vs Template Part Decision Tree

```
Is the content identical everywhere?
│
├── YES → Template Part
│   Examples: breadcrumbs, pagination
│
└── NO → Pattern
    │
    ├── Does content vary per post type?
    │   Examples: sidebar-tour vs sidebar-accommodation
    │
    ├── Does content vary per instance?
    │   Examples: section-heading (different titles)
    │
    └── Is it a reusable layout component?
        Examples: cards, hero-cover, gallery-section
```

### Classification Summary

| Element | Type | Reason |
|---------|------|--------|
| `breadcrumbs` | Template Part | Identical Yoast breadcrumbs everywhere |
| `query-pagination` | Template Part | Identical pagination structure everywhere |
| `sidebar-tour` | Pattern | Post-type specific fields, user may customize |
| `sidebar-accommodation` | Pattern | Post-type specific fields, user may customize |
| `sidebar-destination` | Pattern | Post-type specific fields, user may customize |
| `section-heading` | Pattern | Title varies per usage |
| `hero-cover` | Pattern | Title varies, overlay may vary |
| `hero-archive` | Pattern | Used in archives, query title varies |
| `enquire-button` | Pattern | User may want different text/styling |
| `gallery-section` | Pattern | Heading may vary |
| `map-section` | Pattern | May have different settings |
| All card patterns | Pattern | Used in queries, content varies |
| All modal patterns | Pattern | Post-type specific |

---

## Pattern Categories

Register these categories in `class-patterns.php`:

| Category Slug | Label | Description |
|---------------|-------|-------------|
| `lsx-tour-operator` | Tour Operator | Parent category for all patterns |
| `lsx-to-tours` | Tours | Tour-specific patterns |
| `lsx-to-accommodation` | Accommodation | Accommodation-specific patterns |
| `lsx-to-destinations` | Destinations | Destination-specific patterns |
| `lsx-to-reviews` | Reviews | Review-specific patterns |
| `lsx-to-cards` | Cards | Card layouts for any post type |
| `lsx-to-hero` | Hero | Hero/banner sections |
| `lsx-to-featured` | Featured | Featured content sections |
| `lsx-to-archives` | Archives | Archive/listing layouts |
| `lsx-to-pricing` | Pricing | Price displays |
| `lsx-to-buttons` | Buttons | Button patterns |

---

## Pattern File Header Template

**Note:** Unlike themes where patterns auto-register from the `/patterns/` directory using file header comments, **plugins must use PHP array return format** with manual registration via `register_block_pattern()` or a registration class.

### Plugin Pattern Format (array return)

```php
<?php
/**
 * Pattern Name
 *
 * Brief description of the pattern.
 *
 * @package    Tour_Operator
 * @subpackage Patterns
 * @since      1.0.0
 * @version    2.0.0
 */

// phpcs:ignoreFile PluginCheck.CodeAnalysis.ImageFunctions.NonEnqueuedImage

return array(
    // Required: Human-readable title displayed in inserter
    'title'         => __( 'Pattern Name', 'tour-operator' ),

    // Required: Block HTML markup (or use filePath instead)
    'content'       => '<!-- wp:group ... -->',

    // Optional: Visually hidden description for searching patterns
    'description'   => __( 'A brief description of the pattern purpose.', 'tour-operator' ),

    // Optional: Registered pattern categories for grouping
    'categories'    => array( 'lsx-tour-operator', 'lsx-to-category' ),

    // Optional: Keywords/aliases to help users discover the pattern
    'keywords'      => array( 'keyword1', 'keyword2', 'keyword3' ),

    // Optional: Block names that could use this pattern (placeholders, transforms)
    'blockTypes'    => array( 'core/group', 'core/query' ),

    // Optional: Restrict pattern to specific post types only
    'postTypes'     => array( 'tour', 'accommodation', 'destination' ),

    // Optional: Template types where the pattern fits (since WP 6.2)
    'templateTypes' => array( 'single', 'archive', 'page' ),

    // Optional: Intended width for scaled preview in inserter
    'viewportWidth' => 1200,

    // Optional: Hide from inserter (for programmatic insertion only)
    'inserter'      => true,

    // Optional: Full path to file with pattern content (instead of 'content')
    // 'filePath'   => LSX_TO_PATH . 'patterns/pattern-name.html',
);
```

### Pattern Properties Reference

| Property | Type | Required | Since | Description |
|----------|------|----------|-------|-------------|
| `title` | `string` | **Yes** | 5.5.0 | Human-readable title for the pattern |
| `content` | `string` | **Yes*** | 5.5.0 | Block HTML markup for the pattern |
| `filePath` | `string` | **Yes*** | 6.5.0 | Full path to file with pattern content (alternative to `content`) |
| `description` | `string` | No | 5.5.0 | Hidden text for discovering patterns while searching |
| `categories` | `string[]` | No | 5.5.0 | Registered category slugs for grouping |
| `keywords` | `string[]` | No | 5.5.0 | Aliases/keywords for search discovery |
| `blockTypes` | `string[]` | No | 5.8.0 | Block names for contextual use (placeholders, transforms) |
| `postTypes` | `string[]` | No | 6.1.0 | Restrict to specific post types only |
| `templateTypes` | `string[]` | No | 6.2.0 | Template types where pattern fits |
| `viewportWidth` | `int` | No | 5.5.0 | Intended width for scaled preview |
| `inserter` | `bool` | No | 5.5.0 | Show in inserter (default: `true`) |

*Either `content` or `filePath` is required.

---

## CSS Variables with Fallbacks

Since this is a plugin, all CSS variables must have absolute fallbacks:

### In Block JSON Attributes

```json
{
  "style": {
    "color": {
      "background": "var:preset|color|primary",
      "text": "var:preset|color|contrast"
    },
    "spacing": {
      "padding": {
        "top": "var:preset|spacing|medium",
        "bottom": "var:preset|spacing|medium"
      }
    }
  }
}
```

### In Inline Styles (with fallbacks)

```html
style="
    background-color: var(--wp--preset--color--primary, #4a7311);
    color: var(--wp--preset--color--contrast, #090909);
    padding-top: var(--wp--preset--spacing--medium, 2rem);
    padding-bottom: var(--wp--preset--spacing--medium, 2rem);
    border-radius: var(--wp--preset--spacing--radius-small, 0.25rem);
"
```

### Common Fallback Values

| Variable | Fallback | Notes |
|----------|----------|-------|
| `--wp--preset--color--primary` | `#4a7311` | Main brand green |
| `--wp--preset--color--primary-700` | `#3d5f0e` | Darker green |
| `--wp--preset--color--primary-900` | `#2a4109` | Darkest green |
| `--wp--preset--color--primary-200` | `#a3c47a` | Light green |
| `--wp--preset--color--contrast` | `#090909` | Near black |
| `--wp--preset--color--base` | `#ffffff` | White |
| `--wp--preset--color--secondary-900` | `#1a1a1a` | Dark secondary |
| `--wp--preset--spacing--x-small` | `0.5rem` | 8px |
| `--wp--preset--spacing--small` | `1rem` | 16px |
| `--wp--preset--spacing--medium` | `2rem` | 32px |
| `--wp--preset--spacing--large` | `3rem` | 48px |

---

## Complete Patterns List

| Pattern | Extract From | Categories |
|---------|--------------|------------|
| `accommodation-card.php` | Already exists | `lsx-to-accommodation`, `lsx-to-cards` |
| `destination-card.php` | Already exists | `lsx-to-destinations`, `lsx-to-cards` |
| `review-card.php` | Create new | `lsx-to-reviews`, `lsx-to-cards` |
| `tour-card.php` | Already exists | `lsx-to-tours`, `lsx-to-cards` |
| `room-card.php` | Already exists | `lsx-to-accommodation`, `lsx-to-cards` |
| `modal-accommodation.php` | Rename from single-modal-* | `lsx-to-accommodation` |
| `modal-destination.php` | Rename from single-modal-* | `lsx-to-destinations` |
| `modal-tour.php` | Rename from single-modal-* | `lsx-to-tours` |
| `hero-cover.php` | All single templates | `lsx-to-hero` |
| `hero-archive.php` | All archive templates | `lsx-to-hero`, `lsx-to-archives` |
| `section-heading.php` | Repeated heading pattern | `lsx-to-featured` |
| `gallery-section.php` | Already exists (gallery.php) | `lsx-to-featured` |
| `map-section.php` | Single templates | `lsx-to-featured` |
| `videos-section.php` | Similar to gallery | `lsx-to-featured` |
| `enquire-button.php` | Repeated CTA button | `lsx-to-featured` |
| `related-tours.php` | single-destination, single-accommodation | `lsx-to-featured`, `lsx-to-tours` |
| `related-accommodation.php` | single-tour, single-destination | `lsx-to-featured`, `lsx-to-accommodation` |
| `related-destinations.php` | single-tour | `lsx-to-featured`, `lsx-to-destinations` |
| `sidebar-tour.php` | single-tour.html | `lsx-to-tours` |
| `sidebar-accommodation.php` | single-accommodation.html | `lsx-to-accommodation` |
| `sidebar-destination.php` | single-destination.html | `lsx-to-destinations` |
| `itinerary-section.php` | single-tour.html | `lsx-to-tours` |
| `itinerary-list.php` | Already exists | `lsx-to-tours` |
| `include-exclude.php` | single-tour.html | `lsx-to-tours` |
| `units-section.php` | single-accommodation.html | `lsx-to-accommodation` |
| `units-list.php` | single-accommodation.html | `lsx-to-accommodation` |
| `travel-information.php` | Already exists | `lsx-to-destinations` |
| `regions-list.php` | single-country.html | `lsx-to-destinations` |
| `archive-query-tours.php` | archive-tour.html | `lsx-to-archives`, `lsx-to-tours` |
| `archive-query-accommodation.php` | archive-accommodation.html | `lsx-to-archives`, `lsx-to-accommodation` |
| `archive-query-destinations.php` | archive-destination.html | `lsx-to-archives`, `lsx-to-destinations` |
| `archive-query-reviews.php` | archive-review.html | `lsx-to-archives`, `lsx-to-reviews` |
| `price-display.php` | Cards and sidebars | `lsx-to-pricing` |

---

## Template Parts

### `parts/breadcrumbs.html`

**Purpose:** Yoast breadcrumbs - identical on every page

```html
<!-- wp:group {"metadata":{"name":"Breadcrumbs"},"align":"full","style":{"spacing":{"padding":{"top":"6px","bottom":"6px","left":"var:preset|spacing|x-small","right":"var:preset|spacing|x-small"},"margin":{"top":"0","bottom":"0"}},"elements":{"link":{":hover":{"color":{"text":"var:preset|color|tertiary"}},"color":{"text":"var:preset|color|base"}}}},"backgroundColor":"primary-900","textColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-base-color has-primary-900-background-color has-text-color has-background has-link-color" style="margin-top:0;margin-bottom:0;padding-top:6px;padding-right:var(--wp--preset--spacing--x-small, 0.5rem);padding-bottom:6px;padding-left:var(--wp--preset--spacing--x-small, 0.5rem)">
    <!-- wp:group {"align":"wide","layout":{"type":"default"}} -->
    <div class="wp-block-group alignwide">
        <!-- wp:yoast-seo/breadcrumbs /-->
    </div>
    <!-- /wp:group -->
</div>
<!-- /wp:group -->
```

### `parts/query-pagination.html`

**Purpose:** Pagination - identical on all archive pages

```html
<!-- wp:group {"metadata":{"name":"Pagination"},"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|medium"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide" style="padding-top:var(--wp--preset--spacing--medium, 2rem);padding-bottom:var(--wp--preset--spacing--medium, 2rem)">
    <!-- wp:query-pagination {"paginationArrow":"chevron","layout":{"type":"flex","justifyContent":"space-between"}} -->
        <!-- wp:query-pagination-previous /-->
        <!-- wp:query-pagination-numbers /-->
        <!-- wp:query-pagination-next /-->
    <!-- /wp:query-pagination -->
</div>
<!-- /wp:group -->
```

---

## Updated class-patterns.php

```php
<?php
/**
 * Patterns Registration
 *
 * @package    Tour_Operator
 * @subpackage Blocks
 * @since      1.0.0
 * @version    2.0.0
 */

namespace lsx\blocks;

class Patterns {

    /**
     * Holds the slug of the main pattern category.
     *
     * @var string
     */
    private $category = 'lsx-tour-operator';

    /**
     * Pattern categories to register.
     *
     * @var array
     */
    private $categories = array();

    /**
     * Initialize the plugin.
     *
     * @since 1.0.0
     */
    public function __construct() {
        $this->categories = array(
            'lsx-tour-operator'    => __( 'Tour Operator', 'tour-operator' ),
            'lsx-to-tours'         => __( 'Tours', 'tour-operator' ),
            'lsx-to-accommodation' => __( 'Accommodation', 'tour-operator' ),
            'lsx-to-destinations'  => __( 'Destinations', 'tour-operator' ),
            'lsx-to-reviews'       => __( 'Reviews', 'tour-operator' ),
            'lsx-to-cards'         => __( 'Cards', 'tour-operator' ),
            'lsx-to-hero'          => __( 'Hero', 'tour-operator' ),
            'lsx-to-featured'      => __( 'Featured', 'tour-operator' ),
            'lsx-to-archives'      => __( 'Archives', 'tour-operator' ),
            'lsx-to-pricing'       => __( 'Pricing', 'tour-operator' ),
            'lsx-to-buttons'       => __( 'Buttons', 'tour-operator' ),
        );

        // Register categories.
        add_filter( 'block_categories_all', array( $this, 'register_block_category' ), 10, 1 );
        add_action( 'init', array( $this, 'register_block_pattern_categories' ) );

        // Register patterns.
        add_action( 'init', array( $this, 'register_block_patterns' ), 10 );
    }

    /**
     * Registers the block category for the editor.
     *
     * @param array $categories Existing categories.
     * @return array
     */
    public function register_block_category( $categories ) {
        $categories[] = array(
            'slug'  => $this->category,
            'title' => __( 'Tour Operator', 'tour-operator' ),
        );
        return $categories;
    }

    /**
     * Registers all pattern categories.
     *
     * @return void
     */
    public function register_block_pattern_categories() {
        foreach ( $this->categories as $slug => $label ) {
            register_block_pattern_category(
                $slug,
                array( 'label' => $label )
            );
        }
    }

    /**
     * Registers block patterns from the patterns directory.
     *
     * @return void
     */
    public function register_block_patterns() {
        // Check root patterns/ directory first (new location).
        $root_directory = LSX_TO_PATH . 'patterns/';
        
        // Fallback to includes/patterns/ (legacy location).
        $legacy_directory = LSX_TO_PATH . 'includes/patterns/';
        
        $directories = array();
        
        if ( is_dir( $root_directory ) ) {
            $directories[] = $root_directory;
        }
        
        if ( is_dir( $legacy_directory ) ) {
            $directories[] = $legacy_directory;
        }

        foreach ( $directories as $directory ) {
            foreach ( glob( $directory . '*.php' ) as $file ) {
                $filename = basename( $file, '.php' );
                $key = 'lsx-tour-operator/' . $filename;

                // Check if pattern is already registered.
                if ( \WP_Block_Patterns_Registry::get_instance()->is_registered( $key ) ) {
                    continue;
                }

                register_block_pattern( $key, require $file );
            }
        }
    }
}
```

---

## New class-template-parts.php

```php
<?php
/**
 * Template Parts Registration
 *
 * @package    Tour_Operator
 * @subpackage Blocks
 * @since      2.0.0
 */

namespace lsx\blocks;

class Template_Parts {

    /**
     * Initialize the class.
     */
    public function __construct() {
        add_filter( 'default_template_types', array( $this, 'register_template_parts' ) );
    }

    /**
     * Register custom template parts.
     *
     * @param array $template_types Existing template types.
     * @return array
     */
    public function register_template_parts( $template_types ) {
        $template_types['breadcrumbs'] = array(
            'title'       => __( 'Breadcrumbs', 'tour-operator' ),
            'description' => __( 'Displays breadcrumb navigation using Yoast SEO.', 'tour-operator' ),
        );

        $template_types['query-pagination'] = array(
            'title'       => __( 'Query Pagination', 'tour-operator' ),
            'description' => __( 'Displays pagination for archive queries.', 'tour-operator' ),
        );

        return $template_types;
    }
}
```

---

## Refactored Template Examples

### `templates/single-tour.html` (Refactored)

```html
<!-- wp:template-part {"slug":"header","area":"header"} /-->

<!-- wp:pattern {"slug":"lsx-tour-operator/hero-cover"} /-->

<!-- wp:template-part {"slug":"breadcrumbs"} /-->

<!-- wp:group {"tagName":"main","metadata":{"name":"Description & Fast Facts"},"align":"wide"} -->
<main class="wp-block-group alignwide">
    <!-- wp:columns {"align":"wide"} -->
    <div class="wp-block-columns alignwide">
        <!-- wp:column {"width":"65%"} -->
        <div class="wp-block-column" style="flex-basis:65%">
            <!-- wp:post-content /-->
        </div>
        <!-- /wp:column -->
        
        <!-- wp:column {"width":"35%"} -->
        <div class="wp-block-column" style="flex-basis:35%">
            <!-- wp:pattern {"slug":"lsx-tour-operator/sidebar-tour"} /-->
        </div>
        <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->
</main>
<!-- /wp:group -->

<!-- wp:pattern {"slug":"lsx-tour-operator/gallery-section"} /-->

<!-- wp:pattern {"slug":"lsx-tour-operator/itinerary-section"} /-->

<!-- wp:pattern {"slug":"lsx-tour-operator/include-exclude"} /-->

<!-- wp:pattern {"slug":"lsx-tour-operator/map-section"} /-->

<!-- wp:pattern {"slug":"lsx-tour-operator/related-accommodation"} /-->

<!-- wp:template-part {"slug":"footer","area":"footer"} /-->
```

### `templates/archive-tour.html` (Refactored)

```html
<!-- wp:template-part {"slug":"header","area":"header"} /-->

<!-- wp:pattern {"slug":"lsx-tour-operator/hero-archive"} /-->

<!-- wp:template-part {"slug":"breadcrumbs"} /-->

<!-- wp:group {"tagName":"main","align":"wide"} -->
<main class="wp-block-group alignwide">
    <!-- wp:pattern {"slug":"lsx-tour-operator/archive-query-tours"} /-->
</main>
<!-- /wp:group -->

<!-- wp:template-part {"slug":"query-pagination"} /-->

<!-- wp:template-part {"slug":"footer","area":"footer"} /-->
```

---

## Block Bindings

Use the custom `lsx/post-meta` binding source for dynamic content:

```html
<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"price"}}}}} -->
<p class="amount"></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"duration"}}}}} -->
<p></p>
<!-- /wp:paragraph -->
```

Available meta keys:
- `price` - Tour/accommodation price
- `duration` - Tour duration in days
- `group_size` - Tour group size
- `single_supplement` - Single supplement price
- `booking_validity_start` - Booking start date
- `booking_validity_end` - Booking end date
- `tagline` - Post tagline
- `number_of_rooms` - Accommodation rooms count

---

## Migration Checklist

### Phase 1: Foundation
- [ ] Create `/patterns/` directory at root
- [ ] Create `/parts/` directory at root
- [ ] Update `class-patterns.php` for new directory structure
- [ ] Create `class-template-parts.php`
- [ ] Update main plugin file to instantiate `Template_Parts`

### Phase 2: Move Existing Patterns
- [ ] Move `accommodation-card.php` to `patterns/`
- [ ] Move `destination-card.php` to `patterns/`
- [ ] Move `gallery.php` to `patterns/gallery-section.php`
- [ ] Move `itinerary-list.php` to `patterns/`
- [ ] Move `room-card.php` to `patterns/`
- [ ] Move `tour-card.php` to `patterns/`
- [ ] Move `travel-information.php` to `patterns/`
- [ ] Update categories in all moved patterns

### Phase 3: Create Template Parts
- [ ] Create `parts/breadcrumbs.html`
- [ ] Create `parts/query-pagination.html`

### Phase 4: Extract New Patterns
- [ ] Create `patterns/hero-cover.php`
- [ ] Create `patterns/hero-archive.php`
- [ ] Create `patterns/section-heading.php`
- [ ] Create `patterns/map-section.php`
- [ ] Create `patterns/enquire-button.php`
- [ ] Create `patterns/sidebar-tour.php`
- [ ] Create `patterns/sidebar-accommodation.php`
- [ ] Create `patterns/sidebar-destination.php`
- [ ] Create `patterns/itinerary-section.php`
- [ ] Create `patterns/include-exclude.php`
- [ ] Create `patterns/units-section.php`
- [ ] Create `patterns/units-list.php`
- [ ] Create `patterns/regions-list.php`
- [ ] Create `patterns/related-tours.php`
- [ ] Create `patterns/related-accommodation.php`
- [ ] Create `patterns/related-destinations.php`
- [ ] Create `patterns/archive-query-tours.php`
- [ ] Create `patterns/archive-query-accommodation.php`
- [ ] Create `patterns/archive-query-destinations.php`
- [ ] Create `patterns/archive-query-reviews.php`
- [ ] Create `patterns/price-display.php`
- [ ] Create `patterns/videos-section.php`
- [ ] Create `patterns/review-card.php`
- [ ] Create `patterns/modal-accommodation.php`
- [ ] Create `patterns/modal-destination.php`
- [ ] Create `patterns/modal-tour.php`

### Phase 5: Refactor Templates
- [ ] Refactor `single-tour.html` to use patterns/parts
- [ ] Refactor `single-accommodation.html` to use patterns/parts
- [ ] Refactor `single-destination.html` to use patterns/parts
- [ ] Refactor `single-country.html` to use patterns/parts
- [ ] Refactor `single-region.html` to use patterns/parts
- [ ] Refactor `single-review.html` to use patterns/parts
- [ ] Refactor `archive-tour.html` to use patterns/parts
- [ ] Refactor `archive-accommodation.html` to use patterns/parts
- [ ] Refactor `archive-destination.html` to use patterns/parts
- [ ] Refactor `archive-review.html` to use patterns/parts
- [ ] Refactor `archive-travel-style.html` to use patterns/parts
- [ ] Refactor `search-results.html` to use patterns/parts

### Phase 6: Testing & Cleanup
- [ ] Test all single templates
- [ ] Test all archive templates
- [ ] Test pattern insertion in editor
- [ ] Verify patterns work with multiple themes
- [ ] Remove old `includes/patterns/` directory (if migrated)
- [ ] Update documentation

---

## Summary Statistics

| Type | Current | Proposed | Change |
|------|---------|----------|--------|
| **Patterns** | 7 | 35+ | +28 |
| **Template Parts** | 0 | 2 | +2 |
| **Templates** | 12 | 12 | 0 (refactored) |
| **Pattern Categories** | 1 | 11 | +10 |

---

## 12. Block Validation Quick Reference

WordPress validates saved block markup against the block's `save` function. Mismatches cause "This block contains unexpected or invalid content" errors.

### Critical Rules

1. **Self-closing syntax for dynamic blocks:**
   ```html
   <!-- wp:lsx-tour-operator/icons {"iconName":"priceIcon"} /-->
   <!-- wp:post-featured-image {"isLink":true} /-->
   ```

2. **Never embed HTML for icon blocks** - The block renders it:
   ```html
   <!-- ✅ Correct -->
   <!-- wp:lsx-tour-operator/icons {"iconName":"priceIcon"} /-->
   
   <!-- ❌ Wrong - causes validation error -->
   <!-- wp:lsx-tour-operator/icons {"iconName":"priceIcon"} -->
   <div class="wp-block-lsx-tour-operator-icons">...</div>
   <!-- /wp:lsx-tour-operator/icons -->
   ```

3. **JSON vs Inline Style Variable Formats:**
   ```html
   <!-- JSON attribute format -->
   {"style":{"border":{"radius":"var:preset|spacing|20"}}}
   
   <!-- Inline style format - matches JSON, NOT CSS variable -->
   style="border-radius:var:preset|spacing|20"
   
   <!-- CSS variable format (for padding/margin in inline styles) -->
   style="padding-top:var(--wp--preset--spacing--20)"
   ```

4. **No CSS fallbacks in inline styles** (causes validation mismatch):
   ```html
   <!-- ✅ Correct -->
   style="padding-top:var(--wp--preset--spacing--20)"
   
   <!-- ❌ Wrong - WordPress doesn't add fallback -->
   style="padding-top:var(--wp--preset--spacing--tiny, 0.625rem)"
   ```

### Icon Block Reference

| Attribute | Values | Default |
|-----------|--------|---------|
| `iconType` | `"outline"`, `"solid"` | `"outline"` |
| `iconName` | `"priceIcon"`, `"accommodationTypeIcon"`, `"roomBasisIcon"`, `"durationIcon"`, `"groupSizeIcon"`, `"calendarIcon"` | Required |

### Quick Validation Test

After creating/editing a pattern:
1. Insert it in the editor
2. Check for validation warning (yellow outline)
3. If error: Click "Resolve" → "Attempt Block Recovery"
4. Switch to Code editor view
5. Copy the recovered markup back to pattern file

---

## 13. Fast Pattern Creation Workflow

### Step 1: Get Working Markup

Build visually in editor → Switch to Code editor → Copy markup.

### Step 2: Apply Template

```php
<?php
/**
 * [Pattern Name] - [Brief description]
 *
 * @package    Tour_Operator
 * @subpackage Patterns  
 * @since      1.0.0
 */

// phpcs:ignoreFile PluginCheck.CodeAnalysis.ImageFunctions.NonEnqueuedImage

return array(
	'title'         => __( '[Pattern Name]', 'tour-operator' ),
	'description'   => __( '[Description]', 'tour-operator' ),
	'categories'    => array( 'lsx-tour-operator', 'lsx-to-cards' ),
	'postTypes'     => array( '[post-type]' ),
	'blockTypes'    => array( 'core/query' ),
	'templateTypes' => array( 'archive', 'single' ),
	'content'       => '[PASTE_BLOCK_MARKUP]',
);
```

### Step 3: Escape Translatable Content

```php
// Plain text
'>' . esc_html__( 'Text', 'tour-operator' ) . '<'

// In JSON attribute
'"name":"' . esc_attr__( 'Text', 'tour-operator' ) . '"'
```

---

## 14. Common Spacing/Color Values

### Spacing (smallest to largest)

| Use Case | JSON Format | CSS Variable | Pixels |
|----------|-------------|--------------|--------|
| Tiny gaps | `var:preset\|spacing\|tiny` | `--wp--preset--spacing--tiny` | 10px |
| Border radius | `var:preset\|spacing\|20` | `--wp--preset--spacing--20` | 8px |
| Small padding | `var:preset\|spacing\|small` | `--wp--preset--spacing--small` | 16px |
| Medium gaps | `var:preset\|spacing\|medium` | `--wp--preset--spacing--medium` | 32px |

### Colors

| Use Case | JSON Format |
|----------|-------------|
| Primary (buttons, borders) | `var:preset\|color\|primary` |
| Text/links | `var:preset\|color\|contrast` |
| White backgrounds | `var:preset\|color\|base` |
| Hover states | `var:preset\|color\|primary-700` |

---

## Related Documentation

- **[Figma Pattern Instructions](figma-to-wordpress-pattern-extraction.instructions.md)** - For converting Figma designs to patterns
- **[WordPress 6.9 Preparation Brief](../../WordPress%206.9%20Release%20Preparation%20Brief_%20Tour%20Operator%20Plugin.md)** - Release planning document

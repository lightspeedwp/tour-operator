# Changelog

## [[2.1.0]](https://github.com/lightspeedwp/tour-operator/releases/tag/2.1.0) - In Dev

### Added

#### Build & Pattern Infrastructure

- **Pattern Registration Infrastructure** - Established directory structure and registration system for tour operator patterns with proper categorization and template support - PR[#803](https://github.com/lightspeedwp/tour-operator/pull/803), Issue [#795](https://github.com/lightspeedwp/tour-operator/issues/795)

#### Patterns

- **Section Header Pattern** - Added reusable section header pattern (`lsx-tour-operator/section-header`) with centered heading text flanked by horizontal separators for consistent section dividers across templates. Includes pattern overrides binding for easy customization - [#809](https://github.com/lightspeedwp/tour-operator/pull/809), Issue [#796](https://github.com/lightspeedwp/tour-operator/issues/796)
- **Review Card Pattern** - Added review card pattern for displaying review content with quotation icons and consistent formatting - Issue [#798](https://github.com/lightspeedwp/tour-operator/issues/798), PR [#814](https://github.com/lightspeedwp/tour-operator/pull/814)

#### Template Parts

- **Template Parts Infrastructure** - Added `Template_Parts` registration class for auto-discovery and registration of template parts from the `parts/` directory with proper metadata, i18n support, and area assignment - [#809](https://github.com/lightspeedwp/tour-operator/pull/809), Issue [#796](https://github.com/lightspeedwp/tour-operator/issues/796)
- **Fast Facts Template Parts** - Created fast facts template parts for tour, accommodation, and destination single templates with comprehensive information display including duration, price, facilities, location, and quick reference details - [#809](https://github.com/lightspeedwp/tour-operator/pull/809), Issue [#796](https://github.com/lightspeedwp/tour-operator/issues/796)
  - `fast-facts-tour.html` - Tour information including duration, price, group size, booking validity, destinations, travel styles, and enquiry button
  - `fast-facts-accommodation.html` - Accommodation details including rating, number of rooms, facilities, check-in/out times, location, and accommodation type
  - `fast-facts-destination.html` - Destination overview including country, travel styles, and best time to visit
- **Modal Template Parts** - Created modal template parts for preview functionality across tour operator post types with customizable content display - [#809](https://github.com/lightspeedwp/tour-operator/pull/809), Issue [#796](https://github.com/lightspeedwp/tour-operator/issues/796)
  - `modal-tour.html` - Tour preview modal with featured image, title, tagline, excerpt, and destinations
  - `modal-accommodation.html` - Accommodation preview modal with featured image, title, tagline, excerpt, location, and facilities
  - `modal-destination.html` - Destination preview modal with featured image, title, and excerpt
  - `modal-enquiry.html` - Enquiry form modal placeholder for contact functionality

#### New Blocks

- **Icons Block** - Added new icons block for improved icon management and display capabilities - [#547](https://github.com/lightspeedwp/tour-operator/pull/547), Issue [#548](https://github.com/lightspeedwp/tour-operator/issues/548)
- **Banner Cover Block** - New block that pulls the image set in the Banner Image custom field for dynamic banner display - [#604](https://github.com/lightspeedwp/tour-operator/pull/604)
- **Tagline Block** - New block that pulls text from the Tagline custom field for consistent branding - [#604](https://github.com/lightspeedwp/tour-operator/pull/604)
- **Sticky Menu Block** - Added sticky navigation menu block with desktop and mobile navigation support for single post templates, includes anchor support and section group functionality - [#684](https://github.com/lightspeedwp/tour-operator/pull/684), Issue [#496](https://github.com/lightspeedwp/tour-operator/issues/496)
- **TO Videos Block** - Added YouTube video gallery block for displaying videos on tours, accommodation, and destination templates in a professional gallery layout - [#598](https://github.com/lightspeedwp/tour-operator/pull/598), Issue [#397](https://github.com/lightspeedwp/tour-operator/issues/397)
- **Check-in/Checkout Time Icon Blocks** - Added icon-based blocks (replacing images) for check-in and checkout times with filters to display only on relevant post types (accommodation) and related templates - [#645](https://github.com/lightspeedwp/tour-operator/pull/645)
- **Unit Blocks** - Added comprehensive unit blocks functionality with refined assets and WordPress coding standards alignment - [#815](https://github.com/lightspeedwp/tour-operator/pull/815)

#### Features & Integrations

- **Tour Expiration with Action Scheduler** - Integrated Action Scheduler to automatically expire tours and set them to draft status. Works with any plugin using Action Scheduler as a vendor including WooCommerce, PublishPress, and Action Scheduler plugin - [#490](https://github.com/lightspeedwp/tour-operator/pull/490)
- **Modal Support for Blocks** - Added modal functionality support to various blocks for enhanced user interaction - Issue [#488](https://github.com/lightspeedwp/tour-operator/issues/488)
- **Related Post Connections** - Added CMB2 metaboxes for related post connections to single posts, enabling better content relationships - [#596](https://github.com/lightspeedwp/tour-operator/pull/596), Issue [#595](https://github.com/lightspeedwp/tour-operator/issues/595)
- **Terms Query Block** - Allowing the use of the permalink and featured image blocks inside the Terms Query -  - [#776](https://github.com/lightspeedwp/tour-operator/pull/776)

#### Filters & Extensibility

- **Core Featured Image Block Integration** - Added comprehensive filtering system for core/post-featured-image block to support taxonomy images. New filters: `lsx_to_taxonomy_images_featured_image_id`, `lsx_to_taxonomy_images_featured_image_size`, `lsx_to_taxonomy_images_featured_image_attr`, and `lsx_to_taxonomy_images_featured_image_html` to enable complete customization of taxonomy-based featured image display with support for term meta 'thumbnail' field - [#776](https://github.com/lightspeedwp/tour-operator/pull/776)
- **Destinations Filtering** - Added filter `lsx_to_{$key}_include_destinations` to allow disabling of destinations when searching for related content - [BH-74](https://www.bugherd.com/projects/430995/tasks/74)
- **Facility Block Links Control** - Added filter `lsx_to_accommodation_facilities_should_link` to optionally disable facility block links - [#608](https://github.com/lightspeedwp/tour-operator/pull/608)
- **Query Block Ordering** - Added filter to allow ordering of query blocks by `post__in` parameter for custom content ordering - [#653](https://github.com/lightspeedwp/tour-operator/pull/653), Issue [#123](https://github.com/lightspeedwp/tour-operator/issues/123)
- **Travel Information Filters** - Added filter `lsx_travel_information_excerpt_length` to control character length for travel information excerpts - [#663](https://github.com/lightspeedwp/tour-operator/pull/663)
- **Travel Information Modal Control** - Added filter `lsx_travel_information_modal_enable` to optionally disable travel information modal functionality - [#663](https://github.com/lightspeedwp/tour-operator/pull/663)
- **Query Loop Arguments** - Added filter `lsx_to_query_loop_query_args_{$key}` to allow third-party plugins and themes to alter query arguments in Query_Loop class - [#675](https://github.com/lightspeedwp/tour-operator/pull/675)

### Enhancements

#### Template Refactoring

- **Complete Template System Modernization** - Refactored all archive and single templates to use patterns and template parts instead of hardcoded HTML, enabling full Site Editor customization - Issue [#798](https://github.com/lightspeedwp/tour-operator/issues/798), PR [#814](https://github.com/lightspeedwp/tour-operator/pull/814)
  - Updated `single-tour.html` with pattern-based sections (sticky menu, itinerary, gallery, reviews)
  - Updated `single-accommodation.html` with pattern-based layout (units, gallery sections)
  - Updated `single-destination.html` with travel information and gallery patterns
  - Updated `single-country.html` and `single-region.html` templates
  - Updated all archive templates (`archive-tour.html`, `archive-accommodation.html`, `archive-destination.html`, `archive-review.html`)
  - Replaced hardcoded inline styles with WordPress CSS variables (`var(--wp--preset--*)`)
  - Implemented responsive spacing using WordPress spacing scale
  - Added placeholder image fallback for posts without featured images
  - Improved sticky menu behavior with proper sticky positioning
  - Fixed travel information section visibility (hides when no cards are visible)
  - Cleaned up queryIDs and local development paths from templates

#### Block System Improvements
- **Fast-Facts Meta Display Enhancement** - Implemented single-line display for fast-facts and meta data blocks with bold prefixes for improved clarity. Enhanced 20+ blocks including duration, travel styles, accommodation type, check-in/out times, ratings, and language blocks with consistent prefix formatting and responsive layout improvements - [#802](https://github.com/lightspeedwp/tour-operator/pull/802), Issue [#514](https://github.com/lightspeedwp/tour-operator/issues/514), Issue [#433](https://github.com/lightspeedwp/tour-operator/pull/433)
- **Sticky Menu Mobile UX** - Improved mobile user experience by opening the first section by default on mobile devices for better initial content visibility - [#817](https://github.com/lightspeedwp/tour-operator/pull/817)
- **Sticky Menu Positioning** - Enhanced sticky menu width constraints to match default section width and improved scroll spy computing for more accurate section-to-menu item synchronization - [#817](https://github.com/lightspeedwp/tour-operator/pull/817)
- **Block List Modernization** - Updated block structure by breaking out monolithic blocks from assets folder into individual files with dedicated block.json files for better organization and maintainability - [#489](https://github.com/lightspeedwp/tour-operator/pull/489)
- **Conditional Block Registration** - Extracted conditional block registration logic to a separate utility file for easier maintainability and reusability - [#696](https://github.com/lightspeedwp/tour-operator/pull/696)
- **Tour Blocks Metadata** - Enhanced tour-related blocks with comprehensive metadata, improved internationalization, descriptions, keywords, and custom SVG icons for better searchability - [#696](https://github.com/lightspeedwp/tour-operator/pull/696), [#667](https://github.com/lightspeedwp/tour-operator/pull/667)
- **Destination Blocks Metadata** - Enhanced destination block variations with comprehensive metadata and conditional registration for destination-specific posts/pages - [#697](https://github.com/lightspeedwp/tour-operator/pull/697), [#656](https://github.com/lightspeedwp/tour-operator/pull/656), Issue [#691](https://github.com/lightspeedwp/tour-operator/issues/691)
- **Accommodation Blocks Metadata** - Enhanced accommodation related blocks (Rating, Special Interests, Spoken Languages, Suggested Visitor Types, Minimum Child Age) with comprehensive metadata, improved internationalization, descriptions, keywords, and schema compliance - [#763](https://github.com/lightspeedwp/tour-operator/pull/763), [#625](https://github.com/lightspeedwp/tour-operator/pull/625), Issue [#692](https://github.com/lightspeedwp/tour-operator/issues/692), Issue [#624](https://github.com/lightspeedwp/tour-operator/issues/624)
- **Block Icons Update** - Updated block icons for various block variations with custom SVGs for: dress, facilities, health, ends-in, departs-from, climate, transport - [#579](https://github.com/lightspeedwp/tour-operator/pull/579), Issue [#563](https://github.com/lightspeedwp/tour-operator/issues/563)
- **Itinerary Block Refactoring** - Refactored itinerary block registration logic and integrated day-by-day block functionality directly into the itinerary block for better maintainability and functionality - Issue [#783](https://github.com/lightspeedwp/tour-operator/issues/783)
- **Google Map Block Enhancements** - Enhanced Google Map block with improved localization support, better example content, and refined block metadata for consistent international display - Issue [#783](https://github.com/lightspeedwp/tour-operator/issues/783)
- **Number of Rooms Block Metadata** - Enhanced Number of Rooms block with comprehensive metadata, improved examples, and better internationalization support for accommodation templates
- **Permalink Button and More Link Blocks** - Fixed registration issues for permalink-button and more-link blocks to ensure proper functionality and consistent behavior across templates
- **Block Structure Standardization** - Standardized all block variations to use consistent registration patterns, examples, and metadata structure for improved maintainability and better user experience in the block editor - Issue [#770](https://github.com/lightspeedwp/tour-operator/issues/770)
- **Conditional Block Registration System** - Refactored all destination, accommodation, and tour blocks to use the conditional registration utility, ensuring blocks appear only in relevant post type contexts for cleaner editor experience - Issue [#583](https://github.com/lightspeedwp/tour-operator/issues/583)
- **Internationalization Improvements** - Enhanced all block definitions with proper i18n support using `@wordpress/i18n` for consistent translation handling across the entire block system - Issue [#583](https://github.com/lightspeedwp/tour-operator/issues/583)
- **Block Metadata Cleanup** - Cleaned up block.json files and registration code across 80+ blocks, removing unused dependencies and improving asset loading efficiency - Issue [#770](https://github.com/lightspeedwp/tour-operator/issues/770)
- **Banner Block** - Allowing the user of the banner block on the terms archive, and it falls back to the terms featured image if non is found. - [#776](https://github.com/lightspeedwp/tour-operator/pull/776)

#### Feature Updates

- **Modal System Refactoring** - Refactored modal system to use template parts instead of hardcoded PHP templates, enabling customization through Site Editor. Added automatic default modal template selection for tour, accommodation, and destination post types with support for custom modal template parts in the 'modals' area - [#809](https://github.com/lightspeedwp/tour-operator/pull/809), Issue [#796](https://github.com/lightspeedwp/tour-operator/issues/796)
- **Itinerary Departure Day Logic** - Updated departure day to rely on the previous day's Location and Accommodation values to mimic WETU layout for better data consistency - [#491](https://github.com/lightspeedwp/tour-operator/pull/491), Issue [#481](https://github.com/lightspeedwp/tour-operator/issues/481)
- **Gallery Render Block** - Updated Gallery render block to return blank string if gallery field is empty, preventing display of empty galleries - [#608](https://github.com/lightspeedwp/tour-operator/pull/608)
- **Unit Block** - The unit block was merged into the Units Block [#766](https://github.com/lightspeedwp/tour-operator/pull/766)

### Removed

- **Bootstrap File Consolidation** - Removed `tour-operator-bootstrap.php` and merged its logic into `tour-operator.php` for a cleaner, more maintainable plugin structure - Issue [#787](https://github.com/lightspeedwp/tour-operator/issues/787)
- **Search Template Removal** - Removed non-functional search page template - Issue [#798](https://github.com/lightspeedwp/tour-operator/issues/798)
- **Sticky Header Template** - Removed custom sticky header in favor of WordPress default header behavior - Issue [#798](https://github.com/lightspeedwp/tour-operator/issues/798)
- **Outdated Admin Assets** - Removed outdated admin pages and assets: add-ons.php, help.php, and welcome.php - [#553](https://github.com/lightspeedwp/tour-operator/pull/553), Issue [#549](https://github.com/lightspeedwp/tour-operator/issues/549)
- **Block Settings** - Removed deprecated block settings functionality - [#493](https://github.com/lightspeedwp/tour-operator/pull/493)
- **Unused CSS** - Audited and cleaned out unused CSS files from /assets/css directory reducing plugin size and improving performance - [#574](https://github.com/lightspeedwp/tour-operator/pull/574), Issue [#533](https://github.com/lightspeedwp/tour-operator/issues/533)
- **Destination Restrictions** - Removed the condition restriction for 3-tier destinations for regions, allowing more flexible region hierarchies - [#654](https://github.com/lightspeedwp/tour-operator/pull/654), Issue [#330](https://github.com/lightspeedwp/tour-operator/issues/330)
- **Outdated Testing Icons** - Removed outdated testing icons and replaced with correct icons from the design system - [#575](https://github.com/lightspeedwp/tour-operator/pull/575), Issue [#554](https://github.com/lightspeedwp/tour-operator/issues/554)
- **Day-by-Day Block** - Removed standalone day-by-day block and integrated its functionality directly into the itinerary block for better maintainability and reduced code complexity - Issue [#783](https://github.com/lightspeedwp/tour-operator/issues/783)
- **Block Registration Cleanup** - Removed legacy block registration patterns and unused dependencies across all block definitions to improve loading performance and code maintainability - Issue [#770](https://github.com/lightspeedwp/tour-operator/issues/770)

### Fixed

- **Icon System Compliance** - Replaced outdated testing icons with correct icons from the design system, ensuring consistent 20px sizing and "currentColor" styling for all icons - [#575](https://github.com/lightspeedwp/tour-operator/pull/575), Issue [#554](https://github.com/lightspeedwp/tour-operator/issues/554)
- **Template Part Registration** - Fixed template part registration to work correctly with current theme context - Issue [#798](https://github.com/lightspeedwp/tour-operator/issues/798)
- **Card Image Styling** - Removed border-radius from card images for consistent design - Issue [#798](https://github.com/lightspeedwp/tour-operator/issues/798)
- **Pattern Variables** - Fixed WordPress CSS variable usage in patterns for proper theme integration - Issue [#798](https://github.com/lightspeedwp/tour-operator/issues/798)
- **Itinerary and Units Display** - Fixed conditional display logic to properly show itinerary and units sections when data exists - Issue [#798](https://github.com/lightspeedwp/tour-operator/issues/798)
- **Sticky Menu Colors** - Fixed color scheme for sticky menu to match theme design system - Issue [#798](https://github.com/lightspeedwp/tour-operator/issues/798)
- **Location Field Visibility** - Fixed issue where "location" custom field and related JavaScript were shown even when Google Maps API key was missing. Now properly hides location field and excludes relevant JS when API key is not configured - [#659](https://github.com/lightspeedwp/tour-operator/pull/659), Issue [#657](https://github.com/lightspeedwp/tour-operator/issues/657)
- **Modal Button Block Styling** - Fixed Modal Button block where styling support was incorrectly applying to wrapper instead of button element, added missing border controls - [#674](https://github.com/lightspeedwp/tour-operator/pull/674), Issue [#666](https://github.com/lightspeedwp/tour-operator/issues/666)
- **Null Safety in Slotfills** - Added comprehensive null safety checks for meta attributes in slotfills to prevent JavaScript errors with missing data - [#762](https://github.com/lightspeedwp/tour-operator/pull/762)
- **Travel Style Read More** - Enhanced and fixed read more functionality for travel style taxonomy descriptions to properly handle long content - [#660](https://github.com/lightspeedwp/tour-operator/pull/660), Issue [#332](https://github.com/lightspeedwp/tour-operator/issues/332)
- **Special Interests Key** - Fixed special-interests key issue in accommodation blocks metadata - Multiple commits in [#763](https://github.com/lightspeedwp/tour-operator/pull/763)
- **Block isActive Selector** - Fixed isActive selector for blocks to properly highlight active block variations in the editor - [#696](https://github.com/lightspeedwp/tour-operator/pull/696)
- **Dialog Attribute Handling** - Fixed dialog open attribute handling in allowed HTML tags for proper KSES compatibility - Multiple commits, Issue [#69](https://github.com/lightspeedwp/tour-operator/issues/69)
- **Block Translation Consistency** - Fixed missing translatable strings and inconsistent i18n implementation across block definitions, ensuring all block titles, descriptions, and keywords are properly translatable - Issue [#770](https://github.com/lightspeedwp/tour-operator/issues/770)
- **Array to String Conversion Warnings** - Fixed PHP warnings in `lsx_to_custom_field_query()` helper function by filtering out non-scalar values (nested arrays, objects) before implode operation to prevent "Array to string conversion" errors when debug mode is enabled - PR [#803](https://github.com/lightspeedwp/tour-operator/pull/803)
- **Show prices only when set** - Fixed prices that were showing up when a currency was set, but no price value (or value of 0) - PR [#814](https://github.com/lightspeedwp/tour-operator/pull/814)

### Security

- **WordPress Compatibility** - Tested and verified compatibility with WordPress 6.8.1+ for secure operation on latest platform
- **PHP Version Requirements** - Dropped support for older PHP versions and fixed version mismatches to align with modern WordPress standards - Issue [#469](https://github.com/lightspeedwp/tour-operator/issues/469)
- **PHPCS Standards Compliance** - Updated to WordPress Coding Standards 3.x for improved code security and quality standards - [#577](https://github.com/lightspeedwp/tour-operator/pull/577), Issue [#556](https://github.com/lightspeedwp/tour-operator/issues/556)
- **Null Safety Improvements** - Added comprehensive null safety checks for meta attributes in slotfills to prevent potential errors and improve stability - [#762](https://github.com/lightspeedwp/tour-operator/pull/762)
- **Input Sanitization** - Enhanced input sanitization and output escaping throughout the plugin following WordPress security best practices


### Documentation

- **Changelog Updates** - Multiple comprehensive changelog updates documenting travel style read more functionality, travel information filters, and other feature additions - [#661](https://github.com/lightspeedwp/tour-operator/pull/661), [#663](https://github.com/lightspeedwp/tour-operator/pull/663), Issue [#332](https://github.com/lightspeedwp/tour-operator/issues/332)
- **Code Documentation** - Improved inline documentation and comments throughout codebase for better developer experience
- **Block Metadata Documentation** - Enhanced block.json files with comprehensive descriptions, keywords, and i18n support for better discoverability - Multiple PRs [#625](https://github.com/lightspeedwp/tour-operator/pull/625), [#667](https://github.com/lightspeedwp/tour-operator/pull/667), [#656](https://github.com/lightspeedwp/tour-operator/pull/656), [#697](https://github.com/lightspeedwp/tour-operator/pull/697), [#763](https://github.com/lightspeedwp/tour-operator/pull/763), [#764](https://github.com/lightspeedwp/tour-operator/pull/764), [#765](https://github.com/lightspeedwp/tour-operator/pull/765)

### Deprecated

- **Legacy Admin Pages** - The add-ons.php, help.php, and welcome.php admin pages are deprecated and removed - [#553](https://github.com/lightspeedwp/tour-operator/pull/553), Issue [#549](https://github.com/lightspeedwp/tour-operator/issues/549)

### Performance

- **Query Block Optimization** - Fixed query block pagination to properly inherit query variables, reducing redundant database queries and improving page load times - [#608](https://github.com/lightspeedwp/tour-operator/pull/608)
- **Block Registration Efficiency** - Standardized block metadata across 50+ blocks for more efficient block registration and loading, reducing memory footprint - [#625](https://github.com/lightspeedwp/tour-operator/pull/625), Issue [#624](https://github.com/lightspeedwp/tour-operator/issues/624)
- **CSS Optimization** - Removed unused CSS from /assets/css directory, reducing total plugin size and improving frontend load times - [#574](https://github.com/lightspeedwp/tour-operator/pull/574), Issue [#533](https://github.com/lightspeedwp/tour-operator/issues/533)
- **Conditional Block Registration** - Implemented conditional block registration to only load blocks when needed, improving initial page load performance - [#696](https://github.com/lightspeedwp/tour-operator/pull/696)
- **Block Asset Optimization** - Optimized block asset dependencies and loading patterns across 80+ blocks, reducing JavaScript bundle sizes and improving editor loading times - Issue [#770](https://github.com/lightspeedwp/tour-operator/issues/770)


## [[2.0.2]](https://github.com/lightspeedwp/tour-operator/releases/tag/2.0.2) - 2025-05-06

### Added
- The Itinerary Included and Excluded field handling and block output.
- `lsx_to_wetu_map_url_params` filter to allow 3rd party plugins to change the WETU map attributes and what shows.
- Permalink Settings fields, to allow the URL change for Travel Styles, Accommodation Type, and Brands.
- The user can now alter the taxonomy slugs using the "Permalink" settings in WordPress.

### Fixed
- Fixed the output of the Special Interests - [BH-77](https://www.bugherd.com/projects/430995/tasks/77)
- Drinks Basis labels outputting "Drinks Basis" - [BH-80](https://www.bugherd.com/projects/430995/tasks/80)
- The Archive redirects and single redirects now use the correct post type arg parameters to disable the relevant option. #367
- The version number display on the welcome page. - #482

### Enhancements Added
- `lsx_to_wetu_map_url_params` filter to allow 3rd party plugins to change the WETU map attributes. [7364e48
](https://github.com/lightspeedwp/tour-operator/commit/7364e48dbbe8ac9130a6de1afc3eb4a63e1937f4)
- Adding in a "none" option for the "Special Interests" and the "Friendly" custom field selections. [edd55f3
](https://github.com/lightspeedwp/tour-operator/commit/edd55f3ccb06e285146db23d3e21df25cc66920b)

### Additional
- Removed commented out code.
- Removed unused template tags.
- Changed the label "LSX Tour Operator" to "Tour Operator" in all files.

### Security
- Tested with WordPress 6.8.1

## [[2.0.1]](https://github.com/lightspeedwp/tour-operator/releases/tag/2.0.1) - 2025-01-24

### Added
- A "Parents Only" checkbox to the TO query block settings, allowing you to select only the parent items for a query. (the WordPress parent field does not accept a 0 value).
- The Google Map, map block for Tour Operator, bringing back the various maps shows on the pages. [#477](https://github.com/lightspeedwp/tour-operator/pull/477)

### Fixed
- Fixes to the post relation fields and when they save, detected via the TO Reviews plugin.
- Fixed the Slider not detecting the amount of columns set on the block. [a6e0ea](https://github.com/lightspeedwp/tour-operator/commit/a6e0eafb508532dc7c137aedc30a17c5856a0309)
- Fixed the Related Content dection, we check to see if the posts exist before trying to display them [b20f879](https://github.com/lightspeedwp/tour-operator/commit/b20f879da7e9abfced7623f7e5348737af064db3)

### Removed
- Unused icons and placeholders from previous versions. [#477](https://github.com/lightspeedwp/tour-operator/pull/477)
- Removed the SVG Uploader Code causing a security issue. [c972c84](https://github.com/lightspeedwp/tour-operator/commit/c972c84224e2b51564fddc04d547ea6d204a356d)

### Integrations
- Fixed the Destinations Facet dropdowns using the Fselect field. [8e4cfc](https://github.com/lightspeedwp/tour-operator/commit/8e4cfcb08333c342e9d41fd9fad3fe4f9c31e4c8)

## [[2.0.0]](https://github.com/lightspeedwp/tour-operator/releases/tag/2.0.0) - 2025-01-10

### New Features

#### Backend/Block Editor
- **Revamped Settings Page**: Updated the settings interface to align with WordPress standards, reduced unused settings, and streamlined functionality. [#331](https://github.com/lightspeedwp/tour-operator/issues/331)
- **CMB2 Custom Fields Migration**: Upgraded to CMB2 for custom fields, ensuring REST API integration and streamlined field usage. [#333](https://github.com/lightspeedwp/tour-operator/issues/333)
- **Custom Fields Meta Panel**: Grouped custom fields into dedicated panels for Tours, Destinations, and Accommodation, enhancing admin usability. [#350](https://github.com/lightspeedwp/tour-operator/issues/350)
- **Block Options Sidebar**: Added a sidebar meta panel for essential fields like price, duration, and custom taxonomies to enhance user experience. [#349](https://github.com/lightspeedwp/tour-operator/issues/349)
- **Sticky Post Renaming**: Renamed "Sticky Post" functionality to "Featured" for clarity and consistent use across post types. [#399](https://github.com/lightspeedwp/tour-operator/issues/399)
- **Custom Block Inserter Category**: Grouped all Tour Operator blocks under a custom category for better discoverability in the Block Editor. [#403](https://github.com/lightspeedwp/tour-operator/issues/403)

#### Frontend
- **Fast Facts Blocks**: Added Fast Facts block variations for Tours, Accommodation, and Destinations, dynamically displaying key information with conditional field checks. [#385](https://github.com/lightspeedwp/tour-operator/issues/385), [#387](https://github.com/lightspeedwp/tour-operator/issues/387), [#388](https://github.com/lightspeedwp/tour-operator/issues/388)
- **Clickable Cover Block**: Introduced a custom Cover block variation, making the entire block clickable for better UX. [#422](https://github.com/lightspeedwp/tour-operator/issues/422)
- **Travel Information Section**: Designed and implemented a responsive travel information carousel for Single Country templates, dynamically populated from custom fields. [#383](https://github.com/lightspeedwp/tour-operator/issues/383)
- **Regions Section**: Created a carousel to display child regions in the Single Country template. Hidden if no regions are associated. [#384](https://github.com/lightspeedwp/tour-operator/issues/384)

#### Plugin Code
- **New Templates**: Updated Single Post templates for Tours, Accommodation, Destinations, and more to match the Tour Operator Design System. [#334](https://github.com/lightspeedwp/tour-operator/issues/334)
- **Custom Query Loops**: Introduced variations for dynamically displaying related content (e.g., related tours, accommodation) based on specific criteria. [#431](https://github.com/lightspeedwp/tour-operator/issues/431)
- **Custom Block Dashicons**: Added a custom compass icon for branding consistency. [#401](https://github.com/lightspeedwp/tour-operator/issues/401)

#### Wetu Integration
- **Wetu Map Embed Block**: Created a block to display Wetu maps in the Single Tour template. [#365](https://github.com/lightspeedwp/tour-operator/issues/365)
- **Simplified Wetu Importer Settings**: Reduced complexity in the Wetu Importer settings, added image controls, and improved UI based on Figma designs. [#173](https://github.com/lightspeedwp/wetu-importer/issues/173)

### Compatibility & Integration
- **Theme & Page Builder Compatibility:**  
  Increased compatibility with popular WordPress themes and page builders, minimizing styling conflicts and ensuring consistent front-end rendering. ([#229](https://github.com/lightspeedwp/tour-operator/pull/229), [#204](https://github.com/lightspeedwp/tour-operator/issues/204))
- **Translation & Localization Updates:**  
  Added missing translation strings and updated `.pot` files, improving internationalization support and making it easier to localize the plugin. ([#217](https://github.com/lightspeedwp/tour-operator/pull/217))

### Email & Notification Templates
- **Email Template System Improvements:**  
  Integrated a refined email templating structure that supports dynamic placeholders for tour details, booking confirmations, and reminders. ([#240](https://github.com/lightspeedwp/tour-operator/pull/240))

### Updates
- Defined consistent image sizes across single posts, featured images, and archive pages, with custom aspect ratios. [#392](https://github.com/lightspeedwp/tour-operator/issues/392)
- Updated plugin requirements to PHP 8.0 and WordPress 6.7 for improved compatibility and performance. [#406](https://github.com/lightspeedwp/tour-operator/issues/406)
- Registered custom fields for post types using JSON for better data handling and display. [#407](https://github.com/lightspeedwp/tour-operator/issues/407)
- **Admin UI & UX Improvements:**  
  Refined the admin interface for managing tours, bookings, and availability. Updated field layouts, improved navigation, and clearer labeling for a more intuitive experience. ([#225](https://github.com/lightspeedwp/tour-operator/pull/225), [#237](https://github.com/lightspeedwp/tour-operator/issues/237))
- **Checkout & Payment Flow Adjustments:**  
  Enhanced integration with WooCommerce and other payment gateways, providing more reliable data handling and reducing the chance of failed booking entries at checkout. ([#231](https://github.com/lightspeedwp/tour-operator/pull/231))
- **Performance Optimizations:**  
  Further optimized database queries, improving load times on large tour catalogs and ensuring smoother browsing experiences. ([#215](https://github.com/lightspeedwp/tour-operator/pull/215))
---
  
### Fixes
- **Resolved Seasonal Pricing Bugs:**  
  Addressed incorrect display of overlapping seasonal rates and ensured accurate calculation of discounted or peak-season prices. ([#199](https://github.com/lightspeedwp/tour-operator/issues/199))
- **Checkout Data Handling:**  
  Fixed issues where certain checkout fields failed to render or process correctly, ensuring customers’ booking details are recorded consistently. ([#203](https://github.com/lightspeedwp/tour-operator/issues/203))
- Fixed issues with setting featured images for custom taxonomies, ensuring proper saving and display. [#419](https://github.com/lightspeedwp/tour-operator/issues/419)
- Resolved syncing issues in the Wetu Importer, addressing a PHP fatal error and spinner loading problem. [#444](https://github.com/lightspeedwp/tour-operator/issues/444)
- Ensured blocks are hidden when related custom fields are empty, preventing display of incomplete content. [#372](https://github.com/lightspeedwp/tour-operator/issues/372)

### Removed
- UIX vendor library handling the TO Settings and refactored the settings code - (PR #332)[https://github.com/lightspeedwp/tour-operator/pull/332]
- Various settings which are now handled by Block and Site Editor options. - (PR #332)[https://github.com/lightspeedwp/tour-operator/pull/332]
- Removed unused settings and legacy PHP code from the plugin to align with new block-based functionality. [#331](https://github.com/lightspeedwp/tour-operator/issues/331)

### Notes for Upgrading
- **Backups & Settings Review:**  
  Before upgrading, back up your site. After update, review and re-save your booking and pricing settings to ensure that seasonal rules and availability data are correctly applied.

### Security
- General testing to ensure compatibility with latest WordPress version (6.7).

## [[1.4.10]](https://github.com/lightspeedwp/tour-operator/releases/tag/1.4.10) - 2024-

### Fixes
- Fixed the multiple select2 box bloat, causing slow pageloads.

## [[1.4.9]](https://github.com/lightspeedwp/tour-operator/releases/tag/1.4.9) - 2023-08-09

### Fixes
- Fixing the Single Specials "read more" spacing.

### Added
- Adding in suport for the read more block while using the Block Editor.

### Security
- General testing to ensure compatibility with latest WordPress version (6.3).

## [[1.4.8]](https://github.com/lightspeedwp/tour-operator/releases/tag/1.4.8) - 2023-04-20

### Added
- Adding in the - `lsx_to_disable_dynamic_gallery` filter

### Fixed
- A conflict with WooCommerce and select2

### Security
- General testing to ensure compatibility with latest WordPress version (6.2).

## [[1.4.7]](https://github.com/lightspeedwp/tour-operator/releases/tag/1.4.7) - 2022-12-23

### Added
- A parameter to the `to_banner_navigation` shortcode to allow changing the element selector.
- A filter to allowing the overwritting of the `banner_navigation` shortcode.  `to_banner_navigation_atts`
- Added in an option to switch the itinerary to the destination images instead of the accommodation images.
- A filter to allow the use of destination pins in the map, for rail and boat tours. `lsx_to_get_itinerary_ids_meta_key`
- A function to allow you to include the parent images in the itinerary pool. `lsx_to_itinerary_append_parent_destinations`

### Fixed
- The banner easing navigation.
- The output of the Mobile Tours destinations.
- A fatal error with maps outputting on the travel style archives.

### Security
- General testing to ensure compatibility with latest WordPress version (6.1.1).

## [[1.4.6]](https://github.com/lightspeedwp/tour-operator/releases/tag/1.4.6) - 2022-09-22

### Fixed
- An issue causing the LSX TO Widget slider pagination to break.

## [[1.4.5]](https://github.com/lightspeedwp/tour-operator/releases/tag/1.4.5) - 2022-09-21

### Added

#### General
- Added a size parameter to `lsx_to_itinerary_thumbnail()` to allow selecting of different size images.
- Added the slider breakpoints and tablet slider amounts to the `lsx_to_js_params` params
- Fixing the return of `lsx_to_itinerary_title`

#### Destinations
- Added the option to disable the countries regions only.

#### Tours
- Allowing the return of `lsx_to_itinerary_title`
- Allowing the return of `lsx_to_itinerary_destinations`
- Allowing the return of `lsx_to_itinerary_accommodation`
- Allowing the selection of the meta key in `lsx_to_itinerary_thumbnail`

### Fixed

- Fixed the impropper escaping of the months to visit function.
- Fixed the PHP error on taxonomies - missing add_expert_form_field

### Security
- General testing to ensure compatibility with latest WordPress version (6.0.2).

## [[1.4.4]](https://github.com/lightspeedwp/tour-operator/releases/tag/1.4.4) - 2022-05-25

### Security
- General testing to ensure compatibility with latest WordPress version (6.0).

### Added
 - An `items` parameter to the `lsx_to_connected_panel_query` allowing you to specify tours to find.

## [[1.4.3]](https://github.com/lightspeedwp/tour-operator/releases/tag/1.4.3) - 2021-07-20

### Added
 - Missing string translations.

### Fixed
- Styling Issue with Destination Map on Various Pages
- Fixed Placeholder Image not filling space
- Fixed Breadcrumbs width on search pages

### Security
- General testing to ensure compatibility with latest WordPress version (5.8).

## [[1.4.2]](https://github.com/lightspeedwp/tour-operator/releases/tag/1.4.2) - 2021-01-15

### Added

- Added support for native Lazy-loading images on WordPress 5.5 version.
- Added banner functionality to the core plugin, to deprecate the usage of LSX Banners
- Enabled the ability to switch to the block editor on TO post types

### Fixed

- Fixing the map placeholder, so it can assign placeholders for each type of posts.
- Fixed LSX Search styling issues
- Fixed Map placement issues.

### Changed

- Changed the label "Tour Operator" to "LSX Tour Operator"
- Merged the Dashboard Help and Add-ons page.

### Security
- General testing to ensure compatibility with latest WordPress version (5.6).

## [[1.4.1]](https://github.com/lightspeedwp/tour-operator/releases/tag/1.4.1) - 2020-03-30

### Added

- Added in a filter `lsx_to_maps_tour_connections` to allow 3rd party filters of the tour itinerary map connections.
- Adding in the `lsx_to_get_tour_itinerary_ids` to fix the order of the map IDS.
- Updating the `lsx_to_to_widget_item_size()` function to be more specific.

### Fixed

- Fixed a few typos.
- Making sure the if conditions for the maps are strict.
- Fixing the departure day not using the tours featured image.
- Fix output escaping issues.
- Fixed issue `PHP Deprecated: dbx_post_advanced is deprecated since version 3.7.0! Use add_meta_boxes instead`.
- Fixed Slick slider bug.
- Fixed PHP error `Undefined variable: connection`.
- Fixed PHP error `preg_match() expects parameter 2 to be string, array given`.
- Fixed PHP error `Undefined variable: accommodation_id`.
- Fixed PHP error `Undefined variable: temp_id`.

### Security

- Sanitizing widget fields.
- Updating dependencies to prevent vulnerabilities.
- General testing to ensure compatibility with latest WordPress version (5.4).
- General testing to ensure compatibility with latest LSX Theme version (2.7).

## [[1.4.0]](https://github.com/lightspeedwp/tour-operator/releases/tag/1.4) - 2019-12-19

### Added

- Added in a parameter to lsx_to_enquire_modal() to allow a form_id to be specified.
- Allowing the modal to be disabled in lsx_to_enquire_modal via a parameter.
- Adding in an \$args parameter to lsx_to_gallery(), allowing you to specify what 'gallery_ids' to use to build the gallery.
- Styles for single team page if banner is disabled.
- Set the region archive map to a zoom level of 10.
- Enabled the sorting of Gallery images.
- Added in a sticky order field to destinations to allow sticky posts functionality.
- Added in a "lsx_to_post_type_widget_query_args" to allow 3rd Party plugins to alter the queries.
- Added in an "orderby" parameter to the "lsx_to_connected_panel_query" helper function.
- Added in a 'lsx_to_js_params' filters which allows you to alter the JS params of the slick slider JS.
- Added a filter `lsx_to_map_placeholder_enabled` for the maps placeholder to enable 3rd parties to change the toggle.
- Added in a filter to `lsx_to_has_map()` to allow 3rd party functions to disable the map `lsx_to_disable_map`
- Added in a filter to allow the disabling of the map JS `lsx_to_disable_map_js`.
- Adding hierarchy for the Destination sitemap section.

### Changed

- Changing the Destination Region to show the connected accommodation in the map instead of just a pin.

### Fixed

- Added in a function to clear the term cache when ordering, so the order reflects immediately.
- Fixing the returning variables of the destinations template tags.
- Fixed the Tour Itinerary not using the featured image for the departure day.
- Fixed the map JS file url.
- Restricted the map JS enqueue to only TO allowed pages.
- Removing the "wp-editor" dependency from the TO Block register function.
- Removing the flag-icons vendor CSS and Images.
- Fix for 'Content wider than screen' Google Console issue.
- Fixed the undefined notice when using and array of post types with WP_Query
- Moving the description text on main Archive pages above the filters.

## [[1.3.0]](https://github.com/lightspeedwp/tour-operator/releases/tag/1.3.0) - 2019-10-02

### Added

- Added in a view more disable for the post type widget.
- Adding the .gitattributes file to remove unnecessary files from the WordPress version.
- Added in a 'lsx_to_maps_args' to allow plugins to alter the map arguments before output.
- Added in a 'lsx_to_has_maps_location' to allow plugins to alter the map arguments before output.
- Added lazyloading for the TO Slick sliders.
- Added in a 'lsx_to_map_override' to allow 3rd party plugins to overrider the map before it generates.
- Added the possibility to call the form set on the options of each post type if the archive page requires it.
- Updated the compatible version notice.
- Added in the Schema for accommodation / destinations / tours, using the Yoast API.

### Changed

- Changing the single template width.

### Fixed

- Fixed the Post Type enquiry dropdown.
- Fix for the reviews thumbnails.
- Making 'Best Time' show only if it has content.
- Updating the gallery thumbnail image size.
- Fixing PHP issue 'Invalid argument supplied for foreach()'.
- Changing the priority of the enqueued assets.

## [[1.2.0]](https://github.com/lightspeedwp/tour-operator/releases/tag/1.2.0) - 2019-08-06

### Added

- Made sure the regions also move the map to the banner when the setting is activated.
- PHP Class updates.
- Removing old templates.
- Integrated the TO Maps plugin into TO Core.
- Added in an option to disable the maps.
- Added in a desktop and mobile map placeholder setting.
- Added in the bot blocker function for google maps requests.
- Integrated the TO Videos plugin into TO Core.
- Added in the region taxonomy for housing the Continent Sub Regions.

### Fixed

- Hiding the banner title on regions when the map is set to output there.
- Fixed the Room Section not collapsing on mobile.
- Fixed the collapse section title colour on mobile.

## [[1.1.5]](https://github.com/lightspeedwp/tour-operator/releases/tag/1.1.5) - 2019-07-03

### Changed

- Updated the help page.
- Updated the Add-Ons page.

## [[1.1.4]](https://github.com/lightspeedwp/tour-operator/releases/tag/1.1.4) - 2019-06-14

### Added

- Added in WPForms Lite as a list of forms to choose for your enquiry.
- Added in the destinations to the Accommodation and Tour breadcrumbs.
- Changed the widgets and shortcodes images sizes from 'lsx-thumbnail-single' to 'lsx-thumbnail-wide'.
- Added in a filter to allow the extending of fields via 3rd party plugins and themes - 'lsx_to_tours_itinerary_fields'.
- Converted the Shortcode in to a block.
- Updated default text for block and fixing travis issues.
- Changed the attributes from Numbers to strings.
- Added the taxonomy block and updates.

### Fixed

- Fixed tours and destinations collapsible tabs on mobile issue.
- Adding the list of Envira Gallery tags to the wp_kses_post allowed filter method.

## [[1.1.3]]()

### Security

- Cleaning code to meet more Wordpress Standards

## [[1.1.2]]()

### Added

- Added in an option to disable the collapse function on single posts.

### Changed

- Updated "Tested up to" WordPress version.
- Renamed the Object abstract class to Frame.

### Fixed

- Fixed archive excerpt display when there is not post content.
- Changing the "id" to avoid cached sites pulling through the same gallery for each destination.
- Upgraded the `mb_strtolower` to `strtolower` for newer PHP versions.

## [[1.1.1]](https://github.com/lightspeedwp/tour-operator/releases/tag/v1.1.1) - 2017-11-07

### Added

- Added compatibility with LSX Videos

### Fixed

- Removed the "prepare" statement from the destinations "filter_countries" function.
- Fixed extra spacing on Included and Not-Included items list.
- Crop huge excerpts o archive and widget items.
- Fixed Post Type Widget specific IDs front-end.
- TO Maps undefined function removed.
- Fixed PHP notice related to call is_singular() function.

## [[1.1.0]](https://github.com/lightspeedwp/tour-operator/releases/tag/v1.1.0) - 2017-10-07

### Added

- New totally awesome version! The visual was fully redesigned.
- Added compatibility with LSX 2.0.
- New project structure.
- UIX updated + Fixed issue with sub tabs click (settings).
- Added in a filter to call the Tours Featured image for the Departure Day.
- Added the accommodations room images to the pool of possible itinerary day images.
- Allowing the to_country_regions() to be ordered by the menu order or any other valid WP_Query order.

### Fixed

- Fixed scripts/styles loading order
- Fixed many small issues

## [[1.0.8]](https://github.com/lightspeedwp/tour-operator/releases/tag/v1.0.8) - 2017-06-14

### Fixed

- LSX tabs working integrated with TO tabs (dashboard settings).
- Fixed admin styles (help and add-on pages).
- UIX framework saving all tabs.

## [[1.0.7]](https://github.com/lightspeedwp/tour-operator/releases/tag/v1.0.7) - 2017-06-08

### Added

- Added .editorconfig file to help developers to maintain consistent coding styles between different editors and IDEs.
- LSX Customizer SASS selector extended to new FacetWP selectors.
- Make the team image displays square.
- Enable BS sliders on all small breakpoints.
- New slider code for: Widgets, Regions (destination archive), and Related items section.
- CMB updated (copied from LSX Banners).
- Changing the archives and widgets to show only the countries.
- Added in a filters for the itinerary image so 3rd party plugins and themes can overwrite it if they want to.
- Added in a filter for the destinations facets, so they only display the countries.
- Add .editorconfig file to help developers to maintain consistent coding styles between different editors and IDEs.
- Add RTL styles option.
- New folder structure for CSS files.
- New folder structure for JS files.
- Adds the FontAwesome fonts if the theme is not LSX Theme or if it isn’t loaded by another plugin/theme.
- Adding in the LSX sharing support.
- Added in the ability to queue your imports.
- Adding in support for the TO reviews section.
- Added compatibility (styles) with different column order on single team extension.

### Changed

- Restructure metabox.
- Update all NPM packages and re-structure Gulp’s tasks.

### Deprecated

- Removed from accommodation archive the brands slider.

### Fixed

- Removed "read more" from regions excerpt widgets on destination archive page.
- Small fix on TO custom post type (single template - CSS) for small breakpoints.
- Added in a filter to fix the API tab not showing when certain LSX Extensions are enabled.
- Removed "read more" from regions excerpt widgets on destination archive page.
- Small fix on TO custom post type (single template - CSS) for small breakpoints.
- Removed the locations taxonomy.
- Restricting the amount of accommodation allowed to be attached to an itinerary to 1.
- Allowing the itineraries to display other images from and accommodations gallery.
- Fixed the selecting of the general enquiry form.
- Ordering the destinations by the title, allowing all of the destinations to be pulled through to the destination archive.
- Fixed settings page header.
- Fixed settings page tabs.
- Trigger was triggered before defining the hook.
- Make save a real button and add saved indicator.
- Refactor loading.
- Globalize initializer for backwards compatibility.
- Wrapper reference for tour_operator().
- Tidy inline docs and add missing property declarations.
- Inline docs cleanup WIP.
- Architecture: Overhaul organization of plugin.
- Architecture: Class files should not have functions.
- Fixed up the style for the save changes button.
- Fixed the display of the metaboxes with other plugins active.
- Correct cols count for price to fix tabs.
- Fixed the selecting of the enquiry forms.
- Adding in a test to the settings page.
- Getting the API key inline with the rest of the extensions.
- Fixed the General Tab display.
- Fixed the API key settings tab.
- Removing the enqueue for the metabox js and css.
- Fixed the cropping options.
- Declaring the \$tour_operator variable for the archive destinations work properly.
- Fixed lsx thumbnails parameter for single image size.
- Help page updated with the current plugin version and WordPress requirement.
- Travis CI file.

## [[1.0.6]]()

### Added

- Added en_US language file.
- Changed the "Insert into Post" button text from media modal to "Select featured image".
- Added in the Day inclusions fields along with the styling.
- Added in "full" as an option to be replaced.
- Removing the destinations, accommodation and the tour dependencies on the TO Galleries.
- Standardized the Gallery fields across the post types. Allowing the TO Videos to always inject after.

### Fixed

- Load correctly the translations/language files.
- Fixed the read more when you click it removes the formatting.
- Fixed the display of the destination galleries.

## [[1.0.5]]()

### Added

- Added TO Search as subtab on LSX TO settings page.
- Styles from TO Search addon moved to it.
- Made the function lsx_to_archive_entry_top function test all active post types, not only the three core post types.
- Replaced body and post (TO post type) classes by same classes using prefix "lsx-to-POST_TYPE".
- Added swiper JS library for sliders.
- Added extra class to all sliders (lsx-to-slider).
- Metadata: calendar info moved to the next line.
- Metadata: term "price" change to "price from".
- Metadata: term “duration” added to duration meta.
- New fields from Wetu Importer.

### Fixed

- Fixed global variable (LSX TO) to enable/disable slider on mobile.
- Fixed (back-end) checkbox to display map on destination archive.
- Fixed menu navigation improved.
- Fixed the default pagination from LSX.
- Facilities without child items can't display.
- Fixed styles from post meta details on banner.
- Fixed fideos 16x9.
- Mysterious Man PNG image.
- Internal banner on small devices.
- Small fixes on front-end fields.
- Made Google Maps works on back-end.
- Fixed content_part filter for plugin and add-ons.
- Removed general contact fields from post types.

## [[1.0.4]]()

### Added

- Removed the last of the LSX_TO_POSTEXPIRATOR_TYPES constants.
- Added generic business contact details for enquire call to action.
- Best time to visit added to destination (copied from tour).
- Enabled compatibility with LSX Blog Customizer (categories carousel).

### Fixed

- Fixed an issue with empty post meta (depart from, end point).

### Deprecated

- Removed Certain Travis CI code sniffers.

## [[1.0.3]]()

### Added

- Added in a compatability check for all versions below PHP 7.
- Hid the "Contact Details" custom field panel from Accommodation, these fields don't output to the frontend yet.
- Updated the readme.txt content.

### Fixed

- Fixed PHP errors when activating the plugin with a non LSX theme.

## [[1.0.2]]()

### Added

- Added a test to avoid the plugin activate with older versions from PHP than 5.6.
- Added a warning for users that have the plugin activated in older versions from PHP than 5.6.

### Fixed

- Fixed a conflict with some plugins using https://github.com/humanmade/Custom-Meta-Boxes.

## [[1.0.1]]()

### Added

- Allowing the placeholder to overwrite any empty image on all post types.

### Fixed

- Fixed PHP warning notice, removed the constant LSX_TO_POSTEXPIRATOR_TYPES.
- Fixed the PHP warning with the post order class.
- Fixed the selecting of the global default placeholders.
- Fixed PHP compatibility errors.

## [[1.0.1]]()

### Added

- First Version

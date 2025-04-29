# Changelog

## [[2.0.2]](https://github.com/lightspeeddevelopment/tour-operator/releases/tag/2.0.2) - In Development

### Added
- The Itinerary Included and Excluded field handling and block output.
- `lsx_to_wetu_map_url_params` filter to allow 3rd party pplugins to change the WETU map attributes and what shows.

### Fixed
- Fixed the output of the Special Interests -  - [BH-77](https://www.bugherd.com/projects/430995/tasks/77)
- Drinks Basis labels outputting "Drinks Basis" - [BH-80](https://www.bugherd.com/projects/430995/tasks/80)

### Enhancements Added
- `lsx_to_wetu_map_url_params` filter to allow 3rd party plugins to change the WETU map attributes. [7364e48
](https://github.com/lightspeedwp/tour-operator/commit/7364e48dbbe8ac9130a6de1afc3eb4a63e1937f4)
- Adding in a "none" option for the "Special Interests" and the "Friendly" custom field selections. [edd55f3
](https://github.com/lightspeedwp/tour-operator/commit/edd55f3ccb06e285146db23d3e21df25cc66920b)

### Additional
- Removed commented out code.
- Removed unused template tags.

### Security
- Tested with WordPress 6.8

## [[2.0.1]](https://github.com/lightspeeddevelopment/tour-operator/releases/tag/2.0.1) - 2025-01-24

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

## [[2.0.0]](https://github.com/lightspeeddevelopment/tour-operator/releases/tag/2.0.0) - 2025-01-10

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
- **New Templates**: Updated Single Post templates for Tours, Accommodation, Destinations, and more to match the LSX Tour Operator Design System. [#334](https://github.com/lightspeedwp/tour-operator/issues/334)
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

## [[1.4.10]](https://github.com/lightspeeddevelopment/tour-operator/releases/tag/1.4.10) - 2024-

### Fixes
- Fixed the multiple select2 box bloat, causing slow pageloads.

## [[1.4.9]](https://github.com/lightspeeddevelopment/tour-operator/releases/tag/1.4.9) - 2023-08-09

### Fixes
- Fixing the Single Specials "read more" spacing.

### Added
- Adding in suport for the read more block while using the Block Editor.

### Security
- General testing to ensure compatibility with latest WordPress version (6.3).

## [[1.4.8]](https://github.com/lightspeeddevelopment/tour-operator/releases/tag/1.4.8) - 2023-04-20

### Added
- Adding in the - `lsx_to_disable_dynamic_gallery` filter

### Fixed
- A conflict with WooCommerce and select2

### Security
- General testing to ensure compatibility with latest WordPress version (6.2).

## [[1.4.7]](https://github.com/lightspeeddevelopment/tour-operator/releases/tag/1.4.7) - 2022-12-23

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

## [[1.4.6]](https://github.com/lightspeeddevelopment/tour-operator/releases/tag/1.4.6) - 2022-09-22

### Fixed
- An issue causing the LSX TO Widget slider pagination to break.

## [[1.4.5]](https://github.com/lightspeeddevelopment/tour-operator/releases/tag/1.4.5) - 2022-09-21

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

## [[1.4.4]](https://github.com/lightspeeddevelopment/tour-operator/releases/tag/1.4.4) - 2022-05-25

### Security
- General testing to ensure compatibility with latest WordPress version (6.0).

### Added
 - An `items` parameter to the `lsx_to_connected_panel_query` allowing you to specify tours to find.

## [[1.4.3]](https://github.com/lightspeeddevelopment/tour-operator/releases/tag/1.4.3) - 2021-07-20

### Added
 - Missing string translations.

### Fixed
- Styling Issue with Destination Map on Various Pages
- Fixed Placeholder Image not filling space
- Fixed Breadcrumbs width on search pages

### Security
- General testing to ensure compatibility with latest WordPress version (5.8).

## [[1.4.2]](https://github.com/lightspeeddevelopment/tour-operator/releases/tag/1.4.2) - 2021-01-15

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

## [[1.4.1]](https://github.com/lightspeeddevelopment/tour-operator/releases/tag/1.4.1) - 2020-03-30

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

## [[1.4.0]](https://github.com/lightspeeddevelopment/tour-operator/releases/tag/1.4) - 2019-12-19

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

## [[1.3.0]](https://github.com/lightspeeddevelopment/tour-operator/releases/tag/1.3.0) - 2019-10-02

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

## [[1.2.0]](https://github.com/lightspeeddevelopment/tour-operator/releases/tag/1.2.0) - 2019-08-06

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

## [[1.1.5]](https://github.com/lightspeeddevelopment/tour-operator/releases/tag/1.1.5) - 2019-07-03

### Changed

- Updated the help page.
- Updated the Add-Ons page.

## [[1.1.4]](https://github.com/lightspeeddevelopment/tour-operator/releases/tag/1.1.4) - 2019-06-14

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

## [[1.1.1]](https://github.com/lightspeeddevelopment/tour-operator/releases/tag/v1.1.1) - 2017-11-07

### Added

- Added compatibility with LSX Videos

### Fixed

- Removed the "prepare" statement from the destinations "filter_countries" function.
- Fixed extra spacing on Included and Not-Included items list.
- Crop huge excerpts o archive and widget items.
- Fixed Post Type Widget specific IDs front-end.
- TO Maps undefined function removed.
- Fixed PHP notice related to call is_singular() function.

## [[1.1.0]](https://github.com/lightspeeddevelopment/tour-operator/releases/tag/v1.1.0) - 2017-10-07

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

## [[1.0.8]](https://github.com/lightspeeddevelopment/tour-operator/releases/tag/v1.0.8) - 2017-06-14

### Fixed

- LSX tabs working integrated with TO tabs (dashboard settings).
- Fixed admin styles (help and add-on pages).
- UIX framework saving all tabs.

## [[1.0.7]](https://github.com/lightspeeddevelopment/tour-operator/releases/tag/v1.0.7) - 2017-06-08

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

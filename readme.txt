=== Tour Operators ===
Contributors: feedmymedia
Donate link: https://www.lsdev.biz/
Tags: tour operator, tour operators, tour, tours, tour itinerary, tour itineraries, accommodation, accommodation listings, destinations, regions, tourism, lsx
Requires at least: 4.3
Tested up to: 4.8
Requires PHP: 7.0
Stable tag: 1.1.1
License: GPLv3

The Tour Operators plugin brings live availability, bookings, digital itineraries, and other post types tour operators need to succeed.

== Description ==

LightSpeed’s LSX Tour Operator plugin is here to help you take your Tour Operator business online. 

The plugin features digital itineraries which include interactive galleries, day-by-day information, integrated maps that show a tour’s progression, information per destination, accommodation, activities and other features that will bring your tour offerings to life online. 

Its destination management features make featuring destinations super simple, and attractive to boot. We’ve also built a “Travel Style” feature so you can categorise tours by the type of experience they offer.

Detailed accommodation listings show off room facilities, image galleries, video material, reviews, interactive digital tours, special offers, team members and more.

= Works with the free LSX Theme =
We've also made a fantastic [free theme](https://www.lsdev.biz/product/lsx-wordpress-theme/) that work well with the Tour Operator plugin.

= It's free, and always will be. =
We’re firm believers in open source - that’s why we’re releasing the Tour Operators plugin for free, forever. We offer free support on the [Tour Operator support forums](https://wordpress.org/support/plugin/tour-operator). 

= Actively Developed =
The Tour Operator plugin is actively developed with new features and exciting enhancements all the time. Keep track on the [Tour Operator GitHub repository](https://github.com/lightspeeddevelopment/tour-operator).
Report any bugs via github issues.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/tour-operator` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Settings->Tour Operator screen to configure the plugin

== Frequently Asked Questions ==

= Where can I find Tour Operator plugin documentation and user guides? =
For help setting up and configuring the Tour Operator plugin please refer to our [user guide](https://www.lsdev.biz/documentation/tour-operator/)

= Where can I get support or talk to other users =
If you get stuck, you can ask for help in the [Tour Operator plugin forum](https://wordpress.org/support/plugin/tour-operator).
For help with premium add-ons from LightSpeed, use [our contact page](https://www.lsdev.biz/contact-us/)

= Will the Tour Operator plugin work with my theme 
Yes; the Tour Operator plugin will work with any theme, but may require some styling to make it match nicely. Please see our [codex](https://www.lsdev.biz/documentation/lsx/) for help. If you're looking for a theme with built in Tour Operator plugin integration we recommend [LSX Theme](https://www.lsdev.biz/product/lsx-wordpress-theme/).

= Where can I report bugs or contribute to the project? =
Bugs can be reported either in our support forum or preferably on the [Tour Operator GitHub repository](https://github.com/lightspeeddevelopment/lsx/issues).

= The Tour Operator plugin is awesome! Can I contribute? =
Yes you can! Join in on our [GitHub repository](https://github.com/lightspeeddevelopment/tour-operator) :)

== Screenshots ==

1. The slick Tour Operator plugin settings panel.
2. Tour itinerary admin panel.
3. Accommodation panel.
4. A tour itinerary archive.
5. A single tour itinerary page.

== Changelog ==

= 1.1.1 =
* Fix - Removed the "prepare" statement from the destinations "filter_countries" function.
* Fix - Fixed extra spacing on Included and Not-Included items list
* Fix - Crop huge excerpts o archive and widget items.
* Fix - Fixed Post Type Widget specific IDs front-end
* Fix - TO Maps undefined function removed
* Dev - Added compatibility with LSX Videos
* Fix - Fixed PHP notice related to call is_singular() function
* Fix - Changing the "id" to use a sanitized title string, to avoid cached sites pulling through the same gallery for each destination

= 1.1.0 =
* New totally awesome version! The visual was fully redesigned
* Added compatibility with LSX 2.0
* Dev - New project structure
* Dev - UIX updated + Fixed issue with sub tabs click (settings)
* Dev - Added in a filter to call the Tours Featured image for the Departure Day.
* Dev - Added the accommodations room images to the pool of possible itinerary day images.
* Dev - Allowing the to_country_regions() to be ordered by the menu order or any other valid WP_Query order
* Fix - Fixed scripts/styles loading order
* Fix - Fixed many small issues

= 1.0.8 =
* Fix - LSX tabs working integrated with TO tabs (dashboard settings)
* Fix - Fixed admin styles (help and add-on pages)
* Fix - UIX framework saving all tabs

= 1.0.7 =
* Dev - Added .editorconfig file to help developers to maintain consistent coding styles between different editors and IDEs
* Dev - LSX Customizer SASS selector extented to new FacetWP selectors
* Dev - Make the team image displays square
* Dev - Enable BS sliders on all small breakpoints
* Dev - New slider code for: Widgets, Regions (destination archive), and Related items section
* Dev - CMB updated (copied from LSX Banners)
* Dev - Changing the archives and widgets to show only the countries
* Dev - Added in a filters for the itinerary image so 3rd party plugins and themes can overwrite it if they want to
* Dev - Added in a filter for the destinations facets, so they only display the countries
* Dev - Add .editorconfig file to help developers to maintain consistent coding styles between different editors and IDEs
* Dev - Add RTL styles option
* Dev - New folder structure for CSS files
* Dev - New folder structure for JS files
* Dev - Update all NPM packages and re-structure Gulp’s tasks
* Dev - Adds the FontAwesome fonts if the theme is not LSX Theme or if it isn’t loaded by another plugin/theme
* Dev - Adding in the LSX sharing support
* Dev - Added in the ability to queue your imports
* Dev - Restructure metabox
* Dev - Adding in support for the TO reviews section
* Dev - Added compatibility (styles) with different column order on single team extension
* Dev - Removed from accommodation archive the brands slider
* Fix - Added in a filter to fix the API tab not showing when certain LSX Extensions are enabled
* Fix - Removed "read more" from regions excerpt widgets on destination archive page
* Fix - Small fix on TO custom post type (single template - CSS) for small breakpoints
* Fix - Removed the locations taxonomy
* Fix - Restricting the amount of accommodation allowed to be attached to an itinerary to 1
* Fix - Allowing the itineraries to display other images from and accommodations gallery
* Fix - Fixed the selecting of the general enquiry form
* Fix - Ordering the destinations by the title, allowing all of the destinations to be pulled through to the destination archive
* Fix - Fixed settings page header
* Fix - Fixed settings page tabs
* Fix - Trigger was triggered before defining the hook
* Fix - Make save a real button and add saved indicator
* Fix - Refactor loading
* Fix - Globalize initilizer for backwards compatilility
* Fix - Wrapper reference for tour_operator()
* Fix - Tidy inline docs and add missing property declarations
* Fix - Inline docs cleanup WIP
* Fix - Architecture: Overhaul organization of plugin
* Fix - Architecture: Class files should not have functions
* Fix - Fixed up the style for the save changes button
* Fix - Fixed the display of the metaboxes with other plugins active
* Fix - Correct cols count for price to fix tabs
* Fix - Fixed the selecting of the enquiry forms
* Fix - Adding in a test to the settings page
* Fix - Getting the API key inline with the rest of the extensions
* Fix - Fixed the General Tab display
* Fix - Fixed the API key settings tab
* Fix - Removing the enqueue for the metabox js and css
* Fix - Fixed the cropping options
* Fix - Declaring the $tour_operator variable for the archive destinations work properly
* Fix - Fixed lsx thumbnails parameter for single image size
* Fix - Help page updated with the current plugin version and WordPress requirement
* Fix - Travis CI file

= 1.0.6 =
* Fix - Load correctly the translations/language files
* Fix - Fixed the read more when you click it removes the formatting
* Fix - Fixed the display of the destination galleries
* Dev - Added en_US language file
* Dev - Changed the "Insert into Post" button text from media modal to "Select featured image"
* Dev - Added in the Day inclusions fields along with the styling
* Dev - Added in "full" as an option to be replaced
* Dev - Removing the destinations, accommodation and the tour dependancies on the TO Galleries
* Dev - Standardized the Gallery fields across the post types. Allowing the TO Videos to always inject after.

= 1.0.5 =
* Added TO Search as subtab on LSX TO settings page
* Styles from TO Search addon moved to it
* Fixed menu navigation improved
* Made the function lsx_to_archive_entry_top function test all active post types, not only the three core post types
* Fixed (back-end) checkbox to display map on destination archive
* Replaced body and post (TO post type) classes by same classes using prefix "lsx-to-POST_TYPE"
* Fixed global variable (LSX TO) to enable/disable slider on mobile
* Added swiper JS library for sliders
* Added extra class to all sliders (lsx-to-slider)
* Dev - Metadata: calendar info moved to the next line
* Dev - Metadata: term "price" change to "price from"
* Dev - Metadata: term “duration” added to duration meta
* Fix - Fixed the default pagination from LSX
* Fix - Facilities without child items can't display
* Fix - Fixed styles from post meta details on banner
* Fix - Fixed fideos 16x9
* Fix - Mysterious Man PNG image
* Fix - Internal banner on small devices
* Fix - Small fixes on front-end fields
* Fix - Made Google Maps works on back-end
* Fix - Fixed content_part filter for plugin and add-ons
* Fix - Removed general contact fields from post types
* Dev - New fields from Wetu Importer

= 1.0.4 =
* Removed the last of the LSX_TO_POSTEXPIRATOR_TYPES constants
* Fixed an issue with empty post meta (depart from, end point)
* Removed Certain Travis CI code sniffers
* Added generic business contact details for enquire call to action
* Best time to visit added to destination (copied from tour)
* Enabled compatibility with LSX Blog Customiser (categories carousel)

= 1.0.3 =
* Added in a compatability check for all versions below PHP 7
* Fixed PHP errors when activating the plugin with a non LSX theme
* Hid the "Contact Details" custom field panel from Accommodation, these fields don't output to the frontend yet
* Updated the readme.txt content

= 1.0.2 =
* Fixed a conflict with some plugins using https://github.com/humanmade/Custom-Meta-Boxes
* Added a test to avoid the plugin activate with older versions from PHP than 5.6
* Added a warning for users that have the plugin activated in older versions from PHP than 5.6

= 1.0.1 =
* Allowing the placeholder to overwrite any empty image on all post types
* Fixed PHP warning notice, removed the constant LSX_TO_POSTEXPIRATOR_TYPES
* Fixed the PHP warning with the post order class
* Fixed the selecting of the global default placeholders
* Fixed PHP compatibility errors

= 1.0.0 =
* Initial release

== Upgrade Notice ==

= 1.0 =
Initial release no updates available

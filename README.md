# LSX Tour Operators
[![built with gulp.js](https://img.shields.io/badge/built%20with-gulp.js-green.svg)](http://gulpjs.com/) [![build status](https://travis-ci.org/lightspeeddevelopment/tour-operator.svg?branch=master)](https://travis-ci.org/lightspeeddevelopment/tour-operator) [![Code Climate](https://codeclimate.com/github/lightspeeddevelopment/tour-operator/badges/gpa.svg)](https://codeclimate.com/github/lightspeeddevelopment/tour-operator) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/lightspeeddevelopment/tour-operator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/lightspeeddevelopment/tour-operator/?branch=master) [![Coverage Status](https://coveralls.io/repos/github/lightspeeddevelopment/tour-operator/badge.svg?branch=master)](https://coveralls.io/github/lightspeeddevelopment/tour-operator?branch=master)

## Description

Welcome to the LSX Tour Operator repository on GitHub. Here you can browse the source, look at open issues and keep track of development. Developers can also stay up to date with latest developments in the plugin via our [Twitter](https://twitter.com/lightspeedwp) and [Facebook](https://www.facebook.com/LightSpeedWordPressDevelopment) pages.

## Documentation

* [Core functionality](https://www.lsdev.biz/documentation/tour-operator-plugin/) 
* [Videos](https://www.lsdev.biz/documentation/tour-operator-videos/) 
* [Galleries](https://www.lsdev.biz/documentation/tour-operator-galleries/) 
* [Specials](https://www.lsdev.biz/documentation/tour-operator-specials/) 
* [Team](https://www.lsdev.biz/documentation/tour-operator-team/) 
* [Maps](https://www.lsdev.biz/documentation/tour-operator-maps/) 
* [Vehicles](https://www.lsdev.biz/documentation/tour-operator-vehicles/) 
* [Activities](https://www.lsdev.biz/documentation/tour-operator-activities/) 
* [Reviews](https://www.lsdev.biz/documentation/tour-operator-reviews/) 

## Support

For support with using the Tour Operator plugin, please contact us at support@lsdev.biz or log issues on this github repo. 

## Shortcode to emulate Archive Entries

`[lsx_to_archive]`

### Parameters

- Layout
 - parameter name: `layout`
 - accepts: list / grid
 - default: list
- Post Type
 - parameter name: `post_type`
 - accepts: post type slug
 - default: tour
- Order By
 - parameter name: `orderby`
 - accepts: WP_Query orderby acceptable value
 - default: date
- Order
 - parameter name: `order`
 - accepts: ASC / DESC
 - default: DESC
- Maximum Amount
 - parameter name: `limit`
 - accepts: numeric value
 - default: 10
- Specify Entries by ID
 - parameter name: `include`
 - accepts: comma seperated list of team member post IDs
- Featured Entries
 - parameter name: `featured`
 - accepts: 0 / 1
 - default: 0

## Shortcode to emulate Post Type Widget

`[lsx_to_post_type_widget]`

### Parameters

- Widget Title
 - parameter name: `title`
 - accepts: string
- Widget Link
 - parameter name: `title_link`
 - accepts: string
- Widget Class
 - parameter name: `class`
 - accepts: string
- Columns
 - parameter name: `columns`
 - accepts: numeric value
 - default: 1
- Post Type
 - parameter name: `post_type`
 - accepts: post type slug
 - default: tour
- Order By
 - parameter name: `orderby`
 - accepts: WP_Query orderby acceptable value
 - default: date
- Order
 - parameter name: `order`
 - accepts: ASC / DESC
 - default: DESC
- Maximum Amount
 - parameter name: `limit`
 - accepts: numeric value
 - default: -1 (all)
- Specify Entries by ID
 - parameter name: `include`
 - accepts: comma seperated list of team member post IDs
- Featured Entries
 - parameter name: `featured`
 - accepts: 0 / 1
 - default: 0
- Disable Placeholder
 - parameter: `disable_placeholder`
 - accepts: 0 / 1
 - default: 0
- Disable Text
 - parameter: `disable_text`
 - accepts: 0 / 1
 - default: 0
- Enable Button
 - parameter: `buttons`
 - accepts: 0 / 1
 - default: 0
- Button Text
 - parameter name: `button_text`
 - accepts: string (button label)
- Enable Carousel
 - parameter: `carousel`
 - accepts: 0 / 1
 - default: 0
- Carousel Interval
 - parameter name: `interval`
 - accepts: numeric value
 - default: 7000 (ms)

## Shortcode to emulate Taxonomy Widget

`[lsx_to_taxonomy_widget]`

### Parameters

- Widget Title
 - parameter name: `title`
 - accepts: string
- Widget Link
 - parameter name: `title_link`
 - accepts: string
- Widget Class
 - parameter name: `class`
 - accepts: string
- Columns
 - parameter name: `columns`
 - accepts: numeric value
 - default: 1
- Taxonomy
 - parameter name: `taxonomy`
 - accepts: taxonomy slug
- Order By
 - parameter name: `orderby`
 - accepts: WP_Query orderby acceptable value
 - default: date
- Order
 - parameter name: `order`
 - accepts: ASC / DESC
 - default: DESC
- Maximum Amount
 - parameter name: `limit`
 - accepts: numeric value
 - default: -1 (all)
- Specify Entries by ID
 - parameter name: `include`
 - accepts: comma seperated list of team member post IDs
- Featured Entries
 - parameter name: `featured`
 - accepts: 0 / 1
 - default: 0
- Disable Placeholder
 - parameter: `disable_placeholder`
 - accepts: 0 / 1
 - default: 0
- Disable Text
 - parameter: `disable_text`
 - accepts: 0 / 1
 - default: 0
- Disable Single Link
 - parameter: `disable_single_link`
 - accepts: 0 / 1
 - default: 0
- Enable Button
 - parameter: `buttons`
 - accepts: 0 / 1
 - default: 0
- Button Text
 - parameter name: `button_text`
 - accepts: string (button label)
- Enable Carousel
 - parameter: `carousel`
 - accepts: 0 / 1
 - default: 0
- Carousel Interval
 - parameter name: `interval`
 - accepts: numeric value
 - default: 7000 (ms)

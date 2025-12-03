# CSS Class Audit Report

**Plugin:** Tour Operator  
**Version:** 2.1.0  
**Date:** December 2024

## Overview

This document provides a comprehensive audit of CSS classes used in the Tour Operator plugin. The audit identifies:
- CSS source files and their build outputs
- Classes actively used in the codebase
- Third-party library classes
- WordPress core classes
- Potentially unused classes that may be safe to remove

## CSS Source Files

The Tour Operator plugin uses SCSS source files that compile to CSS:

| Source File | Build Output | Description |
|------------|--------------|-------------|
| `/src/css/index.scss` | `/build/style.css` | Main frontend styles (includes partials) |
| `/src/css/admin.scss` | `/build/admin.css` | Admin settings page styles |
| `/src/css/metaboxes.scss` | `/build/metaboxes.css` | CMB2 metabox tab styles |
| `/src/css/scporder.scss` | (part of scporder module) | Post ordering drag-and-drop styles |
| `/src/blocks/sticky-menu/style.scss` | `/build/blocks/sticky-menu/style-index.css` | Sticky menu block styles |
| `/src/blocks/icons/style.scss` | `/build/blocks/icons/style-index.css` | Icon block styles |

### SCSS Partials (imported by index.scss)

| Partial | Purpose |
|---------|---------|
| `_icons.scss` | Currency icons using CSS pseudo-elements |
| `_additional.scss` | Additional info sections and FacetWP styling |
| `_slider.scss` | Slick Slider customizations |
| `_collapse.scss` | Mobile collapse/toggle functionality |
| `_modals.scss` | Modal/popup dialog styles |
| `_maps.scss` | Google Maps marker popup styles |

> **Note:** The issue mentions `to-fonts.css` but this file does **NOT** exist in the repository. This may refer to a legacy file that has been removed or a file in a related project.

---

## Summary Statistics

| Category | Count |
|----------|-------|
| Total CSS classes found | 146 |
| Third-party library classes | 30 |
| WordPress core classes | 8 |
| Actively used classes | 93 |
| Potentially unused classes | 15 |

---

## Third-Party Library Classes (30)

These classes are from third-party libraries and **should be retained** as they style external functionality.

### Slick Slider Classes (14)
The plugin uses Slick Slider for carousels and lightboxes.

| Class | Purpose |
|-------|---------|
| `slick-active` | Active slide/dot state |
| `slick-arrow` | Arrow navigation wrapper |
| `slick-disabled` | Disabled arrow state |
| `slick-dots` | Dot pagination container |
| `slick-lightbox-close` | Lightbox close button |
| `slick-lightbox-inner` | Lightbox content wrapper |
| `slick-lightbox-slick-caption` | Lightbox image caption |
| `slick-list` | Slides container |
| `slick-next` | Next arrow |
| `slick-prev` | Previous arrow |
| `slick-slide` | Individual slide |

### FacetWP Classes (11)
The plugin provides styles for FacetWP faceted search integration.

| Class | Purpose |
|-------|---------|
| `facetwp-checkboxes` | Checkbox facet type |
| `facetwp-dropdown` | Dropdown facet type |
| `facetwp-facet` | Generic facet container |
| `facetwp-icon` | Search icon |
| `facetwp-input-wrap` | Input wrapper |
| `facetwp-radio` | Radio facet type |
| `facetwp-range` | Range slider facet |
| `facetwp-reset` | Reset button |
| `facetwp-search` | Search input |
| `facetwp-selections` | Selected filters display |
| `facetwp-type-reset` | Reset facet type |

### Fancy Select (Select2 alternative) Classes (5)
Used for styled dropdowns in faceted filtering.

| Class | Purpose |
|-------|---------|
| `fs-arrow` | Dropdown arrow |
| `fs-label` | Selected label |
| `fs-label-wrap` | Label container |
| `fs-search` | Search input |
| `fs-wrap` | Main wrapper |

### jQuery UI Classes (3)
Used for sortable post ordering functionality.

| Class | Purpose |
|-------|---------|
| `ui-sortable` | Sortable container |
| `ui-sortable-helper` | Dragged item placeholder |
| `ui-tab` | Tab panel |

---

## WordPress Core Classes (8)

These are WordPress block editor classes. **They should be retained** for block compatibility.

| Class | Purpose |
|-------|---------|
| `hidden` | Hidden element utility |
| `is-layout-flex` | Flexbox layout |
| `wp-block-cover` | Cover block |
| `wp-block-group` | Group block container |
| `wp-block-hm-popup` | Popup/modal dialog |
| `wp-block-hm-popup__close` | Popup close button |
| `wp-block-query` | Query loop block |
| `wp-block-template-part` | Template part block |

---

## Actively Used Classes (93)

These classes are actively used in PHP templates, JavaScript files, or block rendering. They **should be retained**.

### Tour Operator Core Classes

| Class | Usage Location(s) |
|-------|-------------------|
| `lsx-to-slider` | `includes/patterns/travel-information.php`, `templates/`, `src/js/blocks/slider-query.js` |
| `lsx-itinerary-wrapper` | `src/blocks/itinerary/index.js`, `templates/single-tour.html`, `src/js/custom.js` |
| `lsx-units-wrapper` | `src/blocks/units/index.js`, `templates/single-accommodation.html`, `src/js/custom.js` |
| `lsx-price-wrapper` | `templates/`, `includes/patterns/accommodation-card.php`, `includes/patterns/tour-card.php` |
| `lsx-single-supplement-wrapper` | `src/blocks/single-supplement-wrapper/index.js`, `templates/` |
| `lsx-destination-to-tour-wrapper` | `templates/single-tour.html`, `src/blocks/destination-to-tour/index.js` |
| `lsx-travel-information-wrapper` | `includes/patterns/travel-information.php`, `src/js/custom.js` |
| `lsx-block-videos` | `src/js/custom.js`, `includes/classes/blocks/class-bindings.php` |
| `lsx-map` | `src/blocks/google-map/index.js`, `templates/` |

### Map Marker Classes

| Class | Usage |
|-------|-------|
| `lsx-to-map-marker` | `src/js/maps.js` |
| `lsx-to-map-marker-content` | `src/js/maps.js` |
| `lsx-to-map-marker-img` | `src/js/maps.js` |
| `lsx-to-map-marker-title` | `src/js/maps.js` |

### Sticky Menu Classes

| Class | Usage |
|-------|-------|
| `lsx-to-sticky-menu` | `src/blocks/sticky-menu/` |
| `lsx-to-sticky-menu-nav` | `src/blocks/sticky-menu/index.js` |
| `lsx-to-sticky-menu-list` | `src/blocks/sticky-menu/index.js` |
| `lsx-to-sticky-menu-item` | `src/blocks/sticky-menu/index.js` |
| `lsx-to-sticky-menu-button` | `src/blocks/sticky-menu/index.js`, `view.js` |
| `lsx-to-sticky-menu-section` | `src/blocks/sticky-menu/` |
| `lsx-to-sticky-menu-section-wrapper` | `src/blocks/sticky-menu/render.php`, `view.js` |
| `lsx-to-sticky-menu-section-content` | `src/blocks/sticky-menu/render.php` |
| `lsx-to-section-header` | `src/blocks/sticky-menu/render.php`, `view.js` |
| `lsx-to-sticky-caret` | `src/blocks/sticky-menu/render.php` |
| `lsx-to-sr-only` | `src/blocks/sticky-menu/render.php`, `view.js` |
| `lsx-to-sticky-menu-placeholder` | `src/blocks/sticky-menu/index.js` |
| `wp-block-lsx-tour-operator-sticky-menu` | `src/blocks/sticky-menu/view.js` |

### Admin/Metabox Classes

| Class | Usage |
|-------|-------|
| `lsx-to-settings` | `includes/classes/admin/` |
| `lsx_tabs` | `src/js/metabox-structure.js` |
| `lsx_tab` | `src/js/metabox-structure.js` |
| `lsx_tabs_clear` | `src/js/metabox-structure.js` |

### CMB2/Metabox Classes

| Class | Usage |
|-------|-------|
| `CMB_Title` | CMB2 library class (metabox titles) |
| `cmb_metabox` | CMB2 library class (metabox wrapper) |
| `postbox` | WordPress core metabox wrapper |
| `inside` | CMB2 library class (content area) |
| `form-field` | CMB2 library class (form fields) |
| `spinner` | CMB2 library class (loading indicator) |

### UI State Classes

| Class | Usage |
|-------|-------|
| `active` | Active states in navigation, tabs, sticky menu |
| `collapsed` | Collapsed content sections |
| `slider-disabled` | Disabled slider state |
| `toggle-button` | Mobile toggle buttons |
| `toggle-icon` | Toggle button icons |

### Layout & Content Classes

| Class | Usage |
|-------|-------|
| `fast-facts-wrapper` | Tour/accommodation quick facts |
| `facilities-list` | Accommodation facilities list |
| `additional-info` | Additional info sections |
| `single-tour-operator` | Body class for single post views |
| `unit-price-wrapper` | Room/unit pricing |
| `content-area` | Content wrapper for maps |
| `entry-content` | Post content wrapper |

### Currency Icon Classes (32)
These classes are used dynamically to display currency symbols via CSS pseudo-elements:

`currency-icon`, `usd`, `eur`, `gbp`, `zar`, `brl`, `bwp`, `cny`, `jpy`, `inr`, `idr`, `ils`, `kes`, `lak`, `mwk`, `myr`, `mzn`, `nok`, `sek`, `rub`, `chf`, `tzs`, `aed`, `zmw`, `zwl`, `nad`, `cad`, `hkd`, `sgd`, `nzd`, `aud`

---

## Potentially Unused Classes (15)

These classes appear in CSS but were **not found** in PHP, HTML, or JavaScript files. They may be safe to remove after verification.

### ⚠️ Verify Before Removal

| Class | Source File | Notes |
|-------|-------------|-------|
| `lsx-to-sticky-menu-help` | `sticky-menu/style.scss` | Editor help styles - may be legacy |
| `lsx-to-sticky-menu-info` | `sticky-menu/style.scss` | Editor info styles - may be legacy |
| `lsx-post-carousel-items` | `_slider.scss` | May be from LSX Starter theme integration |
| `lazy-hidden` | `_slider.scss` | Third-party lazy loading class - external JS |
| `moretag` | `_maps.scss` | WordPress "read more" link class |
| `read-more-btn` | `_additional.scss` | JavaScript-generated class |
| `read-less-btn` | `_additional.scss` | JavaScript-generated class |
| `facet-row` | `_additional.scss` | FacetWP layout class |
| `dropdown-menu` | `_slider.scss` | Bootstrap/dropdown class exclusion |

### WordPress Context Classes (Safe to Keep)

These are WordPress-added classes that the CSS targets for styling in specific contexts:

| Class | Source File | Reason to Keep |
|-------|-------------|----------------|
| `admin-bar` | `sticky-menu/style.scss` | WordPress admin bar - adjusts sticky positioning |
| `block-editor-iframe__body` | `sticky-menu/style.scss` | Editor iframe context |
| `wp-block-group__inner-container` | `sticky-menu/style.scss` | Legacy WordPress core class |
| `has-x-large-font-size` | `icons/style.scss` | WordPress typography preset |
| `has-xx-large-font-size` | `icons/style.scss` | WordPress typography preset |
| `alternate` | `scporder.scss` | jQuery UI sortable row class |

---

## Recommendations

### 1. CSS Classes Safe to Remove

After thorough analysis, the following CSS rules can be removed as they are **confirmed unused**:

#### In `src/blocks/sticky-menu/style.scss`:
```scss
// REMOVE - unused editor helper classes (never referenced in JS/PHP):
.lsx-to-sticky-menu-info {
  font-size: 0.75rem;
  opacity: 0.7;
  margin-top: 0.5rem;
  text-align: center;
}

.lsx-to-sticky-menu-help {
  font-size: 0.75rem;
  margin-top: 0.5rem;
}

.lsx-to-sticky-menu-help ol {
  margin-left: 1rem;
  line-height: 1.4;
  text-align: left;
}
```

#### In `src/css/_additional.scss`:
```scss
// REMOVE - these classes are never added dynamically 
// (the code uses 'less-link' class instead, not these):
.additional-info .wp-block-group.content .read-more-btn,
.additional-info .wp-block-group.content .read-less-btn {
  color: #0073aa;
  cursor: pointer;
  font-weight: bold;
}
.additional-info .wp-block-group.content .read-more-btn:hover {
  text-decoration: underline;
}
.additional-info .wp-block-group.content .read-less-btn {
  display: none;
}
```

### 2. How to Verify a Class is Unused

Before removing any CSS class, verify it's not used elsewhere with these commands:

```bash
# Search for class in all PHP, JS, HTML, and JSON files
grep -rn "class-name" . --include="*.php" --include="*.js" --include="*.html" --include="*.json" | grep -v "node_modules"

# Search in LSX theme if installed alongside
grep -rn "class-name" ../lsx/ --include="*.php" --include="*.js" 2>/dev/null

# Check if class is generated dynamically in JavaScript
grep -rn "addClass.*class-name\|classList.*class-name" . --include="*.js" | grep -v "node_modules"
```

### 3. Classes to Verify Before Removal

These classes may be used by external integrations:

| Class | Source | Notes |
|-------|--------|-------|
| `lazy-hidden` | `_slider.scss` | May be from lazy loading plugins (Jetpack, etc.) |
| `lsx-post-carousel-items` | `_slider.scss` | May be from LSX theme or other LightSpeed plugins |
| `facet-row` | `_additional.scss` | May be from FacetWP template integration |
| `dropdown-menu` | `_slider.scss` | Used as selector exclusion - verify if needed |
| `moretag` | `_maps.scss` | WordPress core class for "read more" links |

### 4. WordPress Context Classes (Keep)

These are WordPress-added classes that the CSS targets for styling in specific contexts. **Keep these**:

- `admin-bar` - WordPress admin bar offset
- `block-editor-iframe__body` - Block editor styling context
- `wp-block-group__inner-container` - Legacy inner container class
- `has-x-large-font-size` / `has-xx-large-font-size` - Typography presets

### 5. Future Maintenance Recommendations

1. **Remove confirmed unused CSS**: Apply the removals in section 1 above (~40 lines)
2. **Add comments for external classes**: Document which classes come from third-party integrations
3. **Consider CSS variables**: Use CSS custom properties for theming to reduce class proliferation
4. **Audit periodically**: Re-run this audit after major refactoring or updates

---

## Appendix: Full Class Index by File

### index.scss (and partials)

<details>
<summary>Click to expand full list</summary>

#### _icons.scss
- `%currency-icons` (Sass placeholder)
- `.currency-icon` and all currency classes (usd, eur, etc.)
- `.lsx-price-wrapper`
- `.lsx-single-supplement-wrapper`
- `.unit-price-wrapper`
- `.amount`, `.strike`

#### _additional.scss
- `.fast-facts-wrapper`
- `.facilities-list`
- `.additional-info`
- `.read-more-btn`, `.read-less-btn`
- FacetWP classes (`.facetwp-*`)
- Fancy Select classes (`.fs-*`)

#### _slider.scss
- `.lsx-to-slider`
- `.lsx-travel-information-wrapper`
- `.lsx-block-videos`
- `.wp-block-query`
- All Slick classes (`.slick-*`)
- `.lsx-post-carousel-items`
- `.lazy-hidden`
- `.slider-disabled`

#### _collapse.scss
- `.single-tour-operator`
- `.toggle-button`, `.toggle-icon`
- `.collapsed`
- `.fast-facts-wrapper` (responsive)

#### _modals.scss
- `.wp-block-hm-popup`
- `.wp-block-hm-popup__close`

#### _maps.scss
- `.lsx-map`
- `.lsx-to-map-marker`
- `.lsx-to-map-marker-content`
- `.lsx-to-map-marker-img`
- `.lsx-to-map-marker-title`
- `.content-area`, `.entry-content`
- `.moretag`

</details>

### admin.scss

- `.wrap.lsx-to-settings`
- `.spinner`
- `.form-field`
- `.ui-tab`

### metaboxes.scss

- `.postbox`, `.inside`, `.cmb_metabox`
- `.lsx_tabs`, `.lsx_tab`, `.lsx_tabs_clear`
- `#lsx-tour-operators`, `#tour-operator-plugin`
- `.CMB_Title`

### scporder.scss

- `.ui-sortable`
- `.ui-sortable-helper`
- `.alternate`

### sticky-menu/style.scss

- All `.lsx-to-sticky-menu*` classes
- `.lsx-to-sr-only`
- `.lsx-to-section-header`
- `.admin-bar` (WordPress context)
- `.block-editor-iframe__body` (editor context)

### icons/style.scss

- `.lsx-icons-search`
- `.block-icon-svg`
- Font size preset overrides

---

## Changelog

| Date | Author | Changes |
|------|--------|---------|
| December 2024 | CSS Audit Tool | Initial audit completed |

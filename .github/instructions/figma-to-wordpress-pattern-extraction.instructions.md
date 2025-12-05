# GitHub Copilot Custom Instructions - Figma to WordPress Pattern Extraction (Plugin)

## When Converting Figma Designs to WordPress Patterns

Whenever you invoke Figma MCP server tools to create WordPress block patterns for the **Tour Operator plugin**, follow these instructions:

---

## 1. Pre-Processing: Extract Design Tokens from Figma

Before converting any Figma design to a WordPress pattern:

1. **Fetch design tokens from Figma Design System** using MCP tools:

   ```
   mcp_figma_dev-mod_get_variable_defs
   ```

   This returns the actual design token names and values from Figma, for example:
   ```json
   {
     "Buttons/Fill/Background Default": "#ac9f7c",
     "Buttons/CTA/Background Default": "#4a7311",
     "Theme/Contrast": "#090909",
     "Font Family/Heading": "Lora",
     "Buttons/Small/Horizontal": "20",
     "Buttons/Small/Vertical": "8",
     "Radius Small": "4"
   }
   ```

2. **Map Figma tokens to WordPress CSS custom properties with fallbacks**:

   Since this is a **plugin** (not a theme), patterns must work with any theme. Always include absolute fallback values:

   | Figma Token | WordPress Variable | Fallback |
   |-------------|-------------------|----------|
   | `Buttons/Fill/Background Default` | `var(--wp--preset--color--buttons-fill-background-default, #ac9f7c)` | `#ac9f7c` |
   | `Theme/Contrast` | `var(--wp--preset--color--contrast, #090909)` | `#090909` |
   | `Buttons/Small/Horizontal` | `var(--wp--preset--spacing--buttons-small-horizontal, 1.25rem)` | `1.25rem` (20px) |
   | `Radius Small` | `var(--wp--preset--spacing--radius-small, 0.25rem)` | `0.25rem` (4px) |

3. **Store token mappings** in memory for reference during conversion

---

## 2. Design Token Conversion Rules

### Color Tokens

**Figma Format → WordPress Format (with fallback)**

```css
/* Figma: var(--buttons/fill/background-default, #ac9f7c) */
/* WordPress Block JSON attribute: */
"backgroundColor": "var:preset|color|buttons-fill-background-default"

/* WordPress inline style (with fallback): */
background-color: var(--wp--preset--color--buttons-fill-background-default, #ac9f7c);
```

### Spacing Tokens

Convert pixel values to rem (base 16px):

```css
/* Figma: 20px horizontal padding */
/* WordPress Block JSON: */
"padding": {
  "left": "var:preset|spacing|buttons-small-horizontal",
  "right": "var:preset|spacing|buttons-small-horizontal"
}

/* WordPress inline style (with fallback): */
padding-left: var(--wp--preset--spacing--buttons-small-horizontal, 1.25rem);
padding-right: var(--wp--preset--spacing--buttons-small-horizontal, 1.25rem);
```

### Typography Tokens

```css
/* Figma: Font Family/Heading = "Lora" */
/* WordPress Block JSON: */
"fontFamily": "heading"

/* Figma: size: 16, weight: 500, lineHeight: 1.5 */
/* WordPress inline style (with fallback): */
font-family: var(--wp--preset--font-family--heading, 'Lora', serif);
font-size: var(--wp--preset--font-size--medium, 1rem);
font-weight: 500;
line-height: 1.5;
```

### Border Radius Tokens

```css
/* Figma: Radius Small = 4 */
/* WordPress Block JSON: */
"border": {
  "radius": "var:preset|spacing|radius-small"
}

/* WordPress inline style (with fallback): */
border-radius: var(--wp--preset--spacing--radius-small, 0.25rem);
```

---

## 3. Token Slug Conversion

Convert Figma token names to valid WordPress preset slugs:

| Original Figma Token | WordPress Slug |
|---------------------|----------------|
| `Buttons/Fill/Background Default` | `buttons-fill-background-default` |
| `Buttons/CTA/Text & Icon Default` | `buttons-cta-text-icon-default` |
| `Theme/Contrast` | `theme-contrast` or `contrast` |
| `Font Family/Heading` | `heading` |
| `Buttons/Small/Block Space` | `buttons-small-block-space` |

**Rules:**
- Replace `/` with `-`
- Replace ` ` (spaces) with `-`
- Replace `&` with nothing or `-`
- Convert to lowercase
- Remove special characters

---

## 4. Extract Design from Figma

Use the Figma MCP tools to extract the design:

```
mcp_figma_dev-mod_get_design_context
mcp_figma_dev-mod_get_screenshot
mcp_figma_dev-mod_get_variable_defs
```

**Important Parameters:**

- `nodeId`: Extract from the Figma URL (e.g., `node-id=10251-3139` → `10251-3139`)
- `clientFrameworks`: `wordpress`
- `clientLanguages`: `php,html`

**Parse the Generated Code:**

- Extract CSS variables from Tailwind classes: `var(--buttons/fill/background-default,#ac9f7c)`
- Identify layout structure (flex, columns, groups, spacing)
- Note colors, typography, borders, spacing values
- Document interactive elements (buttons, links)
- **Always capture the fallback values** - these are the hex codes or pixel values in the Figma code

---

## 5. WordPress Pattern File Structure (Plugin)

**File Location:** `/patterns/[pattern-slug].php` (root level, not in includes/)

**Required Metadata (PHP DocBlock):**

```php
<?php
/**
 * Title: Pattern Name
 * Slug: lsx-tour-operator/pattern-name
 * Description: A brief description of the pattern's purpose.
 * Categories: lsx-tour-operator, lsx-to-category
 * Keywords: keyword1, keyword2, keyword3
 * Block Types: core/group
 * Post Types: tour, accommodation, destination
 * Inserter: yes
 *
 * @package    Tour_Operator
 * @subpackage Patterns
 * @since      2.0.0
 */

// phpcs:ignoreFile PluginCheck.CodeAnalysis.ImageFunctions.NonEnqueuedImage
?>
<!-- Block markup here -->
```

**Pattern Array Format (for includes/patterns/):**

When patterns are registered via PHP (current structure), use:

```php
<?php
// phpcs:ignoreFile PluginCheck.CodeAnalysis.ImageFunctions.NonEnqueuedImage
return array(
    'title'         => __( 'Pattern Name', 'tour-operator' ),
    'description'   => __( 'A brief description.', 'tour-operator' ),
    'categories'    => array( $this->category, 'lsx-to-buttons' ),
    'keywords'      => array( 'button', 'cta', 'action' ),
    'postTypes'     => array( 'tour', 'accommodation', 'destination' ),
    'blockTypes'    => array( 'core/buttons' ),
    'content'       => '<!-- wp:buttons -->...',
);
```

---

## 6. Plugin-Specific Conventions

### Asset Paths

**Use plugin constants, not theme functions:**

```php
// ✅ Correct (Plugin)
LSX_TO_URL . 'assets/img/icon.png'

// ❌ Wrong (Theme)
get_template_directory_uri() . '/assets/images/icon.png'
```

In pattern content strings:
```php
'content' => '<!-- wp:image -->
<figure class="wp-block-image">
    <img src="' . LSX_TO_URL . 'assets/img/blocks/icon.png" alt=""/>
</figure>
<!-- /wp:image -->'
```

### Text Domain

Always use `'tour-operator'`:

```php
__( 'Button Text', 'tour-operator' )
esc_html__( 'View More', 'tour-operator' )
esc_attr__( 'Alt text', 'tour-operator' )
```

### Block Bindings

Use the custom `lsx/post-meta` binding source:

```html
<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"price"}}}}} -->
<p class="amount"></p>
<!-- /wp:paragraph -->
```

---

## 7. WordPress Block Markup with Fallbacks

### Button Block (from Figma example)

**Figma Design:**
- Background: `#ac9f7c` (Buttons/Fill/Background Default)
- Border: `#ac9f7c` (Buttons/Fill/Border Default)
- Text: `#090909` (Buttons/Fill/Text & Icon Default)
- Padding: 8px vertical, 20px horizontal
- Font: Lora Medium, 16px
- Border Radius: 4px (Radius Small)

**WordPress Pattern:**

```php
<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons">
    <!-- wp:button {"metadata":{"name":"View More Button"},"style":{"color":{"background":"var:preset|color|buttons-fill-background-default","text":"var:preset|color|buttons-fill-text-icon-default"},"border":{"radius":"var:preset|spacing|radius-small","color":"var:preset|color|buttons-fill-border-default","width":"1px"},"spacing":{"padding":{"top":"var:preset|spacing|buttons-small-vertical","bottom":"var:preset|spacing|buttons-small-vertical","left":"var:preset|spacing|buttons-small-horizontal","right":"var:preset|spacing|buttons-small-horizontal"}},"typography":{"fontFamily":"var:preset|font-family|heading","fontWeight":"500","lineHeight":"1.5"}}} -->
    <div class="wp-block-button">
        <a class="wp-block-button__link wp-element-button" style="border-radius:var(--wp--preset--spacing--radius-small, 0.25rem);border-color:var(--wp--preset--color--buttons-fill-border-default, #ac9f7c);border-width:1px;padding-top:var(--wp--preset--spacing--buttons-small-vertical, 0.5rem);padding-right:var(--wp--preset--spacing--buttons-small-horizontal, 1.25rem);padding-bottom:var(--wp--preset--spacing--buttons-small-vertical, 0.5rem);padding-left:var(--wp--preset--spacing--buttons-small-horizontal, 1.25rem);background-color:var(--wp--preset--color--buttons-fill-background-default, #ac9f7c);color:var(--wp--preset--color--buttons-fill-text-icon-default, #090909)">
            <?php esc_html_e( 'View More', 'tour-operator' ); ?>
        </a>
    </div>
    <!-- /wp:button -->
</div>
<!-- /wp:buttons -->
```

### Group Block with Design Token Fallbacks

```html
<!-- wp:group {"metadata":{"name":"Card Container"},"style":{"color":{"background":"var:preset|color|base"},"border":{"radius":"var:preset|spacing|radius-base","color":"var:preset|color|theme-contrast","width":"1px"},"spacing":{"padding":{"top":"var:preset|spacing|buttons-small-vertical","bottom":"var:preset|spacing|buttons-small-vertical","left":"var:preset|spacing|buttons-small-horizontal","right":"var:preset|spacing|buttons-small-horizontal"},"blockGap":"var:preset|spacing|buttons-small-block-space"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="border-color:var(--wp--preset--color--theme-contrast, #090909);border-width:1px;border-radius:var(--wp--preset--spacing--radius-base, 0.5rem);padding-top:var(--wp--preset--spacing--buttons-small-vertical, 0.5rem);padding-right:var(--wp--preset--spacing--buttons-small-horizontal, 1.25rem);padding-bottom:var(--wp--preset--spacing--buttons-small-vertical, 0.5rem);padding-left:var(--wp--preset--spacing--buttons-small-horizontal, 1.25rem);background-color:var(--wp--preset--color--base, #ffffff)">
    <!-- Inner content -->
</div>
<!-- /wp:group -->
```

---

## 8. Block Metadata and Figma Layer Names

**CRITICAL:** Preserve Figma layer names in WordPress blocks using the `metadata` attribute.

**Extract from Figma Code:**

```jsx
<div data-name="Size=Small, State=Default, Style=Fill" data-node-id="3024:1989">
  <div data-name="Button Content" data-node-id="9663:215771">
```

**Convert to WordPress:**

```html
<!-- wp:group {"metadata":{"name":"Size=Small, State=Default, Style=Fill"}} -->
<div class="wp-block-group">
    <!-- wp:group {"metadata":{"name":"Button Content"}} -->
```

**Rules:**
- Add metadata to **container blocks** (Group, Columns, Buttons)
- **Do NOT add** to leaf content blocks (Heading, Paragraph, Button link)
- Use the exact layer name from Figma's `data-name` attribute

---

## 9. Pixel to Rem Conversion Reference

Always convert Figma pixel values to rem (base 16px):

| Figma (px) | WordPress (rem) | Notes |
|------------|-----------------|-------|
| 4px | 0.25rem | Radius small |
| 8px | 0.5rem | Small spacing, padding |
| 10px | 0.625rem | |
| 12px | 0.75rem | |
| 14px | 0.875rem | Small text |
| 16px | 1rem | Base/medium text |
| 18px | 1.125rem | |
| 20px | 1.25rem | Button horizontal padding |
| 24px | 1.5rem | |
| 32px | 2rem | |
| 40px | 2.5rem | |
| 48px | 3rem | |

---

## 10. Conversion Workflow

**Step-by-step process:**

1. **Fetch Design Tokens First**
   ```
   mcp_figma_dev-mod_get_variable_defs (nodeId from URL)
   ```
   - Document all token names and their fallback values
   - Create a mapping table for the specific component

2. **Fetch Figma Design Context**
   ```
   mcp_figma_dev-mod_get_design_context (nodeId)
   mcp_figma_dev-mod_get_screenshot (nodeId)
   ```
   - Study the screenshot carefully for exact layout
   - Parse the generated React/Tailwind code for CSS variables

3. **Map Tokens to WordPress**
   - Convert Figma token names to WordPress slug format
   - Calculate rem fallback values from pixel values
   - Extract hex color fallbacks

4. **Build Pattern Markup**
   - Start with outer container
   - Add `metadata.name` from Figma layer names
   - Apply token-based styles with fallbacks
   - Nest blocks according to Figma hierarchy

5. **Add Internationalization**
   - Wrap all text in `esc_html_e()` or `__()` 
   - Use `'tour-operator'` text domain

6. **Use Plugin Asset Paths**
   - Replace any image URLs with `LSX_TO_URL . 'assets/img/...'`

7. **Connect to Figma (optional)**
   ```
   mcp_figma_dev-mod_add_code_connect_map
   ```
   - Link the Figma component to the pattern file

8. **Validate**
   - Verify all closing block comments match opening
   - Check fallback values are present
   - Confirm text domain is correct
   - Test in WordPress editor

---

## 11. Common Figma Token Mappings

Based on the Tour Operator Design System:

### Button Tokens

| Figma Token | WordPress Preset | Fallback |
|-------------|------------------|----------|
| `Buttons/Fill/Background Default` | `buttons-fill-background-default` | `#ac9f7c` |
| `Buttons/Fill/Border Default` | `buttons-fill-border-default` | `#ac9f7c` |
| `Buttons/Fill/Text & Icon Default` | `buttons-fill-text-icon-default` | `#090909` |
| `Buttons/CTA/Background Default` | `buttons-cta-background-default` | `#4a7311` |
| `Buttons/CTA/Text & Icon Default` | `buttons-cta-text-icon-default` | `#ffffff` |
| `Buttons/Small/Horizontal` | `buttons-small-horizontal` | `1.25rem` |
| `Buttons/Small/Vertical` | `buttons-small-vertical` | `0.5rem` |
| `Buttons/Small/Block Space` | `buttons-small-block-space` | `0.5rem` |

### General Tokens

| Figma Token | WordPress Preset | Fallback |
|-------------|------------------|----------|
| `Theme/Contrast` | `contrast` | `#090909` |
| `Radius Small` | `radius-small` | `0.25rem` |
| `Radius Base` | `radius-base` | `0.5rem` |
| `Font Family/Heading` | `heading` | `'Lora', serif` |

---

## 12. Inline Style Format

When writing inline styles in the HTML element, always include fallbacks:

```html
style="
    background-color: var(--wp--preset--color--buttons-fill-background-default, #ac9f7c);
    border-color: var(--wp--preset--color--buttons-fill-border-default, #ac9f7c);
    border-width: 1px;
    border-radius: var(--wp--preset--spacing--radius-small, 0.25rem);
    padding: var(--wp--preset--spacing--buttons-small-vertical, 0.5rem) var(--wp--preset--spacing--buttons-small-horizontal, 1.25rem);
    color: var(--wp--preset--color--buttons-fill-text-icon-default, #090909);
"
```

**Note:** Inline styles must use the full CSS variable syntax with fallbacks. The JSON block attributes use the short `var:preset|type|slug` format.

---

## 13. Validation Checklist

Before completing pattern creation:

- [ ] Design tokens fetched from Figma via `get_variable_defs`
- [ ] All CSS variables have absolute fallback values (hex colors, rem sizes)
- [ ] Token slugs are lowercase with hyphens (no spaces, slashes, or special chars)
- [ ] Pixel values converted to rem
- [ ] Pattern uses `LSX_TO_URL` for asset paths (not theme functions)
- [ ] Text domain is `'tour-operator'`
- [ ] All text wrapped in i18n functions
- [ ] Figma layer names preserved in `metadata.name`
- [ ] Block comment structure matches HTML structure
- [ ] Pattern categories include `$this->category` (lsx-tour-operator)
- [ ] Screenshot studied and layout matches exactly

---

## 14. Example: Complete Button Pattern Conversion

**Figma Node:** `10251-3139` (View More Button, Style=Fill)

**Tokens Retrieved:**
```json
{
  "Buttons/Fill/Background Default": "#ac9f7c",
  "Buttons/Fill/Border Default": "#ac9f7c", 
  "Buttons/Fill/Text & Icon Default": "#090909",
  "Buttons/Small/Horizontal": "20",
  "Buttons/Small/Vertical": "8",
  "Font Family/Heading": "Lora",
  "Radius Small": "4"
}
```

**Final Pattern:**

```php
<?php
// phpcs:ignoreFile PluginCheck.CodeAnalysis.ImageFunctions.NonEnqueuedImage
return array(
    'title'       => __( 'Button - Fill Style', 'tour-operator' ),
    'description' => __( 'A filled button with neutral background color.', 'tour-operator' ),
    'categories'  => array( $this->category, 'lsx-to-buttons' ),
    'keywords'    => array( 'button', 'fill', 'cta', 'action' ),
    'blockTypes'  => array( 'core/buttons', 'core/button' ),
    'content'     => '<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"metadata":{"name":"Size=Small, State=Default, Style=Fill"},"style":{"color":{"background":"var:preset|color|buttons-fill-background-default","text":"var:preset|color|buttons-fill-text-icon-default"},"border":{"radius":"var:preset|spacing|radius-small","color":"var:preset|color|buttons-fill-border-default","width":"1px","style":"solid"},"spacing":{"padding":{"top":"var:preset|spacing|buttons-small-vertical","bottom":"var:preset|spacing|buttons-small-vertical","left":"var:preset|spacing|buttons-small-horizontal","right":"var:preset|spacing|buttons-small-horizontal"}}}} -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" style="border-color:var(--wp--preset--color--buttons-fill-border-default, #ac9f7c);border-style:solid;border-width:1px;border-radius:var(--wp--preset--spacing--radius-small, 0.25rem);padding-top:var(--wp--preset--spacing--buttons-small-vertical, 0.5rem);padding-right:var(--wp--preset--spacing--buttons-small-horizontal, 1.25rem);padding-bottom:var(--wp--preset--spacing--buttons-small-vertical, 0.5rem);padding-left:var(--wp--preset--spacing--buttons-small-horizontal, 1.25rem);background-color:var(--wp--preset--color--buttons-fill-background-default, #ac9f7c);color:var(--wp--preset--color--buttons-fill-text-icon-default, #090909)">' . esc_html__( 'View More', 'tour-operator' ) . '</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->',
);
```

---

## 15. Block Validation & Editor Compatibility

**CRITICAL:** WordPress block editor validates saved block content against the block's `save` function output. Mismatches cause "This block contains unexpected or invalid content" errors.

### Key Rules for Valid Patterns

1. **Use self-closing block syntax for dynamic/static blocks that render via PHP:**
   ```html
   <!-- wp:lsx-tour-operator/icons {"iconName":"priceIcon"} /-->
   <!-- wp:post-featured-image {"isLink":true,"aspectRatio":"3/2"} /-->
   <!-- wp:post-title {"textAlign":"center","level":3} /-->
   ```

2. **Do NOT embed SVG markup for icon blocks** - Let the block render it:
   ```html
   <!-- ✅ Correct - block renders SVG dynamically -->
   <!-- wp:lsx-tour-operator/icons {"iconName":"priceIcon"} /-->
   
   <!-- ❌ Wrong - embedded SVG causes validation errors -->
   <!-- wp:lsx-tour-operator/icons {"iconName":"priceIcon"} -->
   <div class="wp-block-lsx-tour-operator-icons"><span class="block-icon-svg"><svg>...</svg></span></div>
   <!-- /wp:lsx-tour-operator/icons -->
   ```

3. **Match JSON attributes exactly with inline styles:**
   ```html
   <!-- JSON uses var:preset|spacing|20 format -->
   <!-- wp:group {"style":{"border":{"radius":"var:preset|spacing|20"}}} -->
   
   <!-- Inline style uses the same reference, NOT CSS variable with fallback -->
   <div class="wp-block-group" style="border-radius:var:preset|spacing|20">
   ```

4. **Do NOT add CSS fallbacks in inline styles for block validation:**
   ```html
   <!-- ✅ Correct - WordPress handles the variable resolution -->
   style="padding-top:var(--wp--preset--spacing--20)"
   
   <!-- ❌ Causes validation mismatch -->
   style="padding-top:var(--wp--preset--spacing--tiny, 0.625rem)"
   ```

### Testing Pattern in Editor

After creating a pattern:
1. Insert the pattern in the editor
2. Switch to "Code editor" view
3. Copy the exact block markup WordPress generates
4. Use that markup in the pattern file

---

## 16. Icon Block Usage

The `lsx-tour-operator/icons` block uses attributes to reference icons from the icon library:

### Available Icon Attributes

```json
{
  "iconType": "outline",  // "outline" (default) or "solid"
  "iconName": "priceIcon" // Name from icons.react.js
}
```

### Common Icon Names

| Icon Name | Type | Usage |
|-----------|------|-------|
| `priceIcon` | outline | Price/currency display |
| `accommodationTypeIcon` | solid | Accommodation type |
| `roomBasisIcon` | solid | Room/unit count |
| `durationIcon` | outline | Tour duration |
| `groupSizeIcon` | outline | Group size |
| `calendarIcon` | outline | Dates/booking |

### Pattern Usage

```html
<!-- Outline icon (default type) -->
<!-- wp:lsx-tour-operator/icons {"iconName":"priceIcon"} /-->

<!-- Solid icon -->
<!-- wp:lsx-tour-operator/icons {"iconType":"solid","iconName":"accommodationTypeIcon"} /-->
```

---

## 17. Quick Reference: Common Preset Values

### Spacing Presets (use in JSON attributes)

| Value | JSON Format | CSS Variable |
|-------|-------------|--------------|
| 8px / 0.5rem | `"var:preset\|spacing\|20"` | `var(--wp--preset--spacing--20)` |
| 10px / 0.625rem | `"var:preset\|spacing\|tiny"` | `var(--wp--preset--spacing--20)` |
| 16px / 1rem | `"var:preset\|spacing\|small"` | `var(--wp--preset--spacing--small)` |
| 24px / 1.5rem | `"var:preset\|spacing\|x-small"` | `var(--wp--preset--spacing--x-small)` |
| 32px / 2rem | `"var:preset\|spacing\|medium"` | `var(--wp--preset--spacing--medium)` |

### Color Presets

| Color | JSON Format | Usage |
|-------|-------------|-------|
| Primary | `"var:preset\|color\|primary"` | Borders, buttons, accents |
| Contrast | `"var:preset\|color\|contrast"` | Text, links |
| Base | `"var:preset\|color\|base"` | Backgrounds (white) |
| Primary-700 | `"var:preset\|color\|primary-700"` | Hover states |

### Hardcoded Values (when presets don't exist)

For small values without presets, use rem directly:
- `2px` → `0.125rem`
- `5px` → `0.3125rem`
- `100px` → `6.25rem` (flex column width)
- `120px` → `7.5rem` (flex column width)

---

## 18. Pattern File Quick Template

Use this template for fast pattern creation:

```php
<?php
/**
 * [Pattern Name]
 *
 * [Brief description]
 *
 * @package    Tour_Operator
 * @subpackage Patterns
 * @since      1.0.0
 * @version    2.1.0
 */

// phpcs:ignoreFile PluginCheck.CodeAnalysis.ImageFunctions.NonEnqueuedImage

return array(
	'title'         => __( '[Pattern Name]', 'tour-operator' ),
	'description'   => __( '[Description]', 'tour-operator' ),
	'categories'    => array( 'lsx-tour-operator', 'lsx-to-[category]', 'lsx-to-cards' ),
	'keywords'      => array(
		__( 'keyword1', 'tour-operator' ),
		__( 'keyword2', 'tour-operator' ),
	),
	'postTypes'     => array( '[post-type]' ),
	'blockTypes'    => array( 'core/query' ),
	'templateTypes' => array( 'archive', 'single' ),
	'content'       => '[BLOCK_MARKUP_HERE]',
);
```

---

## 19. Workflow: Fast Pattern Creation

### Step 1: Get Working Markup from Editor

1. Build the pattern visually in WordPress editor
2. Style it using the editor controls
3. Switch to "Code editor" view
4. Copy the entire block markup

### Step 2: Create Pattern File

1. Create new file in `/patterns/[name].php`
2. Use the quick template above
3. Paste the block markup into `'content'`
4. Add escaping for translatable strings:
   - Replace `>Text<` with `>' . esc_html__( 'Text', 'tour-operator' ) . '<`
   - Replace `"name":"Text"` with `"name":"' . esc_attr__( 'Text', 'tour-operator' ) . '"`

### Step 3: Validate

1. Clear any caches
2. Insert pattern from inserter
3. Verify no block validation errors
4. Check responsive behavior

### Common Fixes for Validation Errors

| Error | Cause | Fix |
|-------|-------|-----|
| "Unexpected content" | Inline SVG in icon block | Use self-closing icon block syntax |
| "Invalid content" | CSS fallback in style | Remove fallback, use plain variable |
| Block shows "Fix" button | Attribute mismatch | Copy markup from editor code view |

---

## Priority Rules

1. **Figma Tokens First** - Always fetch tokens before building patterns
2. **Fallbacks Required** - Every CSS variable must have an absolute fallback
3. **Plugin Paths** - Use `LSX_TO_URL`, never theme functions
4. **Rem over Pixels** - Convert all pixel values to rem
5. **Exact Design Match** - Screenshot must match final pattern

---

**This file ensures accurate, theme-independent WordPress patterns from Figma designs for the Tour Operator plugin.**

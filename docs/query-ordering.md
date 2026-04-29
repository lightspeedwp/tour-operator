# Query Block Ordering by Custom Fields

## Overview

Tours and accommodations displayed on destination pages can now be ordered by the sequence set in the backend multiselect fields (`tour_to_destination` and `accommodation_to_destination`).

You can enable custom ordering in two ways:
1. **Checkbox Control** - Enable "Custom Order" checkbox in any Query block settings panel
2. **Automatic Variations** - Specific query variations automatically preserve order

## Method 1: Custom Order Checkbox (Recommended)

### How to Use

1. Add a Query Loop block to your page/template
2. In the block sidebar settings, find the **Tour Operator** panel
3. Enable the **"Custom Order"** checkbox
4. The query will now preserve the order from connected posts

This works for **any query variation** - tours, destinations, accommodations, or reviews.

### What It Does

When enabled, the Custom Order checkbox:
- Adds a `custom-order` CSS class to the block
- Forces the query to use `orderby=post__in` 
- Preserves the exact order from multiselect fields or `post__in` arrays

**Example Use Case:**  
On a destination page showing related tours, the tours will display in the exact order you arrange them in the "Related Tours" multiselect field in the destination editor.

## Method 2: Automatic Query Variations

### Backend Configuration

1. Edit a destination in the WordPress admin
2. Find the "Related Tours" multiselect field
3. Select tours in the order you want them to appear
4. The order you arrange them in the multiselect box will be preserved on the front-end

### Query Block Setup

Use a Query Loop block with the appropriate variation class name:

- For tours on destination pages: `lsx-tour-related-destination-query`
- For accommodations on destination pages: `lsx-accommodation-related-destination-query`

Example:
```html
<!-- wp:query {"className":"lsx-tour-related-destination-query"} -->
```

These variations automatically enable custom ordering without needing the checkbox.

## Technical Details

The ordering system works through these components:

1. **Custom Field Storage**: The `tour_to_destination` field stores post IDs in the selected order
2. **Query Filter**: The `related_connection_query()` method retrieves these IDs in order
3. **Orderby Filter**: The `enable_post_in_ordering()` method enables `orderby=post__in` for:
   - Blocks with the `custom-order` class
   - Specific query variations
4. **Result**: WordPress queries return posts in the exact order from the custom field

### Adding Custom Variations

To enable automatic ordering for additional query variations, modify the `$ordered_variations` array in the `enable_post_in_ordering()` method:

```php
$ordered_variations = array(
	'tour-related-destination',
	'accommodation-related-destination',
	'your-custom-variation', // Add your variation here
);
```

## Filter Hooks

### `lsx_to_query_orderby_post__in`

Controls which query variations use `post__in` ordering.

**Parameters:**
- `$enable` (bool): Whether to enable post__in ordering (default: false)
- `$query` (array): The query arguments
- `$block` (array): The block data

**Example:**
```php
add_filter( 'lsx_to_query_orderby_post__in', function( $enable, $query, $block ) {
	// Custom logic to enable/disable ordering
	return $enable;
}, 10, 3 );
```

## Related Files

- `/includes/classes/blocks/class-query-loop.php` - Main query customization logic
- `/src/js/blocks/slider-query.js` - Block editor controls (Custom Order checkbox)
- `/includes/metaboxes/config-destination.php` - Destination custom fields configuration
- `/includes/metaboxes/config-tour.php` - Tour custom fields configuration

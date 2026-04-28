# Query Block Ordering by Custom Fields

## Overview

Tours and accommodations displayed on destination pages can now be ordered by the sequence set in the backend multiselect fields (`tour_to_destination` and `accommodation_to_destination`).

## How It Works

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

### Technical Details

The ordering system works through these components:

1. **Custom Field Storage**: The `tour_to_destination` field stores post IDs in the selected order
2. **Query Filter**: The `related_connection_query()` method retrieves these IDs in order
3. **Orderby Filter**: The `enable_post_in_ordering()` method enables `orderby=post__in` for specific variations
4. **Result**: WordPress queries return posts in the exact order from the custom field

### Adding Custom Variations

To enable ordering for additional query variations, modify the `$ordered_variations` array in the `enable_post_in_ordering()` method:

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
- `/includes/metaboxes/config-destination.php` - Destination custom fields configuration
- `/includes/metaboxes/config-tour.php` - Tour custom fields configuration

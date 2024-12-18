<?php
/**
 * LSX_Search_FacetWP_Hierarchy Frontend Main Class
 */

namespace lsx\integrations\facetwp;

class Post_Connections {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx\integrations\facetwp\Post_Connections()
	 */
	protected static $instance = null;

	/**
	 * Holds the plugin options.
	 *
	 * @var array
	 */
	public $options = array();

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->get_cmb2_options();
		add_filter( 'facetwp_indexer_row_data', array( $this, 'facetwp_index_row_data' ), 10, 2 );
		add_filter( 'facetwp_index_row', array( $this, 'facetwp_index_row' ), 10, 2 );
		add_filter( 'facetwp_facet_html', array( $this, 'destination_facet_html' ), 10, 2 );
	}

	/**
	 * Gets the cmb2 options.
	 *
	 * @return void
	 */
	private function get_cmb2_options() {
		$cmb2_options = get_option( 'lsx-search-settings' );
		if ( false !== $cmb2_options && ! empty( $cmb2_options ) ) {
			$this->options['display'] = $cmb2_options;
			foreach ( $this->options['display'] as $option_key => $option_value ) {
				if ( is_array( $option_value ) && ! empty( $option_value ) ) {
					$new_values = array();
					foreach ( $option_value as $empty_key => $key_value ) {
						$new_values[ $key_value ] = 'on';
					}
					$this->options['display'][ $option_key ] = $new_values;
				}
			}
		}
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx\search\classes\facetwp\Post_Connections()    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 *	Alter the rows and include extra facets rows for the continents
	 */
	public function facetwp_index_row_data( $rows, $params ) {
		switch ( $params['facet']['source'] ) {
			case 'cf/destination_to_tour':
			case 'cf/destination_to_accommodation':
				$countries = array();

				$new_rows     = [];
				// First lets process our new rows, depending of if its a serialized array or not.
				foreach ( $rows as $r_index => $row ) {

					// first lets check if we have an array as the values.
					if ( is_array( $row['facet_value'] ) ) {
						foreach ( $row['facet_value'] as $r_index => $pid ) {

							$title = get_the_title( $pid );
							if ( '' === $title ) {
								continue;
							}

							$template_row                        = $row;
							$template_row['facet_value']         = $pid;
							$template_row['facet_display_value'] = $title;
							$parent                              = wp_get_post_parent_id( $template_row['facet_value'] );
							$template_row['parent_id']           = $parent;


							if ( 0 === $parent || '0' === $parent ) {
								if ( ! isset( $countries[ $r_index ] ) ) {
									$countries[ $r_index ] = $row['facet_value'];
								}

								if ( ! empty( $this->options['display']['engine_search_continent_filter'] ) ) {
									$template_row['depth'] = 1;
								} else {
									$template_row['depth'] = 0;
								}
							} else {
								if ( ! empty( $this->options['display']['engine_search_continent_filter'] ) ) {
									$template_row['depth'] = 2;
								} else {
									$template_row['depth'] = 1;
								}
							}

							$new_rows[ $r_index ] = $template_row;
						}

					} else {
						$parent                        = wp_get_post_parent_id(  );
						$rows[ $r_index ]['parent_id'] = $parent;
	
						if ( 0 === $parent || '0' === $parent ) {
							if ( ! isset( $countries[ $r_index ] ) ) {
								$countries[ $r_index ] = $row['facet_value'];
							}
	
							if ( ! empty( $this->options['display']['engine_search_continent_filter'] ) ) {
								$rows[ $r_index ]['depth'] = 1;
							} else {
								$rows[ $r_index ]['depth'] = 0;
							}
						} else {
							if ( ! empty( $this->options['display']['engine_search_continent_filter'] ) ) {
								$rows[ $r_index ]['depth'] = 2;
							} else {
								$rows[ $r_index ]['depth'] = 1;
							}
						}
					}
				}

				// Replace the old rows with the new once used.
				if ( ! empty( $new_rows ) ) {
					$rows = $new_rows;
				}

				if ( ! empty( $this->options['display']['enable_search_continent_filter'] ) ) {
					if ( ! empty( $countries ) ) {
						foreach ( $countries as $row_index => $country ) {
							$continents   = wp_get_object_terms( $country, 'continent' );
							$continent_id = 0;

							if ( ! is_wp_error( $continents ) ) {
								$new_row = $params['defaults'];
								if ( ! is_array( $continents ) ) {
									$continents = array( $continents );
								}

								foreach ( $continents as $continent ) {
									$new_row['facet_value'] = $continent->slug;
									$new_row['facet_display_value'] = $continent->name;
									$continent_id = $continent->term_id;
									$new_row['depth'] = 0;
								}
								$rows[] = $new_row;
								$rows[ $row_index ]['parent_id'] = $continent_id;
							}
						}
					}
				}

				break;

			default:
				break;
		}

		return $rows;
	}

	/**
	 * Displays the destination specific settings
	 */
	public function facetwp_index_row( $params, $class ) {
		$custom_field = false;
		$meta_key = false;

		preg_match( '/cf\//', $class->facet['source'], $custom_field );
		preg_match( '/_to_/', $class->facet['source'], $meta_key );

		if ( ! empty( $custom_field ) && ! empty( $meta_key ) ) {

			$values = (array) $params['facet_value'];
			foreach ( $values as $val ) {
				$params['facet_value'] = $val;
				$params['facet_display_value'] = $val;
				
				$title = get_the_title( $params['facet_value'] );
				if ( '' !== $title ) {
					$params['facet_display_value'] = $title;
				}
				if ( '' === $title && ! empty( $meta_key ) ) {
					$params['facet_value'] = '';
				}
				// Insert into the DB
				$class->insert( $params );
			}

			return false; // skip default indexing
		}

		// If its a price, save the value as a standard number.
		if ( 'cf/price' === $class->facet['source'] ) {
			$params['facet_value'] = preg_replace( '/[^0-9.]/', '', $params['facet_value'] );
			$params['facet_value'] = ltrim( $params['facet_value'], '.' );
			#$params['facet_value'] = number_format( (int) $params['facet_value'], 2 );
			$params['facet_display_value'] = $params['facet_value'];
		}

		// If its a duration, save the value as a standard number.
		if ( 'cf/duration' === $class->facet['source'] ) {
			$params['facet_value'] = preg_replace( '/[^0-9 ]/', '', $params['facet_value'] );
			$params['facet_value'] = trim( $params['facet_value'] );
			$params['facet_value'] = explode( ' ', $params['facet_value'] );
			$params['facet_value'] = $params['facet_value'][0];
			#$params['facet_value'] = (int) $params['facet_value'];
			$params['facet_display_value'] = $params['facet_value'];
		}

		return $params;
	}

	/**
	 * Checks the facet source value and outputs the destination facet HTML if needed.
	 *
	 * @param  string  $output
	 * @param  array   $params
	 * @return string
	 */
	public function destination_facet_html( $output, $params ) {
		$possible_keys = array(
			'cf/destination_to_accommodation',
			'cf/destination_to_tour',
			'cf/destination_to_special',
			'cf/destination_to_activity',
			'cf/destination_to_review',
			'cf/destination_to_vehicle',
		);
		if ( in_array( $params['facet']['source'], $possible_keys ) && 'checkboxes' === $params['facet']['type'] ) {
			$output = $this->destination_facet_render( $params );
		}
		return $output;
	}

	/**
	 * Generate the facet HTML
	 */
	public function destination_facet_render( $params ) {
		$facet = $params['facet'];

		if ( 'checkboxes' !== $params['facet']['type'] ) {
			return;
		}

		$output = '';
		$values = (array) $params['values'];
		$selected_values = (array) $params['selected_values'];
		$soft_limit = empty( $facet['soft_limit'] ) ? 0 : (int) $facet['soft_limit'];
		$countries = array();
		$continents = array();

		$continent_terms = get_terms(
			array(
				'taxonomy' => 'continent',
			)
		);

		if ( ! is_wp_error( $continent_terms ) ) {
			foreach ( $continent_terms as $continent ) {
				$continents[ $continent->term_id ] = $continent->slug;
			}
		}

		//Create a relationship of the facet value and the their depths
		$depths = array();
		$parents = array();
		foreach ( $values as $value ) {
			$depths[ $value['facet_value'] ]  = (int) $value['depth'];
			$parents[ $value['facet_value'] ] = (int) $value['parent_id'];
		}

		//Determine the current depth and check if the selected values parents are in the selected array.
		$current_depth = 0;
		$additional_values = array();
		if ( ! empty( $selected_values ) ) {
			foreach ( $selected_values as $selected ) {
				if ( $depths[ $selected ] > $current_depth ) {
					$current_depth = $depths[ $selected ];
				}
			}
			$current_depth++;
		}

		if ( ! empty( $additional_values ) ) {
			$selected_values = array_merge( $selected_values, $additional_values );
		}

		// This is where the items are sorted by their depth
		$sorted_values = array();
		$stored = $values;

		//sort the options so
		foreach ( $values as $key => $result ) {
			if ( ! empty( $this->options['display']['engine_search_continent_filter'] ) ) {
				if ( in_array( $result['facet_value'], $continents ) ) {
					$sorted_values[] = $result;
					$destinations    = $this->get_countries( $stored, $result['facet_value'], $continents, '1' );

					if ( ! empty( $destinations ) ) {
						foreach ( $destinations as $destination ) {
							$sorted_values[] = $destination;
						}
					}
				}
			} else {
				if ( '0' === $result['depth'] || 0 === $result['depth'] ) {
					$sorted_values[] = $result;
					$destinations    = $this->get_regions( $stored, $result['facet_value'], '1' );

					if ( ! empty( $destinations ) ) {
						foreach ( $destinations as $destination ) {
							$sorted_values[] = $destination;
						}
					}
				}
			}
		}
		$values = $sorted_values;

		$continent_class = '';
		$country_class = '';

		// Run through each value and output the values.
		foreach ( $values as $key => $facet ) {
			$depth_type = '';

			if ( ! empty( $this->options['display']['engine_search_continent_filter'] ) ) {
				switch ( $facet['depth'] ) {
					case '0':
						$depth_type = '';
						$continent_class = in_array( $facet['facet_value'], $selected_values ) ? $depth_type .= ' continent-checked' : '';
						break;

					case '1':
						$depth_type = 'country' . $continent_class;
						$country_class = in_array( $facet['facet_value'], $selected_values ) ? $depth_type .= ' country-checked' : '';
						break;

					case '2':
						$depth_type = 'region' . $continent_class . $country_class;
						break;
				}
			} else {
				switch ( $facet['depth'] ) {
					case '0':
						$depth_type = 'country continent-checked';
						$country_class = in_array( $facet['facet_value'], $selected_values ) ? $depth_type .= ' country-checked' : '';
						break;

					case '1':
						$depth_type = 'region continent-checked' . $country_class;
						break;
				}
			}

			if ( $facet['depth'] <= $current_depth ) {
				if ( 'checkboxes' === $params['facet']['type'] ) {
					$options[] = $this->format_checkbox_facet( $key, $facet, $selected_values, $depth_type );
				} else if ( 'fselect' === $params['facet']['type'] ) {
					$options[] = $this->format_fselect_facet( $key, $facet, $selected_values, $depth_type );
				}
				
			}
		}

		if ( ! empty( $options ) ) {
			$output = implode( '', $options );
		}

		$output = '' . $output . '';

		return $output;
	}

	/**
	 * Gets the direct countries from the array.
	 */
	public function get_countries( $values, $parent, $continents, $depth ) {
		$children = array();
		$stored = $values;

		foreach ( $values as $value ) {
			if ( isset( $continents[ $value['parent_id'] ] ) && $continents[ $value['parent_id'] ] === $parent && $value['depth'] === $depth ) {
				$children[] = $value;

				$destinations = $this->get_regions( $stored, $value['facet_value'], '2' );
				if ( ! empty( $destinations ) ) {
					foreach ( $destinations as $destination ) {
						$children[] = $destination;
					}
				}
			}
		}
		return $children;
	}

	/**
	 * Gets the direct regions from the array.
	 */
	public function get_regions( $values, $parent, $depth ) {
		$children = array();
		foreach ( $values as $value ) {
			if ( $value['parent_id'] === $parent && $value['depth'] === $depth ) {
				$children[] = $value;
			}
		}
		return $children;
	}

	public function format_checkbox_facet( $key, $result, $selected_values, $region = '' ) {
		$temp_html = '';

		$selected = in_array( $result['facet_value'], $selected_values ) ? ' checked' : '';
		$selected .= ( 0 == $result['counter'] && '' == $selected ) ? ' disabled' : '';
		$selected .= ' ' . $region;

		$temp_html .= '<div class="facetwp-checkbox' . $selected . '" data-value="' . $result['facet_value'] . '">';
		$temp_html .= $result['facet_display_value'] . ' <span class="facetwp-counter">(' . $result['counter'] . ')</span>';
		$temp_html .= '</div>';

		return $temp_html;
	}

	public function format_fselect_facet( $key, $result, $selected_values, $region = '' ) {
		$temp_html = '';

		$selected = in_array( $result['facet_value'], $selected_values ) ? ' checked' : '';
		$selected .= ( 0 == $result['counter'] && '' == $selected ) ? ' disabled' : '';
		$selected .= ' ' . $region;

		$temp_html .= '<div class="fs-option g0 d0" data-value="' . $result['facet_value'] . '" data-idx="' . $key . '" tabindex="-1">
							<span class="fs-checkbox' . $selected . '"><i></i></span>
							<div class="fs-option-label">' . $result['facet_display_value'] . ' (' . $result['counter'] . ')</div>
						</div>';

		return $temp_html;
	}
}

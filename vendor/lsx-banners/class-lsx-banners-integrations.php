<?php
/**
 * LSX Banners Plugin Integrations
 *
 * @package   LSX Banners
 * @author    LightSpeed
 * @license   GPL3
 * @link
 * @copyright 2016 LightSpeed
 */
class LSX_Banners_Integrations {

	/**
	 * Hold the current plugin options
	 *
	 * @var array
	 */
	public $options = array();

	/**
	 * Holds the plugins integration post types
	 *
	 * @var      array|Lsx_Banners
	 */
	public $post_types = array( 'tribe_events' );

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	public function __construct() {
		add_filter( 'lsx_banner_allowed_post_types', array( $this, 'lsx_banner_allowed_post_types' ), 10, 1 );
		add_filter( 'lsx_banner_title', array( $this, 'banner_title' ), 30, 1 );
		add_filter( 'lsx_banner_tagline', array( $this, 'banner_tagline' ), 30, 1 );

		if ( false !== $this->post_types ) {
			foreach ( $this->post_types as $post_type ) {
				if ( function_exists( 'tour_operator' ) ) {
					add_action( 'lsx_to_framework_' . $post_type . '_tab_archive_settings_top', array( $this, 'enable_banners_setting' ), 20 );
				} else {
					add_action( 'lsx_framework_' . $post_type . '_tab_content_top', array( $this, 'enable_banners_setting' ), 20 );
				}
			}
		}

		$this->set_options();
	}

	public function set_options() {
		$this->options = get_option( '_lsx_settings', false );

		if ( false === $this->options ) {
			$this->options = get_option( '_lsx_lsx-settings', false );
		}

		$lsx_to_options = get_option( '_lsx-to_settings', false );

		if ( ! empty( $lsx_to_options ) ) {
			$this->options = $lsx_to_options;
		}
	}

	/**
	 * Enable project custom post type on LSX Banners.
	 */
	public function lsx_banner_allowed_post_types( $post_types ) {
		if ( class_exists( 'Tribe__Events__Main' ) ) {
			$post_types[] = 'tribe_events';
		}
		return $post_types;
	}

	public function enable_banners_setting( $tab = 'general' ) {
		if ( in_array( $tab, $this->post_types ) ) {
			?>
			<tr class="form-field">
				<th scope="row">
					<label for="banners_plugin_title"><?php esc_html_e( 'Dynamic Title', 'lsx-banners' ); ?></label>
				</th>
				<td>
					<input type="checkbox" {{#if banners_plugin_title}} checked="checked" {{/if}} name="banners_plugin_title" />
					<small><?php esc_html_e( 'Check this option to use the dynamic title generate by the plugin.', 'lsx-banners' ); ?></small>
				</td>
			</tr>
			<?php
		}
	}

	public function banner_title( $title ) {

		if ( is_post_type_archive( $this->post_types ) || is_singular( $this->post_types ) ) {
			$current_post_type = get_post_type();

			if ( class_exists( 'Tribe__Events__Main' )
				 && ( tribe_is_day() || tribe_is_list_view() || tribe_is_month() ) ) {
					$current_post_type = 'tribe_events';
			}

			switch ( $current_post_type ) {
				case 'tribe_events':
					$title = $this->get_tribe_events_title();
					break;

				default;
			}
		}

		return $title;
	}

	/**
	 * Returns the Tribe events meta as the tagline.
	 *
	 * @return string
	 */
	public function get_tribe_events_title() {
		$title = '';
		if ( isset( $this->options['tribe_events'] ) ) {
			// Check if we should use the dynamic title or if the title is set use it.
			if ( isset( $this->options['tribe_events']['banners_plugin_title'] ) && 'on' === $this->options['tribe_events']['banners_plugin_title'] ) {
				$title = tribe_get_events_title();
			} elseif ( ( isset( $this->options['tribe_events']['banners_plugin_title'] ) ) && ( '' !== $this->options['tribe_events']['banners_plugin_title'] ) ) {
				$title = $this->options['tribe_events']['banners_plugin_title'];
			}

			if ( '' !== $title ) {
				$title = '<h1 class="page-title">' . $title . '</h1>';
			}
		}
		return $title;
	}

	/**
	 * Disable the events title for the post archive if the dynamic setting is active.
	 *
	 * @param $title
	 *
	 * @return string
	 */
	public function disable_post_meta( $title ) {
		return '';
	}

	/**
	 * Adds the Tribe events meta to the banner tagline
	 *
	 * @param $tagline
	 *
	 * @return string
	 */
	public function banner_tagline( $tagline ) {

		if ( is_singular( $this->post_types ) ) {
			$current_post_type = get_post_type();

			if ( class_exists( 'Tribe__Events__Main' )
			&& ( tribe_is_event() ) ) {
				$current_post_type = 'tribe_events';
			}

			switch ( $current_post_type ) {
				case 'tribe_events':
					$tagline = tribe_events_event_schedule_details( get_the_ID(), '<p class="tagline" >', '</p>' );
					break;

				default;
			}
		}

		return $tagline;
	}

	// apply_filters( 'tribe_events_event_schedule_details', $schedule, $event->ID, $before, $after )
}

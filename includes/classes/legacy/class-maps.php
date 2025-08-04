<?php
/**
 * Maps Class
 *
 * @package   Destination
 * @author    LightSpeed
 * @license   GPL3
 * @link
 * @copyright 2019 LightSpeedDevelopment
 */

namespace lsx\legacy;

/**
 * Main plugin class.
 *
 * @package Destination
 * @author  LightSpeed
 */
class Maps
{

    /**
     * If the maps are enabled.
     *
     * @var bool
     */
    public $maps_enabled = false;

    /**
     * Holds the value of the current marker
     *
     * @var bool
     */
    public $current_marker = false;

    /**
     * If the map placeholder is enabled.
     *
     * @var bool
     */
    public $placeholder_enabled = false;

    /**
     * If the map should display in the destinations banner.
     *
     * @var bool
     */
    public $enable_banner_map = false;

    /**
     * The post types this post should work with
     *
     * @var array
     */
    public $post_types = array();

    /**
     * Constructor
     */
    public function __construct() {
        $this->post_types = array(
			'destination',
			'accommodation',
			'tour',
        );
		add_filter( 'lsx_to_maps_tour_connections', [ $this, 'map_start_end_points' ], 40, 1 );
    }

    /**
     * Enques the assets
     */
    public function assets()
    {
        if ($this->is_a_bot() || ! lsx_to_has_map() || true === apply_filters('lsx_to_disable_map_js', false) ) {
            return;
        }
        $settings    = tour_operator()->options;
        $api_key     = '';

        if (isset($settings['googlemaps_key']) ) {
            $api_key = $settings['googlemaps_key'];
        }

		if ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) {
			$prefix = 'src/js/';
			$suffix = '';
		} else {
			$prefix = 'build/';
			$suffix = '';
			//$suffix = '.min'; 
		}

        $dependacies = array( 'jquery' );
        $google_url  = 'https://maps.googleapis.com/maps/api/js?key=' . $api_key . '&libraries=places';
        $google_marker_cluster = LSX_TO_URL . 'assets/js/vendor/google-markerCluster.js';

        wp_enqueue_script(
            'lsx_to_maps',
            LSX_TO_URL . $prefix . 'maps' . $suffix . '.js',
            $dependacies,
            LSX_TO_VER,
            true
        );
        wp_localize_script(
            'lsx_to_maps',
            'lsx_to_maps_params',
            array(
            'apiKey'              => $api_key,
            'start_marker'        => tour_operator()->markers->start,
            'end_marker'          => tour_operator()->markers->end,
            'placeholder_enabled' => true,
            'enable_banner_map'   => false,
            'google_url'          => $google_url,
            'google_cluster_url'  => $google_marker_cluster,
            )
        );
    }

    /**
     * Output the Map
     *
     * @since 1.0.0
     *
     * @return null
     */
    public function map_output( $post_id = false, $args = array() )
    {
        $defaults = array(
        'latitude' => '-33.914482',
        'longitude' => '18.3758789',
        'zoom' => 14,
        'width' => '100%',
        'height' => '400px',
        'type' => 'single',
        'search' => '',
        'connections' => false,
        'link' => true,
        'selector' => '.lsx-map-preview',
        'icon' => false,
        'content' => 'address',
        'kml' => false,
        'cluster_small'     => tour_operator()->markers->cluster_small,
        'cluster_medium'    => tour_operator()->markers->cluster_medium,
        'cluster_large'     => tour_operator()->markers->cluster_large,
        'fusion_tables' => false,
        'fusion_tables_colour_border' => '#000000',
        'fusion_tables_width_border' => '2',
        'fusion_tables_colour_background' => '#000000',
        'disable_cluster_js' => false,
        'disable_auto_zoom' => false,
        'classes' => array(),
        );

        $args        = wp_parse_args($args, $defaults);
        $map_classes = array_merge([ 'lsx-map' ], $args['classes']);

        if (true === $args['disable_auto_zoom'] ) {
            $map_classes[] = 'disable-auto-zoom';
        }
        if (true === $this->placeholder_enabled ) {
            $map_classes[] = 'map-has-placeholder';
        }

        $thumbnail = '';
        if (false === $args['icon'] ) {
            $icon = $this->set_icon($post_id);
        }

        if (( '-33.914482' !== $args['latitude'] && '18.3758789' !== $args['longitude'] ) || false !== $args['search'] || 'cluster' === $args['type'] || 'route' === $args['type'] ) {
            $map = '<div class="' . implode(' ', $map_classes) . '" data-zoom="' . $args['zoom'] . '" data-icon="' . $icon . '" data-type="' . $args['type'] . '" data-class="' . $args['selector'] . '" data-fusion-tables-colour-border="' . $args['fusion_tables_colour_border'] . '" data-fusion-tables-width-border="' . $args['fusion_tables_width_border'] . '" data-fusion-tables-colour-background="' . $args['fusion_tables_colour_background'] . '"';

            if ('route' === $args['type'] && false !== $args['kml'] ) {
                $map .= ' data-kml="' . $args['kml'] . '"';
            }

            $map .= ' data-lat="' . $args['latitude'] . '" data-long="' . $args['longitude'] . '"';

            if (false === $args['disable_cluster_js'] ) {
                $map .= ' data-cluster-small="' . $args['cluster_small'] . '" data-cluster-medium="' . $args['cluster_medium'] . '" data-cluster-large="' . $args['cluster_large'] . '"';
            }

            $map .= '>';

            $map .= '<div class="lsx-map-markers" style="display:none;">';

            if ('single' === $args['type'] ) {
                $thumbnail = get_the_post_thumbnail_url($post_id, array( 100, 100 ));
                $tooltip   = $args['search'];

                if ('excerpt' === $args['content'] ) {
                    $tooltip = wp_strip_all_tags(get_the_excerpt($post_id));
                }

                $icon = $this->set_icon($post_id);

                $map .= '<div class="map-data" data-icon="' . $icon . '" data-id="' . $post_id . '" data-long="' . $args['longitude'] . '" data-lat="' . $args['latitude'] . '" data-thumbnail="' . $thumbnail . '" data-link="' . get_permalink($post_id) . '" data-title="' . get_the_title($post_id) . '" data-fusion-tables="' . ( true === $args['fusion_tables'] ? '1' : '0' ) . '">
							<p style="line-height: 20px;">' . $tooltip . '</p>
						</div>';
            } elseif (( 'cluster' === $args['type'] || 'route' === $args['type'] ) && false !== $args['connections'] ) {
                if (! is_array($args['connections']) ) {
                    $args['connections'] = array( $args['connections'] );
                }

                foreach ( $args['connections'] as $connection ) {
                    $location = get_post_meta($connection, 'location', true);

                    if (false !== $location && '' !== $location && is_array($location) ) {
                        $thumbnail = '';

                        if ('' !== $location['longitude'] && '' !== $location['latitude'] ) {
                               $thumbnail = get_the_post_thumbnail_url($connection, array( 100, 100 ));

                               $this->current_marker = $connection;

                               $tooltip = $location['address'];

                            if ('excerpt' === $args['content'] ) {
                                $tooltip = wp_strip_all_tags(get_the_excerpt($connection));
                            }

                            $icon = $this->set_icon($connection);

                            $map .= '<div class="map-data" data-icon="' . $icon . '" data-id="' . $connection . '" data-long="' . $location['longitude'] . '" data-lat="' . $location['latitude'] . '" data-link="' . get_permalink($connection) . '" data-thumbnail="' . $thumbnail . '" data-title="' . get_the_title($connection) . '" data-fusion-tables="' . ( true === $args['fusion_tables'] ? '1' : '0' ) . '">';

                            global $post;
                            $post = get_post($connection);
                            setup_postdata($post);

                            ob_start();
                            $this->map_marker_html($connection);
                            wp_reset_postdata();
                            $tooltip = ob_get_clean();

                            $map .= $tooltip;
                            $map .= '</div>';
                        }
                    }
                }
            }

            $map .= '</div>';
            $map .= '</div>';

            $this->assets();

            return $map;
        }
    }

    /**
     * Returns the map marker.
     *
     * @param  boolean $post_id
     * @return mixed
     */
    public function set_icon( $post_id = false ) {
        $icon = tour_operator()->markers->default_marker;
        if (false !== $post_id ) {
            $connection_type = get_post_type($post_id);
            $to_post_types = array_keys(lsx_to_get_post_types());
            if ( in_array( $connection_type, $to_post_types ) && isset( tour_operator()->markers->post_types[ $connection_type ] ) ) {
                $icon = tour_operator()->markers->post_types[ $connection_type ];
            } else {
                $icon = apply_filters('lsx_to_default_map_marker', tour_operator()->markers->default_marker);
            }
        }
        return $icon;
    }

    /**
     * Checking for bots on the maps.
     *
     * @package ctt-lsx-child
     */
    public function is_a_bot() {
        $is_bot = false;
        $user_agents = array(
        'Googlebot',
        'Googlebot-Mobile',
        'Googlebot-Image',
        'Googlebot-News',
        'Googlebot-Video',
        'AdsBot-Google',
        'AdsBot-Google-Mobile-Apps',
        'Feedfetcher-Google',
        'Mediapartners-Google',
        'APIs-Google',
        'GTmetrix',
        'Baiduspider',
        'ia_archiver',
        'R6_FeedFetcher',
        'NetcraftSurveyAgent',
        'Sogou web spider',
        'bingbot',
        'BingPreview',
        'slurp',
        'Yahoo! Slurp',
        'Ask Jeeves/Teoma',
        'facebookexternalhit',
        'PrintfulBot',
        'msnbot',
        'Twitterbot',
        'UnwindFetchor',
        'urlresolver',
        'Butterfly',
        'TweetmemeBot',
        'PaperLiBot',
        'MJ12bot',
        'AhrefsBot',
        'Exabot',
        'Ezooms',
        'YandexBot',
        'SearchmetricsBot',
        'picsearch',
        'TweetedTimes Bot',
        'QuerySeekerSpider',
        'ShowyouBot',
        'woriobot',
        'merlinkbot',
        'BazQuxBot',
        'Kraken',
        'SISTRIX Crawler',
        'R6_CommentReader',
        'magpie-crawler',
        'GrapeshotCrawler',
        'PercolateCrawler',
        'MaxPointCrawler',
        'R6_FeedFetcher',
        'NetSeer crawler',
        'grokkit-crawler',
        'SMXCrawler',
        'PulseCrawler',
        'Y!J-BRW',
        '80legs.com/webcrawler',
        'Mediapartners-Google',
        'Spinn3r',
        'InAGist',
        'Python-urllib',
        'NING',
        'TencentTraveler',
        'Feedfetcher-Google',
        'mon.itor.us',
        'spbot',
        'Feedly',
        'bitlybot',
        'ADmantX Platform',
        'Niki-Bot',
        'Pinterest',
        'python-requests',
        'DotBot',
        'HTTP_Request2',
        'linkdexbot',
        'A6-Indexer',
        'Baiduspider',
        'TwitterFeed',
        'Microsoft Office',
        'Pingdom',
        'BTWebClient',
        'KatBot',
        'SiteCheck',
        'proximic',
        'Sleuth',
        'Abonti',
        '(BOT for JCE)',
        'Baidu',
        'Tiny Tiny RSS',
        'newsblur',
        'updown_tester',
        'linkdex',
        'baidu',
        'searchmetrics',
        'genieo',
        'majestic12',
        'spinn3r',
        'profound',
        'domainappender',
        'VegeBot',
        'terrykyleseoagency.com',
        'CommonCrawler Node',
        'AdlesseBot',
        'metauri.com',
        'libwww-perl',
        'rogerbot-crawler',
        'MegaIndex.ru',
        'ltx71',
        'Qwantify',
        'Traackr.com',
        'Re-Animator Bot',
        'Pcore-HTTP',
        'BoardReader',
        'omgili',
        'okhttp',
        'CCBot',
        'Java/1.8',
        'semrush.com',
        'feedbot',
        'CommonCrawler',
        'AdlesseBot',
        'MetaURI',
        'ibwww-perl',
        'rogerbot',
        'MegaIndex',
        'BLEXBot',
        'FlipboardProxy',
        'techinfo@ubermetrics-technologies.com',
        'trendictionbot',
        'Mediatoolkitbot',
        'trendiction',
        'ubermetrics',
        'ScooperBot',
        'TrendsmapResolver',
        'Nuzzel',
        'Go-http-client',
        'Applebot',
        'LivelapBot',
        'GroupHigh',
        'SemrushBot',
        'ltx71',
        'commoncrawl',
        'istellabot',
        'DomainCrawler',
        'cs.daum.net',
        'StormCrawler',
        'GarlikCrawler',
        'The Knowledge AI',
        'getstream.io/winds',
        'YisouSpider',
        'archive.org_bot',
        'semantic-visions.com',
        'FemtosearchBot',
        '360Spider',
        'linkfluence.com',
        'glutenfreepleasure.com',
        'Gluten Free Crawler',
        'YaK/1.0',
        'Cliqzbot',
        'app.hypefactors.com',
        'axios',
        'semantic-visions.com',
        'webdatastats.com',
        'schmorp.de',
        'SEOkicks',
        'DuckABot',
        'AOLBuild',
        'Barkrowler',
        'ZoominfoBot',
        'Linguee Bot',
        'Mail.RU_Bot',
        'OnalyticaBot',
        'Linguee Bot',
        'admantx-adform',
        'Buck/2.2',
        'Barkrowler',
        'Zombiebot',
        'Nutch',
        'SemanticScholarBot',
        "Jetslid'e",
        'scalaj-http',
        'XoviBot',
        'sysomos.com',
        'PocketParser',
        'newspaper',
        'serpstatbot',
        );
     // @phpcs:ignore WordPress.Security.NonceVerification.Recommended
        if (isset($_GET['debug_bot']) ) {
         // @phpcs:ignore WordPress.Security.NonceVerification.Recommended
            $user_agent = sanitize_text_field(wp_unslash($_GET['debug_bot']));
         // @phpcs:ignore WordPress.Security.NonceVerification.Recommended
        } else if (isset($_GET['HTTP_USER_AGENT']) ) {
         // @phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated
            $user_agent = sanitize_text_field(wp_unslash($_SERVER['HTTP_USER_AGENT']));
        } else {
			return false;
		}

        foreach ( $user_agents as $agent ) {
            if (strtolower($agent) === strtolower($user_agent) ) {
                $is_bot = true;
            }
        }
        return $is_bot;
    }

    public function map_marker_html( $connection ) {
        ?>
        <article <?php post_class(); ?>>
        <?php

			$meta_class = 'lsx-to-meta-data lsx-to-meta-data-';
			if ( 'accommodation' === get_post_type() ) {
				the_terms( get_the_ID(), 'travel-style', '<span class="' . $meta_class . 'style"><span class="lsx-to-meta-data-key">' . esc_html__( 'Style', 'tour-operator' ) . ':</span> ', ', ', '</span>' );
				the_terms( get_the_ID(), 'accommodation-type', '<span class="' . $meta_class . 'type"><span class="lsx-to-meta-data-key">' . esc_html__( 'Type', 'tour-operator' ) . ':</span> ', ', ', '</span>' );
			}
		?>

        	<div class="entry-content">
			<?php
			if ( empty( $connection ) || '' === $connection || 'undefined' === $connection ) {
				$connection = '';
			}
			$excerpt = get_the_excerpt($connection);
			if ( empty( $excerpt ) || '' === $excerpt ) {
				$tooltip = apply_filters( 'get_the_excerpt', get_the_content() );
				$tooltip = wp_strip_all_tags( $tooltip );
				echo wp_kses_post( wpautop( $tooltip ) );
			} else {
				echo wp_kses_post( $excerpt );
			}
			?>
            </div>
        </article>
        <?php
    }

	/**
	 * Add in the departure and the ends in destinations.
	 *
	 * @param array $connections
	 * @return array
	 */
	function map_start_end_points( $connections = array() ) {
		if ( ! empty( $connections ) ) {
			$departs_from = get_post_meta( get_the_ID(), 'departs_from', true );
			if ( false !== $departs_from && '' !== $departs_from ) {
				$connections = array_merge( array( $departs_from ), $connections );
			}
			$ends_in = get_post_meta( get_the_ID(), 'ends_in', true );
			if ( false !== $ends_in && '' !== $ends_in ) {
				$connections[] = $ends_in;
			}
		}
		return $connections;
	}
}

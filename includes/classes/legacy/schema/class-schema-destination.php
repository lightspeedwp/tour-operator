<?php
/**
 * The Trip Schema for Tours
 *
 * @package tour-operator
 */

/**
 * Returns schema Review data.
 *
 * @since 10.2
 */
class LSX_TO_Schema_Country extends LSX_TO_Schema_Graph_Piece {

	/**
	 * Constructor.
	 *
	 * @param \WPSEO_Schema_Context $context A value object with context variables.
	 */
	public function __construct( WPSEO_Schema_Context $context ) {
		$this->post_type = 'destination';
		parent::__construct( $context );
	}

	/**
	 * Returns Review data.
	 *
	 * @return array $data Review data.
	 */
	public function generate() {
		$type = 'Country';
		if ( ! $this->is_top_level ) {
			$type = 'State';
		}
		$data = array(
			'@type'            => array(
				$type,
			),
			'@id'              => $this->context->canonical . '#destination',
			'name'             => $this->post->post_title,
			'description'      => wp_strip_all_tags( $this->post->post_content ),
			'url'              => $this->post_url,
			'mainEntityOfPage' => array(
				'@id' => $this->context->canonical . WPSEO_Schema_IDs::WEBPAGE_HASH,
			),
		);

		$data = \lsx\legacy\Schema_Utils::add_image( $data, $this->context );
		$data = $this->add_places( $data );
		$data = $this->add_reviews( $data );
		$data = $this->add_articles( $data );

		if ( isset( $_GET['debug'] ) ) {
			print_r('<pre>');
			print_r($data);
			print_r('</pre>');
		}
		return $data;
	}
}

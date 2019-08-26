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
class LSX_TO_Schema_Special extends LSX_TO_Schema_Graph_Piece {

	/**
	 * Constructor.
	 *
	 * @param \WPSEO_Schema_Context $context A value object with context variables.
	 */
	public function __construct( WPSEO_Schema_Context $context ) {
		$this->post_type = 'special';
		parent::__construct( $context );
	}

	/**
	 * Returns Review data.
	 *
	 * @return array $data Review data.
	 */
	public function generate() {
		$data = array(
			'@type'            => array(
				'Offer',
			),
			'@id'              => $this->context->canonical . '#special',
			'name'             => $this->post->post_title,
			'description'      => wp_strip_all_tags( $this->post->post_content ),
			'url'              => $this->post_url,
			'mainEntityOfPage' => array(
				'@id' => $this->context->canonical . WPSEO_Schema_IDs::WEBPAGE_HASH,
			),
		);

		if ( $this->context->site_represents_reference ) {
			//$data['publisher'] = $this->context->site_represents_reference;
		}

		$data = \lsx\legacy\Schema_Utils::add_image( $data, $this->context );
		$data = $this->add_offers( $data );
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

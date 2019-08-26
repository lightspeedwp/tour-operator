<?php
/**
 * The Review Schema
 *
 * @package tour-operator
 */

/**
 * Returns schema Review data.
 *
 * @since 10.2
 */
class LSX_TO_Schema_Review extends LSX_TO_Schema_Graph_Piece {

	/**
	 * Constructor.
	 *
	 * @param \WPSEO_Schema_Context $context A value object with context variables.
	 */
	public function __construct( WPSEO_Schema_Context $context ) {
		$this->post_type = 'review';
		parent::__construct( $context );
	}

	/**
	 * Returns Review data.
	 *
	 * @return array $data Review data.
	 */
	public function generate() {
		$post          = get_post( $this->context->id );
		$review_author = get_post_meta( $post->ID, 'reviewer_name', true );
		$review_email  = get_post_meta( $post->ID, 'reviewer_email', true );
		$rating_value  = get_post_meta( $post->ID, 'rating', true );
		$description   = wp_strip_all_tags( get_the_content() );
		$tour_list     = get_post_meta( get_the_ID(), 'tour_to_review', false );
		$accom_list    = get_post_meta( get_the_ID(), 'accommodation_to_review', false );
		$comment_count = get_comment_count( $this->context->id );
		$data          = array(
			'@type'            => 'Review',
			'@id'              => $this->context->canonical . '#review',
			'author'           => array(
				'@type' => 'Person',
				'@id'   => \lsx\legacy\Schema_Utils::get_author_schema_id( $review_author, $review_email, $this->context ),
				'name'  => $review_author,
				'email' => $review_email,
			),
			'headline'         => get_the_title(),
			'datePublished'    => mysql2date( DATE_W3C, $post->post_date_gmt, false ),
			'dateModified'     => mysql2date( DATE_W3C, $post->post_modified_gmt, false ),
			'commentCount'     => $comment_count['approved'],
			'mainEntityOfPage' => array(
				'@id' => $this->context->canonical . WPSEO_Schema_IDs::WEBPAGE_HASH,
			),
			'reviewRating' => array(
				'@type'       => 'Rating',
				'ratingValue' => $rating_value,
				'bestRating'  => $rating_value,
			),
			'reviewBody'       => $description,
			'itemReviewed'     => \lsx\legacy\Schema_Utils::get_item_reviewed( $tour_list, 'Trip' ),
			'itemReviewed'     => \lsx\legacy\Schema_Utils::get_item_reviewed( $accom_list, 'Accommodation' ),
		);

		if ( $this->context->site_represents_reference ) {
			$data['publisher'] = $this->context->site_represents_reference;
		}

		$data = \lsx\legacy\Schema_Utils::add_image( $data, $this->context );
		$data = $this->add_taxonomy_terms( $data, 'keywords', 'post_tag' );
		$data = $this->add_taxonomy_terms( $data, 'reviewSection', 'category' );

		if ( isset( $_GET['debug'] ) ) {
			print_r('<pre>');
			print_r($data);
			print_r('</pre>');
		}

		return $data;
	}
}

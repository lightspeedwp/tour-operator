<?php
/**
 * Destination Archive
 *
 * @package 	tour-operator
 * @category	destination
 */
$tour_operator = tour_operator();
?>

<?php get_header() ?>

	<?php lsx_content_wrap_before(); ?>

	<section id="primary" class="content-area <?php echo esc_attr( lsx_main_class() ); ?>">

		<?php lsx_content_before() ?>

		<main id="main" class="site-main" role="main">

			<?php
			/**
			 * Hooked
			 *
			 *  - lsx_to_global_header() - 100
			 */
				lsx_content_top();
			?>

			<?php if ( have_posts() ) : ?>

				<section id="countries_custom-elementz">

					<?php
						$counter = 0;

						while ( have_posts() ) :
							$counter++;
							the_post();
							$slug = sanitize_title( the_title( '', '', FALSE ) );
						?>

						<section class="countries" id="<?php echo esc_attr( $slug ); ?>">
							<?php if ( $counter > 1 ) : ?>
								<div class="lsx-breaker"></div>
							<?php endif ?>

							<div class="country">
								<div class="row">
									<div class="col-sm-6">
										<div class="thumbnail">
											<a href="<?php the_permalink() ?>" title="<?php the_title_attribute() ?>">
												<?php lsx_thumbnail( 'lsx-thumbnail-single' ) ?>
											</a>
										</div>
									</div>

									<div class="col-sm-6">
										<h2 class="section-title"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute() ?>"><?php the_title() ?></a></h2>
										<?php lsx_to_tagline( '<p class="tagline">', '</p>') ?>
										<div class="entry-content"><?php echo wp_kses_post( $tour_operator->apply_filters_the_content( $post->post_content, 'Continue Reading', get_permalink() ) ); ?></div>
									</div>
								</div>
							</div>

							<?php
								$regions = get_posts(
									array(
										'post_type' => 'destination',
										'posts_per_page' => -1,
										'orderby' => 'menu_order',
										'order' => 'ASC',
										'post_parent' => get_the_ID()
									)
								);

								$regions_size = count( $regions );
							?>

							<?php if ( $regions_size > 0 ) : ?>

								<?php
									global $post;
									$counter = 0;
									$slider_id = get_the_ID();
								?>

								<div class="regions">
									<h3 class="section-title"><?php esc_html_e( 'Travel Regions Within ', 'tour-operator' ) ?><a href="<?php the_permalink() ?>" title="<?php the_title_attribute() ?>"><?php the_title() ?></a></h3>

									<div class="slider-container">
										<div id="slider-<?php echo esc_attr( $slider_id ); ?>" class="lsx-to-slider">
											<div class="lsx-to-slider-wrap">
												<div class="lsx-to-slider-inner">

													<?php
														foreach ( $regions as $region ) :
															$post = $region;
															setup_postdata( $region );

															$counter++;
														?>

														<div class="item row">
															<div class="panel col-xs-12">
																<article id="post-<?php the_ID() ?>" <?php post_class() ?>>
																	<div class="thumbnail">
																		<a href="<?php the_permalink() ?>">
																			<?php lsx_thumbnail( 'lsx-thumbnail-wide' ) ?>
																		</a>
																	</div>

																	<h4 class="title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h4>
																	<?php lsx_to_tagline( '<p class="tagline">', '</p>') ?>
																	<div class="widget-content">
																		<div class="entry-content">
																			<?php
																				ob_start();
																				the_excerpt();
																				$excerpt = ob_get_clean();
																				$excerpt = strip_tags( $excerpt );
																				$excerpt = preg_replace( '/(continue reading$)|(read more$)/i', '', $excerpt );
																				echo wp_kses_post( $excerpt );
																			?>
																		</div>

																		<div class="view-more">
																			<a href="<?php the_permalink() ?>" class="btn btn-primary">View More</a>
																		</div>
																	</div>
																</article>
															</div>
														</div>

														<?php
															wp_reset_postdata();
														endforeach;
													?>
												</div>
											</div>
										</div>
									</div>
								</div>

							<?php endif ?>

						</section>

					<?php endwhile ?>

				</section>

			<?php else : ?>

				<?php get_template_part( 'content', 'none' ); ?>

			<?php endif ?>

			<?php lsx_to_travel_styles( '<section id="travel-styles"><h2 class="section-title">'. esc_html__( 'Travel Styles','tour-operator' ) .'</h2>', '</section>' ) ?>

			<?php if(function_exists('lsx_to_has_map') && lsx_to_has_map()){ ?>
				<section id="destination-map">
					<?php if ( ! lsx_to_has_destination_banner_map() ) : ?>
						<h2 class="section-title"><?php esc_html_e( 'Map','tour-operator' ) ?></h2>
					<?php endif ?>
					<?php lsx_to_map() ?>
				</section>
			<?php }	?>

			<?php lsx_to_sharing() ?>

			<?php lsx_content_bottom() ?>

		</main><!-- #main -->

		<?php lsx_content_after() ?>

	</section><!-- #primary -->

<?php lsx_content_wrap_after(); ?>

<?php get_sidebar() ?>

<?php get_footer() ?>

<?php
/**
 * Destination Archive
 *
 * @package 	tour-operator
 * @category	destination
 */
?>

<?php get_header() ?>

	<?php lsx_content_wrap_before(); ?>

	<section id="primary" class="content-area <?php echo esc_attr( lsx_main_class() ); ?>">

		<?php lsx_content_before() ?>

		<main id="main" class="site-main" role="main">
		
			<?php if ( have_posts() ) : ?>

				<?php
					global $tour_operator;
					if ( ! isset( $tour_operator->search )
						|| empty( $tour_operator->search )
						|| false === $tour_operator->search->options
						|| ! isset( $tour_operator->search->options['destination']['enable_search'] ) ) :
					?>

					<section class="destinations-navigation">
						<div class="container">
							<ul class="scroll-easing">
								
								<?php
									while ( have_posts() ) :
										the_post();
										$slug = sanitize_title( the_title( '', '', FALSE ) );
									?>
									
									<li><a href="#<?php echo esc_attr( $slug ); ?>" title="<?php the_title() ?>"><?php the_title() ?></a></li>
								
								<?php endwhile ?>

							</ul>
						</div>
					</section>

					<?php
					endif;
				?>

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
											<a href="<?php the_permalink() ?>" title="<?php the_title() ?>">
												<?php lsx_thumbnail( 'lsx-single-thumbnail' ) ?>
											</a>
										</div>
									</div>

									<div class="col-sm-6">
										<h2 class="section-title"><a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php the_title() ?></a></h2>
										<?php to_tagline( '<p class="tagline">', '</p>') ?>
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
									$inner_counter = 0;
									$total_counter = 0;
									$column_counter = 0;
									$slider_id = get_the_ID();
								?>

								<div class="regions">
									<h3 class="section-title"><?php esc_html_e( 'Travel Regions Within ', 'tour-operator' ) ?><a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php the_title() ?></a></h3>
									
									<div class="slider-container">
										<div id="slider-<?php echo esc_attr( $slider_id ); ?>" class="carousel slide" data-interval="false">
											<div class="carousel-wrap">
												<div class="carousel-inner" role="listbox">
													<div class="item row active">
															
															<?php
																foreach ( $regions as $region ) :
																	$post = $region;
																	setup_postdata( $region );

																	$inner_counter++;
																	$total_counter++;
																?>
																
																<div class="panel col-sm-4">
																	<article id="post-<?php the_ID() ?>" <?php post_class() ?>>
																		<div class="thumbnail">
																			<a href="<?php the_permalink() ?>">
																				<?php lsx_thumbnail( 'lsx-thumbnail-wide' ) ?>
																			</a>
																		</div>
																		
																		<h4 class="title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h4>
																		
																		<div class="widget-content">
																			<div class="entry-content">
																				<?php 
																					ob_start();
																					the_excerpt();
																					$excerpt = ob_get_clean();
																					$excerpt = strip_tags( $excerpt );
																					$excerpt = preg_replace( '/Continue reading$/', '', $excerpt );
																					echo wp_kses_post( $excerpt );
																				?>
																			</div>
																			
																			<div class="view-more">
																				<a href="<?php the_permalink() ?>" class="btn btn-primary">View More</a>
																			</div>
																		</div>
																	</article>
																</div>

																<?php
																	if ( ( $inner_counter % 3 ) == 0 && $total_counter < $regions_size ) {
																		$inner_counter = 0;
																		$column_counter++;
																		echo '</div><div class="item row">';
																	}
																?>						
															
																<?php
																	wp_reset_postdata();
																endforeach;
															?>
														
															<?php
																if ( 0 !== $inner_counter ) {
																	$column_counter++;
																	echo '</div>';
																}
															?>
												</div>
												
												<?php if ( $column_counter > 1 ) : ?>

													<a class="left carousel-control" href="#slider-<?php echo esc_attr( $slider_id ); ?>" role="button" data-slide="prev">
														<span class="fa fa-chevron-left" aria-hidden="true"></span>
														<span class="sr-only">Previous</span>
													</a>

													<a class="right carousel-control" href="#slider-<?php echo esc_attr( $slider_id ); ?>" role="button" data-slide="next">
														<span class="fa fa-chevron-right" aria-hidden="true"></span>
														<span class="sr-only">Next</span>
													</a>

												<?php endif ?>
											</div>

											<?php if ( $column_counter > 1 ) : ?>

												<ol class="carousel-indicators">
													<?php
														$i = 0;

														while ( $i < $column_counter ) {
															$class = 0 == $i ? 'active' : '';
															echo '<li data-target="#slider-'. esc_attr( $slider_id ) .'" data-slide-to="'. esc_attr( $i ) .'" class="'. esc_attr( $class ) .'"></li>';
															$i++;
														}
													?>
												</ol>

											<?php endif ?>

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
			
			<?php to_travel_styles( '<section id="travel-styles"><h2 class="section-title">'. __( 'Travel Styles','tour-operator' ) .'</h2>', '</section>' ) ?>
			
			<?php if ( to_has_map() ) : ?>
				<section id="destination-map">
					<?php if ( ! to_has_destination_banner_map() ) : ?>
						<h2 class="section-title"><?php esc_html_e( 'Map','tour-operator' ) ?></h2>
					<?php endif ?>
					<?php to_map() ?>
				</section>
			<?php endif	?>
			
			<?php to_sharing() ?>

			<?php lsx_content_bottom() ?>

		</main><!-- #main -->

		<?php lsx_content_after() ?>
		
	</section><!-- #primary -->

<?php lsx_content_wrap_after(); ?>	

<?php get_sidebar() ?>

<?php get_footer() ?>
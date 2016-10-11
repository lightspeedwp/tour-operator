<?php use Roots\Sage\Extras; ?>
<?php while (have_posts()) : the_post(); ?>

<?php 
	/*  
	 *	This is where the custom fields are called, and mapped to php variables
	 */
	
	$general_group = get_post_meta(get_the_ID(),'info',true);
	
	$duration = false;
	if(isset($general_group['duration'])){
		$duration = $general_group['duration'];
	}	
	
	$itinerary_map = false;
	if(isset($general_group['itinerary_map'])){
		$itinerary_map = $general_group['itinerary_map'];
	}
	
	$steps = false;
	if(isset($general_group['steps'])){
		$steps = $general_group['steps'];
	}	
	
	$contact_details = false;
	if(isset($general_group['contact_details'])){
		$contact_details = $general_group['contact_details'];
	}
	if(isset($general_group['best_time_to_visit'])){
		$best_time_to_visit = $general_group['best_time_to_visit'];
	}
	
	$advisor_comments = false;
	if(isset($general_group['advisor_comments'])){
		$advisor_comments = $general_group['advisor_comments'];
	}	
	
	$prices_group = get_post_meta(get_the_ID(),'price',true);
	
	$price = false;
	if(isset($prices_group['price'])){
		$price = $prices_group['price'];
	}
	
	$special_offer = false;
	if(isset($prices_group['special_offer'])){
		$special_offer = $prices_group['special_offer'];
	}
	
	$included = false;
	if(isset($prices_group['included'])){
		$included = $prices_group['included'];
	}
	
	$not_included = false;
	if(isset($prices_group['not_included'])){
		$not_included = $prices_group['not_included'];
	}	

	$itineraries = get_post_meta(get_the_ID(),'itinerary');
	
	
	$accommodation_ids = get_post_meta(get_the_ID(),'accommodation_to_tour',false);
	$review_ids = get_post_meta(get_the_ID(),'review_to_tour',false);
	$team_member = get_post_meta(get_the_ID(),'team_to_tour',false);
	
	
	$travel_style_array = wp_get_object_terms(get_the_ID(), 'travel-style');
	$travel_styles = false;
	if(!is_wp_error($travel_styles)){
		foreach($travel_style_array as $ts){
			$travel_styles[] = $ts->name;
		} 
	}
	
?>

  <article <?php post_class('row intro'); ?>>
	<div class="col-sm-10 col-sm-offset-1">
	      <div class="team-member consultant col-sm-3 center">
	    <?php if(false !== $team_member && is_array($team_member) && !empty($team_member)) { 
		    
	    		$team_info = get_post_meta($team_member[0],'general',true);
	    	
				echo '.<a href="'.esc_url( home_url('equipe/') ).'">'.get_the_post_thumbnail( $team_member[0], 'thumbnail' ).'</a>';
			    echo '<h4><a href="'.esc_url( home_url('equipe/') ).'">'.get_the_title($team_member[0]).'</a></h4>';
			    
			    ?>
	
				<?php if(isset($team_info['designation'])){ ?>
					<h6 class="contact-designation contact">
					    <i class="fa fa-user"></i> <?php echo esc_attr( $team_info['designation'] ); ?>
					</h6>
				<?php } ?>
				<?php if(isset($team_info['skype'])){ ?>
					<h6 class="contact-skype contact">
					    <i class="fa fa-skype"></i> <?php echo esc_attr( $team_info['skype'] ); ?>
					</h6>
				<?php } ?>
				<?php if(isset($team_info['contact_number'])){ ?>
				    <h6 class="contact-number contact">
				    	<i class="fa fa-phone orange"></i> <a href="tel:<?php echo esc_attr( $team_info['contact_number'] ); ?>"><?php echo esc_html( $team_info['contact_number'] ); ?></a>
				    </h6>
				<?php } ?>
				<?php if(isset($team_info['contact_email'])){ ?>
				    <h6 class="contact-email contact">
				    	<i class="fa fa-envelope orange"></i> <a href="mailto:<?php echo esc_attr( $team_info['contact_email'] ); ?>"><?php echo esc_html( $team_info['contact_email'] ); ?></a>
				    </h6>
				<?php } ?>
			    
	     <?php } ?>

	</div>
	  
	      <section class="meta tour col-sm-9 intro">
	      
		      <?php if($price) { ?>
			  <div class="price">&Agrave; partir de &euro;<?php echo wp_kses_post( $price );?></div>
		      <?php }?>
		      
		      <?php if($duration) { ?>
			  <div class="duration"><?php echo wp_kses_post( $duration );?></div>
		      <?php }?>
		      
		      <?php if(false != $travel_styles){ ?>
				<div class="travel-styles">
				   Voyage:
				  <?php echo wp_kses_post( implode(',', $travel_styles) ); ?>
				  </div>
			  
			<?php } ?>
		      
		      <?php if(is_array($best_time_to_visit) && isset($best_time_to_visit['cmb-field-0'])) { ?>
			  <div class="best-time-to-visit">
				  Meilleur moment pour visiter: 
			  <?php
				  $best_times = false;
				  
					  foreach($best_time_to_visit['cmb-field-0'] as $month){
						  $best_times[] = ucfirst($month);
					  }; 
						  
					  echo wp_kses_post( implode(', ', $best_times) );
				  ?></div>
		      <?php }?> 
		      
		      <?php if($contact_details) { ?>
			  <div class="contact-details"><?php echo wp_kses_post( wpautop($contact_details) ); ?></div>
		      <?php }?>
		      
	      <div class="sharing">
	      	<?php 
	      	if ( function_exists( 'sharing_display' ) ) {
			    sharing_display( '', true );
			}
			 
			if ( class_exists( 'Jetpack_Likes' ) ) {
			    $custom_likes = new Jetpack_Likes;
			    echo wp_kses_post( $custom_likes->post_likes( '' ) );
			}
			?>
	      </div>
	      </section>
	      <div class="spacer-after"></div>
	<div id="tabs-hook"></div>
	<section role="tabs">
		    <ul class="nav nav-tabs">
		      <li class="active"><a href="#travel-summary">R&eacute;sum&eacute; du voyage</a></li>
		      <li><a href="#itinerary">Jour par jour</a></li>
		      <li><a href="#price">Prix</a></li>
		      <li><a href="#accommodation">H&eacute;bergements</a></li>
		      <?php if(false !== $review_ids && !empty($review_ids)) { ?>
		      	<li><a href="#reviews">T&eacute;moignages</a></li>
		      <?php } ?>
		      <?php if(false !== $advisor_comments){ ?>
		      	<li><a href="#advisor_comments">Avis du conseiller voyage</a></li>
		      <?php } ?>
		    </ul>  
		    <div class="tab-content">
			    <div id="travel-summary" class="tab-pane fade in entry-content active col-sm-12">
				<?php
				    if($steps){ ?>
				    <div class="col-sm-9">
					<?php }
				    ?>
					<?php 
				    remove_filter( 'the_excerpt', 'sharing_display',19 );
				    if ( class_exists( 'Jetpack_Likes' ) ) {
					    remove_filter( 'the_excerpt', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
				    }
				    remove_filter( 'the_content', 'sharing_display',19 );
				    if ( class_exists( 'Jetpack_Likes' ) ) {
					    remove_filter( 'the_content', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
				    }				
				    the_content(); ?>
				    
				    <?php
				     if($itinerary_map){
					    $itinerary_map = wp_get_attachment_image_src($itinerary_map,'full');
					    echo wp_kses_post( apply_filters( 'to_lazyload_filter_images', '<img src="'.$itinerary_map[0].'" />' ) );
				    } ?>
				
					<?php
				    if($steps){ ?>
				    </div>
				    <div class="col-sm-3 etapes">
						<?php echo wp_kses_post( apply_filters('the_content',$steps) ); ?>
					</div>
					<?php }
				    ?>
				    
				    
			    </div>
			    <div id="itinerary" class="tab-pane fade col-sm-12">
				    <?php 
				    
				    if(is_array($itineraries) && !empty($itineraries)){
					    foreach($itineraries as $iti){
						    global $itinerary;
						    $itinerary = $iti;
						    get_template_part('templates/content', 'itinerary');
					    }
				    }
				    
				    ?>
			    </div>
			    <div id="price" class="tab-pane fade col-sm-12">
				    <div class="row">
					    <div class="col-sm-12 center">
						    <h3 class="price"><?php esc_html_e('Cette offre &agrave; partir de &euro;','tour-operator'); echo wp_kses_post( $price ); ?></h3>
					    </div>
					    
					    <hr class="divider voyages">
				    
					    <div class="col-sm-6 inclus">
					    	<h4 style="text-align:left;">Inclus</h4>
						    <?php echo wp_kses_post( $included ); ?>
					    </div>
					    
					    <div class="col-sm-6 inclus">
					    	<h4 style="text-align:left;">Non-inclus</h4>
						    <?php echo wp_kses_post( $not_included ); ?>
					    </div>
				    </div>
			    </div>
			    <div id="accommodation" class="tab-pane fade col-sm-12">
				    <?php 
				    $accommodation_args = array(
					    'post_type' => 'accommodation',
					    'post_status' => 'publish',
					    'nopagin'		=> true,
					    'post__in'	=> $accommodation_ids
				    );
				    $accommodation = new \WP_Query($accommodation_args);
				    if($accommodation->have_posts()){
					    while($accommodation->have_posts()){
						    $accommodation->the_post();
						    get_template_part('templates/content', 'accommodation');
					    }
				    }
				    wp_reset_query();
				    ?>		  
			    </div>
			    <?php if(false !== $review_ids && !empty($review_ids)) { ?>
				    <div id="reviews" class="tab-pane fade col-sm-12 reviews">
					    <?php 
					    $reviews_args = array(
						    'post_type' => 'review',
						    'post_status' => 'publish',
						    'nopagin'		=> true,
						    'post__in'	=> $review_ids
					    );
					    $reviews = new \WP_Query($reviews_args);
					    if($reviews->have_posts()){
						    while($reviews->have_posts()){
							    $reviews->the_post();
							    echo '<div class="col-sm-12 reviews">';
							    get_template_part('templates/content', 'review'); 
							    echo '</div>';
						    }
					    }
					    wp_reset_query();
					    ?>
				    </div>
			    <?php } ?>
			    
			    <?php if(false !== $advisor_comments){ ?>
				    <div id="advisor_comments" class="tab-pane fade col-sm-12 advisor-comments">
					
					<div class="team-member consultant col-sm-3 center">
	    <?php if(false !== $team_member && is_array($team_member) && !empty($team_member)) { 
		    
	    		$team_info = get_post_meta($team_member[0],'general',true);
	    	
				echo '.<a href="'.esc_url( home_url('equipe/') ).'">'.get_the_post_thumbnail( $team_member[0], 'thumbnail' ).'</a>';
			    echo '<h4><a href="'.esc_url( home_url('equipe/') ).'">'.get_the_title($team_member[0]).'</a></h4>';
			    
			    ?>
	
				<?php if(isset($team_info['designation'])){ ?>
					<h6 class="contact-designation contact">
					    <i class="fa fa-user"></i> <?php echo esc_html( $team_info['designation'] ); ?>
					</h6>
				<?php } ?>
				<?php if(isset($team_info['skype'])){ ?>
					<h6 class="contact-skype contact">
					    <i class="fa fa-skype"></i> <?php echo esc_html( $team_info['skype'] ); ?>
					</h6>
				<?php } ?>
				<?php if(isset($team_info['contact_number'])){ ?>
				    <h6 class="contact-number contact">
				    	<i class="fa fa-phone orange"></i> <a href="tel:<?php echo esc_attr( $team_info['contact_number'] ); ?>"><?php echo esc_html( $team_info['contact_number'] ); ?></a>
				    </h6>
				<?php } ?>
				<?php if(isset($team_info['contact_email'])){ ?>
				    <h6 class="contact-email contact">
				    	<i class="fa fa-envelope orange"></i> <a href="mailto:<?php echo esc_attr( $team_info['contact_email'] ); ?>"><?php echo esc_html( $team_info['contact_email'] ); ?></a>
				    </h6>
				<?php } ?>
			    
	<?php } ?>
					</div>
					<div class="col-sm-9 content-comments">
						<h4 style="padding-bottom: 10px; border-bottom: 1px solid #ff6600;"><a style="text-decoration:none;" href="<?php echo esc_url( home_url('/equipe/') ); ?>">Les points forts de ce voyage, mon opinion:</a></h4>
						<?php echo wp_kses_post( apply_filters('the_content',$advisor_comments) ); ?>
					</div>
				    </div>	
			    <?php } ?>	  		  
		    </div>		
			    
	</section>
	</div>
    
    
    <footer class="col-sm-12">
      <?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
    </footer>
  </article>
  
  <section class="related-tours row">
  		<div class="col-sm-12">
			<h2>Circuits Similaires</h2>
			<?php to_related_items('tour'); ?>
		</div>
  </section>
  
<?php endwhile; ?>
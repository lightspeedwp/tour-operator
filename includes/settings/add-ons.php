<div class="wrap to_addons_wrap">
	<ul class="addons-nav">
		<li><a class="active" href="#all" title="All Addons">All</a></li>
		<li><a href="#post-types" title="Post Types">Post Types</a></li>
		<li><a href="#functionality" title="Functionality">Functionality</a></li>
	</ul>
	<ul class="products">
		<li class="product all post-types">
			<a href="">
				<img src="https://www.lsdev.biz/wp-content/uploads/2016/04/lsx_tour_operators_square-210x120.jpg">
				<span class="price">$149.00–$399.00</span>
				<p>The Tour Operator plugin integrates and syncs with the Wetu Tour Operator database to bring dynamic features to your WordPress website, such as live availability and bookings, digital itineraries and more.</p>
			</a>
		</li>
		<li class="product all post-types">
			<a href="">
				<h2>Tour Operator Activities</h2>
				<span class="price">$149.00–$399.00</span>
				<p>The Tour Operator plugin integrates and syncs with the Wetu Tour Operator database to bring dynamic features to your WordPress website, such as live availability and bookings, digital itineraries and more.</p>
			</a>
		</li>
		<li class="product all post-types">
			<a href="">
				<h2>Tour Operator Specials</h2>
				<span class="price">$149.00–$399.00</span>
				<p>The Tour Operator plugin integrates and syncs with the Wetu Tour Operator database to bring dynamic features to your WordPress website, such as live availability and bookings, digital itineraries and more.</p>
			</a>
		</li>		
		<li class="product all functionality">
			<a href="">
				<h2>Tour Operator Search</h2>
				<span class="price">$149.00–$399.00</span>
				<p>The Tour Operator plugin integrates and syncs with the Wetu Tour Operator database to bring dynamic features to your WordPress website, such as live availability and bookings, digital itineraries and more.</p>
			</a>
		</li>
		<li class="product all functionality">
			<a href="">
				<h2>Tour Operator Maps</h2>
				<span class="price">$149.00–$399.00</span>
				<p>The Tour Operator plugin integrates and syncs with the Wetu Tour Operator database to bring dynamic features to your WordPress website, such as live availability and bookings, digital itineraries and more.</p>
			</a>
		</li>
		<li class="product all functionality">
			<a href="">
				<h2>Tour Operator Galleries</h2>
				<span class="price">$149.00–$399.00</span>
				<p>The Tour Operator plugin integrates and syncs with the Wetu Tour Operator database to bring dynamic features to your WordPress website, such as live availability and bookings, digital itineraries and more.</p>
			</a>
		</li>		
	</ul>
</div>

<script>
	jQuery(document).ready( function() {
		jQuery('.to_addons_wrap .addons-nav li a').click(function(event) {
			event.preventDefault();

			jQuery('.addons-nav li a.active').removeClass('active');
			jQuery(this).addClass('active')

			var clicked = jQuery(this).attr('href');
			clicked = clicked.replace('#','');
			console.log(clicked);
			jQuery('.products li').each(function() {
				if (jQuery(this).hasClass(clicked)) {
					jQuery(this).show();
				} else {
					jQuery(this).hide();
				}
			});
		});		
	});	
</script>
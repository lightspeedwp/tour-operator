<?php
	$lsx_to_documentation = esc_url( 'https://tour-operator.lsdev.biz/documentation/' );
	$extensions_link      = esc_url( 'https://www.lsdev.biz/lsx/extensions/tour-operator/' );
	$version              = esc_html( LSX_TO_VER );
?>

<div class="wrap about-wrap">
	<div class="row">
		<div class="col-md-12 top-header">
			<h1 class="small"><?php esc_html_e( 'LightSpeed’s LSX Tour Operator Plugin', 'tour-operator' ); ?></h1>
			<p><?php esc_html_e( 'Thank you for using the LSX Tour Operator plugin. All of us here at LightSpeed appreciate your ongoing support and we can\'t wait to see what people create with the plugin. We\'re committed to ensuring you have all the help you need to make the most of the plugin.', 'tour-operator' ); ?></p>
		</div>
	</div>

	<div class="row">
		<div class="col-md-8">
			<div class="row">
				<div class="col-md-12">
					<div class="box support">
						<h2><?php esc_html_e( 'Getting Support', 'tour-operator' ); ?></h2>
						<p><?php esc_html_e( 'Our website\'s', 'tour-operator' ); ?> <a href="<?php echo wp_kses_post( $lsx_to_documentation ); ?>" target="_blank"><?php esc_html_e( 'documentation', 'tour-operator' ); ?></a> <?php esc_html_e( 'page is a great place to start to learn how to configure and customize our plugin and its extensions. Here are some links to some of the key settings and modules:', 'tour-operator' ); ?></p>

						<ul>
							<li><strong><?php esc_html_e( 'General settings:', 'tour-operator' ); ?></strong> <?php esc_html_e( 'Configure the general settings of the plugin as well as some settings per-module.', 'tour-operator' ); ?></li>
							<li><strong><?php esc_html_e( 'Destinations:', 'tour-operator' ); ?></strong> <?php esc_html_e( 'Create and configure your Destination single posts and archives', 'tour-operator' ); ?></li>
							<li><strong><?php esc_html_e( 'Accommodations:', 'tour-operator' ); ?></strong> <?php esc_html_e( 'Create and configure your Accommodation single posts and archives', 'tour-operator' ); ?></li>
							<li><strong><?php esc_html_e( 'Tours:', 'tour-operator' ); ?></strong> <?php esc_html_e( 'Create and configure your Tours single posts and archives', 'tour-operator' ); ?></li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="row">
				<div class="col-md-12">
					<div class="box info">
						<h2><?php esc_html_e( 'LSX Tour Operator', 'tour-operator' ); ?></h2>

						<ul>
							<li><strong><?php esc_html_e( 'Latest Version:', 'tour-operator' ); ?></strong> <?php echo esc_attr( $version ); ?></li>
							<li><strong><?php esc_html_e( 'Requires:', 'tour-operator' ); ?></strong> <?php esc_html_e( 'WordPress 5.0+', 'tour-operator' ); ?></li>
							<li><strong><?php esc_html_e( 'Tested up to:', 'tour-operator' ); ?></strong> <?php esc_html_e( 'WordPress 5.0', 'tour-operator' ); ?></li>
						</ul>

						<div class="more-button">
							<a href="<?php echo wp_kses_post( $tour_operator_link ); ?>" target="_blank" class="button button-primary">
								<?php esc_html_e( 'Visit plugin website', 'tour-operator' ); ?>
							</a>
							<br clear="both" />
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	$lsx_to_documentation = esc_url( 'https://touroperator.solutions/docs/' );
	$tour_operator_link      = esc_url( 'https://wordpress.org/plugins/tour-operator/' );
	$extensions_link      = esc_url( 'https://lightspeedwp.agency/solutions/tour-operators/' );
	$version              = esc_html( LSX_TO_VER );
	$support_link         = esc_url( 'https://github.com/lightspeeddevelopment/tour-operator/issues' );
?>

<div class="wrap about-wrap">
	<div class="row">
		<div class="col-md-12 top-header">
			<h1 class="small"><?php esc_html_e( 'Tour Operator Extensions', 'tour-operator' ); ?></h1>
			<p><?php esc_html_e( 'Extend the functionality of the Tour Operator plugin with one of our many extensions!', 'tour-operator' ); ?></p>
		</div>
	</div>

	<div class="row">
		<div class="col-md-8">
			<div class="row">
				<div class="col-md-12">
					<div class="box support">
						<div class="image">
							<?php // phpcs:ignore PluginCheck.CodeAnalysis.ImageFunctions.NonEnqueuedImage ?>
							<img width="200px" src="
							<?php
								// @phpcs:ignore PluginCheck.CodeAnalysis.ImageFunctions 
								echo esc_url( LSX_TO_URL . 'assets/img/support-cog.svg' ); 
							?>" />
						</div>
						<div class="content">
							<h2><?php esc_html_e( 'Getting Support', 'tour-operator' ); ?></h2>
							<p><?php esc_html_e( 'Our website\'s', 'tour-operator' ); ?> <a href="<?php echo wp_kses_post( $lsx_to_documentation ); ?>" target="_blank"><?php esc_html_e( 'documentation', 'tour-operator' ); ?></a> <?php esc_html_e( 'page is a great place to start to learn how to configure and customize our plugin and its extensions.', 'tour-operator' ); ?></p>
							<div class="more-button">
								<a href="<?php echo wp_kses_post( $support_link ); ?>" target="_blank" class="button button-tertiary">
									<?php esc_html_e( 'Get support today', 'tour-operator' ); ?>
								</a>
								<br clear="both" />
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="row">
				<div class="col-md-12">
					<div class="box info">
						<h2><?php esc_html_e( 'Tour Operator', 'tour-operator' ); ?></h2>

						<ul>
							<li><strong><?php esc_html_e( 'Latest Version:', 'tour-operator' ); ?></strong> <?php echo esc_attr( $version ); ?></li>
							<li><strong><?php esc_html_e( 'Requires:', 'tour-operator' ); ?></strong> <?php esc_html_e( 'WordPress 5.0+', 'tour-operator' ); ?></li>
							<li><strong><?php esc_html_e( 'Tested up to:', 'tour-operator' ); ?></strong> <?php esc_html_e( 'WordPress 5.0', 'tour-operator' ); ?></li>
						</ul>

						<div class="more-button">
							<a href="<?php echo wp_kses_post( $tour_operator_link ); ?>" target="_blank" class="button button-primary">
								<?php esc_html_e( 'Visit on WordPress', 'tour-operator' ); ?>
							</a>
							<br clear="both" />
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="uix-field-wrapper">
    <?php $class = 'active'; ?>
	<ul class="ui-tab-nav">
		<?php if(class_exists('LSX_Banners')) { ?>
		    <li><a href="#ui-general" class="<?php echo wp_kses_post($class); ?>"><?php esc_html_e('General','tour-operator'); ?></a></li>
		<?php $class = ''; } ?>
		<?php if(class_exists('LSX_Currencies')) { ?>
			<li><a href="#ui-currencies" class="<?php echo wp_kses_post($class); ?>"><?php esc_html_e('Currency Switcher','tour-operator'); ?></a></li>
		<?php $class = ''; } ?>
		<?php if(class_exists('LSX_TO_Maps')) { ?>
			<li><a href="#ui-maps" class="<?php echo wp_kses_post($class); ?>"><?php esc_html_e('Maps','tour-operator'); ?></a></li>
		<?php $class = ''; } ?>
		<?php if(class_exists('LSX_TO_Search')) { ?>
			<li><a href="#ui-search" class="<?php echo wp_kses_post($class); ?>"><?php esc_html_e('Search','tour-operator'); ?></a></li>
		<?php $class = ''; } ?>
		<li><a href="#ui-placeholders" class="<?php echo wp_kses_post($class); ?>"><?php esc_html_e('Placeholders','tour-operator'); ?></a></li>
		<li><a href="#ui-advanced"><?php esc_html_e('Advanced','tour-operator'); ?></a></li>
	</ul>

	<?php $class = 'active'; ?>
	<?php if(class_exists('LSX_Banners')) { ?>
        <div id="ui-general" class="ui-tab <?php echo wp_kses_post($class); ?>">
            <table class="form-table">
                <tbody>
                <?php do_action('lsx_to_framework_display_tab_content','basic'); ?>
                </tbody>
            </table>
        </div>
    <?php $class = ''; } ?>

	<?php if(class_exists('LSX_Currencies')) { ?>
		<div id="ui-currencies" class="ui-tab <?php echo wp_kses_post($class); ?>">
			<table class="form-table">
				<tbody>
				<?php do_action('lsx_to_framework_display_tab_content','currency_switcher'); ?>
				</tbody>
			</table>
		</div>
	<?php $class = ''; } ?>

	<?php if(class_exists('LSX_TO_Maps')) { ?>
		<div id="ui-maps" class="ui-tab <?php echo wp_kses_post($class); ?>">
			<table class="form-table">
				<tbody>
				<?php do_action('lsx_to_framework_display_tab_content','maps'); ?>
				</tbody>
			</table>
		</div>
	<?php $class = ''; } ?>

	<?php if(class_exists('LSX_TO_Search')) { ?>
		<div id="ui-search" class="ui-tab <?php echo wp_kses_post($class); ?>">
			<table class="form-table">
				<tbody>
				<?php do_action('lsx_to_framework_display_tab_content','search'); ?>
				</tbody>
			</table>
		</div>
	<?php $class = ''; } ?>

	<div id="ui-placeholders" class="ui-tab <?php echo wp_kses_post($class); ?>">
		<table class="form-table">
			<tbody>
			<?php do_action('lsx_to_framework_display_tab_content','placeholders'); ?>
			</tbody>
		</table>
	</div>

	<div id="ui-advanced" class="ui-tab">
		<table class="form-table">
			<tbody>
			<?php do_action('lsx_to_framework_display_tab_content','advanced'); ?>
			</tbody>
		</table>
	</div>

	<?php do_action('lsx_to_framework_display_tab_bottom','display'); ?>

</div>
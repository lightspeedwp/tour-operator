<?php

?>
<div id="ui-<?php echo esc_attr( $tab_index ); ?>" class="ui-tab tabs-content">
	<table class="form-table">
		<tbody>
			<?php do_action( 'lsx_to_framework_' . $tab_index . '_tab_content', 'placeholders' ); ?>
		</tbody>
	</table>
</div>
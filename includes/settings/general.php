<div class="uix-field-wrapper">
	<table class="form-table" style="margin-top:-13px !important;">
		<tbody>
			<tr class="form-field banner-wrap">
				<th class="<?php echo wp_kses_post($this->product_slug); ?>_table_heading" style="padding-bottom:0px;" scope="row" colspan="2">
					<label><h3 style="margin-bottom:0px;"> General</h3></label>			
				</th>
			</tr>		
			<?php echo do_action('to_framework_dashboard_tab_content','general'); ?>
		</tbody>
	</table>
	<?php do_action('to_framework_dashboard_tab_bottom','general'); ?>
</div>
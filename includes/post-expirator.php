<?php

define('LSX_TO_POSTEXPIRATOR_DATEFORMAT',esc_html__('l F jS, Y','tour-operator'));
define('LSX_TO_POSTEXPIRATOR_TIMEFORMAT',esc_html__('g:ia','tour-operator'));

function lsx_to_expirationdate_add_column($columns,$type) {
	if (in_array($type, LSX_TO_POSTEXPIRATOR_TYPES)) {
	  	$columns['lsx_to_expirationdate'] = esc_html__('Expires','tour-operator');
	}

  	return $columns;
}
add_filter('manage_posts_columns', 'lsx_to_expirationdate_add_column', 10, 2);

function lsx_to_expirationdate_show_value($column_name) {
	global $post;
	$id = $post->ID;
	
	if ('lsx_to_expirationdate' === $column_name) {
		$ed = get_post_meta($id,'_to_expiration-date',true);
		echo esc_html($ed ? get_date_from_gmt(gmdate('Y-m-d H:i:s',$ed),get_option('date_format').' '.get_option('time_format')) : esc_html__("Never",'tour-operator'));
  	}
}
add_action ('manage_posts_custom_column', 'lsx_to_expirationdate_show_value');
add_action ('manage_pages_custom_column', 'lsx_to_expirationdate_show_value');

function lsx_to_expirationdate_meta_custom() {
	$custom_post_types = array('special','tour');
	
	foreach ($custom_post_types as $t) {
		add_meta_box('lsxtoexpirationdatediv', esc_html__('Expires','tour-operator'), 'lsx_to_expirationdate_meta_box', $t, 'side', 'core');
	}
}
add_action('add_meta_boxes','lsx_to_expirationdate_meta_custom');

function lsx_to_expirationdate_meta_box($post) {
	$expirationdatets = get_post_meta($post->ID,'_to_expiration-date',true);
	$firstsave = get_post_meta($post->ID,'_to_expiration-date-status',true);
	$expiretype = '';

	if (empty($expirationdatets)) {
		$defaultmonth 	=	date_i18n('m');
		$defaultday 	=	date_i18n('d');
		$defaulthour 	=	date_i18n('H');
		$defaultyear 	=	date_i18n('Y');
		$defaultminute 	= 	date_i18n('i');

		$enabled = '';
		$disabled = ' disabled="disabled"';
	} else {
		$defaultmonth 	=	get_date_from_gmt(gmdate('Y-m-d H:i:s',$expirationdatets),'m');
		$defaultday 	=	get_date_from_gmt(gmdate('Y-m-d H:i:s',$expirationdatets),'d');
		$defaultyear 	=	get_date_from_gmt(gmdate('Y-m-d H:i:s',$expirationdatets),'Y');
		$defaulthour 	=	get_date_from_gmt(gmdate('Y-m-d H:i:s',$expirationdatets),'H');
		$defaultminute 	=	get_date_from_gmt(gmdate('Y-m-d H:i:s',$expirationdatets),'i');
		$enabled 	= 	' checked="checked"';
		$disabled 	= 	'';
		$opts 		= 	get_post_meta($post->ID,'_to_expiration-date-options',true);
		
		if (isset($opts['expiretype'])) {
			$expiretype = $opts['expiretype'];
		}
	}

	$rv = array();
	$rv[] = '<p><input type="checkbox" name="enable-lsx-to-expirationdate" id="enable-lsx-to-expirationdate" value="checked"'.$enabled.' onclick="lsx_to_expirationdate_ajax_add_meta(\'enable-lsx-to-expirationdate\')" />';
	$rv[] = '<label for="enable-lsx-to-expirationdate">'.esc_html__('Enable Post Expiration','tour-operator').'</label></p>';

	$rv[] = '<table><tr>';
	$rv[] = '<th style="text-align: left;">'.esc_html__('Year','tour-operator').'</th>';
	$rv[] = '<th style="text-align: left;">'.esc_html__('Month','tour-operator').'</th>';
	$rv[] = '<th style="text-align: left;">'.esc_html__('Day','tour-operator').'</th>';
	$rv[] = '</tr><tr>';
	$rv[] = '<td>';	
	$rv[] = '<select name="lsx_to_expirationdate_year" id="lsx_to_expirationdate_year"'.$disabled.'>';
	$currentyear = date('Y');

	if ($defaultyear < $currentyear) $currentyear = $defaultyear;

	for($i = $currentyear; $i < $currentyear + 8; $i++) {
		if ($i == $defaultyear)
			$selected = ' selected="selected"';
		else
			$selected = '';
		$rv[] = '<option'.$selected.'>'.($i).'</option>';
	}
	$rv[] = '</select>';
	$rv[] = '</td><td>';
	$rv[] = '<select name="lsx_to_expirationdate_month" id="lsx_to_expirationdate_month"'.$disabled.'>';

	for($i = 1; $i <= 12; $i++) {
		if (date_i18n('m',mktime(0, 0, 0, $i, 1, date_i18n('Y'))) == $defaultmonth)
			$selected = ' selected="selected"';
		else
			$selected = '';
		$rv[] = '<option value="'.date_i18n('m',mktime(0, 0, 0, $i, 1, date_i18n('Y'))).'"'.$selected.'>'.date_i18n('F',mktime(0, 0, 0, $i, 1, date_i18n('Y'))).'</option>';
	}

	$rv[] = '</select>';	 
	$rv[] = '</td><td>';
	$rv[] = '<input type="text" id="lsx_to_expirationdate_day" name="lsx_to_expirationdate_day" value="'.$defaultday.'" size="2"'.$disabled.' />,';
	$rv[] = '</td></tr><tr>';
	$rv[] = '<th style="text-align: left;"></th>';
	$rv[] = '<th style="text-align: left;">'.esc_html__('Hour','tour-operator').'('.date_i18n('T',mktime(0, 0, 0, $i, 1, date_i18n('Y'))).')</th>';
	$rv[] = '<th style="text-align: left;">'.esc_html__('Minute','tour-operator').'</th>';
	$rv[] = '</tr><tr>';
	$rv[] = '<td>@</td><td>';
 	$rv[] = '<select name="lsx_to_expirationdate_hour" id="lsx_to_expirationdate_hour"'.$disabled.'>';

	for($i = 1; $i <= 24; $i++) {
		if (date_i18n('H',mktime($i, 0, 0, date_i18n('n'), date_i18n('j'), date_i18n('Y'))) == $defaulthour)
			$selected = ' selected="selected"';
		else
			$selected = '';
		$rv[] = '<option value="'.date_i18n('H',mktime($i, 0, 0, date_i18n('n'), date_i18n('j'), date_i18n('Y'))).'"'.$selected.'>'.date_i18n('H',mktime($i, 0, 0, date_i18n('n'), date_i18n('j'), date_i18n('Y'))).'</option>';
	}

	$rv[] = '</select></td><td>';
	$rv[] = '<input type="text" id="lsx_to_expirationdate_minute" name="lsx_to_expirationdate_minute" value="'.$defaultminute.'" size="2"'.$disabled.' />';
	$rv[] = '</td></tr></table>';
	
	$rv[] = wp_nonce_field( 'lsx_to_expirationdate_update_post_meta', '_to_expirationdate_update_post_meta_nonce', true, false );
	echo wp_kses_post(implode("\n",$rv));

	echo '<br/>'.esc_html__('How to expire','tour-operator').': ';
	echo wp_kses_post(lsx_to_post_expirator_expire_type(array('type' => $post->post_type, 'name'=>'lsx_to_expirationdate_expiretype','selected'=>$expiretype,'disabled'=>$disabled)));
}

function lsx_to_expirationdate_js_admin_header() {
	?>
	<script type="text/javascript">
		//<![CDATA[
		function lsx_to_expirationdate_ajax_add_meta(expireenable) {
			var expire = document.getElementById(expireenable);

			if (expire.checked == true) {
				if (document.getElementById('lsx_to_expirationdate_month')) {
					document.getElementById('lsx_to_expirationdate_month').disabled = false;
					document.getElementById('lsx_to_expirationdate_day').disabled = false;
					document.getElementById('lsx_to_expirationdate_year').disabled = false;
					document.getElementById('lsx_to_expirationdate_hour').disabled = false;
					document.getElementById('lsx_to_expirationdate_minute').disabled = false;
				}
				
				document.getElementById('lsx_to_expirationdate_expiretype').disabled = false;
			} else {
				if (document.getElementById('lsx_to_expirationdate_month')) {
					document.getElementById('lsx_to_expirationdate_month').disabled = true;
					document.getElementById('lsx_to_expirationdate_day').disabled = true;
					document.getElementById('lsx_to_expirationdate_year').disabled = true;
					document.getElementById('lsx_to_expirationdate_hour').disabled = true;
					document.getElementById('lsx_to_expirationdate_minute').disabled = true;
				}
				
				document.getElementById('lsx_to_expirationdate_expiretype').disabled = true;
			}
			
			return true;
		}
		//]]>
	</script>
<?php
}
add_action('admin_head', 'lsx_to_expirationdate_js_admin_header' );

function lsx_to_expirationdate_update_post_meta($id) {
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! isset( $_POST['enable-lsx-to-expirationdate'] ) ) {
		lsx_to_unschedule_expirator_event($id);
		return;
	}

	$posttype = get_post_type( $id );
	
	if ( 'revision' == $posttype ) {
		return;
	}

	check_admin_referer( 'lsx_to_expirationdate_update_post_meta', '_to_expirationdate_update_post_meta_nonce' );

	$month	 = intval(wp_unslash($_POST['lsx_to_expirationdate_month']));
	$day 	 = intval(wp_unslash($_POST['lsx_to_expirationdate_day']));
	$year 	 = intval(wp_unslash($_POST['lsx_to_expirationdate_year']));
	$hour 	 = intval(wp_unslash($_POST['lsx_to_expirationdate_hour']));
	$minute  = intval(wp_unslash($_POST['lsx_to_expirationdate_minute']));
	
	$opts = array();
	$ts = get_gmt_from_date("$year-$month-$day $hour:$minute:0",'U');

	$opts['expiretype'] = sanitize_text_field(wp_unslash($_POST['lsx_to_expirationdate_expiretype']));
	$opts['id'] = $id;

	lsx_to_schedule_expirator_event($id,$ts,$opts);
}
add_action('save_post','lsx_to_expirationdate_update_post_meta');

function lsx_to_schedule_expirator_event($id,$ts,$opts) {
	if (wp_next_scheduled('lsxToPostExpiratorExpire',array($id)) !== false) {
		wp_clear_scheduled_hook('lsxToPostExpiratorExpire',array($id));
	}
		
	wp_schedule_single_event($ts,'lsxToPostExpiratorExpire',array($id)); 

	update_post_meta($id, '_to_expiration-date', $ts);
	update_post_meta($id, '_to_expiration-date-options', $opts);
	update_post_meta($id, '_to_expiration-date-status','saved');
}

function lsx_to_unschedule_expirator_event($id) {
	delete_post_meta($id, '_to_expiration-date'); 
	delete_post_meta($id, '_to_expiration-date-options');

	if (wp_next_scheduled('lsxToPostExpiratorExpire',array($id)) !== false) {
		wp_clear_scheduled_hook('lsxToPostExpiratorExpire',array($id));
	}

	update_post_meta($id, '_to_expiration-date-status','saved');
}

function lsx_to_post_expirator_expire($id) {
	if (empty($id)) { 
		return false;
	}

	if (is_null(get_post($id))) {
		return false;
	}

	$postoptions = get_post_meta($id,'_to_expiration-date-options',true);
	
	if (empty($postoptions['expiretype'])) {
		$posttype = get_post_type($id);
		$postoptions['expiretype'] = apply_filters('lsx_to_postexpirator_custom_posttype_expire', $postoptions['expiretype'], $posttype);
	}

	kses_remove_filters();

	// Do Work
	if ('draft' == $postoptions['expiretype']) {
		wp_update_post(array('ID' => $id, 'post_status' => 'draft'));
	} elseif ('private' == $postoptions['expiretype']) {
		wp_update_post(array('ID' => $id, 'post_status' => 'private'));
	} elseif ('delete' == $postoptions['expiretype']) {
		wp_delete_post($id);
	}
}
add_action('lsxToPostExpiratorExpire','lsx_to_post_expirator_expire');

function lsx_to_post_expirator_expire_type($opts) {
	if (empty($opts)) return false;

	if (!isset($opts['name'])) return false;
	if (!isset($opts['id'])) $opts['id'] = $opts['name'];
	if (!isset($opts['disabled'])) $opts['disabled'] = false;
	if (!isset($opts['onchange'])) $opts['onchange'] = '';
	if (!isset($opts['type'])) $opts['type'] = '';

	$rv = array();
	$rv[] = '<select name="'.$opts['name'].'" id="'.$opts['id'].'"'.(true == $opts['disabled'] ? ' disabled="disabled"' : '').' onchange="'.$opts['onchange'].'">';
	$rv[] = '<option value="draft" '. ('draft' == $opts['selected'] ? 'selected="selected"' : '') . '>'.esc_html__('Draft','tour-operator').'</option>';
	$rv[] = '<option value="delete" '. ('delete' == $opts['selected'] ? 'selected="selected"' : '') . '>'.esc_html__('Delete','tour-operator').'</option>';
	$rv[] = '<option value="private" '. ('private' == $opts['selected'] ? 'selected="selected"' : '') . '>'.esc_html__('Private','tour-operator').'</option>';
	
	$rv[] = '</select>';
	return implode("<br/>/n",$rv);
}

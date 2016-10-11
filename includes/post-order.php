<?php
 
$to_scporder = new TO_SCPO_Engine();

class TO_SCPO_Engine {

	function __construct() {
		if (!get_option('to_scporder_install'))
			$this->to_scporder_install();

		add_action('admin_init', array($this, 'refresh'));
		add_action('admin_init', array($this, 'load_script_css'));

		add_action('wp_ajax_update-menu-order', array($this, 'update_menu_order'));
		add_action('wp_ajax_update-menu-order-tags', array($this, 'update_menu_order_tags'));

		add_action('pre_get_posts', array($this, 'to_scporder_pre_get_posts'));

		add_filter('get_previous_post_where', array($this, 'to_scporder_previous_post_where'));
		add_filter('get_previous_post_sort', array($this, 'to_scporder_previous_post_sort'));
		add_filter('get_next_post_where', array($this, 'to_scporder_next_post_where'));
		add_filter('get_next_post_sort', array($this, 'to_scporder_next_post_sort'));

		add_filter('get_terms_orderby', array($this, 'to_scporder_get_terms_orderby'), 10, 3);
		add_filter('wp_get_object_terms', array($this, 'to_scporder_get_object_terms'), 10, 3);
		add_filter('get_terms', array($this, 'to_scporder_get_object_terms'), 10, 3);
	}

	function to_scporder_install() {
		global $wpdb;
		$result = $wpdb->query("DESCRIBE $wpdb->terms `to_term_order`");
		
		if (!$result) {
			$result = $wpdb->query("ALTER TABLE $wpdb->terms ADD `to_term_order` INT(4) NULL DEFAULT '0'");
		}

		update_option('to_scporder_install', 1);
	}

	function _check_load_script_css() {
		$active = false;

		$objects = $this->get_to_scporder_options_objects();
		$tags = $this->get_to_scporder_options_tags();

		if (empty($objects) && empty($tags))
			return false;

		if (isset($_GET['orderby']) || strstr(sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI'])), 'action=edit') || strstr(sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI'])), 'wp-admin/post-new.php'))
			return false;

		if (!empty($objects)) {
			if (isset($_GET['post_type']) && !isset($_GET['taxonomy']) && array_key_exists(sanitize_text_field(wp_unslash($_GET['post_type'])), $objects)) { // if page or custom post types
				$active = true;
			}
			if (!isset($_GET['post_type']) && strstr(sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI'])), 'wp-admin/edit.php') && array_key_exists('post', $objects)) { // if post
				$active = true;
			}
		}

		if (!empty($tags)) {
			if (isset($_GET['taxonomy']) && array_key_exists(sanitize_text_field(wp_unslash($_GET['taxonomy'])), $tags)) {
				$active = true;
			}
		}

		return $active;
	}

	function load_script_css() {
		if ($this->_check_load_script_css()) {
			wp_enqueue_script('jquery');
			wp_enqueue_script('jquery-ui-sortable');
			wp_enqueue_script('scporderjs', TO_URL . '/assets/js/scporder.min.js', array('jquery'), null, true);

			$scporderjs_params = array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'ajax_nonce' => wp_create_nonce( 'scporder' ),
			);

			wp_localize_script( 'scporderjs', 'scporderjs_params', $scporderjs_params );

			wp_enqueue_style('scporder', TO_URL . '/assets/css/scporder.css', array(), null);
		}
	}

	function refresh() {
		global $wpdb;
		$objects = $this->get_to_scporder_options_objects();
		$tags = $this->get_to_scporder_options_tags();

		if (!empty($objects)) {
			foreach ($objects as $object => $object_data) {
				$result = $wpdb->get_results($wpdb->prepare("
					SELECT count(*) as cnt, max(menu_order) as max, min(menu_order) as min 
					FROM $wpdb->posts 
					WHERE post_type = '%s' AND post_status IN ('publish', 'pending', 'draft', 'private', 'future')
				", $object));
				
				if (0 == $result[0]->cnt || $result[0]->cnt == $result[0]->max)
					continue;

				$results = $wpdb->get_results($wpdb->prepare("
					SELECT ID 
					FROM $wpdb->posts 
					WHERE post_type = '%s' AND post_status IN ('publish', 'pending', 'draft', 'private', 'future') 
					ORDER BY menu_order ASC
				", $object));

				foreach ($results as $key => $result) {
					$wpdb->update($wpdb->posts, array('menu_order' => $key + 1), array('ID' => $result->ID));
				}
			}
		}

		if (!empty($tags)) {
			foreach ($tags as $taxonomy => $taxonomy_data) {
				$result = $wpdb->get_results($wpdb->prepare("
					SELECT count(*) as cnt, max(to_term_order) as max, min(to_term_order) as min 
					FROM $wpdb->terms AS terms 
					INNER JOIN $wpdb->term_taxonomy AS term_taxonomy ON ( terms.term_id = term_taxonomy.term_id ) 
					WHERE term_taxonomy.taxonomy = '%s'
				", $taxonomy));
				
				if (0 == $result[0]->cnt || $result[0]->cnt == $result[0]->max)
					continue;

				$results = $wpdb->get_results($wpdb->prepare("
					SELECT terms.term_id 
					FROM $wpdb->terms AS terms 
					INNER JOIN $wpdb->term_taxonomy AS term_taxonomy ON ( terms.term_id = term_taxonomy.term_id ) 
					WHERE term_taxonomy.taxonomy = '%s' 
					ORDER BY to_term_order ASC
				", $taxonomy));

				foreach ($results as $key => $result) {
					$wpdb->update($wpdb->terms, array('to_term_order' => $key + 1), array('term_id' => $result->term_id));
				}
			}
		}
	}

	function update_menu_order() {
		check_ajax_referer( 'scporder', 'security' );

		global $wpdb;

		parse_str(sanitize_text_field(wp_unslash($_POST['order'])), $data);

		if (!is_array($data))
			return false;

		$id_arr = array();
		
		foreach ($data as $key => $values) {
			foreach ($values as $position => $id) {
				$id_arr[] = $id;
			}
		}

		$menu_order_arr = array();
		
		foreach ($id_arr as $key => $id) {
			$results = $wpdb->get_results("SELECT menu_order FROM $wpdb->posts WHERE ID = " . intval($id));
			foreach ($results as $result) {
				$menu_order_arr[] = $result->menu_order;
			}
		}

		sort($menu_order_arr);

		foreach ($data as $key => $values) {
			foreach ($values as $position => $id) {
				$wpdb->update($wpdb->posts, array('menu_order' => $menu_order_arr[$position]), array('ID' => intval($id)));
			}
		}
	}

	function update_menu_order_tags() {
		check_ajax_referer( 'scporder', 'security' );

		global $wpdb;

		parse_str(sanitize_text_field(wp_unslash($_POST['order'])), $data);

		if (!is_array($data))
			return false;

		$id_arr = array();
		
		foreach ($data as $key => $values) {
			foreach ($values as $position => $id) {
				$id_arr[] = $id;
			}
		}

		$menu_order_arr = array();
		
		foreach ($id_arr as $key => $id) {
			$results = $wpdb->get_results("SELECT to_term_order FROM $wpdb->terms WHERE term_id = " . intval($id));
			foreach ($results as $result) {
				$menu_order_arr[] = $result->to_term_order;
			}
		}
		
		sort($menu_order_arr);

		foreach ($data as $key => $values) {
			foreach ($values as $position => $id) {
				$wpdb->update($wpdb->terms, array('to_term_order' => $menu_order_arr[$position]), array('term_id' => intval($id)));
			}
		}
	}

	function to_scporder_previous_post_where($where) {
		global $post;
		$objects = $this->get_to_scporder_options_objects();
		
		if (empty($objects))
			return $where;

		if (isset($post->post_type) && array_key_exists($post->post_type, $objects)) {
			$current_menu_order = $post->menu_order;
			$where = "WHERE p.menu_order > '" . $current_menu_order . "' AND p.post_type = '" . $post->post_type . "' AND p.post_status = 'publish'";
		}
		
		return $where;
	}

	function to_scporder_previous_post_sort($orderby) {
		global $post;
		$objects = $this->get_to_scporder_options_objects();
		
		if (empty($objects))
			return $orderby;

		if (isset($post->post_type) && array_key_exists($post->post_type, $objects)) {
			$orderby = 'ORDER BY p.menu_order ASC LIMIT 1';
		}
		
		return $orderby;
	}

	function to_scporder_next_post_where($where) {
		global $post;
		$objects = $this->get_to_scporder_options_objects();
		
		if (empty($objects))
			return $where;

		if (isset($post->post_type) && array_key_exists($post->post_type, $objects)) {
			$current_menu_order = $post->menu_order;
			$where = "WHERE p.menu_order < '" . $current_menu_order . "' AND p.post_type = '" . $post->post_type . "' AND p.post_status = 'publish'";
		}

		return $where;
	}

	function to_scporder_next_post_sort($orderby) {
		global $post;
		$objects = $this->get_to_scporder_options_objects();
		
		if (empty($objects))
			return $orderby;

		if (isset($post->post_type) && array_key_exists($post->post_type, $objects)) {
			$orderby = 'ORDER BY p.menu_order DESC LIMIT 1';
		}
		
		return $orderby;
	}

	function to_scporder_pre_get_posts($wp_query) {
		$objects = $this->get_to_scporder_options_objects();
		
		if (empty($objects))
			return false;
		
		if (is_admin()) {
			if (isset($wp_query->query['post_type']) && !isset($_GET['orderby'])) {
				if (array_key_exists($wp_query->query['post_type'], $objects)) {
					$wp_query->set('orderby', 'menu_order');
					$wp_query->set('order', 'ASC');
				}
			}
		} else {
			$active = false;

			if (isset($wp_query->query['post_type'])) {
				if (!is_array($wp_query->query['post_type'])) {
					if (array_key_exists($wp_query->query['post_type'], $objects)) {
						$active = true;
					}
				}
			} else {
				if (array_key_exists('post', $objects)) {
					$active = true;
				}
			}

			if (!$active)
				return false;

			if (isset($wp_query->query['suppress_filters'])) {
				if ($wp_query->get('orderby') == 'date')
					$wp_query->set('orderby', 'menu_order');
				if ($wp_query->get('order') == 'DESC')
					$wp_query->set('order', 'ASC');
			} else {
				if (!$wp_query->get('orderby'))
					$wp_query->set('orderby', 'menu_order');
				if (!$wp_query->get('order'))
					$wp_query->set('order', 'ASC');
			}
		}
	}

	function to_scporder_get_terms_orderby($orderby, $args) {
		if (is_admin())
			return $orderby;

		$tags = $this->get_to_scporder_options_tags();

		if (!isset($args['taxonomy']))
			return $orderby;
 
		$taxonomy = $args['taxonomy'];
		if (is_array($taxonomy) && count($taxonomy) == 1)
			$taxonomy = $taxonomy[0];
		if (!array_key_exists($taxonomy, $tags))
			return $orderby;

		$orderby = 't.to_term_order';
		return $orderby;
	}

	function to_scporder_get_object_terms($terms) {
		$tags = $this->get_to_scporder_options_tags();

		if (is_admin() && isset($_GET['orderby']))
			return $terms;

		foreach ($terms as $key => $term) {
			if (is_object($term) && isset($term->taxonomy)) {
				$taxonomy = $term->taxonomy;
				if (!array_key_exists($taxonomy, $tags))
					return $terms;
			} else {
				return $terms;
			}
		}

		usort($terms, array($this, 'taxcmp'));
		return $terms;
	}

	function taxcmp($a, $b) {
		if ($a->to_term_order == $b->to_term_order)
			return 0;
		
		return ( $a->to_term_order < $b->to_term_order ) ? -1 : 1;
	}

	function get_to_scporder_options_objects() {
		global $to_operators;
		return $to_operators->post_types;
	}

	function get_to_scporder_options_tags() {
		global $to_operators;
		return $to_operators->taxonomies;
	}

}

/**
 * SCP Order Uninstall hook
 */
register_uninstall_hook(__FILE__, 'to_scporder_uninstall');

function to_scporder_uninstall() {
	global $wpdb;
	
	if (function_exists('is_multisite') && is_multisite()) {
		$curr_blog = $wpdb->blogid;
		$blogids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
		
		foreach ($blogids as $blog_id) {
			switch_to_blog($blog_id);
			to_scporder_uninstall_db();
		}

		switch_to_blog($curr_blog);
	} else {
		to_scporder_uninstall_db();
	}
}

function to_scporder_uninstall_db() {
	global $wpdb;
	$result = $wpdb->query("DESCRIBE $wpdb->terms `to_term_order`");
	
	if ($result) {
		$result = $wpdb->query("ALTER TABLE $wpdb->terms DROP `to_term_order`");
	}

	delete_option('to_scporder_install');
}

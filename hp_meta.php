<?php
add_action('admin_menu', 'hp_add_postbox');
add_action('save_post', 'hp_handle_post_save');

function hp_add_postbox() {
	if (hp_is_php5()) {
		add_meta_box('hp_postbox', 'hukdpress Options', 'hp_postbox_post_html', 'post', 'side');
		add_meta_box('hp_postbox', 'hukdpress Options', 'hp_postbox_page_html', 'page', 'side');
	}
}

$render_for = false;
function hp_postbox_page_html() {
	global $render_for;
	$render_for = "page";
	hp_postbox_html();
}
function hp_postbox_post_html() {
	global $render_for;
	$render_for = "post";
	hp_postbox_html();
}
   
function hp_postbox_html() {
	global $render_for;
	global $forums;
	global $cats;
	global $orders;
	include('html/hp_meta_box.php');
}

$first_save = true;
function hp_handle_post_save($post_id) {
	global $first_save;
	if ($first_save) {
		$rev = wp_is_post_revision($post_id);
		if ($rev) $post_id = $rev;
		$first_save = false;
		if (!isset($_POST['hp_secure_nonce'])) return $post_id;
	  if (!wp_verify_nonce($_POST['hp_secure_nonce'], plugin_basename(__FILE__))) return $post_id;
	  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
	  if (!current_user_can('edit_post',$post_id)) return $post_id;

	  if (isset($_POST['action'])) {
	  	$action = $_POST['action'];
	  	if ($action == 'post' || $action == 'editpost') {
  			if (isset($_POST['hp_show_for_post'])) update_post_meta($post_id,'_hp_show_for_post',1); else update_post_meta($post_id,'_hp_show_for_post',0);
  			if (isset($_POST['hp_show_in_post_summary'])) update_post_meta($post_id,'_hp_show_in_post_summary',1); else update_post_meta($post_id,'_hp_show_in_post_summary',0);
  			if (isset($_POST['hp_show_in_post_detail'])) update_post_meta($post_id,'_hp_show_in_post_detail',1); else update_post_meta($post_id,'_hp_show_in_post_detail',0);
  			
  			if (isset($_POST['hp_apiopt_search'])) update_post_meta($post_id,'_hp_apiopt_search',trim($_POST['hp_apiopt_search'])); 
  			
  			if (isset($_POST['hp_apiopt_tag'])) update_post_meta($post_id,'_hp_apiopt_tag',trim($_POST['hp_apiopt_tag'])); 
  			
  			if (isset($_POST['hp_apiopt_forum'])) update_post_meta($post_id,'_hp_apiopt_forum',trim($_POST['hp_apiopt_forum'])); 
  			if (isset($_POST['hp_apiopt_cat'])) update_post_meta($post_id,'_hp_apiopt_cat',trim($_POST['hp_apiopt_cat'])); 
  			if (isset($_POST['hp_apiopt_order'])) update_post_meta($post_id,'_hp_apiopt_order',trim($_POST['hp_apiopt_order'])); 
  			if (isset($_POST['hp_apiopt_include_expired'])) update_post_meta($post_id,'_hp_apiopt_include_expired',trim($_POST['hp_apiopt_include_expired'])); 
  			if (isset($_POST['hp_apiopt_merch'])) {
  				if ($_POST['hp_apiopt_merch'] == "Leave blank for all") $_POST['hp_apiopt_merch'] = "";
  				update_post_meta($post_id,'_hp_apiopt_merch',trim($_POST['hp_apiopt_merch'])); 
  			}
  			
  			if (isset($_POST['hp_disopt_titleoverride'])) update_post_meta($post_id,'_hp_disopt_titleoverride',trim($_POST['hp_disopt_titleoverride']));
  			if (isset($_POST['hp_disopt_usejsscroll'])) update_post_meta($post_id,'_hp_disopt_usejsscroll',1); else update_post_meta($post_id,'_hp_disopt_usejsscroll',0);
  			
  			hp_updateAPICacheForPost($post_id);
  			
	  	}
	  
	  
	  } else {
	  	// Who knows why we'd ever be here, but lets just be safe :)
	  	return $post_id;
	  }
	  
  }
}
?>
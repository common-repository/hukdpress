<?php
add_action('admin_menu', 'hp_admin_menu');
add_action('admin_init', 'register_hp_admin_scripts');
add_action('admin_init', 'hp_clear_cache');
if (!get_option('hp_api_key')) add_action('admin_notices', 'hp_no_apikey');
if (!(isset($_GET['page']) && $_GET['page'] == "hp_configs")) add_action('admin_notices', 'hp_api_key_error');
add_action('admin_notices', 'hp_check_php_ver');

function register_hp_admin_scripts() {
	global $plugin_base;
	$admin_js = $plugin_base."js/hp_admin.js";
	$admin_css = $plugin_base."css/hp_admin.css";
	$colorpicker_js = $plugin_base."js/colorpicker/js/colorpicker.js";
	$colorpicker_css = $plugin_base."js/colorpicker/css/colorpicker.css";
	wp_enqueue_style("hp_admin_css",$admin_css);
	wp_enqueue_script("hp_admin_js",$admin_js,"jquery");
	wp_enqueue_style("hp_colorpicker_css",$colorpicker_css);
	wp_enqueue_script("hp_colorpicker_js",$colorpicker_js,"jquery");
}

function hp_admin_menu() {
	$hp_admin_page = add_options_page('hukdpress Settings', 'hukdpress Settings', 'manage_options', 'hp_configs', 'hp_admin_render');
	add_action('admin_init', 'register_hp_settings' );
}

function hp_validate_apikey() {
	//We're going to see if we have a valid API key.
	global $hukd_api_loc;
	$APIkey = get_option('hp_api_key');
	$APIkey = trim($APIkey);
	update_option('hp_api_key',$APIkey);
	$req = $hukd_api_loc."?key=".$APIkey."&output=json";
	$opts = array('http'=>array('timeout' => 5));
	$context = stream_context_create($opts);
	$res = @file_get_contents($req,false,$context);
	$json = json_decode($res,true);
	update_option('hp_api_key_error',false);
	update_option('hp_api_key_error_msg',false);
	if ($json == NULL) return;
	if (isset($json['error'])) {
		update_option('hp_api_key_error',true);
		update_option('hp_api_key_error_msg',$json['error']);
		hp_api_key_error();
	}
}

function hp_clear_cache() {
	global $wpdb;
	$table_name = $wpdb->prefix . "hp_cache";
	if (get_option('hp_empty_cache',false)) {
		$res = $wpdb->query("TRUNCATE `$table_name`;");
		update_option('hp_empty_cache',false);
		if ($res === NULL) {
			add_action('admin_notices', 'hp_cache_clear_failed');
		} else {
			add_action('admin_notices', 'hp_cache_clear_success');
		}
	}
}

function register_hp_settings() {
	register_setting('hp_core_group', 'hp_api_key');
	register_setting('hp_core_group', 'hp_cache_time');
	register_setting('hp_core_group', 'hp_default_count');
	register_setting('hp_core_group', 'hp_title');
	register_setting('hp_core_group', 'hp_enable_twitter');
	register_setting('hp_core_group', 'hp_scroll_time');
	register_setting('hp_core_group', 'hp_empty_cache');
	
	register_setting('hp_defaults_group', 'hp_use_js');
	register_setting('hp_defaults_group', 'hp_default_forum');
	register_setting('hp_defaults_group', 'hp_default_cat');
	register_setting('hp_defaults_group', 'hp_default_order');
	register_setting('hp_defaults_group', 'hp_default_incexp');
	register_setting('hp_defaults_group', 'hp_default_merchant');
	
	register_setting('hp_style_group', 'hp_disable_curves');
	register_setting('hp_style_group', 'hp_base_color');
	register_setting('hp_style_group', 'hp_base_text_color');
	register_setting('hp_style_group', 'hp_base_row_color');
	register_setting('hp_style_group', 'hp_base_altrow_color');
	register_setting('hp_style_group', 'hp_base_hot_color');
	register_setting('hp_style_group', 'hp_base_cold_color');
}

function hp_admin_render() {
	if (get_option('hp_api_key')) hp_validate_apikey();
	global $forums;
	global $cats;
	global $orders;
	global $hukdpress_version;
  include('html/hp_admin_settings.php');
}

function hp_is_php5() {
	$ver = phpversion();
	$exp = explode('.',$ver);
	if ($exp[0] < 5) return false; else return true;
}

function hp_api_key_error() {
	$error = get_option('hp_api_key_error');
	$msg = get_option('hp_api_key_error_msg');
	if ($error) echo "<div id='hukdpress-warning' class='error'><p><strong>hukdpress requires your attention:</strong> ".sprintf('Your API key appears to be invalid. hotukdeals.com returned the following error: "%s" Please <a href="%s">check your API key</a> to continue using this plugin.', $msg, "options-general.php?page=hp_configs")."</p></div>";
}

function hp_check_php_ver() {
	if (!hp_is_php5()) echo "<div id='hukdpress-warning' class='error'><p><strong>hukdpress requires your attention:</strong> PHP 5 is required to use this plugin. You're running PHP ".phpversion()."</p></div>";
}

function hp_cache_clear_failed() {
	echo "<div id='hukdpress-warning' class='error'><p><strong>Cache Clear Failed:</strong> Unable to empty cache at this time.</p></div>";
}

function hp_cache_clear_success() {
	echo "<div id='hukdpress-warning' class='updated fade'><p><strong>Cache Cleared:</strong> The cache was successfully emptied.</p></div>";
}

function hp_no_apikey() {
	echo "<div id='hukdpress-warning' class='error'><p><strong>hukdpress requires your attention:</strong> ".sprintf('You need to <a href="%1$s">enter your hotukdeals.com API key</a> to use this plugin.', "options-general.php?page=hp_configs")."</p></div>";
}

?>
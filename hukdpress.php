<?php
/*
Plugin Name: hukdpress
Plugin URI: http://code.gladdymedia.com/hukdpress
Description: Automagical display of deals from hotukdeals.com relevant to your post, or requirements. Use of this plugin requires an API key available from hotukdeals.com/rest-api
Version: 1.1
Author: Liam Gladdy (@lgladdy)
Author URI: http://www.gladdymedia.com
License: GPL2
*/


/*  Copyright 2010  Liam Gladdy (GladdyMedia)  (email : liam@gladdy.co.uk)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*
 * Notes:
 * Excuse any bad code, this is the first plugin i've ever written.. Feel free to contact me @lgladdy on teh twitterz.
 *
 * Non Javascript users will always get a cached version, no matter how old that cache is.. unless its over 30 days, then they'll get a non-intrusive notice that we
 * can't display any deals.
 * This is to stop us risking having to contact HUKD for every single view. If someones viewing the homepage and its showing
 * 15 posts, it'd have to talk to hukd 15 times, and with a 5 second timeout, it could take upto 75 seconds.. noone will wait that long!
 *
 * Todo: Internationalization. Seeing as this plugin is really only for UK users, it probably isn't needed, but we'll do it anyway, as its good practise. next release!
 */
 
// Configuration.. You probably shouldn't change this..

// Base setup
wp_enqueue_script("jquery");
add_action('wp_ajax_updateCacheForPost', 'hp_doAJAXCacheUpdate');
add_action('wp_ajax_nopriv_updateCacheForPost', 'hp_doAJAXCacheUpdate');
add_action('widgets_init', 'register_hp_user_scripts');
add_action('init', 'register_hp_tooltips');
add_action('wp_print_scripts','hp_dropin_js_globals');
$plugin_base = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
$hukd_api_loc = "http://api.hotukdeals.com/rest_api/v2/";

// Requires
require_once('hp_admin.php');
require_once('hp_meta.php');
require_once('hp_render.php');

// Hooks
register_activation_hook(__FILE__,'hp_install');

$hukdpress_version = "1.0";

// Globals
$forums = array(
	'deals'=>'Deals',
	'all'=>'All',
	'vouchers'=>'Vouchers',
	'freebies'=>'Freebies',
	'competitions'=>'Competitions',
	'deal-requests'=>'Deal Requests',
	'for-sale-trade'=>'For Sale or Trade',
	'misc'=>'Misc',
	'feedback'=>'Feedback'
);

$cats = array(
	'all'=>'All',
	'clothing'=>'Clothing',
	'computers'=>'Computers',
	'electricals'=>'Electricals',
	'entertainment'=>'Entertainment',
	'finance'=>'Finance',
	'general-deals'=>'General Deals',
	'home'=>'Home',
	'kids'=>'Kids',
	'mobiles'=>'Mobiles',
	'nonsense'=>'Nonsense',
	'travel'=>'Travel'
);

$orders = array(
	'new'=>'Newest',
	'hot'=>'Time Made Hot',
	'discussed'=>'Last Discussed'
);

 
function hp_install() {
	global $wpdb;
	
	$hp_db_ver = "1.0";
	
	$table_name = $wpdb->prefix . "hp_cache";
	
	//Here, we check if the table doesn't exist. Right now, we don't bother checking for upgrades. That'll come when an upgrade is possible.
	
	if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
		
		$create_sql = "CREATE TABLE IF NOT EXISTS `".$table_name."` (
		  `cache_id` INT NOT NULL AUTO_INCREMENT COMMENT 'The auto incrementing ID for the cache entry' ,
		  `cache_search` VARCHAR(255) NOT NULL COMMENT 'The parameter string used in the API call. In later versions, we\'ll probably make this a little more efficient.' ,
		  `cache_time` TIMESTAMP NOT NULL COMMENT 'The timestamp of the call (used for expiring caches)' ,
		  `cache_result` MEDIUMTEXT NULL COMMENT 'The full json encoded result from hukd. Like _search, this can be made more efficient in future.' ,
		  PRIMARY KEY  (`cache_id`) )
			COMMENT = 'This table contains the search cache for hukd, this prevents the excessive API calls on hotukdeals.com for users. The cache timeout is defined in preferences.';";
		
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($create_sql);
		
		update_option('hp_cache_time',1800);
		update_option('hp_db_ver', $hp_db_ver);
		
	}

}

function hp_dropin_js_globals() {
	$row = get_option('hp_base_row_color','#fff');
	$altrow = get_option('hp_base_altrow_color','#eee');
	$scrolltime = get_option('hp_scroll_time',5000);
	if ($row[0] != "#") $row = "#".$row;
	if ($altrow[0] != "#") $altrow = "#".$altrow;
	echo "<script>
	var ajaxurl = '".admin_url('admin-ajax.php')."';
	var rowcolor = '".$row."';
	var altrowcolor = '".$altrow."';
	var scrolltime = '".$scrolltime."';
	</script>";
}

function register_hp_tooltips() {
	global $plugin_base;
	$tips_js = $plugin_base."js/tinytip/jquery.tipTip.minified.js";
	$tips_css = $plugin_base."js/tinytip/tipTip.css";
	wp_enqueue_style("hp_tips_css",$tips_css);
	wp_enqueue_script("hp_tips_js",$tips_js,"jquery");
}

function register_hp_user_scripts() {
	global $plugin_base;
	$user_js = $plugin_base."js/hp_user.js";
	$user_css = $plugin_base."css/hp_user.css.php?".hp_generateColorParams();
	wp_enqueue_style("hp_user_css",$user_css);
	wp_enqueue_script("hp_user_js",$user_js,"jquery");
}

function hp_generateColorParams() {
	$params['basecolor'] = get_option('hp_base_color','#414243');
	$params['basetextcolor'] = get_option('hp_base_text_color','#fff');
	$params['baserowcolor'] = get_option('hp_base_row_color','#fff');
	$params['basealtrowcolor'] = get_option('hp_base_altrow_color','#eee');
	$params['basehotcolor'] = get_option('hp_base_hot_color','#fe2323');
	$params['basecoldcolor'] = get_option('hp_base_cold_color','#577df9');
	$url = "withparams=true";
	foreach ($params as $key => $value) {
		$value = preg_replace('/[^0-9a-fA-F]+/','',$value);
		if (strlen($value) == 3 || strlen($value) == 6) {
			$url .= '&'.$key.'='.urlencode($value);
		}
	}
	return $url;
}

function hp_doAJAXCacheUpdate() {
	if (isset($_POST['post_id'])) {
		$post_id = $_POST['post_id'];
		$res = hp_updateAPICacheForPost($post_id);
		if ($res === false) {
			$return = "fail";
		} else {
			$return = hp_render_for_post('',true,$post_id);
		}
	} else {
		$return = "fail";
	}
	die($return);
}

function hp_updateAPICacheForPost($post_id) {
	global $hukd_api_loc;
	global $wpdb;
	$table_name = $wpdb->prefix . "hp_cache";
	$cachelimit = get_option('hp_cache_time',1800);
	$APIkey = get_option('hp_api_key');
	if ($APIkey == false) return;
	
	$url = hp_buildCacheParamsForPost($post_id);
	
	$params = mysql_real_escape_string($url);
	$res = $wpdb->get_results("SELECT *, UNIX_TIMESTAMP(cache_time) AS cache_unixtime FROM `$table_name` WHERE cache_search = '$params'", ARRAY_A);
	if ($res === false) return false;
	
	$should_delete = false;
	if (count($res) > 0) {
		//If we're here, then we've got an article already stored. Lets see if its valid.
		$cachetime = $res[0]['cache_unixtime'];
		if (time() < ($cachetime + $cachelimit)) {
			//We don't need to bother updating the cache, return!
			return null;
		}
		$should_delete = true;
	}
	
	$req = "?key=".$APIkey."&output=json";
	
	$fullURL = $hukd_api_loc.$req.$url;
	
	$opts = array(
	  'http'=>array(
	    'timeout' => 5
	  )
	);
	
	$context = stream_context_create($opts);
	$results = @file_get_contents($fullURL, false, $context);
	
	if ($results === false) return false;
	
	//Check if we have valid JSON..
	$json = json_decode($results,true);
	if ($json === null) return false;

	
	//Check if we have a total_results set - if not, something is going wrong somewhere, maybe API limit exceeded
	//but seeing as its not documented what happens if you exceed the limit, we can only best guess..
	if (!isset($json['total_results'])) return false;
	
	//If we're here, and we have a cached result, we need to delete the cache first
	//We're sure we have a valid update from hukd.
	//This is cleaner than updating incase theres some race condition creating more than 1 cache entry
	if ($should_delete) {
		$wpdb->query("DELETE FROM `$table_name` WHERE cache_search = '$params'");
	}
	
	//We also should clean up caches older than 30 days. This means noones visited the post for 30 days..
	//We can accept a "Sorry, unable to find deals" message if hukd is down or something after this long
	$wpdb->query("DELETE FROM `$table_name` WHERE cache_time < DATE_SUB(NOW(), INTERVAL 30 DAY)");
	
	
	$db_results = mysql_real_escape_string($results);
	$res = $wpdb->query("INSERT INTO `$table_name` (cache_search, cache_time, cache_result) VALUES ('$params',NOW(),'$db_results')");
	return true;
}

function hp_buildCacheParamsForPost($post_id) {

	$showcount = get_option('hp_default_count',5);
	if ($showcount > 100) {
		update_option('hp_default_count',100);
		$showcount = 100;
	}

	$forum = get_post_meta($post_id,'_hp_apiopt_forum',true);
	$cat = get_post_meta($post_id,'_hp_apiopt_cat',true);
	$order = get_post_meta($post_id,'_hp_apiopt_order',true);
	$include_expired = get_post_meta($post_id,'_hp_apiopt_include_expired',true);
	$merch = get_post_meta($post_id,'_hp_apiopt_merch',true);
	$search = get_post_meta($post_id,'_hp_apiopt_search',true);
	$tag = get_post_meta($post_id,'_hp_apiopt_tag',true);
	
	$url = "&results_per_page=".$showcount;
	if ($forum) $url .= "&forum=".$forum;
	if ($cat) $url .= "&category=".$cat;
	if ($order) $url .= "&order=".$order;
	if ($include_expired == 1) $url .= "&exclude_expired=false"; else $url .= "&exclude_expired=true";
	if (!empty($merch)) $url .= "&merchant=".hp_hukdslugify($merch);
	if (!empty($tag)) $url .= "&tag=".hp_hukdslugify($tag); else if (!empty($search)) $url .= "&search=".urlencode($search);
	
	return ($url);

}

function hp_getDealsFromCache($post_id) {
	global $wpdb;
	$table_name = $wpdb->prefix . "hp_cache";
	$cache_search = hp_buildCacheParamsForPost($post_id);
	$res = $wpdb->get_row("SELECT *, UNIX_TIMESTAMP(cache_time) AS cache_unixtime FROM `$table_name` WHERE cache_search = '$cache_search'", ARRAY_A);
	if ($res === NULL) return false;
	else return $res;
	
}

function hp_hukdslugify($str) {
	$str = strtolower($str);
	$str = preg_replace("/[^0-9a-zA-Z]+/",'-',trim($str));
	return $str;
}


?>
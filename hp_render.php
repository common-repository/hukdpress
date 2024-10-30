<?php
//These functions actually add the hukdpress panel to a post, if required.

add_filter('the_content','hp_render_for_post');

function hp_render_for_post($content,$ajax = false,$post_id = false) {
	if ($post_id === false) {
		global $post;
		$post_id = $post->ID;
	}
	$show = intval(get_post_meta($post_id,'_hp_show_for_post',true));
	if (get_option('hp_api_key_error',false)) $show = false;
	$show_for_page = false;
	if (intval(get_post_meta($post_id,'_hp_show_in_post_summary',true)) && (is_front_page() || is_page())) $show_for_page = true;
	if (intval(get_post_meta($post_id,'_hp_show_in_post_detail',true)) && is_single()) $show_for_page = true;
	
	$disable_curves = get_option('hp_disable_curves',false);
	$enable_twitter = get_option('hp_enable_twitter',false);
	
	if ($show && ($show_for_page || $ajax)) {
		$cache = hp_getDealsFromCache($post_id);
		if (!$ajax) $content .= '<div id="hp_deal_'.$post_id.'" class="hp_container">';
		$content .= '<div class="hp_deal_top">';
		$content .= '<div class="hp_deal_top_left';
		if ($disable_curves) $content .= ' notrans';
		$content .= '">'.get_option('hp_title','Related Deals');
		if (get_post_meta($post_id,'_hp_disopt_titleoverride',true)) $content .= ': '.get_post_meta($post_id,'_hp_disopt_titleoverride',true);
		$content .= '</div>';
		$content .= '<div class="hp_deal_top_right';
		if ($disable_curves) $content .= ' notrans';
		$content .= '"><a href="http://code.gladdymedia.com/hukdpress">hukdpress</a></div>';
		$content .= '</div>';
		$content .= '<div id="hp_deal_set_'.$post_id.'" class="hp_deal_set';
		if (get_post_meta($post_id,'_hp_disopt_usejsscroll',true) == 1) $content .= ' hp_scroll';
		$content .= '">';
		//We obey the cache, BUT if its not cached, we don't. This is sensible, to prevent errors.
		if (!is_array($cache)) {
			hp_updateAPICacheForPost($post_id);
			$cache = hp_getDealsFromCache($post_id);
			if (!is_array($cache)) {
				$content .= '<div class="hp_deal_error">Unable to load deals at this time. Please try again later</div>';
			}
		}
		if (is_array($cache)) {
			$json = json_decode($cache['cache_result'],true);
			$cachetime = $cache['cache_unixtime'];
			
			if (!isset($json['deals']['items'])) {
				$content .= '<div class="hp_deal_error">Unable to load deals at this time. Please try again later</div>';
			} else if (empty($json['deals']['items'])) {
				$content .= '<div class="hp_deal_error">No deals match your search at present. We\'ll keep looking..</div>';
			} else {				
				$json_items = $json['deals']['items'];
				//If the sort is new, we'll sort the results, just as hukd refuses to accept sort if searching for a string
				foreach ($json_items as $ji) {
					$timestamp = $ji['timestamp'];
					//On the off chance we have 2 deals at the same timestamp..
					while (isset($items[$timestamp])) {
						$timestamp .= "-".rand(111,999);
					}
					$items[$timestamp] = $ji;
				}
				krsort($items);
				$alt = true;
				$count = 0;
				foreach ($items as $item) {
					$count++;
					if (($count > 10) && (get_post_meta($post_id,'_hp_disopt_usejsscroll',true) == 1)) break;
					if ($alt) $alt = false; else $alt = true;
					$content .= '<div id="hp_deal_';
					$content .= $post_id."_".$count;
					$content .= '" class="hp_deal';
					if ($alt) $content .= ' altrow';
					$content .= '">';
					$temp = round($item['temperature']);
					if ($temp > 0) $temp_class = "hot"; else $temp_class = "cold";
					$content .= '<div class="hp_deal_left">';
					$content .= '<div class="hp_deal_cost';
					if (floatval($item['price']) >= 1000) $content .= ' largecost'; else if (floatval($item['price']) >= 100) $content .= ' mediumcost';
					$content .= '">';
					if (!empty($item['price'])) $content .= '&pound;'.$item['price'];
					$content .= '</div>';
					$content .= '<div class="hp_deal_temp hp_tip '.$temp_class.'" title="This number (in degrees) is the &quot;temperature&quot; of the deal, as rated by users of hotukdeals.com">'.$temp.'&deg;</div>';
					$content .= '</div>';
					$content .= '<div class="hp_deal_right">';
					$content .= '<div class="hp_deal_title"><a href="'.$item['deal_link'].'">'.$item['title'].'</a></div>';
					$content .= '<div class="hp_deal_info">';
					if (!empty($item['merchant']['url_name'])) {
						$content .= 'Available from <a href="http://www.hotukdeals.com/merchant/'.$item['merchant']['url_name'].'">';
						if (strlen($item['merchant']['name']) > 22) $content .= trim(substr($item['merchant']['name'],0,20))."..."; else $content .= $item['merchant']['name'];
						$content .= '</a>, ';
					}
					$content .= 'posted at '.date('d/m/y g:ia',$item['timestamp']).'</div>';
					if ($enable_twitter) $content .= '<div class="hp_deal_tweet"><a href="http://www.twitter.com?status='.$item['deal_link'].'">&nbsp;&nbsp;&nbsp;&nbsp;</a></div>';
					$content .= '</div>';
					$content .= '</div>';
				}
			}
		}
		$content .= '</div>';
		$content .= '<div class="hp_deal_bottom';
		if ($disable_curves) $content .= ' notrans';
		$content .= '">';
		$content .= '<div class="hp_deal_status';
		if ($disable_curves) $content .= ' notrans';
		$content .= '">';
		if (isset($cachetime)) {
			$content .= '<div class="hp_deal_status_text">Last updated: '.date('d/m/y g:ia',$cachetime).'</div></div>';
		} else {
			$content .= '<div class="hp_deal_status_text">Temporarily Unavailable</div></div>';
		}
		$content .= '<div class="hp_deal_selector"';
		if ($disable_curves) $content .= ' style="padding-top: 3px; background-color: #fff;"';
		$content .= '></div>';
		$content .= '<div class="hp_deal_powered';
		if ($disable_curves) $content .= ' notrans';
		$content .= '">';
		if ($disable_curves) $content .= 'Powered by <a href="http://www.hotukdeals.com">hotukdeals</a>';
		$content .= '</div>';
		$content .= '</div>';
		if (!$ajax) $content .= '</div>';
	}
	return $content;
}

?>
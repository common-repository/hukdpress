<?php
if (isset($_GET['post'])) {
	$pid = $_GET['post'];
} else {
	$pid = false;
}
$file = __FILE__;
$parent_file = str_replace("html/hp_meta_box.php","hp_meta.php",$file);
?>
<input type="hidden" name="hp_secure_nonce" id="hp_secure_nonce" value="<?php echo wp_create_nonce(plugin_basename($parent_file)); ?>" />
<p id="hp_meta_js_warn" class="error">You need Javascript enabled to use the admin interface to this plugin!</p>
<script>document.getElementById("hp_meta_js_warn").style.display = "none";</script>

<div id="hukdpress_container" class="hp_if_js" style="display:none">
	<p class="howto">Hover over any input or checkbox for help</p>
  <input id="hp_show_for_post" class="hp_tip" title="If you enable this checkbox, the hukdpress deals box will appear below your post as per the preferences you enable." type="checkbox" name="hp_show_for_post" <?php if ($pid && (intval(get_post_meta($pid,'_hp_show_for_post',true)))) echo 'checked="true"'; ?>/>
  <label for="hp_show_for_post">Use hukdpress for <?php echo $render_for; ?></label>
  
  <div id="hukdpress_options" style="display:none">
  
  	<div class="hukdpress_opt_sect">
  		<div class="hukdpress_opt_title">Display Settings</div>
			<div class="hukdpress_opt_opt">
				<input id="hp_show_in_post_summary" class="hp_tip" <?php if ($render_for == "post") echo 'title="If you enable this checkbox, the hukdpress deals box will appear below your post on your blog front page"'; else echo 'If you enable this checkbox, the hukdpress deals box will appear at the bottom of this page'; ?> type="checkbox" name="hp_show_in_post_summary" <?php if ($pid && (intval(get_post_meta($pid,'_hp_show_in_post_summary',true)))) echo 'checked="true"'; ?>/>
				<?php if ($render_for == "post") { ?>
					<label for="hp_show_in_post_summary">Show hukdpress in post on front page</label>
				<?php } else { ?>
					<label for="hp_show_in_post_summary">Show hukdpress on page</label>
				<?php } ?>
			</div>
			<?php if ($render_for == "post") { ?>
			<div class="hukdpress_opt_opt">
				<input id="hp_show_in_post_detail" class="hp_tip" title="If you enable this checkbox, the hukdpress deals box will on any page which shows the single post (such as a perma-link)" type="checkbox" name="hp_show_in_post_detail" <?php if ($pid && (intval(get_post_meta($pid,'_hp_show_in_post_detail',true)))) echo 'checked="true"'; ?>/>
				<label for="hp_show_in_post_detail">Show hukdpress in <?php echo $render_for; ?> single page</label>
			</div>
			<?php } ?>
  	</div>
  
  	<div class="hukdpress_opt_sect">
  		<div class="hukdpress_opt_title">Search words or tag</div>
  		<div class="hukdpress_opt_opt">
				<label for="hp_apiopt_tag">Tag</label>
				<input type="text" class="hp_tip" title="You need to enter a single tag to search hotukdeals for. This is often better than search words due to speed and the ability to sort results" id="hp_apiopt_tag" style="width:99%" name="hp_apiopt_tag"<?php if ($pid && get_post_meta($pid,'_hp_apiopt_tag',true)) echo ' value="'.get_post_meta($pid,'_hp_apiopt_tag',true).'"'; ?>/>
			</div>
  		<div class="hukdpress_opt_opt">
				<label for="hp_apiopt_search">Search words</label>
				<input type="text" class="hp_tip" title="You need to enter a word, or phrase to search hotukdeals for. Use of this option disables the 'sort order' option below" id="hp_apiopt_search" style="width:99%" name="hp_apiopt_search"<?php if ($pid && get_post_meta($pid,'_hp_apiopt_search',true)) echo ' value="'.get_post_meta($pid,'_hp_apiopt_search',true).'"'; ?>/>
			</div>
  		<div class="hukdpress_note">You need to enter either a tag, <span style='text-weight:bold'>OR</span> a search word or phrase.<br /><br />Tag take precendence over search words.<br /><br />If you use search words, the 'order' setting below is ignored.</div>
  	</div>
  
  	<div class="hukdpress_opt_sect">
  		<div class="hukdpress_opt_title">Display Settings</div>
  		
			
			<div class="hukdpress_opt_opt">
				<input id="hp_disopt_usejsscroll" class="hp_tip" title="If you enable this checkbox, the hukdpress deals box will be much shorter, and cycle through deals automatically, according to the delay configured in hukdpress' settings" type="checkbox" name="hp_disopt_usejsscroll" <?php if ((!$pid && get_option('hp_use_js',true)) || ($pid && (intval(get_post_meta($pid,'_hp_disopt_usejsscroll',true))))) echo 'checked="true"'; ?>/>
				<label for="hp_disopt_usejsscroll">Use Javascript to scroll through deals</label>
			</div>
  		
			<div class="hukdpress_opt_opt">
				<input type="text" class="hp_tip" title="If you wish to append a subtitle to the main title configured in hukdpress' settings, enter it here" id="hp_disopt_titleoverride" name="hp_disopt_titleoverride"<?php if ($pid && get_post_meta($pid,'_hp_disopt_titleoverride',true)) echo ' value="'.get_post_meta($pid,'_hp_disopt_titleoverride',true).'"'; ?>/>
				<label for="hp_apiopt_titleoverride">Box subtitle</label>
			</div>
			
		</div>
		
  
  	<div class="hukdpress_opt_sect">
  		<div class="hukdpress_opt_title">Advanced Settings</div>
  		
  		
			<div class="hukdpress_opt_opt">
				<select id="hp_apiopt_forum" class="hp_tip" title="This limits the 'forums' which are searched. Check hotukdeals.com for a better explaination of how the forums work" type="checkbox" name="hp_apiopt_forum">
					<?php
					foreach ($forums as $forumslug => $forumname) {
						echo '<option value="'.$forumslug.'"';
						if ((!$pid && (get_option('hp_default_forum','deals') == $forumslug)) || ($pid && (get_post_meta($pid,'_hp_apiopt_forum',true) == $forumslug))) echo ' selected="true"';
						echo '>'.$forumname.'</option>';
					}
					?>
				</select>
				<label for="hp_apiopt_forum">Area to search</label>
			</div>
  		
			<div class="hukdpress_opt_opt">
				<select id="hp_apiopt_cat" class="hp_tip" title="This limits the 'categories' which are searched. Check hotukdeals.com for a better explaination of how the categories work" type="checkbox" name="hp_apiopt_cat">
					<?php
					foreach ($cats as $catslug => $catname) {
						echo '<option value="'.$catslug.'"';
						if ((!$pid && (get_option('hp_default_cat','all') == $catslug)) || ($pid && (get_post_meta($pid,'_hp_apiopt_cat',true) == $catslug))) echo ' selected="true"';
						echo '>'.$catname.'</option>';
					}
					?>
				</select>
				<label for="hp_apiopt_cat">Category to search</label>
			</div>
  		
			<div class="hukdpress_opt_opt">
				<select id="hp_apiopt_order" class="hp_tip" title="This changes the order in which search results are found. Due to the API limitations of hotukdeals.com, this option won't work if properly if you use search words above" type="checkbox" name="hp_apiopt_order">
					<?php
					foreach ($orders as $orderslug => $ordername) {
						echo '<option value="'.$orderslug.'"';
						if ((!$pid && (get_option('hp_default_order','new') == $orderslug)) || ($pid && (get_post_meta($pid,'_hp_apiopt_order',true) == $orderslug))) echo ' selected="true"';
						echo '>'.$ordername.'</option>';
					}
					?>
				</select>
				<label for="hp_apiopt_order">Sorting order</label>
			</div>
			
  		
			<div class="hukdpress_opt_opt">
				<select id="hp_apiopt_include_expired" class="hp_tip" title="Do you want to include deals which are marked as expired?" type="checkbox" name="hp_apiopt_include_expired">
					<?php
					$incexps = array(
						'0'=>'No',
						'1'=>'Yes'
					);
					foreach ($incexps as $incexpslug => $incexpname) {
						echo '<option value="'.$incexpslug.'"';
						if ((!$pid && (get_option('hp_default_incexp','0') == $incexpslug)) || ($pid && (get_post_meta($pid,'_hp_apiopt_include_expired',true) == $incexpslug))) echo ' selected="true"';
						echo '>'.$incexpname.'</option>';
					}
					?>
				</select>
				<label for="hp_apiopt_include_expired">Include expired posts</label>
			</div>
			
			<div class="hukdpress_opt_opt">
				<input type="text" id="hp_apiopt_merch" class="hp_tip" title="Enter a merchant name if you only want to search their deals. Check hotukdeals.com for the correct merchant name, this will be something like 'amazon-uk'" name="hp_apiopt_merch"<?php
				$def_merch = get_option('hp_default_merchant',false);
				if (!$pid && !empty($def_merch)) {
					echo ' value="'.$def_merch.'"';
				} else if ($pid && get_post_meta($pid,'_hp_apiopt_merch',true)) echo ' value="'.get_post_meta($pid,'_hp_apiopt_merch',true).'"'; ?>/>
				<label for="hp_apiopt_merch">Merchant</label>
			</div>
			
	
  	</div>
  	
  </div>
  
</div>
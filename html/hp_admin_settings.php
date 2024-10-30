<div class="wrap">
	<div id="icon-options-general" class="icon32"><br /></div>
	<h2>hukdpress Plugin Settings</h2>
	<p style="font-weight:bold">Please note: The "Save Changes" button will only save the changes for that section of options.<br />Make sure you save changes for each section as you go - any others will be lost.</p>
	<p>Your API key is validated each time you visit this page.</p>
	<h3>Core Settings</h3>
	<form method="post" action="options.php">
    <?php settings_fields('hp_core_group'); ?>
    
    <table class="form-table">
        <tr valign="top">
        	<th scope="row">hotukdeals.com API Key</th>
        	<td>
        		<input type="text" name="hp_api_key" style="width:250px" value="<?php echo get_option('hp_api_key'); ?>" />
        		<span class="description">You can get this from <code><a href='http://www.hotukdeals.com/rest-api'>http://www.hotukdeals.com/rest-api</a></code></span>
        	</td>
        </tr>
         
        <tr valign="top">
        	<th scope="row">hukdpress box title</th>
        	<td>
        		<input type="text" name="hp_title" value="<?php echo get_option('hp_title','Related Deals'); ?>" />
        		<span class="description">The title text used on the hukdpress box, default is <code>Related Deals</code>.</span>
        	</td>
        </tr>
         
        <tr valign="top">
        	<th scope="row">Number of deals to display</th>
        	<td>
        		<input type="text" name="hp_default_count" value="<?php if (get_option('hp_default_count',5) > 100) echo '100'; else echo get_option('hp_default_count',5); ?>" />
        		<span class="description">The number of items to show per search, default is <code>5</code>.<br />Please note: If you use the "JS Scroll" option, the maximum number of deals displayed will be 10</span>
        	</td>
        </tr>
         
        <tr valign="top">
        	<th scope="row">Maximum cache time</th>
        	<td>
        		<input type="text" name="hp_cache_time" value="<?php echo get_option('hp_cache_time',1800); ?>" />
        		<span class="description">In seconds, default is <code>1800</code>.<br />This value defines how long deals will be cached. Depending on how busy you are expecting your site to be, you can tweak this setting to prevent yourself exceeding the API call limit.</span>
        	</td>
        </tr>
         
        <tr valign="top">
        	<th scope="row">JS Scroll Waittime</th>
        	<td>
        		<input type="text" name="hp_scroll_time" value="<?php echo get_option('hp_scroll_time',5000); ?>" />
        		<span class="description">In milliseconds, default is <code>5000</code>.<br />This value defines how long, when in Javascript scolling mode, each deal will be displayed before moving to the next one</span>
        	</td>
        </tr>
         
        <tr valign="top">
        	<th scope="row">Enable Twitter</th>
        	<td>
        		<input type="checkbox" name="hp_enable_twitter"<?php if (get_option('hp_enable_twitter',true)) echo ' checked="true"'; ?> />
        		<span class="description">Default is <code>enabled</code>.<br />Adds a small twitter icon on each deal which allows the user to post a link to the deal on twitter.</span>
        	</td>
        </tr>
         
        <tr valign="top">
        	<th scope="row">Empty Cache</th>
        	<td>
        		<input type="checkbox" name="hp_empty_cache" />
        		<span class="description" style="font-weight:bold"><br />WARNING: You probably never want to check this. It'll delete everything in your cache, and mean the next person to visit your blog has to wait for these things to load. Only do this if everything is broken and you need a last resort!</span>
        	</td>
        </tr>
    
    </table>
    
    <p class="submit">
    	<input type="submit" class="button-primary" value="Save Changes" />
    </p>
    
	</form>

	<hr />
	<h3>Default Settings</h3>
	<p>All these setting can be over-ridden on a per post basis, these are just the default populated for you to save time</p>
	<form method="post" action="options.php">
    <?php settings_fields('hp_defaults_group'); ?>
    
    <table class="form-table">
        <tr valign="top">
        	<th scope="row">Use Javascript scrolling display</th>
        	<td>
        		<input type="checkbox" name="hp_use_js"<?php if (get_option('hp_use_js',true)) echo ' checked="true"'; ?> />
        		<span class="description">Default is <code>true</code>.</span>
        	</td>
        </tr>
        
        <tr valign="top">
        	<th scope="row">Default forum</th>
        	<td>
        		<select name="hp_default_forum">
        		<?php
        		foreach ($forums as $forumslug => $forumname) {
							echo '<option value="'.$forumslug.'"';
							if (get_option('hp_default_forum','deals') == $forumslug) echo ' selected="true"';
							echo '>'.$forumname.'</option>';
						}
						?>
						</select>
        		<span class="description">Default is <code>Deals</code>.</span>
        	</td>
        </tr>
        
        <tr valign="top">
        	<th scope="row">Default category</th>
        	<td>
        		<select name="hp_default_cat">
        		<?php
        		foreach ($cats as $catslug => $catname) {
							echo '<option value="'.$catslug.'"';
							if (get_option('hp_default_cat','all') == $catslug) echo ' selected="true"';
							echo '>'.$catname.'</option>';
						}
						?>
						</select>
        		<span class="description">Default is <code>All</code>.</span>
        	</td>
        </tr>
        
        <tr valign="top">
        	<th scope="row">Default order</th>
        	<td>
        		<select name="hp_default_order">
        		<?php
        		foreach ($orders as $orderslug => $ordername) {
							echo '<option value="'.$orderslug.'"';
							if (get_option('hp_default_order','new') == $orderslug) echo ' selected="true"';
							echo '>'.$ordername.'</option>';
						}
						?>
						</select>
        		<span class="description">Default is <code>Newest</code>.</span>
        	</td>
        </tr>
        
        
        <tr valign="top">
        	<th scope="row">Include expired posts</th>
        	<td>
        		<select name="hp_default_incexp">
        			<option value='0'<?php if (get_option('hp_default_incexp','0') == '0') echo ' selected="true"'; ?>>No</option>
        			<option value='1'<?php if (get_option('hp_default_incexp','0') == '1') echo ' selected="true"'; ?>>Yes</option>
						</select>
        		<span class="description">Default is <code>No</code>.</span>
        	</td>
        </tr>
        
        
        <tr valign="top">
        	<th scope="row">Default merchant</th>
        	<td>
        		<input type="text" name="hp_default_merchant" value="<?php echo get_option('hp_default_merchant',''); ?>" />
        		<span class="description">Default is <code>[blank]</code>.<br />This option should be left blank, unless you want to restrict deals to only one merchant. This option needs to be valid, or you won't get any deals found. Use <a href="http://www.hotukdeals.com">hotukdeals.com</a> to find a merchant page and get the correct merchant name from the URL. It will look something like 'amazon-uk'</span>
        	</td>
        </tr>
        
        
        
    
    </table>
    
    <p class="submit">
    	<input type="submit" class="button-primary" value="Save Changes" />
    </p>
    
	</form>
	
	<hr />
	<h3>Style and Theme Settings</h3>
	<p>All other style settings are automatically inherited from your chosen theme automagically</p>
	<form method="post" action="options.php">
    <?php settings_fields('hp_style_group'); ?>
    
    <table class="form-table">
         
        <tr valign="top">
        	<th scope="row">Use basic mode / Disable curved edges</th>
        	<td>
        		<select name="hp_disable_curves">
        			<option value='0'<?php if (intval(get_option('hp_disable_curves','0')) == 0) echo ' selected="true"'; ?>>No</option>
        			<option value='1'<?php if (intval(get_option('hp_disable_curves','0')) == 1) echo ' selected="true"'; ?>>Yes</option>
        		</select>
        		<span class="description">Default <code>No</code><br />If you're using a theme which doesn't have a white background, or your theme breaks the curved edges (such as Mystique 2.1) then the curved edges of the hukdpress box will look strange. If you select 'Yes', the box will have square corners and a more basic feel.</span>
        	</td>
        </tr>
        
        <tr valign="top">
        	<th scope="row">Border / Top & Bottom Background Colour</th>
        	<td>
        		<input type="text" id="hp_base_color" class="hp_with_colorpicker" name="hp_base_color" value="<?php echo get_option('hp_base_color','#414243'); ?>" />
        		<span class="description">A valid hex color string with preceeding #, default is <code>#414243</code></span>
        	</td>
        </tr>
        
        <tr valign="top">
        	<th scope="row">Text colour for header and footer</th>
        	<td>
        		<input type="text" id="hp_base_text_color" class="hp_with_colorpicker" name="hp_base_text_color" value="<?php echo get_option('hp_base_text_color','#fff'); ?>" />
        		<span class="description">A valid hex color string with preceeding #, default is <code>#fff</code></span>
        	</td>
        </tr>
        
        <tr valign="top">
        	<th scope="row">Background colour for non-alternated row</th>
        	<td>
        		<input type="text" id="hp_base_row_color" class="hp_with_colorpicker" name="hp_base_row_color" value="<?php echo get_option('hp_base_row_color','#fff'); ?>" />
        		<span class="description">A valid hex color string with preceeding #, default is <code>#fff</code></span>
        	</td>
        </tr>
        
        <tr valign="top">
        	<th scope="row">Background colour for alternated row</th>
        	<td>
        		<input type="text" id="hp_base_altrow_color" class="hp_with_colorpicker" name="hp_base_altrow_color" value="<?php echo get_option('hp_base_altrow_color','#eee'); ?>" />
        		<span class="description">A valid hex color string with preceeding #, default is <code>#eee</code></span>
        	</td>
        </tr>
        
        <tr valign="top">
        	<th scope="row">Text color for hot temperatures</th>
        	<td>
        		<input type="text" id="hp_base_hot_color" class="hp_with_colorpicker" name="hp_base_hot_color" value="<?php echo get_option('hp_base_hot_color','#fe2323'); ?>" />
        		<span class="description">A valid hex color string with preceeding #, default is <code>#fe2323</code></span>
        	</td>
        </tr>
        
        <tr valign="top">
        	<th scope="row">Text color for cold temperatures</th>
        	<td>
        		<input type="text" id="hp_base_cold_color" class="hp_with_colorpicker" name="hp_base_cold_color" value="<?php echo get_option('hp_base_cold_color','#577df9'); ?>" />
        		<span class="description">A valid hex color string with preceeding #, default is <code>#577df9</code></span>
        	</td>
        </tr>
    
    </table>
    
    <p class="submit">
    	<input type="submit" class="button-primary" value="Save Changes" />
    </p>
    
	</form>
	
	<p>hukdpress uses icons from the creative commons licensed komodomedia social network icon pack, available from <a href='http://www.komodomedia.com/download/#social-network-icon-pack'>komodomedia.com</a></p>
	<p>You're using version <?php echo $hukdpress_version; ?> of hukdpress, from <a href="http://code.gladdymedia.com">GladdyMedia</a>.<br />This is an open source project licensed under a GPLv2 License, or, if you prefer, a <a href="http://creativecommons.org/licenses/by-sa/2.0/uk/">Creative Commons Attribution-Share Alike 2.0 UK: England &amp; Wales License</a>.<br />
	<a rel="license" href="http://creativecommons.org/licenses/by-sa/2.0/uk/"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-sa/2.0/uk/80x15.png" /></a></p>
</div>
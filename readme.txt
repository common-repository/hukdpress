=== Plugin Name ===
Contributors: lgladdy
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=M4RT8SR5XZ2XE
Tags: hotukdeals, deals, products, finder
Requires at least: 2.8
Tested up to: 2.9.2
Stable tag: 1.1

Automagical display of deals from hotukdeals.com on your post or page. Requires a free API key available from hotukdeals.com/rest-api

== Description ==

hukdpress (pronounced hucked-press, or something similar), is a magical, shiny and some even say mystical wordpress
plugin that uses the API from the *awesome* guys at hotukdeals.com.

The plugin appends to any post, or page you want, a list of deals sourced from hotukdeals.com which match some criteria which
you specify on a per-post basis. It's great for showing the best prices or latest offers on the subject of your post or page.

Now, to use this plugin, you need to apply for an API key directly from [hotukdeals.com](http://www.hotukdeals.com/rest-api),
but thats cool. It's totally *free*.

Now, lets give the bad news before the good news. The plugin will work fine on IE6, but might look ugly because of pretty
transparency used all over the place. All other modern browsers are supported. Maybe even lynx, but thats up to you to try.

Features:

*   Full non-javascript support for the odd people who don't use it.
*   Full support of all the aspects of the hotukdeals.com API.
*   Restrict your searches to various categories of hotukdeals.com
*   Cache! Everything is cached (if you want..) to stop you hitting you API limit if you have thousands of viewers.
*   Javascript enabled users unknowingly handle updating the cache by AJAX, so there are no slowdowns in page loads.
*   "Basic" mode disables all the pretty curves in case your theme doesn't look good with the default settings.
*   Configuration of colours, scrolling wait times, number of deals, areas to search.. pretty much everything.
*   Optional integration with twitter means your viewers can tweet deals they find via. your site.
*   Automagic validation of your API key upon entry.

Requirements:

*   Requires wordpress 2.8 thanks to everything thats shiny and new and makes this stuff easier
*   Any version of PHP 5

For what its worth, this is my first wordpress plugin. But don't hold that against it - it's actually pretty neat,
and you know, works, which is a huge plus.


== Installation ==

You have two options. The easiest is to use automagic plugin installation inside wordpress. To do that:

1. Go to the administration site of your blog
1. Click plugins
1. Click "Add New"
1. Search for "hukdpress", then click install!

Alternatively, grab the archive, extract and put the hukdpress folder in /wp-content/plugins/, or, in detail:

1. Download the plugin (zip file) using the link on the right.
1. Extract the contents so you end up with a "hukdpress" folder
1. Upload that whole folder (not just the contents) to /wp-content/plugins/
1. Go to your blogs administration site, click plugins, then "Activate" on hukdpress

== Frequently Asked Questions ==

= My theme background isn't white =

You have two options. You can either edit the images yourself, or if you just want to hit one button and fix it,
enable "basic mode" in the administration settings!

= Where can I find more information? =

We have a proper actual website, you can find it at [http://code.gladdymedia.com/hukdpress](http://code.gladdymedia.com/hukdpress)

= How do I contact you? =

Twitter is the best plan, [@lgladdy](http://twitter.com/lgladdy). Alternatively, you could email
liam[at]gladdymedia.com. I'm happy to support and fix and bugs you find :)

== Screenshots ==

1. This is where you find hukdpress when you create, or edit a post or page.
2. hukdpress's post/page configuration options
3. The default display mode of the hukdpress box
4. The non-javascript version of the hukdpress box
5. A customized version of the hukdpress box (Blue!)
6. The basic (but very compatible) version of the hukdpress box
7. The first page of the hukdpress admin settings
8. The second page of the hukdpress admin settings


== Changelog ==

= 1.1 =
* Added detection of invalid API key (which disables all hukdpress boxes and shows an admin warning)

= 1.0.4 =
* Updating installation instructions

= 1.0.3 = 
* One more update to refresh the wordpress plugin directory with various changes now the code lives here

= 1.0.2 =
* Switches to wordpress hosting for the plugin and updates readme.txt accordingly. No new features

= 1.0.1 =
* Adds a requirement for PHP 5 (it didn't work on PHP 4 before anyway, but now it tell you)
* Improved handling of deals without merchant or prices (from other categories)

= 1.0 =
* Initial release! Yay.

== Upgrade Notice ==

= 1.1 =
No problems expected with upgrades

= 1.0.4 =
No issues at all with upgrading. No core files are changed.

= 1.0 =
Initial release

== TODOs ==

*   Internationalization: Despite this being a uk-based widget, the next version will add localization support.
=== Easy Spoiler ===

Contributors: dyerware
Donate link: http://www.dyerware.com/main/products/easy-spoiler/easy-spoiler-plugin-for-wordpress.html
Tags: spoiler,hint,tip,answer,hidden,hide,mobile,shortcode,dyerware
Requires at least: 2.8
Tested up to: 2.9.1
Stable tag: 0.2.1

This plugin allows you to easily create a container for a spoiler within your blog by use of shortcodes.  It works in pages, posts, comments, and widgets.


== Description ==

This plugin allows you to easily insert spoilers into your blog, making use shortcodes. An attractive container containing a hint to its content is created with a show/hide button.  The container may contain other shortcodes within it.  

You can use this shortcode inside 
 * pages
 * posts
 * comments
 * widgets

Note that if you use it within comments, it is smart enough to not expand embedded shortcakes as this would allow end-users posting comments to invoke any of your site's shortcodes.

It also ensure that it does not turn on any shortcode within widgets and comments, but only itself.

PHP5 Required.

The shortcode format is:

**[spoiler title="Secret location of the code"]It's in the dresser[/spoiler]**

For a complete example and more detailed documentation, visit the plugin home page.  If you do not understand these instructions, please ask questions in the comments section on the plugin home page.  We will be more than happy to answer them.

Go here for up-to-date usage and examples:
[EasySpoiler Tutorial](http://www.dyerware.com/main/products/easy-spoiler/easy-spoiler-plugin-for-wordpress.html "EasySpoiler Tutorial")


== Installation ==

1. Verify that you have PHP5, which is required for this plugin.

2. Upload the `easy-spoiler` directory to the `/wp-content/plugins/` directory

3. Activate the plugin through the 'Plugins' menu in WordPress

Now you can insert the shortcodes within your posts and pages.


== Frequently Asked Questions ==

For an up-to-date FAQ, please visit:
[EasySpoiler FAQ](http://www.dyerware.com/main/products/easy-spoiler/easy-spoiler-faq.html "EasySpoiler FAQ")

== Screenshots ==

1. A plain spoiler, closed

2. A spoiler with title hint, opened

3. A spoiler with custom intro, title hint, and complex contents (in this case, easy chart builder) 


== Upgrade Notice ==

= 0.2.1 =
Now supports being embedded within comments and widgets.

= 0.1 =
First version


== Changelog ==

= 0.2.1 =

 * Can be inserted within comments, and within widgets.  Comment insertion prevents embedded shortcode expansion (i.e. if the spoiler itself contains other shortcodes, they will not be expanded) to prevent security concerns by end-users.

= 0.1 =

 * First public release

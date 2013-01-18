=== Easy Spoiler ===

Contributors: dyerware
Donate link: http://www.dyerware.com/main/products/easy-spoiler/easy-spoiler-plugin-for-wordpress.html
Tags: spoiler,hint,tip,answer,hidden,hide,mobile,shortcode,dyerware
Requires at least: 2.8
Tested up to: 3.5
Stable tag: 1.9

This plugin allows you to create a container for spoilers within pages, posts, comments, and widgets.  Also supports spoiler groups.

== Description ==

This plugin allows you to easily create spoilers with a shortcode. An attractive, animated container with a hint to its content and a show/hide button are created.   Admin control panel allow you to tailor various aspects and colors of the spoiler.

Toolbar buttons are (optionally) added to the HTML editor to make adding spoilers in your posts very easy.  Just highlight the HTML you want hidden and click on 'spoiler'.  Or, highlight a series of spoilers and click on 'spoiler group' for the grouping effect.

You can put spoilers within
 
 * pages
 * posts
 * comments
 * widgets

Note that if you use it within comments, it is smart enough to not expand embedded shortcodes as this would allow end-users posting comments to invoke any of your site's shortcodes.

An administrator page allows you to configure various settings.

PHP5 Required.

The shortcode format is:

**[spoiler title="Secret location of the code"]It's in the dresser[/spoiler]**

For a complete example and more detailed documentation, visit the plugin home page.  If you do not understand these instructions, please ask questions in the comments section on the plugin home page.  We will be more than happy to answer them.

There are a lot of options including colors, controls, and animation behavior.

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

4. A spoiler group

== Upgrade Notice ==

= 1.9 =
 * Fix: some CSS hardening against aggressive wordpress themes

= 1.8 =
 * Fix for Wordpress 3.3+ editor buttons

= 1.7 =
 * Support for Right-to-Left languages and format.  Option is located on admin panel under 'global defaults'.
 * Support to use your theme's native text color for spoiler title and button text when using easyspoiler's native theme.
   Note this feature is ignored if you have enabled custom colors.  The button and title theme enable options are located
   on the admin panel in title and button options, respectively.
 
= 1.6.3 =
 * Fix for fireFox issue with spoilergroups causing a reload of the page when opened.

= 1.6.2 =
 * Fix for fireFox show button not changing to 'hide'
 * Fix for spoiler group aesthetics where padding was incorrect
 * Removed dashed inner border

= 1.6 =
 * You can now embed shortcodes within the spoiler title via a new enable/disable checkbox on the admin panel.  Note you cannot use the angular brackets.  Rather, you use parens: (myshortcode)xxx(/myshortcode).  You can replace the use of parens with something else in the admin panel as well.

= 1.5 =
 * Brought back original button style
 * The 'flat' option for buttons is available with button style option on admin panel
 * Can style the title (font size, bold options) using admin panel
 * Some style bug-fixes with the buttons

= 1.1 =
 * Flat, more subtle buttons
 * Option for using title as the show/hide toggle now changes mouse pointer to indicate it is an actionable area
 * Improved iframe support
 * new select button option which will provide a 'select' button on the title bar for auto-selecting the 
   spoiler content.
 * Admin option to enable/disable select button feature and to configure the text of the select button

= 1.0 =
 * You can now configure the titlebar to be the open/close button.
 * The speed of the spoiler open/close animations can now be customized.
 * New option to force-refresh iframes if they are within a spoiler and you have issues with them.
 * Editor button fixes for WP3.1

= 0.7 =
 * Some CSS tweaks to help with more aggressive themes

= 0.6 =
 * Added new theme color helpers in admin menu.  Easy configuration of several color attributes.
 * W3C HTML validation of the generated output.

= 0.5 =
 * Added HTML editor integration.  You can turn off the buttons via a new admin panel option.

= 0.4.2=
 * Small admin panel bugfix, and link to support form in admin panel

= 0.4.1=
 * Empty function call fix

= 0.4 =
 * New admin page for configuration.  New customization of button text.  New animations.

= 0.3 =
 * Group support: Cluster related spoilers together for graphical and functional grouping.

= 0.2.1 =
 * Now supports being embedded within comments and widgets.

= 0.1 =
 * First version


== Changelog ==

= 1.9 =
 * Fix: some CSS hardening against aggressive wordpress themes
 
= 1.8 =
 * Fix for Wordpress 3.3+ editor buttons

= 1.7 =
 * Support for Right-to-Left languages and format.  Option is located on admin panel under 'global defaults'.
 * Support to use your theme's native text color for spoiler title and button text when using easyspoiler's native theme.
   Note this feature is ignored if you have enabled custom colors.  The button and title theme enable options are located
   on the admin panel in title and button options, respectively.
   
= 1.6.3 =
 * Fix for fireFox issue with spoilergroups causing a reload of the page when opened.
 
= 1.6.2 =
 * Fix for fireFox show button not changing to 'hide'
 * Fix for spoiler group aesthetics where padding was incorrect
 * Removed dashed inner border

= 1.6 =
 * You can now embed shortcodes within the spoiler title via a new enable/disable checkbox on the admin panel.  Note you cannot use the angular brackets.  Rather, you use parens: (myshortcode)xxx(/myshortcode).  You can replace the use of parens with something else in the admin panel as well.

= 1.5 =
 * Brought back original button style
 * The 'flat' option for buttons is available with button style option on admin panel
 * Can style the title (font size, bold options) using admin panel
 * Some style bug-fixes with the buttons

= 1.1 =
 * Flat, more subtle buttons
 * Option for using title as the show/hide toggle now changes mouse pointer to indicate it is an actionable area
 * Improved iframe support
 * new select button option which will provide a 'select' button on the title bar for auto-selecting the 
   spoiler content.
 * Admin option to enable/disable select button feature and to configure the text of the select button

= 1.0 =
 * You can now configure the titlebar to be the open/close button.
 * The speed of the spoiler open/close animations can now be customized.
 * New option to force-refresh iframes if they are within a spoiler and you have issues with them.
 * Editor button fixes for WP3.1

= 0.7 =
 * Some CSS tweaks to help with more aggressive themes

= 0.6 =
 * Added new theme color helpers in admin menu.  Easy configuration of several color attributes.
 * W3C HTML validation of the generated output.

= 0.5 =
 * Added HTML editor integration.  You can turn off the buttons via a new admin panel option.

= 0.4.2 =
 * Small admin panel bugfix
 * Link to support form in admin panel

= 0.4.1 =
 * Empty function call removed

= 0.4 =
 * New admin config page where you can assign your own default shortcode values
 * Override the show/hide text of the spoiler buttons
 * Animations during open/close.  You can turn them off if desired.

= 0.3 =
 * With the new optional spoilergroup tag you can enclose multiple spoiler tags together.  Easy Spoiler will visually group them and auto-close any related spoiler when the user opens another from the same group.

= 0.2.1 =
 * Can be inserted within comments, and within widgets.  Comment insertion prevents embedded shortcode expansion (i.e. if the spoiler itself contains other shortcodes, they will not be expanded) for security concerns.

= 0.1 =
 * First public release

=== WPMS Sidebar Login Widget ===
Contributors: parkerj
Author: Joshua Parker
Tags: wpmu, wpms, widget, login, multisite
Requires at least: 2.8
Tested up to: 3.3.1
Stable tag: 1.9.4

Adds a sidebar widget to the main site of a WPMU/WPMS install.

== Description ==

If you are running a WPMS (Multisite) blogging network, the issue with most login widgets that you add to the main site’s sidebar is that it doesn’t pull the user’s own blog info. That is why the WPMS Sidebar Login Widget was created. Instead of the user trying to remember the login page of their own site/blog, when a user logs into your main site, the widget will conveniently contain links to navigate to 3 different pages of the user's blog: dashboard, new post page, and profile page.

Features:

* Link to Network Admin page (only shows if user logged in is a super admin)
* Link to user's dashboard
* Link to user's new post page
* Link to user's profile page
* Link to forums page
* Subblog registration detection
* Custom CSS settings

To make sure it works, activate the <a href="http://wordpress.org/extend/plugins/user-switching/">User Switching</a> plugin on the main site only to switch to a different user.


== Installation ==

<b>Important Note: If you are using the subscribe users to main blog plugin mentioned on my <a href="http://www.joshparker.us/blog/wordpress/wpms_sidebar_login_widget.html">website</a>, deactivate it, for it has been integrated into this plugin.</b>

-- Wordpress Standalone
1. Extract wpms-login-widget.zip to the /wp-content/plugins/ directory or install it the usual way through the plugins page.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to Settings > WPMS Sidebar Login and set the desired settings for your install.
4. Go to Appearance > Widgets and add the WPMS Sidebar Login Widget to your sidebar.

-- WordPress Multisite
1. Extract wpms-login-widget.zip to the /wp-content/plugins/ directory or install it the usual way through the plugins page.
2. Swith to Network Admin and activate the plugin network wide through the 'Plugins' menu.
3. Switch back to Site Admin, go to Settings > WPMS Sidebar Login and set the desired settings for your install.
4. Go to Appearance > Widgets and add the WPMS Sidebar Login Widget to your sidebar.

== Changelog ==

= 1.9.4 (2012-02-18) =
* Fixed a broken div in the header of login widget.

= 1.9.3 (2012-01-02) =
* Was missing the publish_posts capability check in the first part of the if/then condition.

= 1.9.2 (2011-12-18) =
* Hopefully this fixes the internationalization finally.

= 1.9.1 (2011-11-03) =
* Changed forum option to custom forum url

= 1.9 (2011-11-01) =
* Is now standalone as well as network detectable
* Different settings depending on WordPress setup
* Added option for custom registration page for WP standalone install
* Added option of subblog registration detection
* Added custom css box

= 1.8 (2011-08-14) =
* Finished the bit for internationalization

= 1.7 (2011-08-05) =
* Added setting to subscribe users to a different blog instead of the main site.

= 1.6 (2011-07-31) =
* Added setting for Remember Me
* Added setting for subscribing users to the main site

= 1.5.1 (2011-07-21) =
* Replaced all deprecated code

= 1.5 (2011-07-20) =
* Added internationalization

= 1.4 (2011-07-18) =
* Fixed misplaced "div" tag that was breaking the sidebar.

= 1.3 (2011-07-17) =
* Added an options page so that users can set forum url to true/false without having to edit the plugin file.

= 1.2 (2011-07-16) =
* Deleted deprecated code that caused the plugin to not activate
* Some code changes that didn't get saved in version 1.1
* Added some code back in that was deleted by mistake
* Updated avatar size

= 1.1 (2011-07-15) =
* Added link to the Network Admin page for super admin(s)

= 1.0 (2011-07-14) =
* Initial Release

== Screenshots ==
1. Login form
2. Info shown when user is logged in
3. WPMS Sidebar Login Widget Settings
=== BuddyPress Admin Only Profile Fields ===
Contributors: A5hleyRich
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=S6KBW2ZSVZ8RE
Tags: buddypress, admin, hidden, profile, field, visibility
Requires at least: 4.1
Tested up to: 4.1
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easily set the visibility of BuddyPress profile fields to hidden, allowing only admin users to edit and view them.

== Description ==

Easily set the visibility of BuddyPress profile fields to hidden, allowing only admin users to edit and view them.

**Documentation**

The BuddyPress Admin Only Profile Fields documentation can be found [here](http://ashleyrich.com/documentation/category/buddypress-admin-only-profile-fields/).

**GitHub**

If you would like to contribute to the plugin, you can do so on [GitHub](https://github.com/A5hleyRich/BuddyPress-Admin-Only-Profile-Fields).

== Installation ==

1. Upload `bp-admin-only-profile-fields` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==

= How do I change who can view and edit the hidden field? =

Add the following filter to your theme’s functions.php file, substituting *manage_options* with the desired capability:
`add_filter( 'bp_admin_only_profile_fields_cap', 'edit_others_posts' ); // Editors`

== Screenshots ==



== Changelog ==

= 1.0 =

* Initial release.

== Upgrade Notice ==

= 1.0 =

* Initial release.
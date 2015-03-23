=== BuddyPress Admin Only Profile Fields ===
Contributors: A5hleyRich
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=S6KBW2ZSVZ8RE
Tags: buddypress, admin, hidden, profile, field, visibility
Requires at least: 4.1.1
Tested up to: 4.1.1
Stable tag: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easily set the visibility of BuddyPress profile fields to hidden, allowing only admin users to edit and view them.

== Description ==

Easily set the visibility of BuddyPress profile fields to hidden, allowing only admin users to edit and view them.

**GitHub**

If you would like to contribute to the plugin, you can do so on [GitHub](https://github.com/A5hleyRich/BuddyPress-Admin-Only-Profile-Fields).

== Installation ==

1. Upload `bp-admin-only-profile-fields` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==

= How do I hide a profile field? =

In the WordPress admin area, go to *Users > Profile Fields* and click *Edit* on the desired profile field. Under the *Default Visibility* panel select *Hidden* as the value and click *Save*.

The profile field is now hidden from all users except Administrators.

= How do I change who can view and edit the hidden field? =

Add the following filter to your theme’s functions.php file, substituting *manage_options* with the desired capability:
`add_filter( 'bp_admin_only_profile_fields_cap', 'edit_others_posts' ); // Editors`

== Screenshots ==

1. Edit field BuddyPress screen.

== Changelog ==

= 1.0.1 =

* Hide the _Per-Member Visibility_ options when the _Default Visibility_ is set to _Hidden_

= 1.0 =

* Initial release

== Upgrade Notice ==

= 1.0.1 =

* General improvements

= 1.0 =

* Initial release
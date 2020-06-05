=== Customizer UI ===
Contributors: cperko
Tags: customizer,ui,user interface
Requires at least: 5.2
Tested up to: 5.2
Stable tag: 1.0.2
Requires PHP: 7.2.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Designed to help WordPress developers quickly and easily add Customizer sections and controls.

== Description ==

The WordPress customizer is an amazing tool that developers can use to make their themes easily customizable by their users.

However, creating fields for it requires quite a bit of coding, and lots of trips to the Codex.  WPCUI uses a user-friendly design
to allow the developer to create sections and controls, and get on to what really matters... creating amazing websites!

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/wpcui` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress
1. Navigate to the Customizer UI page found on the left of the admin panel
1. Create a new section by naming it
1. Create any controls for the section.  Give each control an ID.
1. Utilize the controls in your theme code by pulling the saved value for the control.  ie. get_theme_mod('control_id')


== Screenshots ==

1. Adding controls to the "Front Page" customizer section on a WordPress website.

== Changelog ==

= 1.1.x =
* New page to set a global control id prefix

= 1.0.2 =
* Minor updates to fix information on plugin listing

= 1.0.1 =
* First public release!

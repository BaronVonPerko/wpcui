=== Customizer UI ===
Contributors: cperko
Tags: customizer
Requires at least: 5.2
Tested up to: 5.2
Stable tag: 4.3
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
1. Navigate to the WPCUI page found on the left of the admin panel
1. Create a new section by naming it
1. Create any controls for the section.  Give each control an ID.
1. Utilize the controls in your theme code by pulling the saved value for the control.  ie. get_theme_mod('control_id')


== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png`
(or jpg, jpeg, gif).
2. This is the second screen shot

== Changelog ==

= 1.0 =
* First public release!

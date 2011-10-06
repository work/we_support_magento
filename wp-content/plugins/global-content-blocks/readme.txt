=== Global Content Blocks===
Contributors: benz1
Donate link: 
https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=M27BDW5HXKAEQ
Tags: admin, shortcode, shortcodes, code, html, php, javascript, snippet, code snippet, iframe, reuse, reusable, adsense, paypal, insert, global, content block, raw html, formatting, pages, posts, editor, tinymce, form, forms, icon
Requires at least: 2.8.6
Tested up to: 3.2.1
Stable tag: 1.3

Creates shortcodes to add HTML, PHP, forms, opt-ins, iframes, Adsense, code snippets, reusable objects, etc, to posts/pages and preserves formatting.

== Description ==

**Global Content Blocks** lets you create your own shortcodes to insert reusable code snippets, PHP or HTML including forms, opt-in boxes, iframes, Adsense code, etc, into pages and posts. You can insert them directly using the shortcodes or via a button in the TinyMCE visual editor toolbar. You can also insert the entire content of the content block instead of the shortcode.

It is ideal for inserting reusable objects into your content or to prevent the WordPress editor from stripping out your code or otherwise changing your formatting. The shortcodes are masked as images to allow easy manipulation and non-html tags contamination.

The plugin includes an Import/Export fuction to copy content blocks from one WordPress site to another.

Further information and screenshots are available on the plugin homepage at http://wordpress-plugins.org/global-content-blocks/.

If you have any feedback, issues or suggestions for improvements please leave a comment on the plugin homepage.

== Installation ==

1. Download the **global-content-blocks.zip** file to your local machine.
2. Either use the automatic plugin installer *(Plugins - Add New)* or Unzip the file and upload the **global-content-blocks** folder to your **/wp-content/plugins/** directory.
3. Activate the plugin through the Plugins menu
4. Visit the **Global Content Blocks** settings page *(Settings > Global Content Blocks)* to add or edit Content Blocks.
5. Insert the Content Block into pages or posts using the button on the editor tool bar or by inserting the shortcode **[contentblock id=xx]** where **xx** is the ID number of the Content Block.


== Frequently Asked Questions ==

= How big a content block can I add? =
The content block will hold up to 64,000 characters.

= Can I create content blocks with PHP code? =
Yes, just copy the PHP as normal into a content block without the <?php, <?, ?> tags and insert the block into your content as normal.

= Will I lose my content blocks if I change the theme or upgrade WordPress? =
No, the blocks are added to the WordPress database so are independent of the theme and unaffected by WordPress upgrades.

= Can it be completely uninstalled? =
Yes, there is an option to delete the database table if you want to completely remove the plugin.

= Can I copy any content blocks I've created to another WordPress site? =
Yes, an Import/Export function is included. Just Export form one site, install the plugin on the other site and import.

== Screenshots ==

1. The Settings page
2. Adding a new Content Block
3. Inserting a Content Block using the toolbar button
4. Inserting a Content Block using the shortcode

== Changelog ==
= 1.3 =
* Fixed reported expoloit vulnerability
* Fixed export issue in some browsers
* Added option to show/hide the icon in the editor toolbar in case of conflict with other plugins.

= 1.2 =
* Added option to create a new content block while inserting the block in the page/post
* Tidied up code to avoid errors in debug mode

= 1.1.2 =
* Fixed bug, TinyMCE editor button replacing button of some other plugins

= 1.1.1 =
* Fixed bug, slashes being stripped when inserting code block
* Updated TinyMCE default manager for better cross platform compatibility

= 1.1 =
* Added ability to insert PHP blocks into content
* Option to insert to entire content block into pages/posts instead of the shortcode
* Option to select the block type, each represented by a different image block when inserted into content making it easier to identify on the page
* Added Import/Export function to export all or selected content blocks to an xml file that can be imported into the Global Content Blocks plugin on another WordPress site
* Added a link to the Settings page from the Plugins page listing
* Minor cosmetic changes
* Added a Donate button on the Settings page and some advertising

= 1.0.1 =
* Minor typo correction in install file

= 1.0 =
* Stable version released.

== Upgrade Notice ==

= 1.1 =
A major update adding several new features and functions including the ability to insert PHP blocks, insert the entire content block instead of the shortcode and export blocks to another site.

= 1.0.1 =
Minor typo fixed
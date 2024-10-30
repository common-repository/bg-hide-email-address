=== Hide Email Address ===
Contributors: buntegiraffe
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=VTAHA24DSYL5Y
Tags: spam, email, bot, spider, crawler, protect email, hide address, protect address, hide email,
Requires at least: 3.9
Tested up to: 4.9.8
Stable tag: 0.1
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Protect email address from being collected by web crawlers.

== Description ==

Hide Email Address allows you to make email addresses on your site invisible to web spiders and crawlers.
It also makes it still possible to easily copy and paste email addresses.

Please feel free to post your questions in the support threads of this plugin, we will be glad to help you with any issues.

**PRO Version:**
Automatically protects all email addresses on your site, for only 4.95 eur with Hide Email Address PRO (http://bunte-giraffe.de "http://bunte-giraffe.de").

> #### **Main features**

> * Hide email addresses from bots
> * Hide single-line sensitive content from bots
> * Protected content is generated as image 
> * Protected content is turned into text on click (for real visitors to copy)
> * Protected content uses the styles of your posts/pages/widgets 
> * Automaticaly protects all emails on your site (PRO version)
> * Regular updates
> * Great support

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/hide-email-address` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Open post editor, select the email address you want to protect and click the button with a shield icon in the TinyMCE toolbar in Classic editor, or insert [bg-hide-email-address]email@domain.com[/bg-hide-email-address] shortcode into a Gutenberg text block.
4. The address is now hidden from bots, but is shown to real visitors on your site.

== Frequently Asked Questions ==

= What are all the shortcode parameters? =

Normaly you don't need to change anything after the address has been protected.
However, depending on your current theme you might want to adjust the protected
email address to fit the height of other text on your website. 
We give you flexibility to adjust the vertical alignment by adding inline_css parameter to the short code.
For example: 
- If text appears to be above the line, use inline_css="padding-top:2px" to move the address 2 pixels lower.
- If line-spacing under the line with the email address appears to be greater than between other lines, use 
inline_css="margin-bottom:-4px" to reduce the height of the line with the email address by 4 pixels.
Default value for bottom margin is "-3px" and it matches most of cases we tested the plugin with.
Typical short code looks like: [bg-hide-email-address]email@domain.com[/bg-hide-email-address]

= Can I use Hide Email Address to protect something other than email addresses? =

Sure, go ahead. Although we did not test such use cases extensively, we don't see why not.
Get in touch with us in case there is something you tried and it did not work for you.
We will address your issue as soon as possible.

== Screenshots ==

1. Hide Email Address button on the TimyMCE toolbar
2. Resulting text - visualy no difference to the rest of the paragraph
3. Selecting the protected email address

== Changelog ==

= 0.1 =
Initial release.

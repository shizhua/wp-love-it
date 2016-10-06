# WP Love It

Contributors: newbiesup

Donate link: http://ptheme.com/

Tags: like, rate, like it, rating, like count, rating count

Requires at least: 3.0.1

Tested up to: 4.6.1

Stable tag: 1.0.1

License: GPLv2 or later

License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add a simple "Love It" button to post

## Description

This plugin enables you to add an ajax Love It button to your WordPress post. You can choose it to appear on the top or bottom of the content. It also includes a shortcode to let you manually add the button to the post.


Plugin homepage: [http://ptheme.com/item/wp-love-it/](http://ptheme.com/item/wp-love-it/ "WP Love It")

## Features

*   AJAX love it without refreshing the page
*   Cookies support to prevent repeatedly click the button
*   Automatically add the button on top of post content
*	Shortcode included to add the button

## Support

We will do our best to provide support through the WordPress forums. However, all plugin support is provided in our helpdesk. If you have not registered yet, you can do so here: <a href="http://ptheme.com/members/">http://ptheme.com/members/</a>.

## Feedback
If you like this plugin, then please leave us a good rating and review.<br> Consider following us on <a href="https://twitter.com/pthemecom">Twitter</a>, and <a href="https://www.facebook.com/pthemecom">Facebook</a>

## Installation

1. Upload `wp-love-it.zip` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

## Frequently Asked Questions

> How can I display the button at the bottom of post?

By default the button will automatically appear on top of post. You can also change the position to the bottom of post by using filter 'wpli/position'. Put following codes to your 'functions.php'.

```
add_filter( 'wpli/position', function() {return 'bottom';} );
```

> How can I use the shortcode? =
 
One thing you should pay attention to is that if you want to manually add the button by using the shortcode, you should disable the automatically adding functionality otherwise the button may appear multiple times. Put following codes to your 'functions.php'.

```
add_filter( 'wpli/autoadd', function() {return false;} );
```

Then you can use the shortcode ```[wp_love_it]```. *The shortcode should be used in the loop.*

## Changelog

### 1.0.1
* Fixed a small shortcode bug

## 1.0
* First Release

## Upgrade Notice
None

<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://ptheme.com/
 * @since             1.0.0
 * @package           Wp_Love_It
 *
 * @wordpress-plugin
 * Plugin Name:       WP Love It
 * Plugin URI:        http://ptheme.com/item/wp-love-it/
 * Description:       Automatically add a Love it button to your post content
 * Version:           1.0.0
 * Author:            Leo
 * Author URI:        http://ptheme.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-love-it
 * Domain Path:       /languages
 */

require 'class-love-it.php';
$LoveIt = new WPLoveIt();

// Sample code to display the button below post content. 
// If return value is "none" then button won't automatically appear.
// add_filter( 'wpli/position', function() {return 'bottom';} );

<?php
/*
Plugin Name: Easy Code Placement
Version: 2.7
Plugin URI: http://www.randnotizen.org/easy-code-placement/
Author: Jens Herdy
Author URI: http://www.randnotizen.org/
Description: A great Wordpress Plugin to place ANY Code ANYWHERE you want.
License: GPLv3
*/

// standards
ob_start();
define('ECP_FILE',__FILE__);
define('ECP_VERSION','3.0');

// load functions, classes
include( dirname( __FILE__ ) . '/inc/functions.php' );
include( dirname( __FILE__ ) . '/inc/classes/class-ecp-tables.php' );
include( dirname( __FILE__ ) . '/inc/classes/class-ecp-table.php' );

// set filters to replace shortcodes
add_filter ( 'the_content', 'do_shortcode', 99);
add_filter ( 'widget_text', 'do_shortcode', 99);
add_filter ( 'the_excerpt', 'do_shortcode', 99);

// set filters to allow php code
add_filter ( 'the_content', 'ecp_allow_php', 99);
add_filter ( 'widget_text', 'ecp_allow_php', 99);
add_filter ( 'the_excerpt', 'ecp_allow_php', 99);

// load languages
load_plugin_textdomain('ecp', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );

// include install and uninstall files
include( dirname( __FILE__ ) . '/inc/install.php' );
include( dirname( __FILE__ ) . '/inc/uninstall.php' );

// update if neccesary
ecp_do_update();

// add options menu
add_action( 'admin_menu', 'ecp_add_page' );

?>
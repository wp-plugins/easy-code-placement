<?php
/*
Plugin Name: Easy Code Placement
Version: 2.4.2
Plugin URI: http://www.randnotizen.org/easy-code-placement/
Author: Jens Herdy
Author URI: http://www.randnotizen.org/
Description: A great Wordpress Plugin to place ANY Code ANYWHERE you want.
License: GPLv3
*/

// error reporting off for pub releases
// error_reporting(E_ALL);

// standards
ob_start();
define('ECP_FILE',__FILE__);
define('ECP_VERSION','2.4.2');

// load functions, classes
include( dirname( __FILE__ ) . '/inc/functions.php' );
include( dirname( __FILE__ ) . '/inc/classes/class-ecp-tables.php' );
include( dirname( __FILE__ ) . '/inc/classes/class-ecp-options-table.php' );

// set filter
add_filter ( 'the_content', 'do_shortcode' );
add_filter ( 'widget_text', 'do_shortcode' );
add_filter ( 'the_excerpt', 'do_shortcode' );

// load languages
load_plugin_textdomain('ecp', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );

// load install and uninstall files
include( dirname( __FILE__ ) . '/inc/install.php' );
include( dirname( __FILE__ ) . '/inc/uninstall.php' );

// update if neccesary
ecp_do_update();

// add options menu
add_action( 'admin_menu', 'ecp_add_options_page' );

?>
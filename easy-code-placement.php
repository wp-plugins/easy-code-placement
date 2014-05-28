<?php
/*
Plugin Name: Easy Code Placement - for any Code you want
Version: 1.1
Plugin URI: http://www.randnotizen.org/easy-code-placement/
Author: Jens Herdy
Author URI: http://www.randnotizen.org/
Description: A great Wordpress Plugin to place any Code - anywhere you want.
License: GPLv3
*/

// standards
ob_start();
error_reporting(E_ALL);
define('ECP_FILE',__FILE__);

// load languages
load_plugin_textdomain('ecp', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );

// load other files
include( dirname( __FILE__ ) . '/inc/install.php' );
include( dirname( __FILE__ ) . '/inc/uninstall.php' );
include( dirname( __FILE__ ) . '/replace.php' );

// load css-style
function ecp_add_style(){
	wp_register_style('ecp_style', ( dirname( __FILE__ ) . '/css/styles.css' ));
	wp_enqueue_style('ecp_style');
}
add_action('admin_enqueue_scripts', 'ecp_add_style');

// add options menu
function ecp_add_options_page() {
  add_options_page( 'Easy Code Placement', 'Easy Code Placement', 'manage_options', 'ecp_option_page', 'ecp_options' );	
}
add_action( 'admin_menu', 'ecp_add_options_page' );

// add options to menu
function ecp_options(){
include( dirname( __FILE__ ) . '/inc/options.php' );
}

?>
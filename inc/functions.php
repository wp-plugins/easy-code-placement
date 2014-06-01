<?php

// generate options menu
function ecp_add_options_page() {
    add_options_page( 'Easy Code Placement', 'Easy Code Placement', 'manage_options', 'ecp_option_page', 'ecp_options' );	
}

// add options to menu
function ecp_options() {
    include ( dirname( __FILE__ ) . '/options.php' );
}

// show error
function ecp_error($ecp_error, $ecp_error_page, $ecp_error_id) {
    include ( dirname( __FILE__ ) . '/error.php' );
}

?>
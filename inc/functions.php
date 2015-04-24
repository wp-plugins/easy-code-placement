<?php

// generate options menu
function ecp_add_options_page() {
    add_options_page( 'Easy Code Placement', 'Easy Code Placement', 'manage_options', 'ecp_option_page', 'ecp_options' );	
}

// add options to menu
function ecp_options() {
    include ( dirname( __FILE__ ) . '/options.php' );
}

// add css to ecp page
add_action('admin_head', 'table_css');
function table_css() {
    $page = ( isset($_GET['page'] ) ) ? esc_attr( $_GET['page'] ) : false;
    if( 'ecp_option_page' != $page )
        return; 

    echo '<style type="text/css">';
    echo '.wp-list-table .column-name { width: 31%; }';
    echo '.wp-list-table .column-shortcode { width: 45%; }';
    echo '.wp-list-table .column-action { width: 24%; }';
    echo '</style>';
}

// show error
function ecp_error($ecp_error, $ecp_error_page, $ecp_error_id) {
    include ( dirname( __FILE__ ) . '/error.php' );
}

// modify text widget
add_filter('widget_text', 'ecp_widget_text', 9999);
function ecp_widget_text($text) {
    if (strpos($text, '<' . '?') !== false) {
        ob_start();
        eval('?' . '>' . $text);
        $text = ob_get_clean();
    }
    return $text;
}
$ecp_widget_id = null;
add_filter('the_content', 'ecp_widget_content', 9999);
function ecp_widget_content($content) {
    global $post, $ecp_widget_id;
    if (is_single() || is_page()) {
        $ecp_widget_id = $post->ID;
    }
    return $content;
}

// replace shortcode with code
add_shortcode('ecp','ecp_replace');
function ecp_replace($ecp_code){
    global $wpdb;
    $query = $wpdb->get_results($wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."ecp_data WHERE name=%s" ,$ecp_code));
    
    if(count($query)>0){
	foreach ($query as $code_load){
            if($code_load->status === '1') {
                // when status is activ
		if ($code_load->alignment === '0' OR $code_load->alignment === '') {
                    $ecp_output = "<p>" . $code_load->code . "</p>";
                } elseif ($code_load->alignment === '1') {
                    $ecp_output = "<p align='left'>" . $code_load->code . "</p>";
                } elseif ($code_load->alignment === '2') {
                    $ecp_output = "<p align='center'>" . $code_load->code . "</p>";
                } elseif ($code_load->alignment === '3') {
                    $ecp_output = "<p align='right'>" . $code_load->code . "</p>"; 
                }
                return $ecp_output;
            } else {
                // when status is deactive
		return '';
            }
        }
    }else{
        // when shortcode not found
	return '';
    }

}

// create options table
function render_ecp_options_table(){
    $ecp_options_table = new ecp_options_table();
    $ecp_options_table->prepare_items();
    $ecp_options_table->display();
}

// updates from 2.4.2 to 2.5
function ecp_update(){
    global $wpdb;
    $wpdb->query("UPDATE ".$wpdb->prefix."ecp_data SET version='2.5'");
    $wpdb->update($wpdb->prefix.'ecp_options', array( 'option_value'=>'2.5' ), array( 'option_name'=>'version' ));
    $wpdb->query("UPDATE ".$wpdb->prefix."ecp_data SET shortcode = name");
}

// update function
function ecp_do_update(){

global $wpdb;
$ecp_options_version = $wpdb->get_var("SELECT option_value FROM ".$wpdb->prefix."ecp_options WHERE option_name = 'version'" );

if ($ecp_options_version === '2.5') {
    return;
} else {

    ecp_update();
    return;
    
    }

}

?>
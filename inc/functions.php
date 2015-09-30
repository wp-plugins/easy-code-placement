<?php

// error reporting for dev
// error_reporting(E_ALL);
// define( 'DIEONDBERROR', true ); // multisite
// $wpdb->show_errors(); // single site

// generate options menu
function ecp_add_page() {
    add_options_page( 'Easy Code Placement', 'Easy Code Placement', 'manage_options', 'ecp', 'ecp' );	
}

// add options to menu
function ecp() {
    include ( dirname( __FILE__ ) . '/page.php' );
}

// add css to ecp page
add_action('admin_head', 'table_css');
function table_css() {
    $page = ( isset($_GET['page'] ) ) ? esc_attr( $_GET['page'] ) : false;
    if( 'ecp' != $page )
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

// allow php code
function ecp_allow_php($text) {
    if (strpos($text, '<' . '?') !== false) {
        ob_start();
        eval('?' . '>' . $text);
        $text = ob_get_contents();
        ob_end_clean();
    }
    return $text;
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
                    $ecp_output = $code_load->code;
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
function render_ecp_table(){
    $ecp_options_table = new ecp_table();
    $ecp_options_table->prepare_items();
    $ecp_options_table->display();
}

// updates from 2.6.x to 2.7
function ecp_update(){
    // multiside update
    if (is_multisite()) {
        global $wpdb;
	$blog = $wpdb->blogid;
        $blogids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
        foreach ($blogids as $blogid) {
            switch_to_blog($blogid);
            $wpdb->query("UPDATE ".$wpdb->prefix."ecp_data SET version='3.0'");
            $wpdb->update($wpdb->prefix.'ecp_options', array( 'option_value'=>'3.0' ), array( 'option_name'=>'version' ));
        }
	switch_to_blog($blog);
        } else {
    // single update
    global $wpdb;
    $wpdb->query("UPDATE ".$wpdb->prefix."ecp_data SET version='3.0'");
    $wpdb->update($wpdb->prefix.'ecp_options', array( 'option_value'=>'3.0' ), array( 'option_name'=>'version' ));
    }
}

// update function
function ecp_do_update(){
global $wpdb;
$ecp_options_version = $wpdb->get_var("SELECT option_value FROM ".$wpdb->prefix."ecp_options WHERE option_name = 'version'" );
    if (! is_admin()) {
        return;
    } elseif ($ecp_options_version === '3.0') {
        return;
    } else {
        ecp_update();
        return;
    }
}

// add tables and data in it when a new blog is created
function ecp_new_blog($blog_id) {
    if ( is_plugin_active_for_network( 'easy-code-placement/easy-code-placement.php' ) ) {
        switch_to_blog($blog_id);
        ecp_install();
        restore_current_blog();
    }
}

// tell wordpress what to do when adding a new blog
add_action ( 'wpmu_new_blog', 'ecp_new_blog', 99 );

// delete tables and data when a blog is deleted
function ecp_deleted_blog($tables) {
    global $wpdb;
    $tables[] = $wpdb->prefix.'ecp_options';
    $tables[] = $wpdb->prefix.'ecp_data';
    return $tables;
}
add_filter ( 'wpmu_drop_tables', 'ecp_deleted_blog', 99 );

?>
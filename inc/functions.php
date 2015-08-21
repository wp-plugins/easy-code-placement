<?php

// error reporting for dev
// error_reporting(E_ALL);
// define( 'DIEONDBERROR', true ); // multisite
// $wpdb->show_errors(); // single site

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

// updates from 2.6.x to 2.7
function ecp_update(){
    // multiside update
    if (is_multisite()) {
        global $wpdb;
	$blog = $wpdb->blogid;
        $blogids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
        foreach ($blogids as $blogid) {
            switch_to_blog($blogid);
            $wpdb->query("UPDATE ".$wpdb->prefix."ecp_data SET version='2.7'");
            $wpdb->query("DROP TABLE ".$wpdb->prefix."ecp_options");
            $ecp_options = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."ecp_options (
                `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `option_name` varchar(10) COLLATE utf8_unicode_ci NOT NULL UNIQUE,
                `option_value` varchar(10) COLLATE utf8_unicode_ci NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";
            $wpdb->query($ecp_options);
            $wpdb->insert($wpdb->prefix.'ecp_options', array('option_name' => 'version','option_value' => ECP_VERSION));
            $wpdb->insert($wpdb->prefix.'ecp_options', array('option_name' => 'perpage','option_value' => '10'));
        }
	switch_to_blog($blog);
        } else {
    // single update
    global $wpdb;
    $wpdb->query("UPDATE ".$wpdb->prefix."ecp_data SET version='2.7'");
    $wpdb->query("DROP TABLE ".$wpdb->prefix."ecp_options");
    $ecp_options = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."ecp_options (
        `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `option_name` varchar(10) COLLATE utf8_unicode_ci NOT NULL UNIQUE,
        `option_value` varchar(10) COLLATE utf8_unicode_ci NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";
    $wpdb->query($ecp_options);
    $wpdb->insert($wpdb->prefix.'ecp_options', array('option_name' => 'version','option_value' => ECP_VERSION));
    $wpdb->insert($wpdb->prefix.'ecp_options', array('option_name' => 'perpage','option_value' => '10'));
    }
}

// update function
function ecp_do_update(){
global $wpdb;
$ecp_options_version = $wpdb->get_var("SELECT option_value FROM ".$wpdb->prefix."ecp_options WHERE option_name = 'version'" );
    if (! is_admin()) {
        return;
    } elseif ($ecp_options_version === '2.7') {
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
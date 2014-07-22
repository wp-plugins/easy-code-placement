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

// updates
function ecp_update01(){
    global $wpdb;
    $ecp_update1 = "ALTER TABLE ".$wpdb->prefix."ecp_data MODIFY COLUMN name varchar(35)";
    $ecp_update2 = "ALTER TABLE ".$wpdb->prefix."ecp_data MODIFY COLUMN shortcode varchar(55)";
    $ecp_version = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."ecp_version (
        `id` int NOT NULL AUTO_INCREMENT,
        `version` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";
    $wpdb->query($ecp_update1);
    $wpdb->query($ecp_update2);
    $wpdb->query($ecp_version);
    $wpdb->insert($wpdb->prefix.'ecp_version', array('version' => ECP_VERSION));
}
function ecp_update02(){
    global $wpdb;
    $wpdb->update($wpdb->prefix.'ecp_version', array('version'=>'1.3_u'), array( 'ID'=>'1' ));
}
function ecp_update03(){
    global $wpdb;
    $ecp_update3 = "ALTER TABLE ".$wpdb->prefix."ecp_data ADD alignment varchar(35) COLLATE utf8_unicode_ci NOT NULL AFTER code";
    $ecp_update4 = "ALTER TABLE ".$wpdb->prefix."ecp_data ADD version varchar(10) COLLATE utf8_unicode_ci NOT NULL AFTER status";
    $wpdb->query($ecp_update3);
    $wpdb->query($ecp_update4);
    $wpdb->update($wpdb->prefix.'ecp_data', array('version'=>'1.4'), array( 'version'=>'' ));
    $wpdb->update($wpdb->prefix.'ecp_data', array('alignment'=>'0'), array( 'alignment'=>'' ));
    $wpdb->update($wpdb->prefix.'ecp_version', array('version'=>'1.4'), array( 'ID'=>'1' ));
}
function ecp_update04(){
    global $wpdb;
    $wpdb->update($wpdb->prefix.'ecp_data', array('version'=>'1.5'), array( 'version'=>'1.4' ));
    $wpdb->update($wpdb->prefix.'ecp_version', array('version'=>'1.5'), array( 'ID'=>'1' ));
}
function ecp_update05(){
    global $wpdb;
    $wpdb->update($wpdb->prefix.'ecp_data', array('version'=>'1.6'), array( 'version'=>'1.5' ));
    $wpdb->update($wpdb->prefix.'ecp_data', array('version'=>'1.6'), array( 'version'=>'' ));
    $wpdb->update($wpdb->prefix.'ecp_version', array('version'=>'1.6'), array( 'ID'=>'1' ));
}
function ecp_update06(){
    global $wpdb;
    $wpdb->update($wpdb->prefix.'ecp_data', array('version'=>'2.0'), array( 'version'=>'1.6' ));
    $wpdb->update($wpdb->prefix.'ecp_version', array('version'=>'2.0'), array( 'ID'=>'1' ));
    $ecp_options = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."ecp_options (
        `id` int NOT NULL AUTO_INCREMENT,
        `option_name` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
        `option_value` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";
    $wpdb->query($ecp_options);
    $wpdb->insert($wpdb->prefix.'ecp_options', array('option_name' => 'version','option_value' => ECP_VERSION));
    $wpdb->insert($wpdb->prefix.'ecp_options', array('option_name' => 'perpage','option_value' => '10'));
    $wpdb->query("DROP TABLE ".$wpdb->prefix."ecp_version");
}

// update function
function ecp_update(){

global $wpdb;
$ecp_options_version = $wpdb->get_var("SELECT option_value FROM ".$wpdb->prefix."ecp_options WHERE option_name = 'version'" );

if ($ecp_options_version === '2.0') {
    return;
} else {

    global $wpdb;
    $t_ecp_version = $wpdb->get_var("SELECT version FROM ".$wpdb->prefix."ecp_version WHERE ID=1");

    if ($t_ecp_version === '' &&  ECP_VERSION === '2.1') {
        ecp_update01();
        ecp_update02();
        ecp_update03();
        ecp_update04();
        ecp_update05();
        ecp_update06();
        return;
    } elseif ($t_ecp_version === '1.3' &&  ECP_VERSION === '2.1') {
        ecp_update02();
        ecp_update03();
        ecp_update04();
        ecp_update05();
        ecp_update06();
        return;
    } elseif ($t_ecp_version === '1.3_u' &&  ECP_VERSION === '2.1') {
        ecp_update03();
        ecp_update04();
        ecp_update05();
        ecp_update06();
        return;
    } elseif ($t_ecp_version === '1.4' &&  ECP_VERSION === '2.1') {
        ecp_update04();
        ecp_update05();
        ecp_update06();
        return;
    } elseif ($t_ecp_version === '1.5' &&  ECP_VERSION === '2.1') {
        ecp_update05();
        ecp_update06();
        return;
    } elseif ($t_ecp_version === '1.6' &&  ECP_VERSION === '2.1') {
        ecp_update06();
        return;
    }

}
}

?>
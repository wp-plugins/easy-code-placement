<?php

// install function
function ecp_install(){
    global $wpdb;
    // create data table
    $ecp_table = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."ecp_data (
        `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `name` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
        `code` longtext COLLATE utf8_unicode_ci NOT NULL,
        `alignment` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
        `shortcode` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
        `status` int NOT NULL,
        `version` varchar(10) COLLATE utf8_unicode_ci NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";
    $wpdb->query($ecp_table);
    // create options table
    $ecp_options = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."ecp_options (
        `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `option_name` varchar(10) COLLATE utf8_unicode_ci NOT NULL UNIQUE,
        `option_value` varchar(10) COLLATE utf8_unicode_ci NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";
    $wpdb->query($ecp_options);
    // insert data
    $wpdb->insert($wpdb->prefix.'ecp_options', array('option_name' => 'version','option_value' => ECP_VERSION));
    $wpdb->insert($wpdb->prefix.'ecp_options', array('option_name' => 'perpage','option_value' => '10'));
}

// multiside or single installation?
function ecp_net_inst($networkwide) {
    global $wpdb;  
    // multiside installation
    if (is_multisite() && $networkwide) {
	$blog = $wpdb->blogid;
        $blogids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
        foreach ($blogids as $blogid) {
            switch_to_blog($blogid);
            ecp_install();
        }
	switch_to_blog($blog);
    } else {
    // single installation	
    ecp_install();
    }
}

// register install hook
register_activation_hook ( ECP_FILE, 'ecp_net_inst' );

?>
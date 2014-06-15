<?php

// multiside or single installation?
function ecp_net_inst($networkwide) {
    global $wpdb;  
	
    // multiside installation
    if (function_exists('is_multisite') && is_multisite()) {
	if ($networkwide) {
            $old_blog = $wpdb->blogid;
            $blogids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
            foreach ($blogids as $blog_id) {
                switch_to_blog($blog_id);
                ecp_install();
            }
		switch_to_blog($old_blog);
		return;
	}
    }
    
    // single installation	
    ecp_install();
}

// install function
function ecp_install(){
    global $wpdb;
        
    // create data table
    $ecp_table = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."ecp_data (
        `id` int NOT NULL AUTO_INCREMENT,
        `name` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
        `code` longtext COLLATE utf8_unicode_ci NOT NULL,
        `alignment` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
        `shortcode` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
        `status` int NOT NULL,
        `version` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";
    $wpdb->query($ecp_table);

    // create version table
    $ecp_version = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."ecp_version (
        `id` int NOT NULL AUTO_INCREMENT,
        `version` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";
    $wpdb->query($ecp_version);
        
    // insert data
    $wpdb->insert($wpdb->prefix.'ecp_version', array('version' => ECP_VERSION));
}

// tell wordpress that there is an installation routine
register_activation_hook ( ECP_FILE, 'ecp_net_inst' );

?>
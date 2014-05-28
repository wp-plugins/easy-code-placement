<?php

// multiside installation
function ecp_net_inst($networkwide) {
	global $wpdb;  
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
	$ecp_table = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."ecp_data (
	  `id` int NOT NULL AUTO_INCREMENT,
		`name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
		`code` longtext COLLATE utf8_unicode_ci NOT NULL,
		`shortcode` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
		`status` int NOT NULL,
		PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";
	$wpdb->query($ecp_table);
}

register_activation_hook ( ECP_FILE, 'ecp_net_inst' );
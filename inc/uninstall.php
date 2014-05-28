<?php

// multiside uninstall
function ecp_net_uninstall($networkwide) {
	global $wpdb;  
	if (function_exists('is_multisite') && is_multisite()) {
		if ($networkwide) {
			$old_blog = $wpdb->blogid;
			$blogids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
			foreach ($blogids as $blog_id) {
				switch_to_blog($blog_id);
				ecp_uninstall();
			}
			switch_to_blog($old_blog);
			return;
		}
	}
// single uninstall
	ecp_uninstall();
}

// uninstall function
function ecp_uninstall(){
  global $wpdb;
  $wpdb->query("DROP TABLE ".$wpdb->prefix."ecp_data");
}

register_uninstall_hook ( ECP_FILE, 'ecp_net_uninstall' );

?>
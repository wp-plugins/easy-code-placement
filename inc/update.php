<?php

global $wpdb;

// set variable for version comparsion
$t_ecp_version = $wpdb->get_var( "SELECT version FROM ".$wpdb->prefix."ecp_version WHERE ID=1" );

// if version after update = 1.5
if( $t_ecp_version == "1.4" &&  ECP_VERSION == "1.5") {
    
    // update version
    $wpdb->update($wpdb->prefix.'ecp_data', array('version'=>'1.5'), array( 'version'=>'1.4' ));
    $wpdb->update($wpdb->prefix.'ecp_version', array('version'=>'1.5'), array( 'ID'=>'1' ));
}

// if version = 1.4
if( $t_ecp_version == "1.3_u" &&  ECP_VERSION == "1.4") {
    
    // update
    $ecp_update3 = "ALTER TABLE ".$wpdb->prefix."ecp_data ADD alignment varchar(35) COLLATE utf8_unicode_ci NOT NULL AFTER code";
    $ecp_update4 = "ALTER TABLE ".$wpdb->prefix."ecp_data ADD version varchar(10) COLLATE utf8_unicode_ci NOT NULL AFTER status";
    $wpdb->query($ecp_update3);
    $wpdb->query($ecp_update4);
    $wpdb->update($wpdb->prefix.'ecp_data', array('version'=>'1.4'), array( 'version'=>'' ));
    $wpdb->update($wpdb->prefix.'ecp_data', array('alignment'=>'0'), array( 'alignment'=>'' ));

    // update version table
    $wpdb->update($wpdb->prefix.'ecp_version', array('version'=>'1.4'), array( 'ID'=>'1' ));
}

// if version after update = 1.3
if( $t_ecp_version == "1.3" &&  ECP_VERSION == "1.3") {
    
    // update version table
    $wpdb->update($wpdb->prefix.'ecp_version', array('version'=>'1.3_u'), array( 'ID'=>'1' ));
}

// if version = 1.3
if( $t_ecp_version == "" &&  ECP_VERSION == "1.3") {
    
    // update existing table
    $ecp_update1 = "ALTER TABLE ".$wpdb->prefix."ecp_data MODIFY COLUMN name varchar(35)";
    $ecp_update2 = "ALTER TABLE ".$wpdb->prefix."ecp_data MODIFY COLUMN shortcode varchar(55)";

    // create version table
    $ecp_version = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."ecp_version (
        `id` int NOT NULL AUTO_INCREMENT,
        `version` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";
    
    $wpdb->query($ecp_update1);
    $wpdb->query($ecp_update2);
    $wpdb->query($ecp_version);

    // insert version into table
    $wpdb->insert($wpdb->prefix.'ecp_version', array('version' => ECP_VERSION));
    
}

?>
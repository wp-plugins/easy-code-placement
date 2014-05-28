<?php

global $wpdb;

$ecp_id = $_GET['ecpid'];
$ecp_status = $_GET['status'];
	
$wpdb->update($wpdb->prefix.'ecp_data', array('status'=>$ecp_status), array('id'=>$ecp_id));

header('Location: options-general.php?page=ecp_option_page');

?>
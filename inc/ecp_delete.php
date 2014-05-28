<?php

global $wpdb;

$ecp_id = $_GET['ecpid'];
$wpdb->delete($wpdb->prefix.'ecp_data', array('id'=>$ecp_id));
	
header('Location: options-general.php?page=ecp_option_page');

?>
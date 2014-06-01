<?php

global $wpdb;

// secure get data and set variables
$_GET = stripslashes_deep($_GET);
$ecp_id = $_GET['ecpid'];
$ecp_status = $_GET['status'];

if ($ecp_id=="" || !is_numeric($ecp_id)) {
    // when get emty or other than numbers goto error page
    $ecp_error = __('Modifying of the ID is not allowed', 'ecp');
    $ecp_error_page = "";
    $ecp_error_id = "";
    ecp_error($ecp_error, $ecp_error_page, $ecp_error_id);
    exit();
} elseif ($ecp_status !=="1" && $ecp_status !=="2") {
    // when get emty or other than numbers goto error page
    $ecp_error = __('Modifying of the Status to something else than 1 or 2 is not allowed', 'ecp');
    $ecp_error_page = "";
    $ecp_error_id = "";
    ecp_error($ecp_error, $ecp_error_page, $ecp_error_id);
    exit();
}

// change status	
$wpdb->update($wpdb->prefix.'ecp_data', array('status'=>$ecp_status), array('id'=>$ecp_id));

// when status changes goto options page
header('Location: options-general.php?page=ecp_option_page');

?>
<?php

global $wpdb;

// secure get data and set variables
$_GET = stripslashes_deep($_GET);
$ecp_id = $_GET['ecpid'];
$ecp_alignment = $_GET['alignment'];

if ($ecp_id=="" || !is_numeric($ecp_id)) {
    // when get emty or other than numbers goto error page
    $ecp_error = __('Modifying of the ID is not allowed', 'ecp');
    $ecp_error_page = "";
    $ecp_error_id = "";
    return(ecp_error($ecp_error, $ecp_error_page, $ecp_error_id));
} elseif ($ecp_alignment !=="0" && $ecp_alignment !=="1" && $ecp_alignment !=="2" && $ecp_alignment !=="3") {
    // when get emty or other than numbers goto error page
    $ecp_error = __('Modifying the Alignment to something else than 0, 1, 2 or 3 is not allowed', 'ecp');
    $ecp_error_page = "";
    $ecp_error_id = "";
    return(ecp_error($ecp_error, $ecp_error_page, $ecp_error_id));
}

// change status	
$wpdb->update($wpdb->prefix.'ecp_data', array('alignment'=>$ecp_alignment), array('id'=>$ecp_id));

// when status changes goto options page
header('Location: options-general.php?page=ecp');

?>
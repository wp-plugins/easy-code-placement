<?php

global $wpdb;

// secure get data and set variables
$_GET = stripslashes_deep($_GET);
$ecp_id = intval($_GET['ecpid']);

if($ecp_id=="" || !is_numeric($ecp_id)) {
    // when get emty or other than numbers goto error page
    $ecp_error = __('Modifying of the ID is not allowed', 'ecp');
    $ecp_error_page = "";
    $ecp_error_id = "";
    return(ecp_error($ecp_error, $ecp_error_page, $ecp_error_id));
}

// delete code
$wpdb->delete($wpdb->prefix.'ecp_data', array('id'=>$ecp_id));

// when data is deleted goto options page	
header('Location: options-general.php?page=ecp');

?>
<?php

global $wpdb;

// when form was sent
if(isset($_POST) && isset($_POST['submit'])) {

    // secure post data and set variables
    $_POST = stripslashes_deep ($_POST);
    $t_ecp_perpage = $_POST['perpage'];

    if ($t_ecp_perpage == "") {
        // when perpage is empty
        $ecp_error = __('The Option "Codes per Page" must be filled in', 'ecp');
        $ecp_error_page = "&load=settings";
        $ecp_error_id = "";
        return(ecp_error($ecp_error, $ecp_error_page, $ecp_error_id));
    }
    
    if (!is_numeric($t_ecp_perpage)) {
        // when perpage not a number
        $ecp_error = __('The Value for the Option "Codes per Page" must be numeric', 'ecp');
        $ecp_error_page = "&load=settings";
        $ecp_error_id = "";
        return(ecp_error($ecp_error, $ecp_error_page, $ecp_error_id));
    }
    
    $wpdb->update($wpdb->prefix.'ecp_options', array('option_value'=>$t_ecp_perpage), array('option_name'=>'perpage'));

    // when added to database goto options page
    header('Location: options-general.php?page=ecp&load=settings');
    exit();

} else {
    // when nothing done
?>

<div class="wrap">
<h2>Easy Code Placement - <?php _e('Settings','ecp'); ?></h2>
<br>

<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">

<table class="widefat">
    <colgroup>
	<col width="25%" />
	<col width="75%" />
    </colgroup>
    <thead>
	<tr>
            <th><?php _e('Name','ecp'); ?></th>
            <th><?php _e('Value','ecp'); ?></th>
	</tr>
    </thead>
    <tbody>
	<tr>
            <td><?php _e('Codes per Page','ecp'); ?></td>
            <td>
                <?php global $wpdb; $per_page = $wpdb->get_var("SELECT option_value FROM ".$wpdb->prefix."ecp_options WHERE option_name = 'perpage'"); ?>
                <input type="text" name="perpage" value="<?php echo $per_page; ?>" size="10" maxlength="2">
            </td>
	</tr>
    </tbody>
</table>

<br><input type="button" class="button-secondary" value="<?php _e('Back','ecp'); ?>" onClick='document.location.href="<?php echo admin_url('options-general.php?page=ecp');?>"'>&nbsp;&nbsp;<input type="submit" name="submit" class="button-primary" value="<?php _e('Save','ecp'); ?>">
</form>

</div> 

<?php
}
?>
<?php 

global $wpdb;

// when form was sent
if(isset($_POST) && isset($_POST['submit'])) {

    // secure post data and set variables
    $_POST = stripslashes_deep ($_POST);
    $t_ecp_code = $_POST['code'];
    $t_ecp_alignment = $_POST['alignment'];
    $t_ecp_status = $_POST['status'];
    $t_ecp_id = $_POST['id'];

    if($t_ecp_id=="" || !is_numeric($t_ecp_id)) {
        // when get emty or other than numbers goto error page
        $ecp_error = __('Modifying of the ID is not allowed', 'ecp');
        $ecp_error_page = "";
        $ecp_error_id = "";
        return(ecp_error($ecp_error, $ecp_error_page, $ecp_error_id));
    }

    if ($t_ecp_code =="") {
        // when post emty goto error page
	$ecp_error = __('The Code must be filled in', 'ecp');
        $ecp_error_page = "&load=edit";
        $ecp_error_id = "&ecpid=$ecp_id";
        return(ecp_error($ecp_error, $ecp_error_page, $ecp_error_id));
    }
    
    $wpdb->update($wpdb->prefix.'ecp_data', array('code'=>$t_ecp_code,'alignment'=>$t_ecp_alignment,'status'=>$t_ecp_status), array('id'=>$t_ecp_id));

    // when edited goto options page
    header('Location: options-general.php?page=ecp');
    exit();

} else {
    // when nothing done
  
    // secure get data and set variables
    $_GET = stripslashes_deep($_GET);
    $ecp_id = $_GET['ecpid'];

    if($ecp_id=="" || !is_numeric($ecp_id)) {
        // when get emty or other than numbers goto error page
        $ecp_error = __('Modifying of the ID is not allowed', 'ecp');
        $ecp_error_page = "";
        $ecp_error_id = "";
        return(ecp_error($ecp_error, $ecp_error_page, $ecp_error_id));
    }

    $ecp_load = $wpdb->get_row('SELECT * FROM '.$wpdb->prefix.'ecp_data WHERE id= '.$ecp_id.'');
?>

<div class="wrap">
<h2>Easy Code Placement - <?php _e('Edit Code','ecp'); ?></h2>
<br>

<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
<table width="100%" border="0" cellspacing="0" cellpadding="3">    
    <tr>
        <td><?php _e('Name','ecp'); ?>:</td>
    </tr>
    <tr>
        <td><input disabled="disabled" type="text" style="width: 250px; height: 50px;" name="name" align="center" value="<?php echo ($ecp_load->name); ?>">
        <input type="hidden" name="id" align="center" value="<?php echo ($ecp_load->id); ?>">
        <br>- <?php _e('Only Letters and Numbers are allowed','ecp'); ?>.
        <br>- <?php _e('Instead of Whitesspaces use Underlines','ecp'); ?>.
        <br>- <?php _e('A maximum of 30 Characters is allowed','ecp'); ?>.</td>
    </tr>
    <tr>
        <td><?php _e('Code','ecp'); ?>:</td>
    </tr>
    <tr>
        <td><textarea style="width: 600px; height: 150px;" name="code"><?php echo ($ecp_load->code); ?></textarea></td>
    </tr>
    <tr>
        <td><?php _e('Alignment','ecp'); ?>:</td>
    </tr>
    <tr>
        <td>
            <input type="radio" name="alignment" value="0" <?php if ($ecp_load->alignment == "0" OR $ecp_load->alignment == "") {echo "checked";} else {echo "";}; ?>><?php _e('None','ecp'); ?>
            <input type="radio" name="alignment" value="1" <?php if ($ecp_load->alignment == "1") {echo "checked";} else {echo "";}; ?>><?php _e('Left','ecp'); ?>
            <input type="radio" name="alignment" value="2" <?php if ($ecp_load->alignment == "2") {echo "checked";} else {echo "";}; ?>><?php _e('Center','ecp'); ?>
            <input type="radio" name="alignment" value="3" <?php if ($ecp_load->alignment == "3") {echo "checked";} else {echo "";}; ?>><?php _e('Right','ecp'); ?>
        </td>
    </tr>
    <tr>
        <td><?php _e('Status','ecp'); ?>:</td>
    </tr>
    <tr>
        <td>
            <input type="radio" name="status" value="1" <?php if ($ecp_load->status == "1") {echo "checked";} else {echo "";}; ?>><?php _e('Online','ecp'); ?>
            <input type="radio" name="status" value="2" <?php if ($ecp_load->status == "2") {echo "checked";} else {echo "";}; ?>><?php _e('Offline','ecp'); ?>
        </td>
    </tr>
</table>
<br><input type="button" class="button-secondary" value="<?php _e('Back','ecp'); ?>" onClick='document.location.href="<?php echo admin_url('options-general.php?page=ecp');?>"'>&nbsp;&nbsp;<input type="submit" name="submit" class="button-primary" value="<?php _e('Save','ecp'); ?>">
</form>

</div>

<?php
}
?>
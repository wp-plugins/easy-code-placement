<?php

global $wpdb;

// when form was sent
if(isset($_POST) && isset($_POST['submit'])) {

    // secure post data and set variables
    $_POST = stripslashes_deep ($_POST);
    $t_ecp_name = $_POST['name'];
    $t_ecp_code = $_POST['code'];
    $t_ecp_alignment = $_POST['alignment'];
    $t_ecp_status = $_POST['status'];

    if (strlen($t_ecp_name) > 30) {
        // when name is longer than 30 chars
        $ecp_error = __('A maximum of 30 Characters is allowed', 'ecp');
        $ecp_error_page = "&load=ecpadd";
        $ecp_error_id = "";
        ecp_error($ecp_error, $ecp_error_page, $ecp_error_id);
        exit();  
    }

    if (preg_match("/[^a-zA-Z0-9\_-]/i", $t_ecp_name)) {
        // when name contains spechial chars
        $ecp_error = __('Special Characters are not allowed in the Code Name', 'ecp');
        $ecp_error_page = "&load=ecpadd";
        $ecp_error_id = "";
        ecp_error($ecp_error, $ecp_error_page, $ecp_error_id);
        exit();
    }

    if ($t_ecp_name =="" || $t_ecp_code =="") {
        // when post emty goto error page
	$ecp_error = __('The Code Name and / or the Code must be filled in', 'ecp');
        $ecp_error_page = "&load=ecpadd";
        $ecp_error_id = "";
        ecp_error($ecp_error, $ecp_error_page, $ecp_error_id);
        exit();
    }

    $wpdb->insert($wpdb->prefix.'ecp_data', array('name' =>$t_ecp_name,'code'=>$t_ecp_code,'alignment'=>$t_ecp_alignment,'shortcode'=>$t_ecp_name,'status'=>$t_ecp_status));

    // when added to database goto options page
    header('Location: options-general.php?page=ecp_option_page');
    exit();

} else {
    // when nothing done
?>

<div class="wrap">
<h2>Easy Code Placement <?php _e('Options','ecp'); ?></h2>
<br>

<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
<table width="100%" border="0" cellspacing="0" cellpadding="3">    
    <tr>
        <td><?php _e('Name','ecp'); ?>:</td>
    </tr>
    <tr>
        <td><input type="text" style="width: 250px; height: 50px;" name="name" align="center">
        <br>- <?php _e('Only Letters and Numbers are allowed','ecp'); ?>.
        <br>- <?php _e('Instead of Whitesspaces use Underlines','ecp'); ?>.
        <br>- <?php _e('A maximum of 30 Characters is allowed','ecp'); ?>.</td>
    </tr>
    <tr>
        <td><?php _e('Code','ecp'); ?>:</td>
    </tr>
    <tr>
        <td><textarea style="width: 600px; height: 150px;" name="code"></textarea></td>
    </tr>
    <tr>
        <td><?php _e('Alignment','ecp'); ?>:</td>
    </tr>
    <tr>
        <td>
            <input type="radio" name="alignment" value="0" checked><?php _e('None','ecp'); ?>
            <input type="radio" name="alignment" value="1"><?php _e('Left','ecp'); ?>
            <input type="radio" name="alignment" value="2"><?php _e('Center','ecp'); ?>
            <input type="radio" name="alignment" value="3"><?php _e('Right','ecp'); ?>
        </td>
    </tr>
    <tr>
        <td><?php _e('Status','ecp'); ?>:</td>
    </tr>
    <tr>
        <td>
            <input type="radio" name="status" value="1" checked><?php _e('Online','ecp'); ?>
            <input type="radio" name="status" value="2"><?php _e('Offline','ecp'); ?>
        </td>
    </tr>
</table>
<br><input type="button" class="button-secondary" value="<?php _e('Back','ecp'); ?>" onClick='document.location.href="<?php echo admin_url('options-general.php?page=ecp_option_page');?>"'>&nbsp;&nbsp;<input type="submit" name="submit" class="button-primary" value="<?php _e('Add','ecp'); ?>">
</form>

</div> 

<?php
}
?>
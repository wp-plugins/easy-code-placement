<?php

global $wpdb;

// when form was sent
if(isset($_POST) && isset($_POST['submit'])){

$_POST = stripslashes_deep ($_POST);
$t_ecp_name = $_POST['name'];
$t_ecp_code = $_POST['code'];

$wpdb->insert($wpdb->prefix.'ecp_data', array('name' =>$t_ecp_name,'code'=>$t_ecp_code,'shortcode'=>$t_ecp_name,'status'=>'1'));

header('Location: options-general.php?page=ecp_option_page');

}

// when nothing done
else {
?>

<div class="wrap">
<h2>Easy Code Placement <?php _e('Options','ecp'); ?></h2>
<br>

<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
<table width="100%" border="1" cellspacing="0" cellpadding="6">    
	<tr>
  <td><?php _e('Name','ecp'); ?></td>
  <td><?php _e('Code','ecp'); ?></td>
  </tr>
  <tr>
  <td><input type="text" name="name"></td>
  <td><textarea name="code"></textarea></td>
  </tr>
</table>
<input type="button" value="<?php _e('Back','ecp'); ?>" onClick='document.location.href="<?php echo admin_url('options-general.php?page=ecp_option_page');?>"'> - <input type="submit" name="submit" value="<?php _e('Add','ecp'); ?>">
</form>

</div> 

<?php
}
?>
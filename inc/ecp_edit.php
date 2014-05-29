<?php 

global $wpdb;

// when form was sent
if(isset($_POST) && isset($_POST['submit'])) {

// secure post data and set variables
$_POST = stripslashes_deep ($_POST);
$t_ecp_name = $_POST['name'];
$t_ecp_code = $_POST['code'];

// secure get data and set variables
$_GET = stripslashes_deep ($_GET);
$ecp_id = $_GET['ecpid'];

if($ecp_id=="" || !is_numeric($ecp_id)) {
  // when get emty or other than numbers goto error page
  $ecp_error = __('Modifying of the ID is not allowed', 'ecp');
  $ecp_error_page = "";
  $ecp_error_id = "";
  ecp_error($ecp_error, $ecp_error_page, $ecp_error_id);
  exit();
}

if (preg_match("/[^a-zA-Z0-9\_-]/i", $t_ecp_name)) {
    // when name contains spechial chars
    $ecp_error = __('Special Characters are not allowed in the Code Name', 'ecp');
    $ecp_error_page = "&load=ecpedit";
    $ecp_error_id = "&ecpid=$ecp_id";
    ecp_error($ecp_error, $ecp_error_page, $ecp_error_id);
    exit();
}

if ($t_ecp_name =="" || $t_ecp_code =="") {
  // when post emty goto error page
	$ecp_error = __('The Code Name and / or the Code must be filled in', 'ecp');
  $ecp_error_page = "&load=ecpedit";
  $ecp_error_id = "&ecpid=$ecp_id";
  ecp_error($ecp_error, $ecp_error_page, $ecp_error_id);
  exit();
}

$wpdb->update($wpdb->prefix.'ecp_data', array('name' =>$t_ecp_name,'code'=>$t_ecp_code,'shortcode'=>$t_ecp_name,'status'=>'1'), array('id'=>$ecp_id));

// when edited goto options page
header('Location: options-general.php?page=ecp_option_page');
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
  ecp_error($ecp_error, $ecp_error_page, $ecp_error_id);
  exit();
}

$ecp_load = $wpdb->get_row('SELECT * FROM '.$wpdb->prefix.'ecp_data WHERE id= '.$ecp_id.'');
?>

<div class="wrap">
<h2>Easy Code Placement <?php _e('Options','ecp'); ?></h2>
<br>

<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
<table width="100%" border="0" cellspacing="0" cellpadding="6">    
	<tr>
  <td><?php _e('Name','ecp'); ?></td>
  </tr>
  <tr>
  <td><input type="text" style="width: 250px; height: 50px;" name="name" align="center" value="<?php echo ($ecp_load->name); ?>">
  <br>- <?php _e('Only Letters and Numbers are allowed.','ecp'); ?>
  <br>- <?php _e('Instead of Whitesspaces use Underlines.','ecp'); ?></td>
  </tr>
	<tr>
  <td><?php _e('Code','ecp'); ?></td>
  </tr>
  <tr>
  <td><textarea style="width: 600px; height: 150px;" name="code"><?php echo ($ecp_load->code); ?></textarea></td>
  </tr>  
</table>
<input type="button" value="<?php _e('Back','ecp'); ?>" onClick='document.location.href="<?php echo admin_url('options-general.php?page=ecp_option_page');?>"'> - <input type="submit" name="submit" value="<?php _e('Save','ecp'); ?>">
</form>

</div>

<?php
}
?>
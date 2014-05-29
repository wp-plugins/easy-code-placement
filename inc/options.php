<?php

if (isset($_GET['load']) && $_GET['load']=='ecpdelete' ) {
  // when delete load
  include ( dirname( __FILE__ ) . '/ecp_delete.php' );
} elseif (isset($_GET['load']) && $_GET['load']=='ecpedit' ) {
  // when edit load
  include ( dirname( __FILE__ ) . '/ecp_edit.php' );
} elseif ( isset($_GET['load']) && $_GET['load']=='ecpadd' ) {
  // when add load
  include( dirname( __FILE__ ) . '/ecp_add.php' );
} elseif ( isset($_GET['load']) && $_GET['load']=='ecpstatus' ) {
  // when status load
  include ( dirname( __FILE__ ) . '/ecp_status.php' );
} else {
  // when nothing load options page
?>

<div class="wrap">
<h2>Easy Code Placement <?php _e('Options','ecp'); ?></h2>
<br>
<table width="100%" border="1" cellspacing="0" cellpadding="6">    
	<tr>
  <td width="33%" align="center"><?php _e('Name','ecp'); ?></td>
  <td width="33%" align="center"><?php _e('Shortcode','ecp'); ?></td>
  <td width="9%" align="center"><?php _e('Status','ecp'); ?></td>
  <td width="25%" align="center"><?php _e('Action','ecp'); ?></td>
  </tr>
  <tr>

<?php
global $wpdb;
$ecp_codes = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."ecp_data ORDER BY id DESC" );
	if( count($ecp_codes)>0 ) {
		$count=1;
		foreach( $ecp_codes as $ecp_code ) {

// list all codes
?>

  <td width="33%" align="center"><?php echo ($ecp_code->name);?></td>
  <td width="33%" align="center"><?php echo '[ecp code="'.($ecp_code->name).'"]';?></td>
  <td width="9%" align="center"><?php if($ecp_code->status == 2){	echo _e('Inaktiv','ecp');} elseif ($ecp_code->status == 1){echo _e('Activ','ecp');}?></td>

<?php
// begin of last row when inactive
if($ecp_code->status == 2) {
?>

  <td width="25%" align="center"><a href='<?php echo admin_url('options-general.php?page=ecp_option_page&load=ecpstatus&ecpid='.$ecp_code->id.'&status=1'); ?>'><?php _e('Activate','ecp'); ?></a> - 

<?php
// begin of last row when activ
} elseif ($ecp_code->status == 1) {
?>

  <td width="25%" align="center"><a href='<?php echo admin_url('options-general.php?page=ecp_option_page&load=ecpstatus&ecpid='.$ecp_code->id.'&status=2'); ?>'><?php _e('Deactivate','ecp'); ?></a> - 

<?php 	
}
?>

  <a href='<?php echo admin_url('options-general.php?page=ecp_option_page&load=ecpedit&ecpid='.$ecp_code->id); ?>'><?php _e('Edit','ecp'); ?></a> - 
  <a href='<?php echo admin_url('options-general.php?page=ecp_option_page&load=ecpdelete&ecpid='.$ecp_code->id); ?>'><?php _e('Delete','ecp'); ?></a>
  </td>
  </tr>
  
<?php
		 $count++;
		}
	} else {
    // when no code stored    
?>

	<tr>
	<td colspan="4"><center><?php _e('No Code found - Click "Add New Code" to add one.','ecp'); ?></center></td>
	</tr>

<?php
    }
?>

</table>
<input type="button" value="<?php _e('Add New Code','ecp'); ?>" onClick='document.location.href="<?php echo admin_url('options-general.php?page=ecp_option_page&load=ecpadd');?>"'>

</div> 

<?php
}
?>
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
    <td width="15%" align="center"><?php _e('Name','ecp'); ?></td>
    <td width="51%" align="center"><?php _e('Shortcode','ecp'); ?></td>
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

    <td width="15%" align="center"><?php echo ($ecp_code->name);?></td>
    <td width="51%" align="center"><?php echo '<code>[ecp code="'.($ecp_code->name).'"]</code>'; ?></td>
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
<br><input type="button" value="<?php _e('Add New Code','ecp'); ?>" onClick='document.location.href="<?php echo admin_url('options-general.php?page=ecp_option_page&load=ecpadd');?>"'>

<table width="100%" border="0" cellspacing="0" cellpadding="6">
    <tr><td width="600px" align="left"><?php _e('If you want to thank the developer for this free Plugin, you are welcome to make a donation via PayPal (you don\'t need a PayPal account to make the donation).','ecp'); ?>
    </td><td> 
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
    <input type="hidden" name="cmd" value="_s-xclick">
    <input type="hidden" name="hosted_button_id" value="2X2EH5MYGPLL4">
    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG_global.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online.">
    <img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1">
    </form>
    </td></tr>
</table>

</div> 

<?php
    }
?>
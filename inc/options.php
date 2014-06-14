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
<table width="100%" border="1" cellspacing="0" cellpadding="3">
    <tr>
        <td width="15%" align="center"><?php _e('Name','ecp'); ?></td>
        <td width="60%" align="center"><?php _e('Shortcode','ecp'); ?></td>
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
        <td width="60%" align="center"><?php echo '<code>[ecp code="'.($ecp_code->name).'"]</code>'; ?></td>

<?php
// begin of last row when inactive
if($ecp_code->status == 1) {
?>

        <td width="25%" align="center">
            <a href='<?php echo admin_url('options-general.php?page=ecp_option_page&load=ecpstatus&ecpid='.$ecp_code->id.'&status=2'); ?>'><img src="<?php echo plugins_url('../img/green.png' , __FILE__); ?>" style="vertical-align:middle;" width="30" height="30" title="<?php echo _e('Status is Activ - Click to change','ecp'); ?>" alt="<?php echo _e('Activ','ecp'); ?>"></a>&nbsp;<?php
            if ($ecp_code->alignment == 0) {
                ?><img src="<?php echo plugins_url('../img/none.png' , __FILE__); ?>" style="vertical-align:middle;" width="30" height="30" title="<?php echo _e('No Alignment - Change it under Edit','ecp'); ?>" alt="<?php echo _e('None','ecp'); ?>">&nbsp;<?php
            } elseif ($ecp_code->alignment == 1) {
                ?><img src="<?php echo plugins_url('../img/left.png' , __FILE__); ?>" style="vertical-align:middle;" width="30" height="30" title="<?php echo _e('Left Alignment - Change it under Edit','ecp'); ?>" alt="<?php echo _e('Left','ecp'); ?>">&nbsp;<?php
            } elseif ($ecp_code->alignment == 2) {
                ?><img src="<?php echo plugins_url('../img/center.png' , __FILE__); ?>" style="vertical-align:middle;" width="30" height="30" title="<?php echo _e('Center Alignment - Change it under Edit','ecp'); ?>" alt="<?php echo _e('Center','ecp'); ?>">&nbsp;<?php
            } elseif ($ecp_code->alignment == 3) {
                ?><img src="<?php echo plugins_url('../img/right.png' , __FILE__); ?>" style="vertical-align:middle;" width="30" height="30" title="<?php echo _e('Right Alignment - Change it under Edit','ecp'); ?>" alt="<?php echo _e('Right','ecp'); ?>">&nbsp;<?php
            }?>

<?php
// begin of last row when activ
} elseif ($ecp_code->status == 2) {
?>

        <td width="25%" align="center">
            <a href='<?php echo admin_url('options-general.php?page=ecp_option_page&load=ecpstatus&ecpid='.$ecp_code->id.'&status=1'); ?>'><img src="<?php echo plugins_url('../img/red.png' , __FILE__); ?>" style="vertical-align:middle;" width="30" height="30" title="<?php echo _e('Status is Deactive - Click to change','ecp'); ?>" alt="<?php echo _e('Inaktiv','ecp'); ?>"></a>&nbsp;<?php
            if ($ecp_code->alignment == 0) {
                ?><img src="<?php echo plugins_url('../img/none.png' , __FILE__); ?>" style="vertical-align:middle;" width="30" height="30" title="<?php echo _e('No Alignment - Change it under Edit','ecp'); ?>" alt="<?php echo _e('None','ecp'); ?>">&nbsp;<?php
            } elseif ($ecp_code->alignment == 1) {
                ?><img src="<?php echo plugins_url('../img/left.png' , __FILE__); ?>" style="vertical-align:middle;" width="30" height="30" title="<?php echo _e('Left Alignment - Change it under Edit','ecp'); ?>" alt="<?php echo _e('Left','ecp'); ?>">&nbsp;<?php
            } elseif ($ecp_code->alignment == 2) {
                ?><img src="<?php echo plugins_url('../img/center.png' , __FILE__); ?>" style="vertical-align:middle;" width="30" height="30" title="<?php echo _e('Center Alignment - Change it under Edit','ecp'); ?>" alt="<?php echo _e('Center','ecp'); ?>">&nbsp;<?php
            } elseif ($ecp_code->alignment == 3) {
                ?><img src="<?php echo plugins_url('../img/right.png' , __FILE__); ?>" style="vertical-align:middle;" width="30" height="30" title="<?php echo _e('Right Alignment - Change it under Edit','ecp'); ?>" alt="<?php echo _e('Right','ecp'); ?>">&nbsp;<?php
            }?>

<?php 	
}
?>

            <a href='<?php echo admin_url('options-general.php?page=ecp_option_page&load=ecpedit&ecpid='.$ecp_code->id); ?>'><img src="<?php echo plugins_url('../img/edit.png' , __FILE__); ?>" style="vertical-align:middle;" width="30" height="30" title="<?php echo _e('Edit','ecp'); ?>" alt="<?php _e('Edit','ecp'); ?>"></a>&nbsp;
            <a href='<?php echo admin_url('options-general.php?page=ecp_option_page&load=ecpdelete&ecpid='.$ecp_code->id); ?>'><img src="<?php echo plugins_url('../img/delete.png' , __FILE__); ?>" style="vertical-align:middle;" width="30" height="30" title="<?php echo _e('Delete','ecp'); ?>" alt="<?php _e('Delete','ecp'); ?>"></a>
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
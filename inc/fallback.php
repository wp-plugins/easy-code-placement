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
        <td width="25%" align="center">

<?php
// begin of last row when inactive
if($ecp_code->status == 1) {
?>

            <a href='<?php echo admin_url('options-general.php?page=ecp_option_page&load=ecpstatus&ecpid='.$ecp_code->id.'&status=2'); ?>'><img src="<?php echo plugins_url('../img/green.png' , __FILE__); ?>" style="vertical-align:middle;" width="32" height="32" title="<?php echo _e('Status is Online - Click to change','ecp'); ?>" alt="<?php echo _e('Online','ecp'); ?>"></a>&nbsp;&nbsp;

<?php
// begin of last row when activ
} elseif ($ecp_code->status == 2) {
?>

            <a href='<?php echo admin_url('options-general.php?page=ecp_option_page&load=ecpstatus&ecpid='.$ecp_code->id.'&status=1'); ?>'><img src="<?php echo plugins_url('../img/red.png' , __FILE__); ?>" style="vertical-align:middle;" width="32" height="32" title="<?php echo _e('Status is Offline - Click to change','ecp'); ?>" alt="<?php echo _e('Offline','ecp'); ?>"></a>&nbsp;&nbsp;

<?php 	
}

            if ($ecp_code->alignment == 0) {
                ?><a href='<?php echo admin_url('options-general.php?page=ecp_option_page&load=ecpalignment&ecpid='.$ecp_code->id.'&alignment=1'); ?>'><img src="<?php echo plugins_url('../img/none.png' , __FILE__); ?>" style="vertical-align:middle;" width="32" height="32" title="<?php echo _e('No Alignment - Click to change','ecp'); ?>" alt="<?php echo _e('None','ecp'); ?>"></a>&nbsp;<?php
            } elseif ($ecp_code->alignment == 1) {
                ?><a href='<?php echo admin_url('options-general.php?page=ecp_option_page&load=ecpalignment&ecpid='.$ecp_code->id.'&alignment=2'); ?>'><img src="<?php echo plugins_url('../img/left.png' , __FILE__); ?>" style="vertical-align:middle;" width="32" height="32" title="<?php echo _e('Left Alignment - Click to change','ecp'); ?>" alt="<?php echo _e('Left','ecp'); ?>"></a>&nbsp;<?php
            } elseif ($ecp_code->alignment == 2) {
                ?><a href='<?php echo admin_url('options-general.php?page=ecp_option_page&load=ecpalignment&ecpid='.$ecp_code->id.'&alignment=3'); ?>'><img src="<?php echo plugins_url('../img/center.png' , __FILE__); ?>" style="vertical-align:middle;" width="32" height="32" title="<?php echo _e('Center Alignment - Click to change','ecp'); ?>" alt="<?php echo _e('Center','ecp'); ?>"></a>&nbsp;<?php
            } elseif ($ecp_code->alignment == 3) {
                ?><a href='<?php echo admin_url('options-general.php?page=ecp_option_page&load=ecpalignment&ecpid='.$ecp_code->id.'&alignment=0'); ?>'><img src="<?php echo plugins_url('../img/right.png' , __FILE__); ?>" style="vertical-align:middle;" width="32" height="32" title="<?php echo _e('Right Alignment - Click to change','ecp'); ?>" alt="<?php echo _e('Right','ecp'); ?>"></a>&nbsp;<?php
            }?>
            <a href='<?php echo admin_url('options-general.php?page=ecp_option_page&load=ecpedit&ecpid='.$ecp_code->id); ?>'><img src="<?php echo plugins_url('../img/edit.png' , __FILE__); ?>" style="vertical-align:middle;" width="32" height="32" title="<?php echo _e('Edit','ecp'); ?>" alt="<?php _e('Edit','ecp'); ?>"></a>&nbsp;
            <a href='<?php echo admin_url('options-general.php?page=ecp_option_page&load=ecpdelete&ecpid='.$ecp_code->id); ?>'><img src="<?php echo plugins_url('../img/delete.png' , __FILE__); ?>" style="vertical-align:middle;" width="32" height="32" title="<?php echo _e('Delete','ecp'); ?>" alt="<?php _e('Delete','ecp'); ?>"></a>
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
<br>
<?php

if (isset($_GET['load']) && $_GET['load']=='delete' ) {
    // when delete load
    include ( dirname( __FILE__ ) . '/actions/delete.php' );
    } elseif (isset($_GET['load']) && $_GET['load']==='edit' ) {
    // when edit load
    include ( dirname( __FILE__ ) . '/actions/edit.php' );
    } elseif ( isset($_GET['load']) && $_GET['load']==='add' ) {
    // when add load
    include( dirname( __FILE__ ) . '/actions/add.php' );
    } elseif ( isset($_GET['load']) && $_GET['load']==='status' ) {
    // when status load
    include ( dirname( __FILE__ ) . '/actions/status.php' );
    } elseif ( isset($_GET['load']) && $_GET['load']==='alignment' ) {
    // when alignment load
    include ( dirname( __FILE__ ) . '/actions/alignment.php' );
    } elseif ( isset($_GET['load']) && $_GET['load']==='settings' ) {
    // when settings load
    include ( dirname( __FILE__ ) . '/settings.php' );
    } elseif ( isset($_GET['load']) && $_GET['load']==='system' ) {
    // when system load
    include ( dirname( __FILE__ ) . '/system.php' );
    } else {
    // when nothing load options page
     
?>

<div class="wrap">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="70%" align="left"><h2>Easy Code Placement - <?php _e('Codes','ecp'); ?></h2></td>
        <td width="30%" align="right"><input type="button" class="button-secondary" value="<?php _e('System Information','ecp'); ?>" onClick='document.location.href="<?php echo admin_url('options-general.php?page=ecp&load=system');?>"'></td>
    </tr>
</table>

<?php render_ecp_table(); ?>

<input type="button" class="button-primary" value="<?php _e('Add New Code','ecp'); ?>" onClick='document.location.href="<?php echo admin_url('options-general.php?page=ecp&load=add');?>"'>&nbsp;&nbsp;<input type="button" class="button-primary" value="<?php _e('Settings','ecp'); ?>" onClick='document.location.href="<?php echo admin_url('options-general.php?page=ecp&load=settings');?>"'>

<table width="100%" border="0" cellspacing="0" cellpadding="6">
    <tr>
        <td width="600px" align="left"><?php _e('If you want to thank the developer for this free Plugin, you are welcome to make a donation via PayPal (you don\'t need a PayPal account to make the donation).','ecp'); ?></td>
        <td><form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="hosted_button_id" value="2X2EH5MYGPLL4">
            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG_global.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online.">
            <img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1"></form>
        </td>
    </tr>
</table>

</div> 

<?php
    }
?>
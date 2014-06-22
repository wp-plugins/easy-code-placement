<?php

if (isset($_GET['load']) && $_GET['load']=='ecpdelete' ) {
    // when delete load
    include ( dirname( __FILE__ ) . '/actions/ecp_delete.php' );
    } elseif (isset($_GET['load']) && $_GET['load']==='ecpedit' ) {
    // when edit load
    include ( dirname( __FILE__ ) . '/actions/ecp_edit.php' );
    } elseif ( isset($_GET['load']) && $_GET['load']==='ecpadd' ) {
    // when add load
    include( dirname( __FILE__ ) . '/actions/ecp_add.php' );
    } elseif ( isset($_GET['load']) && $_GET['load']==='ecpstatus' ) {
    // when status load
    include ( dirname( __FILE__ ) . '/actions/ecp_status.php' );
    } elseif ( isset($_GET['load']) && $_GET['load']==='ecpalignment' ) {
    // when alignment load
    include ( dirname( __FILE__ ) . '/actions/ecp_alignment.php' );
    } else {
    // when nothing load options page
     
?>

<div class="wrap">
<h2>Easy Code Placement <?php _e('Options','ecp'); ?></h2>

<?php render_ecp_options_table(); ?>

<input type="button" class="button-primary" value="<?php _e('Add New Code','ecp'); ?>" onClick='document.location.href="<?php echo admin_url('options-general.php?page=ecp_option_page&load=ecpadd');?>"'>

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
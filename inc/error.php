<div class="wrap">
<h2>Easy Code Placement <?php _e('Error','ecp'); ?></h2>
<br>

<table width="100%" border="0" cellspacing="0" cellpadding="6">    
    <tr>
        <td><h3><font color="#FF0000"><?php _e('Error','ecp'); ?>!</font></h3></td>
    </tr>
    <tr>
        <td><?php echo $ecp_error; ?>!</td>
    </tr>
</table>
<br><input type="button" class="button-secondary" value="<?php _e('Back','ecp'); ?>" onClick='document.location.href="<?php echo admin_url("options-general.php?page=ecp$ecp_error_page$ecp_error_id");?>"'>

</div>
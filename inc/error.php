<div class="wrap">
<h2>Easy Code Placement <?php _e('Options','ecp'); ?></h2>
<br>

<table width="100%" border="0" cellspacing="0" cellpadding="6">    
    <tr>
    <td><?php _e('Error','ecp'); ?></td>
    </tr>
    <tr>
    <td><?php echo $ecp_error; ?></td>
    </tr>
</table>
<input type="button" value="<?php _e('Back','ecp'); ?>" onClick='document.location.href="<?php echo admin_url("options-general.php?page=ecp_option_page$ecp_error_page$ecp_error_id");?>"'>

</div>
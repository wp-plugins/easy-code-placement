<div class="wrap">
<h2>Easy Code Placement - <?php _e('System Information','ecp'); ?></h2>
<br>

<h3><?php _e('General','ecp'); ?></h3>
<table class="widefat">
    <colgroup>
	<col width="25%" />
	<col width="75%" />
    </colgroup>
    <thead>
	<tr>
            <th><?php _e('Name','ecp'); ?></th>
            <th><?php _e('Value','ecp'); ?></th>
	</tr>
    </thead>
    <tbody>
	<tr>
            <td><?php _e('PHP Version','ecp'); ?></td>
            <td><?php echo PHP_VERSION; ?></td>
	</tr>
        <tr>
            <td><?php _e('MySQL Version','ecp'); ?></td>
            <td><?php
                    if (isset($GLOBALS['wpdb']->dbh->server_info)) {
			echo $GLOBALS['wpdb']->dbh->server_info;
                    } else if (function_exists('mysql_get_server_info')) {
			echo mysql_get_server_info();
                    }
		?>
            </td>
        </tr>
	<tr>
            <td><?php _e('WordPress Version','ecp'); ?></td>
            <td><?php echo get_bloginfo ('version'); ?></td>
	</tr>
	<tr>
            <td><?php _e('WordPress Network Page','ecp'); ?></td>
            <td><?php
                    if (is_multisite()) {
                        _e('Yes','ecp');
                    } else {
                        _e('No','ecp');
                    }
                ?>
            </td>
	</tr>
	<tr>
            <td><?php _e('Plugin Version (File)','ecp'); ?></td>
            <td><?php echo ECP_VERSION; ?></td>
	</tr>
	<tr>
            <td><?php _e('Plugin Version (Database)','ecp'); ?></td>
            <td><?php
                    global $wpdb;
                    $ecp_options_version = $wpdb->get_var("SELECT option_value FROM ".$wpdb->prefix."ecp_options WHERE option_name = 'version'");
                    if ($ecp_options_version === '') {
                        _e('Error','ecp');
                    } else {
                        echo $ecp_options_version;
                    }
                ?>
            </td>
	</tr>
    </tbody>
</table>

<h3><?php _e('Configuration','ecp'); ?></h3>
<table class="widefat">
    <colgroup>
	<col width="25%" />
	<col width="75%" />
    </colgroup>
    <thead>
	<tr>
            <th><?php _e('Name','ecp'); ?></th>
            <th><?php _e('Value','ecp'); ?></th>
	</tr>
    </thead>
    <tbody>
	<tr>
            <td><?php _e('PHP max. execution time','ecp'); ?></td>
            <td><?php if (function_exists('ini_get')) echo ini_get('max_execution_time'); ?>s</td>
	</tr>
	<tr>
            <td><?php _e('PHP memory limit','ecp'); ?></td>
            <td><?php if (function_exists('ini_get')) echo ini_get('memory_limit').'B'; ?></td>
	</tr>
	<tr>
            <td><?php _e('WordPress memory limit','ecp'); ?></td>
            <td><?php echo WP_MEMORY_LIMIT; ?>B</td>
	</tr>
    </tbody>
</table>

<h3><?php _e('Paths','ecp'); ?></h3>
<table class="widefat">
    <colgroup>
        <col width="25%" />
	<col width="75%" />
    </colgroup>
    <thead>
	<tr>
            <th><?php _e('Name','ecp'); ?></th>
            <th><?php _e('Value','ecp'); ?></th>
	</tr>
    </thead>
    <tbody>
	<tr>
            <td><?php _e('Home URL','ecp'); ?></td>
            <td class="code"><?php echo home_url(); ?></td>
	</tr>
	<tr>
            <td><?php _e('Site URL','ecp'); ?></td>
            <td class="code"><?php echo site_url(); ?></td>
	</tr>
	<tr>
            <td><?php _e('Plugin URL','ecp'); ?></td>
            <td class="code"><?php echo plugins_url(); ?></td>
	</tr>
    </tbody>
</table>


<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
<br><input type="button" class="button-secondary" value="<?php _e('Back','ecp'); ?>" onClick='document.location.href="<?php echo admin_url('options-general.php?page=ecp');?>"'>
</form>

</div>
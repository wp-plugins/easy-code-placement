<?php

class ecp_options_table extends ecp_tables {
    
    // set up a constructor that references the parent constructor
    function __construct(){
        global $status, $page;
        parent::__construct( array(
            'singular' => 'shortcode',
            'plural' => 'shortcodes',
            'ajax' => false
        ) );
    }

    // method for action column
    function column_action ($item){
        if ($item['status'] === '1') {
            ?><a href='<?php echo admin_url('options-general.php?page=ecp_option_page&load=ecpstatus&ecpid='.$item['id'].'&status=2'); ?>'><img src="<?php echo plugins_url('../../img/green.png' , __FILE__); ?>" style="vertical-align:middle;" width="32" height="32" title="<?php echo _e('Status is Online - Click to change','ecp'); ?>" alt="<?php echo _e('Online','ecp'); ?>"></a>&nbsp;&nbsp;<?php
        } elseif ($item['status'] === '2') {
            ?><a href='<?php echo admin_url('options-general.php?page=ecp_option_page&load=ecpstatus&ecpid='.$item['id'].'&status=1'); ?>'><img src="<?php echo plugins_url('../../img/red.png' , __FILE__); ?>" style="vertical-align:middle;" width="32" height="32" title="<?php echo _e('Status is Offline - Click to change','ecp'); ?>" alt="<?php echo _e('Offline','ecp'); ?>"></a>&nbsp;&nbsp;<?php
        }
        if ($item['alignment'] === '0') {
            ?><a href='<?php echo admin_url('options-general.php?page=ecp_option_page&load=ecpalignment&ecpid='.$item['id'].'&alignment=1'); ?>'><img src="<?php echo plugins_url('../../img/none.png' , __FILE__); ?>" style="vertical-align:middle;" width="32" height="32" title="<?php echo _e('No Alignment - Click to change','ecp'); ?>" alt="<?php echo _e('None','ecp'); ?>"></a>&nbsp;<?php
        } elseif ($item['alignment'] === '1') {
            ?><a href='<?php echo admin_url('options-general.php?page=ecp_option_page&load=ecpalignment&ecpid='.$item['id'].'&alignment=2'); ?>'><img src="<?php echo plugins_url('../../img/left.png' , __FILE__); ?>" style="vertical-align:middle;" width="32" height="32" title="<?php echo _e('Left Alignment - Click to change','ecp'); ?>" alt="<?php echo _e('Left','ecp'); ?>"></a>&nbsp;<?php
        } elseif ($item['alignment'] === '2') {
            ?><a href='<?php echo admin_url('options-general.php?page=ecp_option_page&load=ecpalignment&ecpid='.$item['id'].'&alignment=3'); ?>'><img src="<?php echo plugins_url('../../img/center.png' , __FILE__); ?>" style="vertical-align:middle;" width="32" height="32" title="<?php echo _e('Center Alignment - Click to change','ecp'); ?>" alt="<?php echo _e('Center','ecp'); ?>"></a>&nbsp;<?php
        } elseif ($item['alignment'] === '3') {
            ?><a href='<?php echo admin_url('options-general.php?page=ecp_option_page&load=ecpalignment&ecpid='.$item['id'].'&alignment=0'); ?>'><img src="<?php echo plugins_url('../../img/right.png' , __FILE__); ?>" style="vertical-align:middle;" width="32" height="32" title="<?php echo _e('Right Alignment - Click to change','ecp'); ?>" alt="<?php echo _e('Right','ecp'); ?>"></a>&nbsp;<?php
        }?>
        <a href='<?php echo admin_url('options-general.php?page=ecp_option_page&load=ecpedit&ecpid='.$item['id']); ?>'><img src="<?php echo plugins_url('../../img/edit.png' , __FILE__); ?>" style="vertical-align:middle;" width="32" height="32" title="<?php echo _e('Edit','ecp'); ?>" alt="<?php _e('Edit','ecp'); ?>"></a>&nbsp;
        <a href='<?php echo admin_url('options-general.php?page=ecp_option_page&load=ecpdelete&ecpid='.$item['id']); ?>'><img src="<?php echo plugins_url('../../img/delete.png' , __FILE__); ?>" style="vertical-align:middle;" width="32" height="32" title="<?php echo _e('Delete','ecp'); ?>" alt="<?php _e('Delete','ecp'); ?>"></a>
        <?php
        return;
    }

    // method for name column
    function column_name ($item){
        return $item['name'];
    }

    // method for shortcode column
    function column_shortcode ($item){
        ?><code>[ecp code="<?php echo $item['shortcode'];?>"]</code><?php
        return;
    }

    // if no method set for a column
    function column_default($item){
        return print_r($item,true);
    }

    // set all columns
    function get_columns(){
        $columns = array(
            'name' => __('Name', 'ecp'),
            'shortcode' => __('Shortcode', 'ecp'),
            'action' => __('Action', 'ecp')
        );
        return $columns;
    }

    // colums wich are not shown
    function get_hidden_columns(){
        return array();
    }

    // if no data - say
    function no_items() {
        _e('No Code found - Click "Add New Code" to add one.','ecp');
    }

    // set up und load everything
    function prepare_items() {
        global $wpdb;

        $per_page = $wpdb->get_var("SELECT option_value FROM ".$wpdb->prefix."ecp_options WHERE option_name = 'perpage'");
        
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array($columns, $hidden, $sortable);

        $sql = "SELECT * FROM ".$wpdb->prefix."ecp_data ORDER BY name ASC";
        $data = $wpdb->get_results($sql, ARRAY_A);

        $current_page = $this->get_pagenum();
        $total_items = count($data);
        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);

        $this->items = $data;
        
        $this->set_pagination_args( array(
            'total_items' => $total_items,
            'per_page' => $per_page,
            'total_pages' => ceil($total_items/$per_page)
        ) );
    }
}

?>
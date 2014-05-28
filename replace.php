<?php 

global $wpdb;

add_shortcode('ecp','ecp_replace');		

function ecp_replace($ecp_code){
	global $wpdb;

		$query = $wpdb->get_results($wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."ecp_data WHERE name=%s" ,$ecp_code));
		
		if(count($query)>0){
			
			foreach ($query as $code_load){
			if($code_load->status==1)
				return do_shortcode($code_load->code) ;
			else 
				return '';
				break;
			}
      			
		}else{
			return '';		
		}
		
	}

add_filter ( 'the_content', 'do_shortcode' );
add_filter ( 'widget_text', 'do_shortcode' );
add_filter ( 'the_excerpt', 'do_shortcode' );

?>
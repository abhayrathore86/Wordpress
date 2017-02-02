<?php
require_once('../../../wp-load.php'); 
global $wpdb;	
	$c_id=$_REQUEST['id'];
	   	$where = array('c_id' => $c_id );
	   	if($wpdb->delete( 'wp_customer', $where)){
				echo "data deleted successfully";
		}
		else {
		    echo "Can not delete data";
		}
?>
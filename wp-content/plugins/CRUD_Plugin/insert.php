<?php
require_once('../../../wp-load.php'); 
global $wpdb;
	$fn=$_REQUEST['firstname'];
	$ln=$_REQUEST['lastname'];
	$age=$_REQUEST['age'];
	$gender=$_REQUEST['gender'];	
	if ( ! function_exists( 'wp_handle_upload' ) ) {
	    require_once( ABSPATH . 'wp-admin/includes/file.php' );
	}

	$uploadedfile = $_FILES['image'];
	$image=$uploadedfile['name'];
	$upload_overrides = array( 'test_form' => false );

	$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );

	if ( $movefile && ! isset( $movefile['error'] ) ) {
	    $data=array('c_fname'=>$fn,'c_lname'=>$ln,'c_age'=>$age,'c_gender'=>$gender,'c_image'=>$image);
	   	if($wpdb->insert( 'wp_customer', $data)){
				echo "data inserted";
		}
	} else {
	    echo $movefile['error'];
	}
?>
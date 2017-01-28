<?php
require_once('../../../wp-load.php'); 
global $wpdb;
	$fn=$_REQUEST['firstname'];
	$ln=$_REQUEST['lastname'];
	$age=$_REQUEST['age'];
	$gender=$_REQUEST['gender'];
	$target_dir = "/var/www/html/wordpress/wp-content/uploads/2017/01/";
	$image=basename($_FILES["image"]["name"]);
	$target_file = $target_dir.$image ;
	if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
	    $data=array('c_fname'=>$fn,'c_lname'=>$ln,'c_age'=>$age,'c_gender'=>$gender,'c_image'=>$image);
	    	if($wpdb->insert( 'wp_customer', $data)){
				echo "data inserted";
			} 
	    } else {
	        echo "Sorry, there was an error uploading your file.";
	    }
		
	
	
?>
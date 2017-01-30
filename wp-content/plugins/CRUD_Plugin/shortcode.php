<?php
/*
* Plugin Name: WordPress ShortCode CRUD
* Description: WordPress shortcode for CRUD operation.
*/
add_action( 'init', 'my_script_enqueuer' );

function my_script_enqueuer() {
   wp_register_script( "crud_script", WP_PLUGIN_URL.'/CRUD_Plugin/js/crud_script.js', array('jquery') );
   wp_localize_script( 'crud_script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        

   wp_enqueue_script( 'jquery' );
   wp_enqueue_script( 'crud_script' );

}
function form_creation(){
?>

<form enctype="multipart/form-data" method="POST" id="insertForm">
<h1>Enter Data Here</h1>
First name : <input type="text" name="firstname" id="firstname"><br>
Last name : <input type="text" name="lastname" id="lastname"><br>
Age : <input type="number" name="age" id="age"><br>
Gender : <input type="radio" name="gender" value="male" id="gender">Male <input type="radio" name="gender" value="female" id="gender">Female<br><br>
Upload Photo : <input type="file" name="image" id="imageUp" accept="image/*"><br><br>
<input type="submit" value="Insert Data" name="submit_btn" id="btn_submit">
</form>
<div id="editForm"></div>
<h1>Customer Data</h1>
<div style="overflow: scroll;height: 500px;width: 700px" id="disp">
</div>
<?php
}
add_shortcode('insert_form', 'form_creation');
if (isset($_REQUEST['update_btn'])) {
	$fn=$_REQUEST['firstname'];
	$ln=$_REQUEST['lastname'];
	$age=$_REQUEST['age'];
	$gender=$_REQUEST['gender'];
	$target_dir = "/var/www/html/wordpress/wp-content/uploads/2017/01/";
	if (empty($_FILES["image"]["name"])) {
    	$image=$_REQUEST['data'];
	}else{
	$image=basename($_FILES["image"]["name"]);
	}
	$target_file = $target_dir.$image ;
		    if (move_uploaded_file($image, $target_file)) {
		    	$data=array('c_fname'=>$fn,'c_lname'=>$ln,'c_age'=>$age,'c_gender'=>$gender,'c_image'=>$image);
		    	$where=array('c_id'=>$_REQUEST['q']);
		    	
		    	if($wpdb->update( 'wp_customer', $data,$where)){
					echo "data updated";
				}
		        
		    } else {
		        echo "Sorry, there was an error uploading your file.";
		    }
		
}
?>
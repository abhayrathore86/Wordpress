<?php
/*
* Plugin Name: WordPress ShortCode CRUD
* Description: WordPress shortcode for CRUD operation.
*/
include_once(ABSPATH . 'wp-includes/pluggable.php');
add_action('wp_head', 'myplugin_ajaxurl');

function myplugin_ajaxurl() {

   echo '<script type="text/javascript">
           var ajaxurl = "' . admin_url('admin-ajax.php') . '";
         </script>';
}

add_action( 'init', 'my_script_enqueuer' );

function my_script_enqueuer() {
   wp_register_script( "crud_script", WP_PLUGIN_URL.'/CRUD_Plugin/js/crud_script.js', array('jquery') );
   wp_localize_script( 'crud_script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        

   wp_enqueue_script( 'jquery' );
   wp_enqueue_script( 'crud_script');
}

function CRUD_plugin_create_table() {
	global $wpdb;
	 $table_name = $wpdb->prefix . 'customer';
	 $sql = "CREATE TABLE IF NOT EXISTS $table_name (
	 c_id int(50) unsigned NOT NULL AUTO_INCREMENT,
	 c_fname varchar(50) NOT NULL,
	 c_lname varchar(50) NOT NULL,
	 c_age int(10) NOT NULL,
	 c_gender varchar(10) NOT NULL,
	 c_image varchar(300) NOT NULL,
	 PRIMARY KEY  (c_id)
	 );";
	 require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	 dbDelta( $sql );
}
register_activation_hook( __FILE__, 'CRUD_plugin_create_table' );

function CRUD_plugin_deactivate() {
    global $wpdb;
    $table = $wpdb->prefix."customer";
    $wpdb->query("DROP TABLE IF EXISTS $table");
}
register_deactivation_hook( __FILE__, 'CRUD_plugin_deactivate' );

function form_creation(){
?>
<div id="Form">
<form enctype="multipart/form-data" method="POST" id="insertForm">
<h1>Enter Data Here</h1>
First name : <input type="text" name="firstname" id="firstname"><br>
Last name : <input type="text" name="lastname" id="lastname"><br>
Age : <input type="number" name="age" id="age"><br>
Gender : <input type="radio" name="gender" value="male" id="gender">Male <input type="radio" name="gender" value="female" id="gender">Female<br><br>
Upload Photo : <input type="file" name="image" id="imageUp" accept="image/*"><br><br>
<input type="submit" value="Insert Data" name="submit_btn" id="btn_submit">
</form>
</div>
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
	$c_id=$_REQUEST['cus_id'];
	
	if ( ! function_exists( 'wp_handle_upload' ) ) {
	    require_once( ABSPATH . 'wp-admin/includes/file.php' );
	}
	$uploadedfile = $_FILES['image'];
	$image=$uploadedfile['name'];
	$upload_overrides = array( 'test_form' => false );
	$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
	if ( $movefile && ! isset( $movefile['error'] ) ) {
	    $data=array('c_fname'=>$fn,'c_lname'=>$ln,'c_age'=>$age,'c_gender'=>$gender,'c_image'=>$image);
		    	$where=array('c_id'=>$c_id);
		    	if($wpdb->update( 'wp_customer', $data,$where)){
					echo "<script>alert('data updated');</script>";
				}
	} else {
	    echo "<script>alert('".$movefile['error']."');</script>";
	}
		
}

function dispData() {
 
	if ( isset($_REQUEST) ) {
		global $wpdb;
		$sql='select * from wp_customer';
		$results=$wpdb->get_results($sql);
		if (count($results)> 0){?>
			<table border="1">
			<thead>
		    <tr>
		     <th>Customer Id</th>
		     <th>First Name</th>
		     <th>Last Name</th>
		     <th>Age</th>
		     <th>Gender</th>
		     <th>Photo</th>
		     <th>Action</th>
		    </tr>
		    </thead>
		    <tbody>
		<?php
			  foreach ( $results as $print )   { ?>
		          <tr>
		                  <td><?php echo $print->c_id; ?> </td>
		                  <td><?php echo $print->c_fname; ?> </td>
		                  <td> <?php echo $print->c_lname ; ?> </td>
		                  <td> <?php echo $print->c_age; ?> </td>
		                  <td><?php echo $print->c_gender; ?> </td>
		                  <td><img src="../wp-content/uploads/2017/01/<?php echo $print->c_image; ?>" style="height:200px;width: 200px"> </td>
		                  <td><input type="button" id="update_btn" value="Update" onClick="UpdateRecord(<?php echo $print->c_id; ?>);"><br><br><input type="button" id="del_btn" value="Delete" onClick="DeleteRecord(<?php echo $print->c_id; ?>);"></td>
		          </tr>
		            <?php 
		        }?>
			</tbody>
			</table>
			</div>
		        <?php
		}else{
			echo '<h2>No Data Found</h2>';
		}
	
	}
   die();
}

add_action( 'wp_ajax_dispData', 'dispData' );

function insertData() {
 	 echo '<script>console.log("request");</script>';
	 if ( isset($_REQUEST) ) {
	 
	global $wpdb;
	$fn=$_REQUEST['fn'];
	$ln=$_REQUEST['ln'];
	$age=$_REQUEST['age'];
	$gender=$_REQUEST['gen'];	
	if ( ! function_exists( 'wp_handle_upload' ) ) {
	    require_once( ABSPATH . 'wp-admin/includes/file.php' );
	}

	$uploadedfile = $_FILES['im'];
	echo $uploadedfile;
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
	}
   die();
}

add_action( 'wp_ajax_insertData', 'insertData' );


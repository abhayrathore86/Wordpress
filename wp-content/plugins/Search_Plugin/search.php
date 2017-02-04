<?php
/*
	Plugin Name: Search Zip Code Plugin
	Description: Search Data Using Zip Code
	*/

function Search_Plugin_activate() {
	global $wpdb;
	 $table_name = $wpdb->prefix . 'zip_code_to_country_code';
	 $sql = "CREATE TABLE IF NOT EXISTS $table_name (
	 z_id int(50) unsigned NOT NULL AUTO_INCREMENT,
	 ZIP int(50) NOT NULL,
	 Country_code int(50) NOT NULL,
	 City varchar(100) NOT NULL,
	 ST varchar(100) NOT NULL,
	 Country varchar(300) NOT NULL,
	 PRIMARY KEY  (z_id),
	 UNIQUE (ZIP)
	 );";
	 $table_name1 = $wpdb->prefix . 'locations';
	 $sql1 = "CREATE TABLE IF NOT EXISTS $table_name1 (
	 l_id int(50) unsigned NOT NULL AUTO_INCREMENT,
	 franchise_id int(50) NOT NULL,
	 franchise_name varchar(50) NOT NULL,
	 phone varchar(50) NOT NULL,
	 website varchar(100) NOT NULL,
	 email varchar(300) NOT NULL,
	 county_codes varchar(100) NOT NULL,
	 PRIMARY KEY  (l_id),
	 UNIQUE (franchise_id)
	 );";
	 require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	 dbDelta( $sql );
	 dbDelta( $sql1);


}
register_activation_hook( __FILE__, 'Search_Plugin_activate' );

function Search_Plugin_deactivate() {
    global $wpdb;
    $table = $wpdb->prefix."zip_code_to_country_code";
    $wpdb->query("DROP TABLE IF EXISTS $table");
    $table1 = $wpdb->prefix."locations";
    $wpdb->query("DROP TABLE IF EXISTS $table1");
}
register_deactivation_hook( __FILE__, 'Search_Plugin_deactivate' );

add_action( 'init', 'my_script' );

function my_script() {

   wp_register_script( "getdatajs", plugin_dir_url(__FILE__).'js/jquery_getdata.js', array('jquery') );
   wp_register_script('bootstrap-js',plugin_dir_url(__FILE__).'js/bootstrap.min.js');
    wp_register_style('bootstrap-css',plugin_dir_url(__FILE__) . 'css/bootstrap.min.css');
   wp_localize_script( 'getdatajs', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        
   
}
//front end
add_filter( 'wp_nav_menu_items','add_search_box', 10, 2 );
function add_search_box( $items, $args ) {
	wp_enqueue_style( 'bootstrap-css');
    wp_enqueue_script('bootstrap-js');
	wp_enqueue_script( 'jquery' );
   wp_enqueue_script( 'getdatajs');
   
    return "<li><input type='text' name='search_zip' id='search_zip' placeholder='Enter Zip Code' style='vertical-align:top;display:inline-block;border:1;width:250px;height:32px;'><button style='display:inline-block;border: 1px solid black;padding:3px;height:32px;' id='search_btn'>Search</button></li><p id='country'></p><br/>".$items;
    return $items;
}

//getdata function ajax call

add_action( 'wp_ajax_getData', 'getData' );

function getData(){
	if ( isset($_REQUEST) ) {
	global $wpdb;
	$output='';
	$str=$_REQUEST['search_txt'];
	$sql='select * from wp_zip_code_to_country_code where ZIP='.$str;
	//echo $sql;
	$results=$wpdb->get_results($sql);
	if (count($results)> 0){
		foreach ( $results as $print ){
			$country_code=$print->Country_code;
		}
	
		$sql1='select * from wp_locations where county_codes LIKE  "%'.$country_code.'%"';
		$results1=$wpdb->get_results($sql1);
	
		if (count($results1)> 0){
			$output .= '<div class="table-responsive">
			<?php echo $country_code?><table class="table table-bordered"><tr>';
    		foreach ( array_slice($wpdb->get_col( "DESC " . "wp_locations", 0 ),1) as $column_name ) {
			  $output.="<th>".$column_name."</th>";
			}
			//echo json_encode($results1);
			foreach ( $results1 as $print ){
				$output.='<tr>';
				$output.='<td>'.$print->franchise_id.'</td>';
				$output.='<td>'.$print->franchise_name.'</td>';
				$output.='<td>'.$print->phone.'</td>';
				$output.='<td>'.$print->website.'</td>';
				$output.='<td>'.$print->email.'</td>';
				$output.='<td>'.$print->county_codes.'</td>';
				$output.='</tr>';
			}
			$output .= "</table></div>";  
      		echo $output;
		}
		}else{
			echo 'No Data Found';
		}
	}
}

add_action('admin_menu', 'register_menu_search');
function register_menu_search() {
    add_menu_page('Search', 'Search', 'manage_options', 'search', 'Upload_Files');
}

function Upload_Files(){
	?>
		<!DOCTYPE html>
		<html>
		<head>
			<title></title>
		</head>
		<body>
		<h1>Upload CSV Files</h1>
		<form enctype="multipart/form-data" method="post">
		<h3>Upload Zip Code File: <input type="file" name="zip_code_to_country_code"/><br>
		Upload Locations File: <input type="file" name="locations"/><br>
		<input type="submit" name="submit" value="Upload Files" id="submit_btn"></h3>		
		</form>
		</body>
		</html>
	<?php
	$in=0;
		$up=0;
		$up1=0;
		$in1=0;
	if(isset($_REQUEST['submit'])){
		
		global $wpdb;
		//upload zip file
    $csvMimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
    if(!empty($_FILES['zip_code_to_country_code']['name']) && in_array($_FILES['zip_code_to_country_code']['type'],$csvMimes)){
        if(is_uploaded_file($_FILES['zip_code_to_country_code']['tmp_name'])){
            //open uploaded csv file with read only mode
            $csvFile = fopen($_FILES['zip_code_to_country_code']['tmp_name'], 'r');
            //skip first line
            fgetcsv($csvFile);
            //parse data from csv file line by line
            while(($line = fgetcsv($csvFile)) !== FALSE){
                //check whether member already exists in database with same email
              	$sql='select * from wp_zip_code_to_country_code where ZIP='.$line[0];
				$results=$wpdb->get_results($sql);
				if (count($results)> 0){
					$dataup=array('ZIP'=>$line[0],'Country_code'=>$line[1],'City'=>$line[2],'ST'=>$line[3],'Country'=>$line[4]);
					$where=array('ZIP'=>$line[0]);
					if($wpdb->update( 'wp_zip_code_to_country_code', $dataup,$where)){
						$up=1;
					}

				}else{
                    //insert member data into database
                     $data=array('ZIP'=>$line[0],'Country_code'=>$line[1],'City'=>$line[2],'ST'=>$line[3],'Country'=>$line[4]);
				   	if($wpdb->insert( 'wp_zip_code_to_country_code', $data)){
							$in=1;
					}
				}
            }
            //close opened csv file
            fclose($csvFile);

            $qstring = '?status=succ';
        }else{
            $qstring = '?status=err';
        }
    }else{
        $qstring = '?status=invalid_file';
    }

    //upload location file
    $csvMimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
    if(!empty($_FILES['locations']['name']) && in_array($_FILES['locations']['type'],$csvMimes)){
        if(is_uploaded_file($_FILES['locations']['tmp_name'])){
            //open uploaded csv file with read only mode
            $csvFile = fopen($_FILES['locations']['tmp_name'], 'r');
            //skip first line
            fgetcsv($csvFile);
            //parse data from csv file line by line
            while(($line = fgetcsv($csvFile)) !== FALSE){
                //check whether member already exists in database with same email
              	$sql1='select * from wp_locations where franchise_id='.$line[0];
				$results=$wpdb->get_results($sql1);
				if (count($results)> 0){
					$dataup1=array('franchise_id'=>$line[0],'franchise_name'=>$line[1],'phone'=>$line[2],'website'=>$line[3],'email'=>$line[4],'county_codes'=>$line[5]);
					$where1=array('franchise_id'=>$line[0]);
					if($wpdb->update( 'wp_locations', $dataup1,$where1)){
						$up1=1;
					}

				}else{
                    //insert member data into database
                $data=array('franchise_id'=>$line[0],'franchise_name'=>$line[1],'phone'=>$line[2],'website'=>$line[3],'email'=>$line[4],'county_codes'=>$line[5]);
			   	if($wpdb->insert( 'wp_locations', $data)){
						$in1=1;
				}
			}
            }            
            //close opened csv file
            fclose($csvFile);
            $qstring = '?status=succ';
        }else{
            $qstring = '?status=err';
        }
    }else{
        $qstring = '?status=invalid_file';
    }
}
if(($up==1 || $in==1) || ($up1==1 || $in1==1)){
	echo "<script>alert('Files uploaded Successfully');</script>";
}else{

}
}
?>

	<div id="dataModal" class="modal fade" style="display:none">  
      <div class="modal-dialog" style="width:75%;height: 75%;vertical-align: middle;position: relative;">  
           <div class="modal-content">  
                <div class="modal-header">    
                     <h1 class="modal-title">Location Info</h1>  
                </div>  
                <div class="modal-body" id="location_info">  
                </div>  
                <div class="modal-footer">  
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                </div>  
           </div>  
      </div>  
 </div>
<?php
/*
* Template Name: dispData
*/
	$output='';
		$sql1='select * from wp_locations';
		$results1=$wpdb->get_results($sql1);
	
		if (count($results1)> 0){
			$output .= '<div class="table-responsive">
			<table class="table table-bordered" border="2"><tr>';
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
		?>
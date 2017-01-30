<?php
require_once('../../../wp-load.php'); 
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
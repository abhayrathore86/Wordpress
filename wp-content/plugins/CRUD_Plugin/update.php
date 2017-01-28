<?php 
require_once('../../../wp-load.php'); 
$var = $_REQUEST['id'];
global $wpdb;
$sql='select * from wp_customer where c_id='.$var;
//echo $sql;
$results=$wpdb->get_results($sql);
foreach ( $results as $print )   {
?>
<form  method="POST" id="updateForm">
<h1>Enter Data Here</h1>
First name : <input type="text" name="firstname" id="firstname" value="<?php echo $print->c_fname; ?>"><br>
Last name : <input type="text" name="lastname" id="lastname" value="<?php echo $print->c_lname ; ?>"><br>
Age : <input type="number" name="age" id="age" value="<?php echo $print->c_age ; ?>"><br>
Gender : <input type="radio" name="gender" value="male" id="gender" <?php echo ($print->c_gender=='male')?'checked':'' ?>>Male <input type="radio" name="gender" value="female" id="gender" <?php echo ($print->c_gender=='female')?'checked':'' ?>>Female<br><br>
Upload Photo : <img src="../wp-content/uploads/2017/01/<?php echo $print->c_image; ?>" style="height:200px;width: 200px"><input type='file' name="image" id="imageUp" accept="image/*"/>
<input type="hidden" name="data" value="<?php echo $print->c_image; ?>"> <br><br>
<input type="submit" value="Update Data" name="update_btn" id="btn_update">
</form>
<?php
}


?>
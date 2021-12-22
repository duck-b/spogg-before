<?php
$email = $_POST['email'];
$emailsite = $_POST['emailsite'];
$id = $email."@".$emailsite;
include "dbconn.php";

$result_check_id = mysqli_query($conn, "SELECT * FROM user where id='$id'");
$check_id_row = mysqli_num_rows($result_check_id);
if($check_id_row){ 
	$check_id = 0; 
}else{ 
	$check_id = "check_id";
}
mysqli_close($conn);

echo $check_id;
?>
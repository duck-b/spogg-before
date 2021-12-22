<?php
$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
include "dbconn.php";
if($_POST['user_no']){
	$user_no = $_POST['user_no'];
}else{
	session_start();
	$user_no = $_SESSION['user_no'];
}
mysqli_query($conn,"UPDATE user SET password = '$password' WHERE no = '$user_no'");
mysqli_close($conn);
?>
<?php
if($_POST['status'] == 1){
	include "dbconn.php";
	session_start();
	$password = $_POST['password'];
	$user_no = $_SESSION['user_no'];
	$result = mysqli_query($conn,"SELECT * FROM user WHERE no='$user_no'");
	mysqli_close($conn);
	if($result != null){
		$row = mysqli_fetch_array($result);
		$hash = $row['password'];
		if(password_verify($password, $hash)){
			echo $user_no;
		}else{
			echo 0;
		}	
	}else{
		echo 0;
	}
}else if($_POST['status'] == 2){
	include "dbconn.php";
	$email = $_POST['email'];
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$result = mysqli_query($conn,"SELECT * FROM user WHERE email='$email' AND name='$name' AND phone='$phone'");
	$row = mysqli_fetch_array($result);
	mysqli_close($conn);
	if($row){
		echo $row['no'];
	}else{
		echo 0;
	}
}else if($_POST['status'] == 3){
	include "dbconn.php";
	$findpw_q = $_POST['findpw_q'];
	$findpw_a = $_POST['findpw_a'];
	$user_no = $_POST['user_no'];
	$result = mysqli_query($conn,"SELECT * FROM user WHERE no='$user_no' AND findpw_q='$findpw_q' AND findpw_a='$findpw_a'");
	$row = mysqli_fetch_array($result);
	mysqli_close($conn);
	if($row){
		echo $row['no'];
	}else{
		echo 0;
	}
}
?>
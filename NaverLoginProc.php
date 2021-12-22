<?php
session_start();
include "dbconn.php";
$email = $_POST["email"];
$regist_result = mysqli_query($conn, "SELECT * FROM user where sns_email = '$email' AND sns_login = '2'");
$regist_row = mysqli_fetch_array($regist_result);
if(!$regist_row){
	$id = $_POST['id'];
	$name = $_POST["name"];
	$created_at = date('Y-m-d H:i:s',time());
	$img = $_POST["img"];
	$birth = $_POST['birth'];
	$status = 1;

	mysqli_query($conn,"INSERT INTO user (sns_email, password, name, phone, birth, findpw_q, findpw_a, status, img, sns_login, created_at) VALUES ('$email', '$id', '$name', '$phone', '$birth', '$findpw_q', '$findpw_a', '$status', '$img', '2','$created_at')");
	if($status == 1){
		$result_login = mysqli_query($conn, "SELECT MAX(no) as maxno FROM user where sns_email = '$email'");
		$row_login = mysqli_fetch_array($result_login);
		$user_no = $row_login['maxno'];
		mysqli_query($conn,"INSERT INTO user_player (user, playercheck, position, hitpitch, playertall, playerweight, playerclass, address, back_num, created_at) VALUES ('$user_no', '$playercheck', '$position', '$hitpitch', '$playertall', '$playerweight', '$playerclass', '$address', '$back_num', '$created_at')");
	}
	$_SESSION['user_no'] = $user_no;
	$player_result = mysqli_query($conn,"SELECT * FROM user_player where user='$user_no'");
	$player_row = mysqli_fetch_array($player_result);
	$_SESSION['player_no'] = $player_row['no'];
	echo 1;
}else if($regist_row['password'] == $_POST['id']){
	if($regist_row['admin_status']=='1'){
		$_SESSION['admin'] = 1;
	}else{
		$_SESSION['admin'] = 0;
	}
	if($regist_row['status']=='1'){
		$_SESSION['user_no'] = $regist_row['no'];
		$user_no = $_SESSION['user_no'];
		$player_result = mysqli_query($conn,"SELECT * FROM user_player where user='$user_no'");
		$player_row = mysqli_fetch_array($player_result);
		$_SESSION['player_no'] = $player_row['no'];
	}else{
		$_SESSION['player_no'] = 0;
	}
	echo 1;
}else{
	echo "error";
}
mysqli_close($conn);
?>
<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<head>
		<style>
		body
			{
			 text-align: center;
			 margin: 0 auto;
			}


		#box
			{
			 position: absolute;
			 width: 50px;
			 height: 50px;
			 left: 50%;
			 top: 50%;
			 margin-left: -25px;
			 margin-top: -25px;
			}
		</style>
	</head>
<?php

include "dbconn.php";

session_start();

$user_no = $_SESSION['user_no'];

$phone = $_POST['phone'];
if($_POST['birth']){
	$birth = $_POST['birth'];
}else{
	$birth = $_POST["birth_y"]."-".$_POST["birth_m"]."-".$_POST["birth_d"];
}
$gender = $_POST['gender'];
$user_result = mysqli_query($conn,"SELECT * FROM user where no='$user_no'");
$user_row = mysqli_fetch_array($user_result);
mysqli_query($conn,"UPDATE user SET phone = '$phone', birth = '$birth', gender = '$gender' WHERE no = '$user_no'");

if($user_row['status'] == 1){
	$playercheck = $_POST["playercheck"];
	$position = $_POST["position"];
	$hitpitch = $_POST["hitpitch"];
	$playertall = $_POST["playertall"];
	$playerweight = $_POST["playerweight"];
	$playerclass = $_POST["playerclass"];
	$address = $_POST["address"];
	$back_num = $_POST["back_num"];
	if($_FILES['img']['tmp_name']){
		if($user_row['img']){
			if($user_row['img']){ unlink($user_row['img']); }
		}
		$_FILES['img']['name'] = $user_no.'_'.$_FILES['img']['name'];
		$user_img = $_FILES['img']['name'];
		$target = 'img/user_prof/'.$user_img;
		$tmp_name = $_FILES['img']['tmp_name'];
		move_uploaded_file($tmp_name, $target);
		mysqli_query($conn,"UPDATE user SET img = '$target' WHERE no = '$user_no'");
	}
	foreach($_POST['team'] as $team) {
		if($team){
			if(!$team_name){
				$team_name = str_replace('|','',$team);
			}else{
				$team_name .= "|".str_replace('|','',$team);
			}
		}
	}
	mysqli_query($conn,"UPDATE user_player SET playercheck = '$playercheck', position = '$position', hitpitch = '$hitpitch', playertall = '$playertall', playerweight = '$playerweight', playerclass = '$playerclass', address = '$address', back_num = '$back_num', team = '$team_name' WHERE user = '$user_no'");
}
echo "<script>alert('회원정보가 수정 되었습니다');</script>";
echo ("<meta http-equiv='Refresh' content='1; URL=user_info.html'>");

mysqli_close($conn);
?>
<body>
	<img id="box" src="img/loading.gif" alt="loading">
</body>
</html>
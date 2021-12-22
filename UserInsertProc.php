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
session_start();
include "dbconn.php";
$email = $_POST["email"]."@".$_POST["emailsite"];
$regist_result = mysqli_query($conn, "SELECT * FROM user where email = '$email'");
$regist_row = mysqli_fetch_array($regist_result);
if(!$regist_row){
	$hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
	$name = $_POST["name"];
	$phone = $_POST["phone"];
	$gender = $_POST["gender"];
	$birth = $_POST["birth_y"]."-".$_POST["birth_m"]."-".$_POST["birth_d"];
	$findpw_q = $_POST["findpw_q"];
	$findpw_a = $_POST["findpw_a"];
	$created_at = date('Y-m-d H:i:s',time());

	$check_id = $_POST["checkid"];
	$status = $_POST["status"];
    $promotion = $_POST["promotion"];
    
	mysqli_query($conn,"INSERT INTO user (email, password, name, phone, birth, gender, findpw_q, findpw_a, status, promotion,created_at) VALUES ('$email', '$hash', '$name', '$phone', '$birth', '$gender', '$findpw_q', '$findpw_a', '$status', '$promotion','$created_at')");
	sleep(2);
	if($status == 1){
		$playercheck = $_POST["playercheck"];
		$position = $_POST["position"];
		$hitpitch = $_POST["hitpitch"];
		$playertall = $_POST["playertall"];
		$playerweight = $_POST["playerweight"];
		$playerclass = $_POST["playerclass"];
		$address = $_POST["address"];
		$back_num = $_POST["back_num"];
		$result_login = mysqli_query($conn, "SELECT MAX(no) as maxno FROM user where email = '$email'");
		$row_login = mysqli_fetch_array($result_login);
		$user_no = $row_login['maxno'];
		foreach($_POST['team'] as $team) {
			if($team){
				if(!$team_name){
					$team_name = str_replace('|','',$team);
				}else{
					$team_name .= "|".str_replace('|','',$team);
				}
			}
		}
		mysqli_query($conn,"INSERT INTO user_player (user, playercheck, position, hitpitch, playertall, playerweight, playerclass, address, back_num, team, created_at) VALUES ('$user_no', '$playercheck', '$position', '$hitpitch', '$playertall', '$playerweight', '$playerclass', '$address', '$back_num', '$team_name', '$created_at')");
	}
	mysqli_close($conn);
	echo "<script>alert('회원가입이 완료되었습니다. 로그인 페이지로 이동합니다.');</script>";
}
echo ("<meta http-equiv='Refresh' content='1; URL=login.html'>");
?>
<body>
	<img id="box" src="img/loading.gif" alt="loading">
</body>
</html>
<html>
	<? include("inc/_head.html");?>
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
<?php
session_start();
include "dbconn.php";

$id = $_POST["id"];
$pw = $_POST["pw"];
$pw_s = $_POST["pw_s"];
$name = "Guest";
$check_id = $_POST["checkid"];
$page = $_POST['page'];

if($check_id){
	if($id != null && $pw !=null){
		if($pw == $pw_s){
			$hash = password_hash($pw, PASSWORD_DEFAULT);
			mysqli_query($conn,"INSERT INTO user (id, pw, name, states) VALUES ('$id', '$hash', '$name', '4')");
			sleep(2);
			$result_login = mysqli_query($conn, "SELECT MAX(no) as maxno FROM user where id LIKE '%$id%'");
			$row_login = mysqli_fetch_array($result_login);
			$user_no = $row_login['maxno'];
			mysqli_query($conn,"INSERT INTO player (user) VALUES ('$user_no')");
			$player_result = mysqli_query($conn,"SELECT * FROM player where user='$user_no'");
			$player_row = mysqli_fetch_array($player_result);
			$_SESSION['user_no'] = $user_no;
			$_SESSION['player_no'] = $player_row['no'];
			mysqli_close($conn);
			echo "<script>alert('회원가입이 완료되었습니다.');</script>";
			echo ("<meta http-equiv='Refresh' content='1; URL=".$page."'>");
		}else{
			//비밀번호 일치 x
			echo "<script>alert('비밀번호가 일치 하지 않습니다.');</script>";
			echo "<script>history.back();</script>";
		}
	}else{
		//공백
		echo "<script>alert('모두 입력되어야 합니다.');</script>";
		echo "<script>history.back();</script>";
	}
}else{
	//중복확인
	echo "<script>alert('아이디 중복확인이 필요합니다.');</script>";
	echo "<script>history.back();</script>";
}
include "inc/_head.html";
?>
<body>
	<img id="box" src="/images/loading.gif" alt="loading">
</body>
</html>
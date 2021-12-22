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

$id = $_POST['id'];
$pw = $_POST['pw'];
$page = $_POST['page'];
if(($id != null) && ($pw != null)){
	include "dbconn.php";
	$result = mysqli_query($conn,"SELECT * FROM user WHERE id='$id'");
	if($result != null){
		$row = mysqli_fetch_array($result);
		$hash = $row['pw'];
		if(password_verify($pw, $hash)){
			session_start();
			$_SESSION['user_no'] = $row['no'];
			if($row['states']=='3'){
				$_SESSION['admin'] = '1';
			}
			if($row['states']=='1' || $row['states']=='3'){
				$user_no = $_SESSION['user_no'];
				$player_result = mysqli_query($conn,"SELECT * FROM player where user='$user_no'");
				$player_row = mysqli_fetch_array($player_result);
				$_SESSION['player_no'] = $player_row['no'];
			}
			mysqli_close($conn);
			echo ("<meta http-equiv='Refresh' content='1; URL=".$page."'>");
		}else{
			mysqli_close($conn);
			echo "<script>alert('아이디 또는 비밀번호를 잘못 입력하였습니다');</script>";
			echo "<script>history.back();</script>";
		}	
	}else{
		mysqli_close($conn);
		echo "<script>alert('아이디 또는 비밀번호를 잘못 입력하였습니다');</script>";
		echo "<script>history.back();</script>";
	}
}else{
	echo "<script>alert('아이디 또는 비밀번호를 입력해주세요');</script>";
	echo "<script>history.back();</script>";
}

include "inc/_head.html";
?>
<body>
	<img id="box" src="/images/loading.gif" alt="loading">
</body>
</html>
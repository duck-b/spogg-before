<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
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

$email = $_POST['email'];
$password = $_POST['password'];
if(($email != null) && ($password != null)){
	include "dbconn.php";
	$result = mysqli_query($conn,"SELECT * FROM user WHERE email='$email'");
	if($result != null){
		$row = mysqli_fetch_array($result);
		$hash = $row['password'];
		if(password_verify($password, $hash)){
			session_start();
			$_SESSION['user_no'] = $row['no'];
			if($row['admin_status']=='1'){
				$_SESSION['admin'] = 1;
			}else{
				$_SESSION['admin'] = 0;
			}
			if($row['status']=='1'){
				$user_no = $_SESSION['user_no'];
				$player_result = mysqli_query($conn,"SELECT * FROM user_player where user='$user_no'");
				$player_row = mysqli_fetch_array($player_result);
				$_SESSION['player_no'] = $player_row['no'];
			}else{
				$_SESSION['player_no'] = 0;
			}
			//if($_POST['auto_login'] == 't'){
				setcookie('user_no',$_SESSION['user_no'],time()+(86400*30),'/');
				if($row['status']=='1'){
					setcookie('player_no',$_SESSION['player_no'],time()+(86400*30),'/');
				}else{
					setcookie('player_no',0,time()+(86400*30),'/');
				}
				if($row['admin_status']=='1'){
					setcookie('admin',1,time()+(86400*30),'/');
				}else{
					setcookie('admin',0,time()+(86400*30),'/');
				}
			//}
			
			mysqli_close($conn);
			echo ("<meta http-equiv='Refresh' content='1; URL=index.html'>");
		}else{
			mysqli_close($conn);
			echo "<script>alert('이메일 또는 비밀번호를 잘못 입력하였습니다');</script>";
			echo "<script>history.back();</script>";
		}	
	}else{
		mysqli_close($conn);
		echo "<script>alert('이메일 또는 비밀번호를 잘못 입력하였습니다');</script>";
		echo "<script>history.back();</script>";
	}
}else{
	echo "<script>alert('이메일 또는 비밀번호를 입력해주세요');</script>";
	echo "<script>history.back();</script>";
}
?>
<body>
	<img id="box" src="img/loading.gif" alt="loading">
</body>
</html>

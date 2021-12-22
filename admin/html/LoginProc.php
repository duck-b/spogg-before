<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php

$id = $_POST['id'];
$pw = $_POST['pw'];
if(!$_GET['no']){
	if(($id != null) && ($pw != null)){
		include "dbconn.php";
		$result = mysqli_query($conn,"SELECT * FROM user where id='$id'");
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
				echo ("<meta http-equiv='Refresh' content='1; URL=index.html'>");
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
}else{
	session_start();
	if($_SESSION['admin']){
		session_destroy();
		$no = $_GET['no'];
		include "dbconn.php";
		$result = mysqli_query($conn,"SELECT * FROM user where no='$no'");
		$row = mysqli_fetch_array($result);
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
		echo ("<meta http-equiv='Refresh' content='1; URL=index.html'>");
	}else{
		echo "<script>alert('잘못된 접근입니다.');";
		echo "window.location.replace('index.html');</script>";
	}
}
include "inc/_head.html";
?>
<body>
	<div class="load">
		<img src="/images/loading.gif" alt="loading">
	</div>
</body>
</html>
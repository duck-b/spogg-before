<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php

include "dbconn.php";

session_start();

$no = $_GET['no'];
$com = $_GET['com'];
$apply_user_result = mysqli_query($conn,"SELECT * FROM league_team where no='$no'");
$apply_user_row = mysqli_fetch_array($apply_user_result);
$league_no = $apply_user_row['league'];
$pro_result = mysqli_query($conn,"SELECT * FROM league where no='$league_no'");
$pro_row = mysqli_fetch_array($pro_result);
$user_no = $_SESSION['user_no'];
if($user_no == $pro_row['pro'] || $_SESSION['admin'] == 1){
	if($com){
		if($com == 'acc'){
			mysqli_query($conn,"UPDATE league_team SET states = '1' WHERE no = '$no'");
			$apply_user = $apply_user_row['user'];
			$before_result = mysqli_query($conn,"SELECT * FROM user_activity WHERE user='$apply_user' AND board='$no' AND board_table = 'league'");
			$before_row = mysqli_fetch_array($before_result);
			if($before_row){
				$activity_no = $before_row['no'];
				mysqli_query($conn,"UPDATE user_activity SET count = '1' WHERE no = '$activity_no'");
			}else{
				mysqli_query($conn,"INSERT INTO user_activity (user, board, board_table, count) VALUES ('$apply_user', '$no', 'league', '1')");
			}
			mysqli_close($conn);
			echo "<script>alert('수정 되었습니다.');</script>";
			echo "<script>history.back();</script>";	
		}elseif($com == 'stp'){
			mysqli_query($conn,"UPDATE league_team SET states = '2' WHERE no = '$no'");
			$apply_user = $apply_user_row['user'];
			$before_result = mysqli_query($conn,"SELECT * FROM user_activity WHERE user='$apply_user' AND board='$no' AND board_table = 'league'");
			$before_row = mysqli_fetch_array($before_result);
			if($before_row){
				$activity_no = $before_row['no'];
				mysqli_query($conn,"UPDATE user_activity SET count = '1' WHERE no = '$activity_no'");
			}else{
				mysqli_query($conn,"INSERT INTO user_activity (user, board, board_table, count) VALUES ('$apply_user', '$no', 'league', '1')");
			}
			mysqli_close($conn);
			echo "<script>alert('수정 되었습니다.');</script>";
			echo "<script>history.back();</script>";	
		}elseif($com == 'ref'){
			mysqli_query($conn,"UPDATE league_team SET states = '3' WHERE no = '$no'");
			$apply_user = $apply_user_row['user'];
			$before_result = mysqli_query($conn,"SELECT * FROM user_activity WHERE user='$apply_user' AND board='$no' AND board_table = 'league'");
			$before_row = mysqli_fetch_array($before_result);
			if($before_row){
				$activity_no = $before_row['no'];
				mysqli_query($conn,"UPDATE user_activity SET count = '1' WHERE no = '$activity_no'");
			}else{
				mysqli_query($conn,"INSERT INTO user_activity (user, board, board_table, count) VALUES ('$apply_user', '$no', 'league', '1')");
			}
			mysqli_close($conn);
			echo "<script>alert('수정 되었습니다.');</script>";
			echo "<script>history.back();</script>";	
		}else{
			echo "<script>alert('잘못된 접근입니다.');</script>";
			echo "<script>history.back();</script>";
		}
	}
}else{
	echo "<script>alert('잘못된 접근입니다.');</script>";
	echo "<script>history.back();</script>";
}
include "inc/_head.html";
?>
<body>
	<div class="load">
		<img src="/images/loading.gif" alt="loading">
	</div>
</body>
</html>
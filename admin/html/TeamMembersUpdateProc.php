<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php

include "dbconn.php";

session_start();

if($_GET['no']){
	$no = $_GET['no'];
}else if($_POST['no']){
	$no = $_POST['no'];
}
if($_GET['com']){
	$com = $_GET['com'];
}else if($_POST['com']){
	$com = $_POST['com'];
}
$user_no = $_SESSION['user_no'];
$player_no = $_SESSION['player_no'];
$member_check_result = mysqli_query($conn,"SELECT * FROM team_members where no='$no'");
$member_check_row = mysqli_fetch_array($member_check_result);
$team_no = $member_check_row['team'];
$manage_check_result = mysqli_query($conn,"SELECT * FROM team_members where team = '$team_no' AND player = '$player_no'");
$manage_check_row = mysqli_fetch_array($manage_check_result);
if($com == 'iut'){
	if($member_check_row['player'] == $player_no){
		mysqli_query($conn,"DELETE FROM team_members WHERE no='$no'");
		mysqli_close($conn);
		echo "<script>alert('탈퇴 되었습니다.');</script>";
		echo "<script>history.back();</script>";
	}else{
		echo "<script>alert('본인만 탈퇴가 가능합니다.');</script>";
		echo "<script>history.back();</script>";	
	}
}else if($com == 'del'){
	if($member_check_row['player'] == $player_no){
		mysqli_query($conn,"DELETE FROM team_members WHERE no='$no'");
		mysqli_close($conn);
		echo "<script>alert('취소 되었습니다.');</script>";
		echo "<script>history.back();</script>";
	}else{
		echo "<script>alert('본인만 취소가 가능합니다.');</script>";
		echo "<script>history.back();</script>";	
	}
}else if($com == 'edit'){
	if($member_check_row['player'] == $player_no){
		$no = $_POST['no'];
		$position = $_POST['position'];
		$back_num = $_POST['back_num'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		$contents = $_POST['memberedit'];
		if($position != null && $back_num != null && $phone  != null && $email != null){
			mysqli_query($conn,"UPDATE team_members SET position = '$position', back_num  = '$back_num ', phone = '$phone', email = '$email', contents = '$contents' WHERE no = '$no'");
			mysqli_close($conn);
			echo "<script>alert('수정 되었습니다.');</script>";
			echo ("<meta http-equiv='Refresh' content='1; URL=team.html?team=page&no=$team_no'>");
		}else{
			echo "<script>alert('모두 입력해야 합니다');</script>";
			echo "<script>history.back();</script>";
		}
	}else{
		echo "<script>alert('본인만 수정이 가능합니다.');</script>";
		echo "<script>history.back();</script>";	
	}
}else{
	if($manage_check_row['class'] == 1 || $_SESSION['admin'] == 1){
		if($com == 'acc'){
			mysqli_query($conn,"UPDATE team_members SET states = '1', updated_who = '$user_no', class = '3' WHERE no = '$no'");
		}elseif($com == 'ref'){
			mysqli_query($conn,"UPDATE team_members SET states = '3', updated_who = '$user_no' WHERE no = '$no'");
		}elseif($com == 'out'){
			mysqli_query($conn,"UPDATE team_members SET states = '4', updated_who = '$user_no', class = null WHERE no = '$no'");
		}elseif($com == 'c1up'){
			mysqli_query($conn,"UPDATE team_members SET class = '3', updated_who = '$user_no' WHERE player = '$player_no' AND team = '$team_no'");
			mysqli_query($conn,"UPDATE team_members SET class = '1', updated_who = '$user_no' WHERE no = '$no'");
		}elseif($com == 'c2up'){
			mysqli_query($conn,"UPDATE team_members SET class = '2', updated_who = '$user_no' WHERE no = '$no'");
		}elseif($com == 'c3dw'){
			mysqli_query($conn,"UPDATE team_members SET class = '3', updated_who = '$user_no' WHERE no = '$no'");
		}
		$board_activiy_result = mysqli_query($conn, "SELECT * FROM user_activity where board = '$no' AND board_table = 'team_members'");
		$board_activiy_row = mysqli_fetch_array($board_activiy_result);
		if($board_activiy_row){
			mysqli_query($conn,"UPDATE user_activity SET count = 1 WHERE board = '$no' AND board_table = 'team_members'");
		}else{
			$board_player_result = mysqli_query($conn, "SELECT * FROM team_members where no = '$no'");
			$board_player_row = mysqli_fetch_array($board_player_result);
			$board_player_no = $board_player_row['player'];
			$board_user_result = mysqli_query($conn, "SELECT * FROM player where no = '$board_player_no'");
			$board_user_row = mysqli_fetch_array($board_user_result);
			$board_user_no = $board_user_row['user'];
			mysqli_query($conn,"INSERT INTO user_activity (user, board, board_table, count) VALUES ('$board_user_no', '$no', 'team_members', '1')");
		}
		mysqli_close($conn);
		echo "<script>alert('수정 되었습니다.');</script>";
		echo "<script>history.back();</script>";	
	}else{
		echo "<script>alert('감독만 접근이 가능합니다.');</script>";
		echo "<script>history.back();</script>";	
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
<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php

include "dbconn.php";

session_start();

$prevPage = $_SERVER['HTTP_REFERER'];
$user_no = $_SESSION['user_no'];
if($user_no){
	$team_no = $_POST['team_no'];
	$player_no = $_SESSION['player_no'];
	$position = $_POST['position'];
	$back_num = $_POST['back_num'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$contents = $_POST['memberinsert'];
	if($position != null && $back_num != null && $phone  != null && $email != null){
		$member_result = mysqli_query($conn, "SELECT * FROM team_members where team = '$team_no' AND player = '$player_no'");
		$member_row = mysqli_fetch_array($member_result);
		if(!$member_row){
			echo "<script>alert('신청이 완료되었습니다');</script>";
			mysqli_query($conn,"INSERT INTO team_members (player, team, states, position, back_num, phone, email, contents) VALUES ('$player_no', '$team_no', '2', '$position', '$back_num', '$phone', '$email', '$contents')");
		}else{
			echo "<script>alert('잘못된 접근입니다.');</script>";
		}
		mysqli_close($conn);
	}else{
		echo "<script>alert('모두 입력해야 합니다');</script>";
	}
}else{
	$prevPage = "user.html?user=login";
	echo "<script>alert('로그인이 필요합니다.');</script>";
}
include "inc/_head.html";
?>
<body>
	<div class="load">
		<img src="/images/loading.gif" alt="loading">
	</div>
</body>
<meta http-equiv="refresh" content="0;url=<? echo $prevPage?>" />
</html>
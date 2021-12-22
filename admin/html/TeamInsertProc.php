<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php

session_start();
$user_no = $_SESSION['user_no'];
$player_no = $_SESSION['player_no'];
$name = $_POST['name'];
$adrs = $_POST['adrs'];
$found = $_POST['found'];
$team_class = $_POST['team_class'];

if($name != null && $adrs != null && $found != null && $team_class != null){
	include "dbconn.php";
	
	if($_FILES['img']['name'] != null){
		$_FILES['img']['name'] = date("YmdHis").'_'.$name.'_'.$_FILES['img']['name'];
		$img = $_FILES['img']['name'];
		$target = 'images/team_logo/'.$img;
		$tmp_name = $_FILES['img']['tmp_name'];
		move_uploaded_file($tmp_name, $target);
	}else{
		$target = "";
	}
	mysqli_query($conn,"INSERT INTO team (name, manager, img, main_img, class, found, adrs, contents) VALUES ('$name', '$user_no', '$target', '', '$team_class', '$found', '$adrs', '')");
	$team_result = mysqli_query($conn, "SELECT MAX(no) as maxno FROM team where name LIKE '%$name%'");
	$team_row = mysqli_fetch_array($team_result);
	$team_no = $team_row['maxno'];
	$user_result = mysqli_query($conn, "SELECT * FROM user where no = '$user_no'");
	$user_row = mysqli_fetch_array($user_result);
	$phone = $user_row['phone'];
	$email = $user_row['email'];;
	mysqli_query($conn,"INSERT INTO team_members (team, player, class, states, position, phone, email) VALUES ('$team_no', '$player_no', '1', '1', '0', '$phone', '$email')");
	mysqli_close($conn);
	echo "<script>alert('창단이 완료 되었습니다. 소속 팀에서 확인해 주세요!');</script>";
	echo ("<meta http-equiv='Refresh' content='1; URL=user.html?user=team'>");
}else{
		echo "<script>alert('모두 입력 해야합니다.');</script>";
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
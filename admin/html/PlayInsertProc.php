<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php

session_start();
include "dbconn.php";
$no = $_POST['no'];
$league_result = mysqli_query($conn,"SELECT * FROM league WHERE no = '$no'");
$league_row = mysqli_fetch_array($league_result);
if($_SESSION['user_no'] == $league_row['pro'] || $_SESSION['admin'] == 1){
	$name = $_POST['name'];
	$kind = $_POST['kind'];
	$play_datetime = $_POST['play_datetime'];
	$stadium = $_POST['stadium'];
	$home_team = $_POST['home_team'];
	$away_team = $_POST['away_team'];
	$umpc = $_POST['umpc'];
	$scoa = $_POST['scoa'];
	if($home_team != $away_team){
		if($name != null && $play_datetime != null && $stadium != null && $home_team != null && $away_team != null && $umpc != null && $scoa != null){
			mysqli_query($conn,"INSERT INTO play (league, kind, name, play_datetime, stadium, home_team, away_team, umpc, scoa) VALUES ('$no', '$kind', '$name', '$play_datetime', '$stadium', '$home_team', '$away_team', '$umpc', '$scoa')");
			echo "<script>alert('개설이 완료 되었습니다');</script>";
			echo "<script>window.location.replace('league.html?league=page&no=$no&page=schedule');</script>";
		}else{
			echo "<script>alert('모두 입력 해야합니다.');</script>";
			echo "<script>history.back();</script>";
		}
	}else{
		echo "<script>alert('홈 팀과 어웨이 팀이 같을 수 없습니다.');</script>";
		echo "<script>history.back();</script>";
	}
}else{
	echo "<script>alert('잘못된 접근입니다.');</script>";
	echo "<script>window.location.replace('index.html');</script>";
}
include "inc/_head.html";
?>
<body>
	<div class="load">
		<img src="/images/loading.gif" alt="loading">
	</div>
</body>
</html>
<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php

session_start();
include "dbconn.php";
$no = $_POST['no'];
$play_result = mysqli_query($conn,"SELECT * FROM league JOIN play WHERE play.no = '$no' AND league.no = play.league");
$play_row = mysqli_fetch_array($play_result);
if($_SESSION['user_no'] == $play_row['pro'] || $_SESSION['admin'] == 1){
	$name = $_POST['name'];
	$play_datetime = $_POST['play_datetime'];
	$stadium = $_POST['stadium'];
	$home_team = $_POST['home_team'];
	$away_team = $_POST['away_team'];
	$umpc = $_POST['umpc'];
	$scoa = $_POST['scoa'];
	if($home_team != $away_team){
		if($name != null && $play_datetime != null && $stadium != null && $home_team != null && $away_team != null && $umpc != null && $scoa != null){
			mysqli_query($conn,"UPDATE play SET name = '$name', play_datetime = '$play_datetime', stadium = '$stadium', home_team = '$home_team', away_team = '$away_team', umpc = '$umpc', scoa = '$scoa' WHERE no = $no");
			echo "<script>alert('수정이 완료 되었습니다');</script>";
			$year = date('Y',strtotime($play_datetime));
			$month = date('m',strtotime($play_datetime));
			echo "<script>window.location.replace('league.html?league=page&no=".$play_row['league']."&page=schedule&year=$year&month=$month');</script>";
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
<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php

session_start();
$user_no = $_SESSION['user_no'];
$player_no = $_SESSION['player_no'];
$team_no = $_POST['team_no'];
include "dbconn.php";
$boss_result = mysqli_query($conn,"SELECT * FROM team_members WHERE player = '$player_no' AND team = '$team_no' AND class = '1'");
$boss_row = mysqli_fetch_array($boss_result);
if($boss_row){
	$com = $_POST['com'];
	if($com == 'info'){
		$adrs = $_POST['adrs'];
		$team_class = $_POST['team_class'];
		$contents = $_POST['teamedit'];
		if($adrs != null && $team_class != null){
			mysqli_query($conn,"UPDATE team SET adrs = '$adrs', class= '$team_class', contents = '$contents' WHERE no = '$team_no'");
			echo "<script>alert('수정 되었습니다.');</script>";
			echo ("<meta http-equiv='Refresh' content='1; URL=team.html?team=page&no=$team_no'>");
		}else{
				echo "<script>alert('모두 입력 해야합니다.');</script>";
				echo "<script>history.back();</script>";		
		}
	}else if($com == 'img'){
		
	}else if($com == 'main_img'){
		
	}
}else{
	echo "<script>alert('잘못된 접근입니다.');</script>";
	echo ("<meta http-equiv='Refresh' content='1; URL=index.html'>");
}
mysqli_close($conn);
include "inc/_head.html";
?>
<body>
	<div class="load">
		<img src="/images/loading.gif" alt="loading">
	</div>
</body>
</html>
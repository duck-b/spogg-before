<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php

session_start();
$no = $_POST['no'];
$contents = $_POST['leaguerule'];

if($contents != null){
	include "dbconn.php";
	$pro_check_result = mysqli_query($conn,"SELECT * FROM league where no='$no'");
	$pro_check_row = mysqli_fetch_array($pro_check_result);
	if($pro_check_row['pro'] == $_SESSION['user_no']){
		$rule_check_result = mysqli_query($conn,"SELECT * FROM league_rule where league='$no'");
		$rule_check_row = mysqli_fetch_array($rule_check_result);
		if($rule_check_row){
			mysqli_query($conn,"UPDATE league_rule SET contents = '$contents' WHERE league = '$no'");
		}else{
			mysqli_query($conn,"INSERT INTO league_rule (league, contents) VALUES ('$no', '$contents')");
		}
		mysqli_close($conn);
		echo "<script>alert('입력이 완료 되었습니다.');</script>";
		echo "<script>window.location.replace('league.html?league=page&no=$no&page=leaguerule');</script>";
	}else{
		mysqli_close($conn);
		echo "<script>alert('잘못된 접근입니다.');</script>";
		echo "<script>history.back();</script>";
	}
}else{
	echo "<script>alert('내용을 입력 해야합니다.');</script>";
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
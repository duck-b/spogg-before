<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
session_start();
include "dbconn.php";
$contents = $_POST['contents'];
$no = $_POST['no'];
if($_SESSION['admin']){
	if($contents){
		mysqli_query($conn,"UPDATE question SET answer = '$contents' WHERE no = '$no'");

		$board_activiy_result = mysqli_query($conn, "SELECT * FROM user_activity where board = '$no' AND board_table = 'question'");
		$board_activiy_row = mysqli_fetch_array($board_activiy_result);
		if($board_activiy_row){
			mysqli_query($conn,"UPDATE user_activity SET count = 1 WHERE board = '$no' AND board_table = 'question'");
		}else{
			$question_user_result = mysqli_query($conn, "SELECT * FROM question where no = '$no'");
			$question_user_row = mysqli_fetch_array($question_user_result);
			$question_user_no = $question_user_row['user'];
			mysqli_query($conn,"INSERT INTO user_activity (user, board, board_table, count) VALUES ('$question_user_no', '$no', 'question', '1')");
		}
		echo "<script>alert('답변이 완료되었습니다.');</script>";
		echo ("<meta http-equiv='Refresh' content='1; URL=admin.html?admin=question'>");
	}else{
		echo "<script>alert('답변을 입력해야 합니다.');</script>";
		echo "<script>history.back();</script>";
	}
}else{
	echo "<script>alert('잘못된 접근입니다.');</script>";
	echo ("<meta http-equiv='Refresh' content='1; URL=index.html'>");
}
include "inc/_head.html";
?>
<body>
	<div class="load">
		<img src="/images/loading.gif" alt="loading">
	</div>
</body>
</html>
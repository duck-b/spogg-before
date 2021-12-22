<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
session_start();
include "dbconn.php";
if($_SESSION['user_no']){
	$user_no = $_SESSION['user_no'];
}else{
	$user_no = 0;
	$email = $_POST['email'];
	$phone = $_POST['phone'];
}
$title = $_POST['title'];
$contents = $_POST['contents'];
if($title != null && $contents != null){
	if($user_no || ($email && $phone)){
		mysqli_query($conn,"INSERT INTO question (title, contents, user, phone, email) VALUES ('$title', '$contents', '$user_no', '$phone', '$email')");
		echo "<script>alert('문의하기가 완료되었습니다. 빠른시간 내 답변 드리겠습니다.');</script>";
		echo ("<meta http-equiv='Refresh' content='1; URL=index.html'>");
	}else{
		echo "<script>alert('모두 입력되어야 합니다.');</script>";
		echo "<script>history.back();</script>";
	}
}else{
	echo "<script>alert('모두 입력되어야 합니다.');</script>";
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
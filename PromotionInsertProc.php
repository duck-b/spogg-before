<!doctype html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
	<style>
	body
		{
		 text-align: center;
		 margin: 0 auto;
		}


	#box
		{
		 position: absolute;
		 width: 50px;
		 height: 50px;
		 left: 50%;
		 top: 50%;
		 margin-left: -25px;
		 margin-top: -25px;
		}
	</style>
</head>
<?php
include "dbconn.php";
session_start();
$manager_no = $_SESSION['manager_no'];
if($manager_no){
	$manager_promotion = $_POST['manager_promotion'];
	$contents = $_POST['contents'];
	$created_at = date('Y-m-d H:i:s',time());
	mysqli_query($conn,"INSERT INTO user_manager_promotion (user_manager, contents, edit_info, created_at) VALUES ('$manager_promotion', '$contents', '작성 됨', '$created_at')");
	mysqli_close($conn);
	echo "<script>alert('입력이 완료되었습니다.');</script>";
	echo ("<meta http-equiv='Refresh' content='1; URL=create_promotion.html'>");
}else{
	mysqli_close($conn);
	echo "<script>alert('잘못된 접근입니다.');</script>";
	echo ("<meta http-equiv='Refresh' content='1; URL=index.html'>");
}
?>
<body>
	<img id="box" src="img/loading.gif" alt="loading">
</body>
</html>
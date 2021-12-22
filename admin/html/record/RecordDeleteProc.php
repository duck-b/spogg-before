<html>
	<? include("inc/_head.html");?>
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
<?php
include "dbconn.php";
$no = $_GET['no'];
if($_POST['pos'] == '타자'){
	$record_result = mysqli_query($conn, "SELECT * FROM data_before_hit WHERE no = '$no'");
	$record_row = mysqli_fetch_array($record_result);
	$player_no = $record_row['player_no'];
}else if($_POST['pos'] == '투수'){
	$record_result = mysqli_query($conn, "SELECT * FROM data_before_pic WHERE no = '$no'");
	$record_row = mysqli_fetch_array($record_result);
	$player_no = $record_row['player_no'];
}
session_start();
if($_SESSION['player_no'] != $player_no){
	echo "<script>alert('잘못된 접근입니다.');";
	echo "history.back()</script>";
}else{
	if($_POST['pos'] == '타자'){
		mysqli_query($conn,"DELETE FROM data_before_hit WHERE no = '$no'");
		echo "<script>alert('삭제 되었습니다.');</script>";
		echo "<script>window.location.replace('data.html');</script>";
	}else if($_GET['pos'] == '투수'){
		mysqli_query($conn,"DELETE FROM data_before_pic WHERE no = '$no'");
		echo "<script>alert('삭제 되었습니다.');</script>";
		echo "<script>window.location.replace('data.html');</script>";
	}
}
mysqli_close($conn);
include "inc/_head.html";
?>
<body>
	<img id="box" src="/images/loading.gif" alt="loading">
</body>
</html>
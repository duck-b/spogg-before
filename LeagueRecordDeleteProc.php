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
<?
session_start();
$no = $_GET['no'];
$player = $_SESSION['player_no'];
include "dbconn.php";
$result = mysqli_query($conn,"SELECT * FROM user_player_record WHERE player='$player' AND no='$no'");
$row = mysqli_fetch_array($result);
if($row){
	mysqli_query($conn,"DELETE FROM user_player_record WHERE player='$player' AND no='$no'");
	mysqli_close($conn);
	echo "<script>alert('삭제되었습니다.');</script>";
	echo ("<meta http-equiv='Refresh' content='1; URL=record_offical.html'>");
}else{
	mysqli_close($conn);
	echo "<script>alert('잘못된 경로입니다.');</script>";
	echo ("<meta http-equiv='Refresh' content='1; URL=record_offical.html'>");
}
?>
<body>
	<img id="box" src="img/loading.gif" alt="loading">
</body>
</html>
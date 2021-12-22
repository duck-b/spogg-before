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
$manager_no = $_SESSION['manager_no'];
include "dbconn.php";
$result = mysqli_query($conn,"SELECT * FROM user_manager JOIN user_manager_promotion WHERE user_manager.user='$manager_no' AND user_manager.no = user_manager_promotion.user_manager AND user_manager_promotion.no = $no");
$row = mysqli_fetch_array($result);
if($row){
	mysqli_query($conn,"DELETE FROM user_manager_promotion WHERE no='$no'");
	mysqli_close($conn);
	echo "<script>alert('삭제되었습니다.');</script>";
	echo ("<meta http-equiv='Refresh' content='1; URL=create_promotion.html'>");
}else{
	mysqli_close($conn);
	echo "<script>alert('잘못된 경로입니다.');</script>";
	echo ("<meta http-equiv='Refresh' content='1; URL=index.html'>");
}
?>
<body>
	<img id="box" src="img/loading.gif" alt="loading">
</body>
</html>
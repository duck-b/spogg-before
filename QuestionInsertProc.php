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
    <body>
    <img id="box" src="img/loading.gif" alt="loading">
<?php
include "dbconn.php";
$title = $_POST['title'];
$email = $_POST['email'];
$contents = $_POST['contents'];
mysqli_query($conn,"INSERT INTO question (title, contents, email) VALUES ('$title','$contents', '$email')");
mysqli_close($conn);
echo "<script>alert('문의하기가 완료되었습니다. 빠른시간 내 답변 드리겠습니다.');</script>";
echo ("<meta http-equiv='Refresh' content='1; URL=info.html?info=question'>");
?>
    </body>
</html>
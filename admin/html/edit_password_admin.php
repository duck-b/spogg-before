<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php
	include "inc/_head.html";
	include "inc/_script.html";
	session_start();
	$yes = $_GET['yes'];
	$no = $_GET['no'];
	
	include "dbconn.php";
	if($_SESSION['admin']){
		if($yes){
			$pwd = "1q2w3e4r!";
			$hash = password_hash($pwd, PASSWORD_DEFAULT);
			mysqli_query($conn,"UPDATE user SET  pw = '$hash' WHERE no = '$no'");
			echo "<script>alert('비밀번호가 변경되었습니다');</script>";
			echo "<script>opener.parent.location.replace('admin.html?admin=user&no=".$no."');</script>";
			echo "<script>window.close();</script>";
			mysqli_close($conn);
		}
	}else{
		echo "<script>alert('잘못된 접근입니다.');";
		echo "window.location.replace('index.html');</script>";
		echo "<script>window.close();</script>";
	}
?>

	<script type="text/javascript">
	function cancle(){
		window.close();
	}
	</script>
	<body>
	<form action = "edit_password_admin.php" style="text-align: center;margin-top:5%">
		<p style="font-size:150%"><a style="color:blue">1q2w3e4r!</a>로 초기화</p><br>
		<div class = "col-md-6">
			<input class="btn btn-primary" style="width:60%" type="submit" value="확인"><br><br>
		</div>
		<div class = "col-md-6">
			<input class="btn btn-primary" style="width:60%" type="button" onclick="cancle()" value="취소">
		</div>
		<input type="hidden" value="1" name="yes">
		<input type="hidden" value="<? echo $no;?>" name="no">
	</form>
	</body>
</html>
<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php
	include "inc/_head.html";
	include "inc/_script.html";
	session_start();
	$user_no = $_SESSION['user_no'];
	$pwd_sert = $_GET['pwd_sert'];
	$pwd = $_GET['pw'];
	$pwd_s = $_GET['pw_s'];
	
	include "dbconn.php";
	
	if($pwd_sert){
		$result = mysqli_query($conn,"SELECT * FROM user where no='$user_no'");
		$row = mysqli_fetch_array($result);
		$hash = $row['pw'];
		if(password_verify($pwd_sert, $hash)){
			$check_pw = '1';
		}else{
			echo "<script>alert('비밀번호를 잘못 입력하였습니다');</script>";
			echo "<script>history.back();</script>";
		}
	}elseif($pwd){
		if($pwd == $pwd_s){
			$hash = password_hash($pwd, PASSWORD_DEFAULT);
			mysqli_query($conn,"UPDATE user SET  pw = '$hash' WHERE no = '$user_no'");
			echo "<script>alert('비밀번호가 변경되었습니다. 다시 로그인을 해주세요');</script>";
			echo "<script>opener.parent.location.replace('user.html?user=login');</script>";
			echo "<script>window.close();</script>";
			session_destroy();
			mysqli_close($conn);
		}else{
			echo "<script>alert('비밀번호가 일치하지 않습니다');</script>";
			echo "<script>history.back();</script>";
		}
	}
?>

	<script type="text/javascript">
	function cancle(){
		window.close();
	}
	</script>
	<body>
	<form action = "edit_password.php" style="text-align: center;margin-top:5%">
		<? if($check_pw){?>
		<p style="font-size:150%">변경하실 비밀번호를 입력해 주세요</p><br>
		<input type="password" name="pw" id="pw" class="form-control " pattern="^.*(?=^.{8,15}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&+=]).*$" placeholder="특수문자 / 문자 / 숫자 모두 포함 형태의 8~15자리 이내" required><br>
		<input type="password" name="pw_s" id="pw_s" class="form-control " pattern="^.*(?=^.{8,15}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&+=]).*$" placeholder="비밀번호 확인" required><br>
		<div class = "col-md-6">
			<input class="btn btn-primary" style="width:60%" type="submit" value="변경하기"><br><br>
		</div>
		<div class = "col-md-6">
			<input class="btn btn-primary" style="width:60%" type="button" onclick="cancle()" value="취소">
		</div>
		<? } else{ ?>
		<p style="font-size:150%">현재 비밀번호를 입력해주세요</p><br>
		<input type="password" name="pwd_sert" id="pwd_sert" class="form-control"><br>
		<div class = "col-md-6">
			<input class="btn btn-primary" style="width:60%" type="submit" value="확인"><br><br>
		</div>
		<div class = "col-md-6">
			<input class="btn btn-primary" style="width:60%" type="button" onclick="cancle()" value="취소">
		</div>
		<? } ?>
	</form>
	</body>
</html>
<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
session_start();
include "dbconn.php";

$id = $_POST["id"];
$pw = $_POST["pw"];
$pw_s = $_POST["pw_s"];
$name = $_POST["name"];
$phone = $_POST["phone"];
$email = $_POST["email"];
$state = $_POST["state"];
$birth = $_POST["birth"];
$sex = $_POST["sex"];
$pw_question = $_POST["pw_question"];
$pw_answer = $_POST["pw_answer"];
$check_id = $_POST["checkid"];

if($check_id){
	if($id != null && $pw !=null && $name != null && $phone != null && $email != null && $birth != null && $sex != null && $pw_question != 0 && $pw_answer != null){
		if($pw == $pw_s){
			$result_check_id = mysqli_query($conn, "SELECT * FROM user WHERE id='$id'");
			$num_record = mysqli_num_rows($result_check_id);
			if(!$num_record){
				$hash = password_hash($pw, PASSWORD_DEFAULT);
				mysqli_query($conn,"INSERT INTO user (id, pw, name, phone, email, states, birth, sex, pw_question, pw_answer) VALUES ('$id', '$hash', '$name', '$phone', '$email', '$state', '$birth', '$sex', '$pw_question', '$pw_answer')");
				if($state == 1){
					sleep(2);
					$none_player = $_POST["none_player"];
					$position = $_POST["position"];
					$leri_pic = $_POST["leri_pic"];
					$leri_hit = $_POST["leri_hit"];
					$player_class = $_POST["player_class"];
					$palyer_height = $_POST["palyer_height"];
					$palyer_weight = $_POST["palyer_weight"];
					$result_login = mysqli_query($conn, "SELECT MAX(no) as maxno FROM user where id LIKE '%$id%'");
					$row_login = mysqli_fetch_array($result_login);
					$user_no = $row_login['maxno'];
					mysqli_query($conn,"INSERT INTO player (user, leri_hit, leri_pic, none_player, position, class, weight, height) VALUES ('$user_no', '$leri_hit', '$leri_pic', '$none_player', '$position', '$player_class', '$palyer_weight', '$palyer_height')");
				}
				mysqli_close($conn);
				echo "<script>alert('회원가입이 완료되었습니다. 로그인 페이지로 이동합니다.');</script>";
				echo ("<meta http-equiv='Refresh' content='1; URL=user.html?user=login'>");
			}else{
				echo "<script>alert('아이디가 존재합니다. 다른 아이디를 사용하세요.');</script>";
				echo "<script>history.back();</script>";
			}
		}else{
			//비밀번호 일치 x
			echo "<script>alert('비밀번호가 일치 하지 않습니다.');</script>";
			echo "<script>history.back();</script>";
		}
	}else{
		//공백
		echo "<script>alert('모두 입력되어야 합니다.');</script>";
		echo "<script>history.back();</script>";
	}
}else{
	//중복확인
	echo "<script>alert('아이디 중복확인이 필요합니다.');</script>";
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
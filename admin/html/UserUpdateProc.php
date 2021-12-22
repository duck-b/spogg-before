<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php

include "dbconn.php";

session_start();

if(!$_POST['admin']){
	$user_no = $_SESSION['user_no'];

	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$user_result = mysqli_query($conn,"SELECT * FROM user where no='$user_no'");
	$user_row = mysqli_fetch_array($user_result);
	mysqli_query($conn,"UPDATE user SET  phone = '$phone', email = '$email' WHERE no = '$user_no'");

	if($user_row['states'] == 1 || $user_row['states'] == 3){
		$position = $_POST["position"];
		$leri_pic = $_POST["leri_pic"];
		$leri_hit = $_POST["leri_hit"];
		$player_class = $_POST["player_class"];
		$player_height = $_POST["player_height"];
		$player_weight = $_POST["player_weight"];
		$team = $_POST["team"];
		
		if($_FILES['img']['tmp_name']){
			if($user_row['img']){
				if($user_row['img']){ unlink($user_row['img']); }
			}
			$_FILES['img']['name'] = $user_no.'_'.$_FILES['img']['name'];
			$user_img = $_FILES['img']['name'];
			$target = 'images/user_prof/'.$user_img;
			$tmp_name = $_FILES['img']['tmp_name'];
			move_uploaded_file($tmp_name, $target);
			mysqli_query($conn,"UPDATE player SET img = '$target' WHERE user = '$user_no'");
		}
		mysqli_query($conn,"UPDATE player SET  position = '$position', leri_pic = '$leri_pic', leri_hit = '$leri_hit', class = '$player_class', weight = '$player_weight', height = '$player_height', team = '$team' WHERE user = '$user_no'");
	}
	echo "<script>alert('회원정보가 수정 되었습니다');</script>";
	echo ("<meta http-equiv='Refresh' content='1; URL=user.html?user=info&no=".$user_no."'>");
}else if($_POST['admin']){
	if($_SESSION['admin']){
		$user_no = $_POST['no'];
		
		$states = $_POST['states'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		$state = $_POST['state'];
		$user_result = mysqli_query($conn,"SELECT * FROM user where no='$user_no'");
		$user_row = mysqli_fetch_array($user_result);
		mysqli_query($conn,"UPDATE user SET  phone = '$phone', email = '$email', states = '$states' WHERE no = '$user_no'");

		if($user_row['states'] == 1 || $user_row['states'] == 3){
			$position = $_POST["position"];
			$leri_pic = $_POST["leri_pic"];
			$leri_hit = $_POST["leri_hit"];
			$player_class = $_POST["player_class"];
			$player_height = $_POST["player_height"];
			$player_weight = $_POST["player_weight"];
			$team = $_POST["team"];
			
			if($_FILES['img']['tmp_name']){
				if($user_row['img']){
					if($user_row['img']){ unlink($user_row['img']); }
				}
				$_FILES['img']['name'] = $user_no.'_'.$_FILES['img']['name'];
				$user_img = $_FILES['img']['name'];
				$target = 'images/user_prof/'.$user_img;
				$tmp_name = $_FILES['img']['tmp_name'];
				move_uploaded_file($tmp_name, $target);
				mysqli_query($conn,"UPDATE player SET img = '$target' WHERE user = '$user_no'");
			}
			mysqli_query($conn,"UPDATE player SET  position = '$position', leri_pic = '$leri_pic', leri_hit = '$leri_hit', class = '$player_class', weight = '$player_weight', height = '$player_height', team = '$team' WHERE user = '$user_no'");
		}
		echo "<script>alert('회원정보가 수정 되었습니다');</script>";
		echo ("<meta http-equiv='Refresh' content='1; URL=admin.html?admin=user&no=".$user_no."'>");
	}else{
		echo "<script>alert('잘못된 접근입니다.');</script>";
		echo "window.location.replace('index.html');</script>";
	}
}
mysqli_close($conn);

include "inc/_head.html";
?>
<body>
	<div class="load">
		<img src="/images/loading.gif" alt="loading">
	</div>
</body>
</html>
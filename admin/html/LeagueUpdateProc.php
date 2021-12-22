<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php

include "dbconn.php";

session_start();

$no = $_GET['no'];
$com = $_GET['com'];
$pro_check_result = mysqli_query($conn,"SELECT * FROM league where no='$no'");
$pro_check_row = mysqli_fetch_array($pro_check_result);
$user_no = $_SESSION['user_no'];
if($user_no == $pro_check_row['pro'] || $_SESSION['admin'] == 1){
	if($com){
		if($com == 'acc' && $_SESSION['admin'] == 1){
			mysqli_query($conn,"UPDATE league SET state = '1' WHERE no = '$no'");
			mysqli_close($conn);
			echo "<script>alert('수정 되었습니다.');</script>";
			echo "<script>history.back();</script>";	
		}elseif($com == 'stp' && $_SESSION['admin'] == 1){
			mysqli_query($conn,"UPDATE league SET state = '2' WHERE no = '$no'");
			mysqli_close($conn);
			echo "<script>alert('수정 되었습니다.');</script>";
			echo "<script>history.back();</script>";	
		}elseif($com == 'ref' && $_SESSION['admin'] == 1){
			mysqli_query($conn,"UPDATE league SET state = '3' WHERE no = '$no'");
			mysqli_close($conn);
			echo "<script>alert('수정 되었습니다.');</script>";
			echo "<script>history.back();</script>";	
		}else{
			echo "<script>alert('잘못된 접근입니다.');</script>";
			echo "<script>history.back();</script>";
		}
	}else{
		$name = $_POST['name'];
		$adrs = $_POST['adrs'];
		$league_class = $_POST['league_class'];
		$kind = $_POST['kind'];
		$contents = $_POST['leagueedit'];
		if($_FILES['img']['tmp_name']){
			if($pro_check_row['img']){
				if($pro_check_row['img']){ unlink($pro_check_row['img']); }
			}
			$_FILES['img']['name'] = date("YmdHis").'_'.$name.'_'.$_FILES['img']['name'];
			$img = $_FILES['img']['name'];
			$target = 'images/league_logo/'.$img;
			$tmp_name = $_FILES['img']['tmp_name'];
			move_uploaded_file($tmp_name, $target);
			mysqli_query($conn,"UPDATE league SET img = '$target' WHERE no = '$no'");
		}
		mysqli_query($conn,"UPDATE league SET name = '$name', adrs = '$adrs', class = '$league_class', kinds = '$kind', contents = '$contents' WHERE no = '$no'");
		mysqli_close($conn);
		echo "<script>alert('수정 되었습니다.');</script>";
		echo "<script>history.back();</script>";	
	}
}else{
	echo "<script>alert('잘못된 접근입니다.');</script>";
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
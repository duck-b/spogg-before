<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php

session_start();
$user_no = $_SESSION['user_no'];
$name = $_POST['name'];
$adrs = $_POST['adrs'];
$found = $_POST['found'];
$league_class = $_POST['league_class'];
$kind = $_POST['kind'];

if($name != null && $adrs != null && $found != null && $league_class != null && $kind != null){
	include "dbconn.php";
	
	if($_FILES['img']['name'] != null){
		$_FILES['img']['name'] = date("YmdHis").'_'.$name.'_'.$_FILES['img']['name'];
		$img = $_FILES['img']['name'];
		$target = 'images/league_logo/'.$img;
		$tmp_name = $_FILES['img']['tmp_name'];
		move_uploaded_file($tmp_name, $target);
	}
	mysqli_query($conn,"INSERT INTO league (name, pro, img, kinds, class, found, adrs, state) VALUES ('$name', '$user_no', '$target', '$kind', '$league_class', '$found', '$adrs', '2')");
	echo "<script>alert('개설이 완료 되었습니다.');</script>";
	echo "<script>window.location.replace('admin.html?admin=league);</script>";
}else{
	echo "<script>alert('모두 입력 해야합니다.');</script>";
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
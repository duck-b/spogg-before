<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php

session_start();
$user_no = $_SESSION['user_no'];
$kind = $_GET['kind'];
if($user_no){
	if($kind == 'game'){
		$no = $_GET['no'];
		include "dbconn.php";
		$writer_result = mysqli_query($conn,"SELECT * FROM game WHERE no ='$no'");
		$writer_row = mysqli_fetch_array($writer_result);
		if($user_no == $writer_row['user']){
			$delete_time = date("Y-m-d H:i:s");
			mysqli_query($conn,"UPDATE game SET deleted_at = '$delete_time' WHERE no = '$no'");
			mysqli_close($conn);
			if($writer_row['kind'] == 1){
				$game = 'hgame';
			}else if($writer_row['kind'] == 2){
				$game = 'agame';
			}else if($writer_row['kind'] == 3){
				$game = 'merc';
			}else if($writer_row['kind'] == 4){
				$game = 'stadium';
			}
			echo "<script>alert('삭제 되었습니다.');</script>";
			echo "<script>window.location.replace('game.html?game=$game');</script>";
		}else{
			echo "<script>alert('잘못된 접근입니다.');</script>";
			echo "<script>window.location.replace('index.html');</script>";	
		}
	}else if($kind == 'comment'){
		$no = $_GET['no'];
		include "dbconn.php";
		$writer_result = mysqli_query($conn,"SELECT * FROM game_comment WHERE no ='$no'");
		$writer_row = mysqli_fetch_array($writer_result);
		if($user_no == $writer_row['user']){
			$delete_time = date("Y-m-d H:i:s");
			mysqli_query($conn,"UPDATE game_comment SET deleted_at = '$delete_time' WHERE no = '$no'");
			mysqli_close($conn);
			$game_no = $writer_row['game'];
			echo "<script>alert('삭제 되었습니다.');</script>";
			echo "<script>window.location.replace('game.html?game=read&no=$game_no');</script>";
		}else{
			echo "<script>alert('잘못된 접근입니다.');</script>";
			echo "<script>window.location.replace('index.html');</script>";	
		}
	}else if($kind == 'recomment'){
		$no = $_GET['no'];
		include "dbconn.php";
		$writer_result = mysqli_query($conn,"SELECT * FROM game_recomment WHERE no ='$no'");
		$writer_row = mysqli_fetch_array($writer_result);
		if($user_no == $writer_row['user']){
			$delete_time = date("Y-m-d H:i:s");
			mysqli_query($conn,"UPDATE game_recomment SET deleted_at = '$delete_time' WHERE no = '$no'");
			$comment_no = $writer_row['comment'];
			$comment_result = mysqli_query($conn,"SELECT * FROM game_comment WHERE no ='$comment_no'");
			$comment_row = mysqli_fetch_array($comment_result);
			$game_no = $comment_row['game'];
			mysqli_close($conn);
			echo "<script>alert('삭제 되었습니다.');</script>";
			echo "<script>window.location.replace('game.html?game=read&no=$game_no');</script>";
		}else{
			echo "<script>alert('잘못된 접근입니다.');</script>";
			echo "<script>window.location.replace('index.html');</script>";	
		}
	}else if($kind == 'mercplayer'){
		$no = $_GET['no'];
		include "dbconn.php";
		$merc_result = mysqli_query($conn,"SELECT * FROM game_merc WHERE no = '$no'");
		$merc_row = mysqli_fetch_array($merc_result);
		mysqli_close($conn);
		if($user_no == $merc_row['user']){
			include "dbconn.php";
			$game = $merc_row['game'];
			mysqli_query($conn,"DELETE FROM game_merc WHERE no='$no'");
			mysqli_close($conn);
			echo "<script>alert('취소 되었습니다.');</script>";
			echo "<script>window.location.replace('game.html?game=read&no=$game');</script>";
		}else{
			echo "<script>alert('잘못된 접근입니다.');</script>";
			echo "<script>window.location.replace('index.html');</script>";	
		}
	}
}else{
	echo "<script>alert('로그인이 필요한 기능입니다');";
	echo "window.location.replace('user.html?user=login');</script>";
}
include "inc/_head.html";
?>
<body>
	<div class="load">
		<img src="/images/loading.gif" alt="loading">
	</div>
</body>
</html>
<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php

session_start();
$user_no = $_SESSION['user_no'];
if($_POST['kind']){
	$kind = $_POST['kind'];
}else if($_GET['kind']){
	$kind = $_GET['kind'];
}
if($user_no){
	if(!$kind){
		$title = $_POST['title'];
		$game_date = $_POST['game_date'];
		$stadium_name = $_POST['stadium_name'];
		if($_POST['stadium_price']){
			$stadium_price = $_POST['stadium_price'];
		}else{
			$stadium_price = "0";
		}
		$adrs = $_POST['adrs'];
		$contents = $_POST['contents'];
		$no = $_POST['no'];
		include "dbconn.php";
		$writer_result = mysqli_query($conn,"SELECT * FROM game WHERE no ='$no'");
		$writer_row = mysqli_fetch_array($writer_result);
		if($user_no == $writer_row['user']){
			mysqli_query($conn,"UPDATE game SET title = '$title', game_date = '$game_date', stadium_name = '$stadium_name', stadium_price = '$stadium_price', adrs = '$adrs', contents = '$contents' WHERE no = '$no'");
			mysqli_close($conn);
			echo "<script>alert('수정 되었습니다.');</script>";
			echo "<script>window.location.replace('game.html?game=read&no=$no');</script>";
		}else{
			echo "<script>alert('잘못된 접근입니다.');</script>";
			echo "<script>window.location.replace('index.html');</script>";	
		}
	}else if($kind == 'comment'){
		$contents = $_POST['contents'];
		$no = $_POST['no'];
		include "dbconn.php";
		$writer_result = mysqli_query($conn,"SELECT * FROM game_comment WHERE no ='$no'");
		$writer_row = mysqli_fetch_array($writer_result);
		if($contents != null && $user_no == $writer_row['user']){
			mysqli_query($conn,"UPDATE game_comment SET contents = '$contents' WHERE no = '$no'");
			mysqli_close($conn);
			$game = $writer_row['game'];
			echo "<script>alert('수정 되었습니다.');</script>";
			echo "<script>window.location.replace('game.html?game=read&no=$game');</script>";
		}else{
			mysqli_close($conn);
			if($user_no != $writer_row['user']){
				echo "<script>alert('잘못된 접근입니다.');</script>";
				echo "<script>window.location.replace('index.html');</script>";	
			}else{
				echo "<script>alert('내용이 필요합니다');</script>";
				echo "<script>history.back();</script>";	
			}
		}
	}else if($kind == 'recomment'){
		$contents = $_POST['contents'];
		$no = $_POST['no'];
		include "dbconn.php";
		$writer_result = mysqli_query($conn,"SELECT * FROM game_recomment WHERE no ='$no'");
		$writer_row = mysqli_fetch_array($writer_result);
		$comment_no = $writer_row['comment'];
		if($contents != null && $user_no == $writer_row['user']){
			mysqli_query($conn,"UPDATE game_recomment SET contents = '$contents' WHERE no = '$no'");
			$comment_result = mysqli_query($conn,"SELECT * FROM game_comment WHERE no ='$comment_no'");
			$comment_row = mysqli_fetch_array($comment_result);
			$game = $comment_row['game'];
			mysqli_close($conn);
			echo "<script>alert('수정 되었습니다.');</script>";
			echo "<script>window.location.replace('game.html?game=read&no=$game');</script>";
		}else{
			mysqli_close($conn);
			if($user_no != $writer_row['user']){
				echo "<script>alert('잘못된 접근입니다.');</script>";
				echo "<script>window.location.replace('index.html');</script>";	
			}else{
				echo "<script>alert('내용이 필요합니다');</script>";
				echo "<script>history.back();</script>";	
			}
		}
	}else if($kind == 'states'){
		$no = $_GET['no'];
		include "dbconn.php";
		$writer_result = mysqli_query($conn,"SELECT * FROM game WHERE no ='$no'");
		$writer_row = mysqli_fetch_array($writer_result);
		if($user_no == $writer_row['user']){
			mysqli_query($conn,"UPDATE game_states SET states = '2' WHERE game = '$no'");
			mysqli_close($conn);
			echo "<script>alert('수정 되었습니다.');</script>";
			echo "<script>window.location.replace('game.html?game=read&no=$no');</script>";
		}else{
			mysqli_close($conn);
			echo "<script>alert('잘못된 접근입니다.');</script>";
			echo "<script>window.location.replace('index.html');</script>";				
		}
	}else if($kind == 'mercplayer'){
		$merc_no = $_GET['no'];
		include "dbconn.php";
		$merc_result = mysqli_query($conn,"SELECT * FROM game_merc WHERE no = '$merc_no'");
		$merc_row = mysqli_fetch_array($merc_result);
		if($merc_row['states'] == 2){
			$game_no = $merc_row['game'];
			$game_result = mysqli_query($conn,"SELECT * FROM game WHERE no = '$game_no'");
			$game_row = mysqli_fetch_array($game_result);
			mysqli_close($conn);
			if($user_no == $game_row['user']){
				include "dbconn.php";
				mysqli_query($conn,"UPDATE game_merc SET states = '1' WHERE no = '$merc_no'");
				$pos = $merc_row['position'];
				$pos_activ_result = mysqli_query($conn,"SELECT * FROM game_merc WHERE position = '$pos' AND game = '$game_no'");
				while($pos_activ_row = mysqli_fetch_array($pos_activ_result)){
					$board_no = $pos_activ_row['no'];
					$board_activiy_result = mysqli_query($conn, "SELECT * FROM user_activity where board = '$board_no' AND board_table = 'merc'");
					$board_activiy_row = mysqli_fetch_array($board_activiy_result);
					if($board_activiy_row){
						mysqli_query($conn,"UPDATE user_activity SET count = 1 WHERE board = '$board_no' AND board_table = 'merc'");
					}else{
						$board_user_result = mysqli_query($conn, "SELECT * FROM game_merc where no = '$board_no'");
						$board_user_row = mysqli_fetch_array($board_user_result);
						$board_user_no = $board_user_row['user'];
						mysqli_query($conn,"INSERT INTO user_activity (user, board, board_table, count) VALUES ('$board_user_no', '$board_no', 'game_merc', '1')");
					}
				}
				mysqli_close($conn);
				echo "<script>alert('수정 되었습니다.');</script>";
				echo "<script>window.location.replace('game.html?game=read&no=$game_no');</script>";
			}else{
				echo "<script>alert('잘못된 접근입니다.');</script>";
				echo "<script>window.location.replace('index.html');</script>";	
			}
		}else if($merc_row['states'] == 1){
			$game_no = $merc_row['game'];
			$game_result = mysqli_query($conn,"SELECT * FROM game WHERE no = '$game_no'");
			$game_row = mysqli_fetch_array($game_result);
			mysqli_close($conn);
			if($user_no == $game_row['user']){
				include "dbconn.php";
				mysqli_query($conn,"UPDATE game_merc SET states = '2' WHERE no = '$merc_no'");
				mysqli_close($conn);
				echo "<script>alert('수정 되었습니다.');</script>";
				echo "<script>window.location.replace('game.html?game=read&no=$game_no');</script>";
			}else{
				echo "<script>alert('잘못된 접근입니다.');</script>";
				echo "<script>window.location.replace('index.html');</script>";	
			}
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
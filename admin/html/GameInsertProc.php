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
	if($kind == '1'){
		$team = $_POST['team'];		
		$title = $_POST['title'];
		$game_date = $_POST['game_date'];
		$stadium_name = $_POST['stadium_name'];
		$stadium_price = $_POST['stadium_price'];
		$adrs = $_POST['adrs'];
		$contents = $_POST['contents'];
		if($team != null && $title != null && $game_date != null && $stadium_name != null && $stadium_price != null && $adrs != null){
			include "dbconn.php";
			mysqli_query($conn,"INSERT INTO game (user, team, title, kind, game_date, stadium_name, stadium_price, adrs, contents) VALUES ('$user_no', '$team', '$title', '$kind', '$game_date', '$stadium_name', '$stadium_price', '$adrs', '$contents')");
			$view_result = mysqli_query($conn, "SELECT MAX(no) as maxno FROM game where title LIKE '%$title%' AND user = '$user_no'");
			$view_row = mysqli_fetch_array($view_result);
			$game_no = $view_row['maxno'];
			mysqli_query($conn,"INSERT INTO game_view (game) VALUES ('$game_no')");
			mysqli_query($conn,"INSERT INTO game_states (game) VALUES ('$game_no')");
			mysqli_close($conn);
			echo "<script>alert('등록 되었습니다.');</script>";
			echo "<script>window.location.replace('game.html?game=hgame');</script>";
		}else{
			echo "<script>alert('모두 입력해야 합니다.');</script>";
			echo "<script>history.back();</script>";	
		}
	}else if($kind == '2'){
		$team = $_POST['team'];
		$title = $_POST['title'];
		$game_date = $_POST['game_date'];
		$adrs = $_POST['adrs'];
		$contents = $_POST['contents'];
		if($team != null && $title != null && $game_date != null && $adrs != null){
			include "dbconn.php";
			mysqli_query($conn,"INSERT INTO game (user, team, title, kind, game_date, adrs, contents) VALUES ('$user_no', '$team', '$title', '$kind', '$game_date', '$adrs', '$contents')");
			$view_result = mysqli_query($conn, "SELECT MAX(no) as maxno FROM game where title LIKE '%$title%' AND user = '$user_no'");
			$view_row = mysqli_fetch_array($view_result);
			$game_no = $view_row['maxno'];
			mysqli_query($conn,"INSERT INTO game_view (game) VALUES ('$game_no')");
			mysqli_query($conn,"INSERT INTO game_states (game) VALUES ('$game_no')");
			mysqli_close($conn);		
			echo "<script>alert('등록 되었습니다.');</script>";
			echo "<script>window.location.replace('game.html?game=agame');</script>";
		}else{
			echo "<script>alert('모두 입력해야 합니다.');</script>";
			echo "<script>history.back();</script>";	
		}
	}else if($kind == '3'){
		$title = $_POST['title'];
		$game_date = $_POST['game_date'];
		$stadium_name = $_POST['stadium_name'];
		$stadium_price = $_POST['stadium_price'];
		$adrs = $_POST['adrs'];
		$contents = $_POST['contents'];
		if($title != null && $game_date != null && $stadium_name != null && $stadium_price != null && $adrs != null){
			include "dbconn.php";
			mysqli_query($conn,"INSERT INTO game (user, title, kind, game_date, stadium_name, stadium_price, adrs, contents) VALUES ('$user_no', '$title', '$kind', '$game_date', '$stadium_name', '$stadium_price', '$adrs', '$contents')");
			$view_result = mysqli_query($conn, "SELECT MAX(no) as maxno FROM game where title LIKE '%$title%' AND user = '$user_no'");
			$view_row = mysqli_fetch_array($view_result);
			$game_no = $view_row['maxno'];
			mysqli_query($conn,"INSERT INTO game_view (game) VALUES ('$game_no')");
			mysqli_query($conn,"INSERT INTO game_states (game) VALUES ('$game_no')");
			if($_POST['position']){
			$position = implode("|", $_POST['position']);
				$position_save = explode("|",$position);
				for ($i=0; $i < count($position_save); $i++) {
					$pos = $position_save[$i];
					mysqli_query($conn,"INSERT INTO game_merc (game, user, position, states) VALUES ('$game_no', '$user_no', '$pos', '1')");
				}
			}
			mysqli_close($conn);
			echo "<script>alert('등록 되었습니다.');</script>";
			echo "<script>window.location.replace('game.html?game=merc');</script>";
		}else{
			echo "<script>alert('모두 입력해야 합니다.');</script>";
			echo "<script>history.back();</script>";	
		}
	}else if($kind == '4'){
		$title = $_POST['title'];
		$game_date = $_POST['game_date'];
		$stadium_name = $_POST['stadium_name'];
		$stadium_price = $_POST['stadium_price'];
		$adrs = $_POST['adrs'];
		$contents = $_POST['contents'];
			if($title != null && $game_date != null && $stadium_name != null && $stadium_price != null && $adrs != null){
			include "dbconn.php";
			mysqli_query($conn,"INSERT INTO game (user, title, kind, game_date, stadium_name, stadium_price, adrs, contents) VALUES ('$user_no', '$title', '$kind', '$game_date', '$stadium_name', '$stadium_price', '$adrs', '$contents')");
			$view_result = mysqli_query($conn, "SELECT MAX(no) as maxno FROM game where title LIKE '%$title%' AND user = '$user_no'");
			$view_row = mysqli_fetch_array($view_result);
			$game_no = $view_row['maxno'];
			mysqli_query($conn,"INSERT INTO game_view (game) VALUES ('$game_no')");
			mysqli_query($conn,"INSERT INTO game_states (game) VALUES ('$game_no')");
			mysqli_close($conn);
			echo "<script>alert('등록 되었습니다.');</script>";
			echo "<script>window.location.replace('game.html?game=stadium');</script>";
		}else{
			echo "<script>alert('모두 입력해야 합니다.');</script>";
			echo "<script>history.back();</script>";	
		}
	}else if($kind == 'comment'){
		$contents = $_POST['contents'];
		$game_no = $_POST['game'];
		include "dbconn.php";
		mysqli_query($conn,"INSERT INTO game_comment (user, game, contents) VALUES ('$user_no', '$game_no', '$contents')");
		$board_activiy_result = mysqli_query($conn, "SELECT * FROM user_activity where board = '$game_no' AND board_table = 'game'");
		$board_activiy_row = mysqli_fetch_array($board_activiy_result);
		if($board_activiy_row){
			mysqli_query($conn,"UPDATE user_activity SET count = count + 1 WHERE board = '$game_no' AND board_table = 'game'");
		}else{
			$board_user_result = mysqli_query($conn, "SELECT * FROM game where no = '$game_no'");
			$board_user_row = mysqli_fetch_array($board_user_result);
			$board_user_no = $board_user_row['user'];
			mysqli_query($conn,"INSERT INTO user_activity (user, board, board_table, count) VALUES ('$board_user_no', '$game_no', 'game', '1')");
		}
		mysqli_close($conn);
		echo "<script>alert('등록 되었습니다.');</script>";
		echo "<script>window.location.replace('game.html?game=read&no=$game_no');</script>";
	}else if($kind == 'recomment'){
		$contents = $_POST['contents'];
		$game_no = $_POST['game'];
		$comment_no = $_POST['comment'];
		include "dbconn.php";
		mysqli_query($conn,"INSERT INTO game_recomment (user, comment, contents) VALUES ('$user_no', '$comment_no', '$contents')");
		$board_activiy_result = mysqli_query($conn, "SELECT * FROM user_activity where board = '$game_no' AND board_table = 'game'");
		$board_activiy_row = mysqli_fetch_array($board_activiy_result);
		if($board_activiy_row){
			mysqli_query($conn,"UPDATE user_activity SET count = count + 1 WHERE board = '$game_no' AND board_table = 'game'");
		}else{
			$board_user_result = mysqli_query($conn, "SELECT * FROM game where no = '$game_no'");
			$board_user_row = mysqli_fetch_array($board_user_result);
			$board_user_no = $board_user_row['user'];
			mysqli_query($conn,"INSERT INTO user_activity (user, board, board_table, count) VALUES ('$board_user_no', '$game_no', 'game', '1')");
		}
		$board_activiy_result = mysqli_query($conn, "SELECT * FROM user_activity where board = '$comment_no' AND board_table = 'game_comment'");
		$board_activiy_row = mysqli_fetch_array($board_activiy_result);
		if($board_activiy_row){
			mysqli_query($conn,"UPDATE user_activity SET count = count + 1 WHERE board = '$comment_no' AND board_table = 'game_comment'");
		}else{
			$board_user_result = mysqli_query($conn, "SELECT * FROM game_comment where no = '$comment_no'");
			$board_user_row = mysqli_fetch_array($board_user_result);
			$board_user_no = $board_user_row['user'];
			mysqli_query($conn,"INSERT INTO user_activity (user, board, board_table, count) VALUES ('$board_user_no', '$comment_no', 'game_comment', '1')");
		}
		mysqli_close($conn);
		echo "<script>alert('등록 되었습니다.');</script>";
		echo "<script>window.location.replace('game.html?game=read&no=$game_no');</script>";
	}else if($kind == 'mercplayer'){
		$game = $_GET['no'];
		$pos = $_GET['pos'];
		include "dbconn.php";
		$merc_result = mysqli_query($conn,"SELECT * FROM game_merc WHERE game ='$game' AND position = '$pos' AND user = '$user_no'");
		$merc_row = mysqli_fetch_array($merc_result);
		mysqli_close($conn);
		if(!$merc_row){
			include "dbconn.php";
			mysqli_query($conn,"INSERT INTO game_merc (game, user, position, states) VALUES ('$game', '$user_no', '$pos' , '2')");
			$board_activiy_result = mysqli_query($conn, "SELECT * FROM user_activity where board = '$game' AND board_table = 'game'");
			$board_activiy_row = mysqli_fetch_array($board_activiy_result);
			if($board_activiy_row){
				mysqli_query($conn,"UPDATE user_activity SET count = count + 1 WHERE board = '$game' AND board_table = 'game'");
			}else{
				$board_user_result = mysqli_query($conn, "SELECT * FROM game where no = '$game'");
				$board_user_row = mysqli_fetch_array($board_user_result);
				$board_user_no = $board_user_row['user'];
				mysqli_query($conn,"INSERT INTO user_activity (user, board, board_table, count) VALUES ('$board_user_no', '$game', 'game', '1')");
			}
			mysqli_close($conn);
			echo "<script>alert('신청 되었습니다.');</script>";
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
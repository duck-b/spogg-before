<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php

session_start();
$user_no = $_SESSION['user_no'];
$kind = $_GET['kind'];
$no = $_GET['no'];
if($kind == 'free'){
	include "dbconn.php";
	$writer_result = mysqli_query($conn,"SELECT * FROM board_free WHERE no ='$no'");
	$writer_row = mysqli_fetch_array($writer_result);
	mysqli_close($conn);
	if($user_no == $writer_row['user']){
		include "dbconn.php";
		$delete_time = date("Y-m-d H:i:s");
		mysqli_query($conn,"UPDATE board_free SET deleted_at = '$delete_time' WHERE no = '$no'");
		mysqli_close($conn);
		echo "<script>alert('삭제 되었습니다.');</script>";
		echo "<script>window.location.replace('board.html?board=free');</script>";
	}else{
		echo "<script>alert('잘못된 접근입니다.');</script>";
		echo "<script>window.location.replace('index.html');</script>";				
	}
}else if($kind == 'commentfree'){
	include "dbconn.php";
	$writer_result = mysqli_query($conn,"SELECT * FROM board_free_comment WHERE no ='$no'");
	$writer_row = mysqli_fetch_array($writer_result);
	mysqli_close($conn);
	if($user_no == $writer_row['user']){
		include "dbconn.php";
		$delete_time = date("Y-m-d H:i:s");
		mysqli_query($conn,"UPDATE board_free_comment SET deleted_at = '$delete_time' WHERE no = '$no'");
		mysqli_close($conn);
		$board = $writer_row['board'];
		echo "<script>alert('삭제 되었습니다.');</script>";
		echo "<script>window.location.replace('board.html?board=free&no=$board');</script>";
	}else{
		echo "<script>alert('잘못된 접근입니다.');</script>";
		echo "<script>window.location.replace('index.html');</script>";				
	}
}else if($kind == 'recommentfree'){
	include "dbconn.php";
	$writer_result = mysqli_query($conn,"SELECT * FROM board_free_recomment WHERE no ='$no'");
	$writer_row = mysqli_fetch_array($writer_result);
	mysqli_close($conn);
	if($user_no == $writer_row['user']){
		include "dbconn.php";
		$delete_time = date("Y-m-d H:i:s");
		mysqli_query($conn,"UPDATE board_free_recomment SET deleted_at = '$delete_time' WHERE no = '$no'");
		$comment_no = $writer_row['comment'];
		$comment_result = mysqli_query($conn,"SELECT * FROM board_free_comment WHERE no ='$comment_no'");
		$comment_row = mysqli_fetch_array($comment_result);
		$board = $comment_row['board'];
		mysqli_close($conn);
		echo "<script>alert('삭제 되었습니다.');</script>";
		echo "<script>window.location.replace('board.html?board=free&no=$board');</script>";	
	}else{
		echo "<script>alert('잘못된 접근입니다.');</script>";
		echo "<script>window.location.replace('index.html');</script>";				
	}
}else if($kind == 'fa'){
	include "dbconn.php";
	$writer_result = mysqli_query($conn,"SELECT * FROM board_fa WHERE no ='$no'");
	$writer_row = mysqli_fetch_array($writer_result);
	mysqli_close($conn);
	if($user_no == $writer_row['user']){
		include "dbconn.php";
		$delete_time = date("Y-m-d H:i:s");
		mysqli_query($conn,"UPDATE board_fa SET deleted_at = '$delete_time' WHERE no = '$no'");
		mysqli_close($conn);
		echo "<script>alert('삭제 되었습니다.');</script>";
		echo "<script>window.location.replace('board.html?board=fa');</script>";		
	}else{
		echo "<script>alert('잘못된 접근입니다.');</script>";
		echo "<script>window.location.replace('index.html');</script>";				
	}
}else if($kind == 'commentfa'){
	include "dbconn.php";
	$writer_result = mysqli_query($conn,"SELECT * FROM board_fa_comment WHERE no ='$no'");
	$writer_row = mysqli_fetch_array($writer_result);
	mysqli_close($conn);
	if($user_no == $writer_row['user']){
		include "dbconn.php";
		$delete_time = date("Y-m-d H:i:s");
		mysqli_query($conn,"UPDATE board_fa_comment SET deleted_at = '$delete_time' WHERE no = '$no'");
		mysqli_close($conn);
		$board = $writer_row['board'];
		echo "<script>alert('삭제 되었습니다.');</script>";
		echo "<script>window.location.replace('board.html?board=fa&no=$board');</script>";		
	}else{
		echo "<script>alert('잘못된 접근입니다.');</script>";
		echo "<script>window.location.replace('index.html');</script>";				
	}
}else if($kind == 'recommentfa'){
	include "dbconn.php";
	$writer_result = mysqli_query($conn,"SELECT * FROM board_fa_recomment WHERE no ='$no'");
	$writer_row = mysqli_fetch_array($writer_result);
	mysqli_close($conn);
	if($user_no == $writer_row['user']){
		include "dbconn.php";
		$delete_time = date("Y-m-d H:i:s");
		mysqli_query($conn,"UPDATE board_fa_recomment SET deleted_at = '$delete_time' WHERE no = '$no'");
		$comment_no = $writer_row['comment'];
		$comment_result = mysqli_query($conn,"SELECT * FROM board_fa_comment WHERE no ='$comment_no'");
		$comment_row = mysqli_fetch_array($comment_result);
		$board = $comment_row['board'];
		mysqli_close($conn);
		echo "<script>alert('삭제 되었습니다.');</script>";
		echo "<script>window.location.replace('board.html?board=fa&no=$board');</script>";		
	}else{
		echo "<script>alert('잘못된 접근입니다.');</script>";
		echo "<script>window.location.replace('index.html');</script>";				
	}
}else if($kind == 'team'){
	include "dbconn.php";
	$writer_result = mysqli_query($conn,"SELECT * FROM board_team WHERE no ='$no'");
	$writer_row = mysqli_fetch_array($writer_result);
	mysqli_close($conn);
	if($user_no == $writer_row['user']){
		include "dbconn.php";
		$delete_time = date("Y-m-d H:i:s");
		mysqli_query($conn,"UPDATE board_team SET deleted_at = '$delete_time' WHERE no = '$no'");
		mysqli_close($conn);
		$team_no = $writer_row['team'];
		echo "<script>alert('삭제 되었습니다.');</script>";
		echo "<script>window.location.replace('team.html?team=page&no=$team_no&page=free');</script>";
	}else{
		echo "<script>alert('잘못된 접근입니다.');</script>";
		echo "<script>window.location.replace('index.html');</script>";				
	}
}else if($kind == 'commentteam'){
	include "dbconn.php";
	$writer_result = mysqli_query($conn,"SELECT * FROM board_team_comment WHERE no ='$no'");
	$writer_row = mysqli_fetch_array($writer_result);
	mysqli_close($conn);
	if($user_no == $writer_row['user']){
		include "dbconn.php";
		$delete_time = date("Y-m-d H:i:s");
		mysqli_query($conn,"UPDATE board_team_comment SET deleted_at = '$delete_time' WHERE no = '$no'");
		$board = $writer_row['board'];
		$board_result = mysqli_query($conn,"SELECT * FROM board_team where no='$board'");
		$board_row = mysqli_fetch_array($board_result);
		$team_no = $board_row['team'];
		mysqli_close($conn);
		echo "<script>alert('삭제 되었습니다.');</script>";
		echo "<script>window.location.replace('team.html?team=page&no=$team_no&page=free&read=$board');</script>";
	}else{
		echo "<script>alert('잘못된 접근입니다.');</script>";
		echo "<script>window.location.replace('index.html');</script>";				
	}	
}else if($kind == 'recommentteam'){
	include "dbconn.php";
	$writer_result = mysqli_query($conn,"SELECT * FROM board_team_recomment WHERE no ='$no'");
	$writer_row = mysqli_fetch_array($writer_result);
	mysqli_close($conn);
	if($user_no == $writer_row['user']){
		include "dbconn.php";
		$delete_time = date("Y-m-d H:i:s");
		mysqli_query($conn,"UPDATE board_team_recomment SET deleted_at = '$delete_time' WHERE no = '$no'");
		$comment_no = $writer_row['comment'];
		$comment_result = mysqli_query($conn,"SELECT * FROM board_team_comment WHERE no ='$comment_no'");
		$comment_row = mysqli_fetch_array($comment_result);
		$board = $comment_row['board'];
		$board_result = mysqli_query($conn,"SELECT * FROM board_team where no='$board'");
		$board_row = mysqli_fetch_array($board_result);
		$team_no = $board_row['team'];
		mysqli_close($conn);
		echo "<script>alert('삭제 되었습니다.');</script>";
		echo "<script>window.location.replace('team.html?team=page&no=$team_no&page=free&read=$board');</script>";
	}else{
		echo "<script>alert('잘못된 접근입니다.');</script>";
		echo "<script>window.location.replace('index.html');</script>";				
	}
}else if($kind == 'league'){
	include "dbconn.php";
	$writer_result = mysqli_query($conn,"SELECT * FROM board_league WHERE no ='$no'");
	$writer_row = mysqli_fetch_array($writer_result);
	mysqli_close($conn);
	if($user_no == $writer_row['user']){
		include "dbconn.php";
		$delete_time = date("Y-m-d H:i:s");
		mysqli_query($conn,"UPDATE board_league SET deleted_at = '$delete_time' WHERE no = '$no'");
		mysqli_close($conn);
		$league_no = $writer_row['league'];
		echo "<script>alert('삭제 되었습니다.');</script>";
		echo "<script>window.location.replace('league.html?league=page&no=$league_no&page=free');</script>";
	}else{
		echo "<script>alert('잘못된 접근입니다.');</script>";
		echo "<script>window.location.replace('index.html');</script>";				
	}
}else if($kind == 'commentleague'){
	include "dbconn.php";
	$writer_result = mysqli_query($conn,"SELECT * FROM board_league_comment WHERE no ='$no'");
	$writer_row = mysqli_fetch_array($writer_result);
	mysqli_close($conn);
	if($user_no == $writer_row['user']){
		include "dbconn.php";
		$delete_time = date("Y-m-d H:i:s");
		mysqli_query($conn,"UPDATE board_league_comment SET deleted_at = '$delete_time' WHERE no = '$no'");
		$board = $writer_row['board'];
		$board_result = mysqli_query($conn,"SELECT * FROM board_league where no='$board'");
		$board_row = mysqli_fetch_array($board_result);
		$league_no = $board_row['league'];
		mysqli_close($conn);
		echo "<script>alert('삭제 되었습니다.');</script>";
		echo "<script>window.location.replace('league.html?league=page&no=$league_no&page=free&read=$board');</script>";
	}else{
		echo "<script>alert('잘못된 접근입니다.');</script>";
		echo "<script>window.location.replace('index.html');</script>";				
	}	
}else if($kind == 'recommentleague'){
	include "dbconn.php";
	$writer_result = mysqli_query($conn,"SELECT * FROM board_league_recomment WHERE no ='$no'");
	$writer_row = mysqli_fetch_array($writer_result);
	mysqli_close($conn);
	if($user_no == $writer_row['user']){
		include "dbconn.php";
		$delete_time = date("Y-m-d H:i:s");
		mysqli_query($conn,"UPDATE board_league_recomment SET deleted_at = '$delete_time' WHERE no = '$no'");
		$comment_no = $writer_row['comment'];
		$comment_result = mysqli_query($conn,"SELECT * FROM board_league_comment WHERE no ='$comment_no'");
		$comment_row = mysqli_fetch_array($comment_result);
		$board = $comment_row['board'];
		$board_result = mysqli_query($conn,"SELECT * FROM board_league where no='$board'");
		$board_row = mysqli_fetch_array($board_result);
		$league_no = $board_row['league'];
		mysqli_close($conn);
		echo "<script>alert('삭제 되었습니다.');</script>";
		echo "<script>window.location.replace('league.html?league=page&no=$league_no&page=free&read=$board');</script>";
	}else{
		echo "<script>alert('잘못된 접근입니다.');</script>";
		echo "<script>window.location.replace('index.html');</script>";				
	}
}
include "inc/_head.html";
?>
<body>
	<div class="load">
		<img src="/images/loading.gif" alt="loading">
	</div>
</body>
</html>
<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php

session_start();
$user_no = $_SESSION['user_no'];
$kind = $_POST['kind'];
if($kind == 'free'){
	if($user_no){
		$title = $_POST['title'];
		$contents = $_POST['contents'];
		$tag = $_POST['tag'];
		if($title != null && $contents != null){
			include "dbconn.php";
			
			if($_FILES['img']['name'] != null){
				$_FILES['img']['name'] = date("YmdHis").'_'.$name.'_'.$_FILES['img']['name'];
				$img = $_FILES['img']['name'];
				$target = 'images/board/'.$img;
				$tmp_name = $_FILES['img']['tmp_name'];
				move_uploaded_file($tmp_name, $target);
			}
			mysqli_query($conn,"INSERT INTO board_free (user, title, contents, img, tag) VALUES ('$user_no', '$title', '$contents', '$target', '$tag')");
			$view_result = mysqli_query($conn, "SELECT MAX(no) as maxno FROM board_free where title LIKE '%$title%'");
			$view_row = mysqli_fetch_array($view_result);
			$board_no = $view_row['maxno'];
			mysqli_query($conn,"INSERT INTO board_free_view (board) VALUES ('$board_no')");
			mysqli_close($conn);
			echo "<script>alert('등록 되었습니다.');</script>";
			echo "<script>window.location.replace('board.html?board=free');</script>";
		}else{
				echo "<script>alert('제목과 내용이 필요합니다');</script>";
				echo "<script>history.back();</script>";		
		}
	}else{
		echo "<script>alert('로그인이 필요한 기능입니다');";
		echo "window.location.replace('user.html?user=login');</script>";
	}
}else if($kind == 'commentfree'){
	if($user_no){
		$contents = $_POST['contents'];
		$board = $_POST['board'];
		if($contents){
			include "dbconn.php";
			mysqli_query($conn,"INSERT INTO board_free_comment (board, user, contents) VALUES ('$board', '$user_no', '$contents')");
			$board_activiy_result = mysqli_query($conn, "SELECT * FROM user_activity where board = '$board' AND board_table = 'board_free'");
			$board_activiy_row = mysqli_fetch_array($board_activiy_result);
			if($board_activiy_row){
				mysqli_query($conn,"UPDATE user_activity SET count = count + 1 WHERE board = '$board' AND board_table = 'board_free'");
			}else{
				$board_user_result = mysqli_query($conn, "SELECT * FROM board_free where no = '$board'");
				$board_user_row = mysqli_fetch_array($board_user_result);
				$board_user_no = $board_user_row['user'];
				mysqli_query($conn,"INSERT INTO user_activity (user, board, board_table, count) VALUES ('$board_user_no', '$board', 'board_free', '1')");
			}
			mysqli_close($conn);
			echo "<script>alert('등록 되었습니다.');</script>";
			echo "<script>window.location.replace('board.html?board=free&no=$board');</script>";
		}else{
			echo "<script>alert('내용이 필요합니다');</script>";
			echo "<script>history.back();</script>";	
		}
	}else{
		echo "<script>alert('로그인이 필요한 기능입니다');";
		echo "window.location.replace('user.html?user=login');</script>";
	}
}else if($kind == 'recommentfree'){
	if($user_no){
		$contents = $_POST['contents'];
		$comment = $_POST['comment'];
		$board = $_POST['board'];
		if($contents){
			include "dbconn.php";
			mysqli_query($conn,"INSERT INTO board_free_recomment (comment, user, contents) VALUES ('$comment', '$user_no', '$contents')");
			$board_activiy_result = mysqli_query($conn, "SELECT * FROM user_activity where board = '$board' AND board_table = 'board_free'");
			$board_activiy_row = mysqli_fetch_array($board_activiy_result);
			if($board_activiy_row){
				mysqli_query($conn,"UPDATE user_activity SET count = count + 1 WHERE board = '$board' AND board_table = 'board_free'");
			}else{
				$board_user_result = mysqli_query($conn, "SELECT * FROM board_free where no = '$board'");
				$board_user_row = mysqli_fetch_array($board_user_result);
				$board_user_no = $board_user_row['user'];
				mysqli_query($conn,"INSERT INTO user_activity (user, board, board_table, count) VALUES ('$board_user_no', '$board', 'board_free', '1')");
			}
			$board_activiy_result = mysqli_query($conn, "SELECT * FROM user_activity where board = '$comment' AND board_table = 'board_free_comment'");
			$board_activiy_row = mysqli_fetch_array($board_activiy_result);
			if($board_activiy_row){
				mysqli_query($conn,"UPDATE user_activity SET count = count + 1 WHERE board = '$comment' AND board_table = 'board_free_comment'");
			}else{
				$board_user_result = mysqli_query($conn, "SELECT * FROM board_free_comment where no = '$comment'");
				$board_user_row = mysqli_fetch_array($board_user_result);
				$board_user_no = $board_user_row['user'];
				mysqli_query($conn,"INSERT INTO user_activity (user, board, board_table, count) VALUES ('$board_user_no', '$comment', 'board_free_comment', '1')");
			}
			mysqli_close($conn);
			echo "<script>alert('등록 되었습니다.');</script>";
			echo "<script>window.location.replace('board.html?board=free&no=$board');</script>";
		}else{
			echo "<script>alert('내용이 필요합니다');</script>";
			echo "<script>history.back();</script>";	
		}
	}else{
		echo "<script>alert('로그인이 필요한 기능입니다');";
		echo "window.location.replace('user.html?user=login');</script>";
	}
}else if($kind == 'fa'){
	if($user_no){
		$title = $_POST['title'];
		$contents = $_POST['contents'];
		$adrs = $_POST['adrs'];
		if($_POST['position']){
			$position = implode("|", $_POST['position']);
		}
		if($_FILES['img']['name'] != null){
			$_FILES['img']['name'] = date("YmdHis").'_'.$name.'_'.$_FILES['img']['name'];
			$img = $_FILES['img']['name'];
			$target = 'images/board/'.$img;
			$tmp_name = $_FILES['img']['tmp_name'];
			move_uploaded_file($tmp_name, $target);
		}else if($_POST['proimg']){
			$target = $_POST['proimg'];
		}
		if($title != null && $position != null && $adrs != null){
			include "dbconn.php";
			$age_result = mysqli_query($conn,"SELECT * FROM user WHERE no ='$user_no'");
			$age_row = mysqli_fetch_array($age_result);
			$birth = $age_row['birth'];
			$birth_time   = strtotime($birth);
			$now          = date('Ymd');
			$birthday     = date('Ymd' , $birth_time);
			$age           = floor(($now - $birthday) / 10000);
			mysqli_query($conn,"INSERT INTO board_fa (user, title, img, position, adrs, contents, age) VALUES ('$user_no', '$title', '$target', '$position', '$adrs', '$contents', '$age')");
			$view_result = mysqli_query($conn, "SELECT MAX(no) as maxno FROM board_fa where user = '$user_no'");
			$view_row = mysqli_fetch_array($view_result);
			$board_no = $view_row['maxno'];
			mysqli_query($conn,"INSERT INTO board_fa_view (board) VALUES ('$board_no')");
			mysqli_close($conn);
			echo "<script>alert('등록 되었습니다.');</script>";
			echo "<script>window.location.replace('board.html?board=fa');</script>";
		}else{
			echo "<script>alert('포지션과 지역이 필요합니다');</script>";
			echo "<script>history.back();</script>";
		}
	}else{
		echo "<script>alert('로그인이 필요한 기능입니다');";
		echo "window.location.replace('user.html?user=login');</script>";
	}	
}else if($kind == 'commentfa'){
	if($user_no){
		$contents = $_POST['contents'];
		$board = $_POST['board'];
		if($contents){
			include "dbconn.php";
			mysqli_query($conn,"INSERT INTO board_fa_comment (board, user, contents) VALUES ('$board', '$user_no', '$contents')");
			$board_activiy_result = mysqli_query($conn, "SELECT * FROM user_activity where board = '$board' AND board_table = 'board_fa'");
			$board_activiy_row = mysqli_fetch_array($board_activiy_result);
			if($board_activiy_row){
				mysqli_query($conn,"UPDATE user_activity SET count = count + 1 WHERE board = '$board' AND board_table = 'board_fa'");
			}else{
				$board_user_result = mysqli_query($conn, "SELECT * FROM board_fa where no = '$board'");
				$board_user_row = mysqli_fetch_array($board_user_result);
				$board_user_no = $board_user_row['user'];
				mysqli_query($conn,"INSERT INTO user_activity (user, board, board_table, count) VALUES ('$board_user_no', '$board', 'board_fa', '1')");
			}
			mysqli_close($conn);
			echo "<script>alert('등록 되었습니다.');</script>";
			echo "<script>window.location.replace('board.html?board=fa&no=$board');</script>";
		}else{
			echo "<script>alert('내용이 필요합니다');</script>";
			echo "<script>history.back();</script>";	
		}
	}else{
		echo "<script>alert('로그인이 필요한 기능입니다');";
		echo "window.location.replace('user.html?user=login');</script>";
	}
}else if($kind == 'recommentfa'){
	if($user_no){
		$contents = $_POST['contents'];
		$comment = $_POST['comment'];
		$board = $_POST['board'];
		if($contents){
			include "dbconn.php";
			mysqli_query($conn,"INSERT INTO board_fa_recomment (comment, user, contents) VALUES ('$comment', '$user_no', '$contents')");
			$board_activiy_result = mysqli_query($conn, "SELECT * FROM user_activity where board = '$board' AND board_table = 'board_fa'");
			$board_activiy_row = mysqli_fetch_array($board_activiy_result);
			if($board_activiy_row){
				mysqli_query($conn,"UPDATE user_activity SET count = count + 1 WHERE board = '$board' AND board_table = 'board_fa'");
			}else{
				$board_user_result = mysqli_query($conn, "SELECT * FROM board_fa where no = '$board'");
				$board_user_row = mysqli_fetch_array($board_user_result);
				$board_user_no = $board_user_row['user'];
				mysqli_query($conn,"INSERT INTO user_activity (user, board, board_table, count) VALUES ('$board_user_no', '$board', 'board_fa', '1')");
			}
			$board_activiy_result = mysqli_query($conn, "SELECT * FROM user_activity where board = '$comment' AND board_table = 'board_fa_comment'");
			$board_activiy_row = mysqli_fetch_array($board_activiy_result);
			if($board_activiy_row){
				mysqli_query($conn,"UPDATE user_activity SET count = count + 1 WHERE board = '$comment' AND board_table = 'board_fa_comment'");
			}else{
				$board_user_result = mysqli_query($conn, "SELECT * FROM board_fa_comment where no = '$comment'");
				$board_user_row = mysqli_fetch_array($board_user_result);
				$board_user_no = $board_user_row['user'];
				mysqli_query($conn,"INSERT INTO user_activity (user, board, board_table, count) VALUES ('$board_user_no', '$comment', 'board_fa_comment', '1')");
			}
			mysqli_close($conn);
			echo "<script>alert('등록 되었습니다.');</script>";
			echo "<script>window.location.replace('board.html?board=fa&no=$board');</script>";
		}else{
			echo "<script>alert('내용이 필요합니다');</script>";
			echo "<script>history.back();</script>";	
		}
	}else{
		echo "<script>alert('로그인이 필요한 기능입니다');";
		echo "window.location.replace('user.html?user=login');</script>";
	}
}else if($kind =='team'){
	if($user_no){
		include "dbconn.php";
		$team_no = $_POST['team_no'];
		$player_no = $_SESSION['player_no'];
		$member_check_result = mysqli_query($conn,"SELECT * FROM team_members where player='$player_no' AND team='$team_no' AND states='1'");
		$member_check_row = mysqli_fetch_array($member_check_result);
		if($member_check_row){
			$title = $_POST['title'];
			$contents = $_POST['freeinsert'];
			$tag = $_POST['tag'];
			$notice = $_POST['notice'];
			if($title != null && $contents != null){
				if($_FILES['img']['name'] != null){
					$_FILES['img']['name'] = date("YmdHis").'_'.$name.'_'.$_FILES['img']['name'];
					$img = $_FILES['img']['name'];
					$target = 'images/board/'.$img;
					$tmp_name = $_FILES['img']['tmp_name'];
					move_uploaded_file($tmp_name, $target);
				}
				mysqli_query($conn,"INSERT INTO board_team (team, user, title, contents, img, tag, notice) VALUES ('$team_no', '$user_no', '$title', '$contents', '$target', '$tag', '$notice')");
				$view_result = mysqli_query($conn, "SELECT MAX(no) as maxno FROM board_team WHERE title LIKE '%$title%'");
				$view_row = mysqli_fetch_array($view_result);
				$board_no = $view_row['maxno'];
				mysqli_query($conn,"INSERT INTO board_team_view (board) VALUES ('$board_no')");
				mysqli_close($conn);
				echo "<script>alert('등록 되었습니다.');</script>";
				echo "<script>window.location.replace('team.html?team=page&no=$team_no&page=free');</script>";
			}else{
					mysqli_close($conn);
					echo "<script>alert('제목과 내용이 필요합니다');</script>";
					echo "<script>history.back();</script>";		
			}
		}else{
			mysqli_close($conn);
			echo "<script>alert('팀원만 가능한 기능입니다');";
			echo "window.location.replace('team.html?team=page&no=$team_no&page=manage');</script>";
		}
	}else{
		echo "<script>alert('로그인이 필요한 기능입니다');";
		echo "window.location.replace('user.html?user=login');</script>";
	}
}else if($kind == 'commentteam'){
	if($user_no){
		include "dbconn.php";
		$contents = $_POST['contents'];
		$board = $_POST['board'];
		$player_no = $_SESSION['player_no'];
		$board_result = mysqli_query($conn,"SELECT * FROM board_team where no='$board'");
		$board_row = mysqli_fetch_array($board_result);
		$team_no = $board_row['team'];
		$player_no = $_SESSION['player_no'];
		$member_check_result = mysqli_query($conn,"SELECT * FROM team_members where player='$player_no' AND team='$team_no' AND states='1'");
		$member_check_row = mysqli_fetch_array($member_check_result);
		if($member_check_row){
			if($contents){
				mysqli_query($conn,"INSERT INTO board_team_comment (board, user, contents) VALUES ('$board', '$user_no', '$contents')");
				$board_activiy_result = mysqli_query($conn, "SELECT * FROM user_activity where board = '$board' AND board_table = 'board_team'");
				$board_activiy_row = mysqli_fetch_array($board_activiy_result);
				if($board_activiy_row){
					mysqli_query($conn,"UPDATE user_activity SET count = count + 1 WHERE board = '$board' AND board_table = 'board_team'");
				}else{
					$board_user_result = mysqli_query($conn, "SELECT * FROM board_team where no = '$board'");
					$board_user_row = mysqli_fetch_array($board_user_result);
					$board_user_no = $board_user_row['user'];
					mysqli_query($conn,"INSERT INTO user_activity (user, board, board_table, count) VALUES ('$board_user_no', '$board', 'board_team', '1')");
				}
				mysqli_close($conn);
				echo "<script>alert('등록 되었습니다.');</script>";
				echo "<script>window.location.replace('team.html?team=page&no=$team_no&page=free&read=$board');</script>";
			}else{
				mysqli_close($conn);
				echo "<script>alert('내용이 필요합니다');</script>";
				echo "<script>history.back();</script>";	
			}
		}else{
			mysqli_close($conn);
			echo "<script>alert('팀원만 가능한 기능입니다');";
			echo "window.location.replace('team.html?team=page&no=$team_no&page=manage');</script>";
		}
	}else{
		echo "<script>alert('로그인이 필요한 기능입니다');";
		echo "window.location.replace('user.html?user=login');</script>";
	}
}else if($kind == 'recommentteam'){
	if($user_no){
		include "dbconn.php";
		$contents = $_POST['contents'];
		$comment = $_POST['comment'];
		$board = $_POST['board'];
		$player_no = $_SESSION['player_no'];
		$board_result = mysqli_query($conn,"SELECT * FROM board_team where no='$board'");
		$board_row = mysqli_fetch_array($board_result);
		$team_no = $board_row['team'];
		$player_no = $_SESSION['player_no'];
		$member_check_result = mysqli_query($conn,"SELECT * FROM team_members where player='$player_no' AND team='$team_no' AND states='1'");
		$member_check_row = mysqli_fetch_array($member_check_result);
		if($member_check_row){
			if($contents){
				mysqli_query($conn,"INSERT INTO board_team_recomment (comment, user, contents) VALUES ('$comment', '$user_no', '$contents')");
				$board_activiy_result = mysqli_query($conn, "SELECT * FROM user_activity where board = '$board' AND board_table = 'board_team'");
				$board_activiy_row = mysqli_fetch_array($board_activiy_result);
				if($board_activiy_row){
					mysqli_query($conn,"UPDATE user_activity SET count = count + 1 WHERE board = '$board' AND board_table = 'board_team'");
				}else{
					$board_user_result = mysqli_query($conn, "SELECT * FROM board_team where no = '$board'");
					$board_user_row = mysqli_fetch_array($board_user_result);
					$board_user_no = $board_user_row['user'];
					mysqli_query($conn,"INSERT INTO user_activity (user, board, board_table, count) VALUES ('$board_user_no', '$board', 'board_team', '1')");
				}
				$board_activiy_result = mysqli_query($conn, "SELECT * FROM user_activity where board = '$comment' AND board_table = 'board_team_comment'");
				$board_activiy_row = mysqli_fetch_array($board_activiy_result);
				if($board_activiy_row){
					mysqli_query($conn,"UPDATE user_activity SET count = count + 1 WHERE board = '$comment' AND board_table = 'board_team_comment'");
				}else{
					$board_user_result = mysqli_query($conn, "SELECT * FROM board_team_comment where no = '$comment'");
					$board_user_row = mysqli_fetch_array($board_user_result);
					$board_user_no = $board_user_row['user'];
					mysqli_query($conn,"INSERT INTO user_activity (user, board, board_table, count) VALUES ('$board_user_no', '$comment', 'board_team_comment', '1')");
				}
				mysqli_close($conn);
				echo "<script>alert('등록 되었습니다.');</script>";
				echo "<script>window.location.replace('team.html?team=page&no=$team_no&page=free&read=$board');</script>";
			}else{
				mysqli_close($conn);
				echo "<script>alert('내용이 필요합니다');</script>";
				echo "<script>history.back();</script>";	
			}
		}else{
			mysqli_close($conn);
			echo "<script>alert('팀원만 가능한 기능입니다');";
			echo "window.location.replace('team.html?team=page&no=$team_no&page=manage');</script>";
		}
	}else{
		echo "<script>alert('로그인이 필요한 기능입니다');";
		echo "window.location.replace('user.html?user=login');</script>";
	}
}else if($kind =='league'){
	if($user_no){
		include "dbconn.php";
		$league_no = $_POST['league_no'];
		$title = $_POST['title'];
		$contents = $_POST['freeinsert'];
		$tag = $_POST['tag'];
		$notice = $_POST['notice'];
		if($title != null && $contents != null){
			if($_FILES['img']['name'] != null){
				$_FILES['img']['name'] = date("YmdHis").'_'.$name.'_'.$_FILES['img']['name'];
				$img = $_FILES['img']['name'];
				$target = 'images/board/'.$img;
				$tmp_name = $_FILES['img']['tmp_name'];
				move_uploaded_file($tmp_name, $target);
			}
			mysqli_query($conn,"INSERT INTO board_league (league, user, title, contents, img, tag, notice) VALUES ('$league_no', '$user_no', '$title', '$contents', '$target', '$tag', '$notice')");
			$view_result = mysqli_query($conn, "SELECT MAX(no) as maxno FROM board_league WHERE title LIKE '%$title%'");
			$view_row = mysqli_fetch_array($view_result);
			$board_no = $view_row['maxno'];
			mysqli_query($conn,"INSERT INTO board_league_view (board) VALUES ('$board_no')");
			mysqli_close($conn);
			echo "<script>alert('등록 되었습니다.');</script>";
			echo "<script>window.location.replace('league.html?league=page&no=$league_no&page=free');</script>";
		}else{
			mysqli_close($conn);
			echo "<script>alert('제목과 내용이 필요합니다');</script>";
			echo "<script>history.back();</script>";		
		}
	}else{
		echo "<script>alert('로그인이 필요한 기능입니다');";
		echo "window.location.replace('user.html?user=login');</script>";
	}
}else if($kind == 'commentleague'){
	if($user_no){
		include "dbconn.php";
		$contents = $_POST['contents'];
		$board = $_POST['board'];
		$board_result = mysqli_query($conn,"SELECT * FROM board_league where no='$board'");
		$board_row = mysqli_fetch_array($board_result);
		$league_no = $board_row['league'];
		if($contents){
			mysqli_query($conn,"INSERT INTO board_league_comment (board, user, contents) VALUES ('$board', '$user_no', '$contents')");
			$board_activiy_result = mysqli_query($conn, "SELECT * FROM user_activity where board = '$board' AND board_table = 'board_league'");
			$board_activiy_row = mysqli_fetch_array($board_activiy_result);
			if($board_activiy_row){
				mysqli_query($conn,"UPDATE user_activity SET count = count + 1 WHERE board = '$board' AND board_table = 'board_league'");
			}else{
				$board_user_result = mysqli_query($conn, "SELECT * FROM board_league where no = '$board'");
				$board_user_row = mysqli_fetch_array($board_user_result);
				$board_user_no = $board_user_row['user'];
				mysqli_query($conn,"INSERT INTO user_activity (user, board, board_table, count) VALUES ('$board_user_no', '$board', 'board_league', '1')");
			}
			mysqli_close($conn);
			echo "<script>alert('등록 되었습니다.');</script>";
			echo "<script>window.location.replace('league.html?league=page&no=$league_no&page=free&read=$board');</script>";
		}else{
			mysqli_close($conn);
			echo "<script>alert('내용이 필요합니다');</script>";
			echo "<script>history.back();</script>";	
		}
	}else{
		echo "<script>alert('로그인이 필요한 기능입니다');";
		echo "window.location.replace('user.html?user=login');</script>";
	}
}else if($kind == 'recommentleague'){
	if($user_no){
		include "dbconn.php";
		$contents = $_POST['contents'];
		$comment = $_POST['comment'];
		$board = $_POST['board'];
		$board_result = mysqli_query($conn,"SELECT * FROM board_league where no='$board'");
		$board_row = mysqli_fetch_array($board_result);
		$league_no = $board_row['league'];
		if($contents){
			mysqli_query($conn,"INSERT INTO board_league_recomment (comment, user, contents) VALUES ('$comment', '$user_no', '$contents')");
			$board_activiy_result = mysqli_query($conn, "SELECT * FROM user_activity where board = '$board' AND board_table = 'board_league'");
			$board_activiy_row = mysqli_fetch_array($board_activiy_result);
			if($board_activiy_row){
				mysqli_query($conn,"UPDATE user_activity SET count = count + 1 WHERE board = '$board' AND board_table = 'board_league'");
			}else{
				$board_user_result = mysqli_query($conn, "SELECT * FROM board_league where no = '$board'");
				$board_user_row = mysqli_fetch_array($board_user_result);
				$board_user_no = $board_user_row['user'];
				mysqli_query($conn,"INSERT INTO user_activity (user, board, board_table, count) VALUES ('$board_user_no', '$board', 'board_league', '1')");
			}
			$board_activiy_result = mysqli_query($conn, "SELECT * FROM user_activity where board = '$comment' AND board_table = 'board_league_comment'");
			$board_activiy_row = mysqli_fetch_array($board_activiy_result);
			if($board_activiy_row){
				mysqli_query($conn,"UPDATE user_activity SET count = count + 1 WHERE board = '$comment' AND board_table = 'board_league_comment'");
			}else{
				$board_user_result = mysqli_query($conn, "SELECT * FROM board_league_comment where no = '$comment'");
				$board_user_row = mysqli_fetch_array($board_user_result);
				$board_user_no = $board_user_row['user'];
				mysqli_query($conn,"INSERT INTO user_activity (user, board, board_table, count) VALUES ('$board_user_no', '$comment', 'board_league_comment', '1')");
			}
			mysqli_close($conn);
			echo "<script>alert('등록 되었습니다.');</script>";
			echo "<script>window.location.replace('league.html?league=page&no=$league_no&page=free&read=$board');</script>";
		}else{
			mysqli_close($conn);
			echo "<script>alert('내용이 필요합니다');</script>";
			echo "<script>history.back();</script>";	
		}
	}else{
		echo "<script>alert('로그인이 필요한 기능입니다');";
		echo "window.location.replace('user.html?user=login');</script>";
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
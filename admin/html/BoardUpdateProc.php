<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php

session_start();
$user_no = $_SESSION['user_no'];
$kind = $_POST['kind'];
$no = $_POST['no'];
if($kind == 'free'){
	$title = $_POST['title'];
	$contents = $_POST['contents'];
	$tag = $_POST['tag'];
	if($title != null && $contents != null && $user_no != null){
		include "dbconn.php";
		$writer_result = mysqli_query($conn,"SELECT * FROM board_free WHERE no ='$no'");
		$writer_row = mysqli_fetch_array($writer_result);
		if($user_no == $writer_row['user']){
			if($_FILES['img']['tmp_name']){
				if($writer_row['img']){
					if($writer_row['img']){ unlink($writer_row['img']); }
				}
				$_FILES['img']['name'] = date("YmdHis").'_'.$name.'_'.$_FILES['img']['name'];
				$img = $_FILES['img']['name'];
				$target = 'images/board/'.$img;
				$tmp_name = $_FILES['img']['tmp_name'];
				move_uploaded_file($tmp_name, $target);
				mysqli_query($conn,"UPDATE board_free SET img = '$target' WHERE no = '$no'");
			}
			mysqli_query($conn,"UPDATE board_free SET  title = '$title', contents = '$contents', tag = '$tag' WHERE no = '$no'");
			mysqli_close($conn);
			echo "<script>alert('수정 되었습니다.');</script>";
			echo "<script>window.location.replace('board.html?board=free&no=$no');</script>";
		}else{
			mysqli_close($conn);
			echo "<script>alert('잘못된 접근입니다.');</script>";
			echo "<script>window.location.replace('index.html');</script>";	
		}
	}else{
		mysqli_close($conn);
		echo "<script>alert('제목과 내용이 필요합니다');</script>";
		echo "<script>history.back();</script>";		
	}
}else if($kind == 'commentfree'){
	$contents = $_POST['contents'];
	include "dbconn.php";
	$writer_result = mysqli_query($conn,"SELECT * FROM board_free_comment WHERE no ='$no'");
	$writer_row = mysqli_fetch_array($writer_result);
	if($contents != null && $user_no == $writer_row['user']){
		mysqli_query($conn,"UPDATE board_free_comment SET contents = '$contents' WHERE no = '$no'");
		mysqli_close($conn);
		$board = $writer_row['board'];
		echo "<script>alert('수정 되었습니다.');</script>";
		echo "<script>window.location.replace('board.html?board=free&no=$board');</script>";
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
}else if($kind == 'recommentfree'){
	$contents = $_POST['contents'];
	include "dbconn.php";
	$writer_result = mysqli_query($conn,"SELECT * FROM board_free_recomment WHERE no ='$no'");
	$writer_row = mysqli_fetch_array($writer_result);
	$comment_no = $writer_row['comment'];
	if($contents != null && $user_no == $writer_row['user']){
		mysqli_query($conn,"UPDATE board_free_recomment SET contents = '$contents' WHERE no = '$no'");
		$comment_result = mysqli_query($conn,"SELECT * FROM board_free_comment WHERE no ='$comment_no'");
		$comment_row = mysqli_fetch_array($comment_result);
		$board = $comment_row['board'];
		mysqli_close($conn);
		echo "<script>alert('수정 되었습니다.');</script>";
		echo "<script>window.location.replace('board.html?board=free&no=$board');</script>";
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
}else if($kind == 'fa'){
	if($user_no){
		$title = $_POST['title'];
		$contents = $_POST['contents'];
		$adrs = $_POST['adrs'];
		include "dbconn.php";
		$writer_result = mysqli_query($conn,"SELECT * FROM board_fa WHERE no ='$no'");
		$writer_row = mysqli_fetch_array($writer_result);
		mysqli_close($conn);
		if($user_no == $writer_row['user']){
			if($_POST['position']){
				$position = implode("|", $_POST['position']);
			}
			if($_FILES['img']['tmp_name']){
				if($writer_row['img']){
					if($writer_row['img']){ unlink($writer_row['img']); }
				}
				$_FILES['img']['name'] = date("YmdHis").'_'.$name.'_'.$_FILES['img']['name'];
				$img = $_FILES['img']['name'];
				$target = 'images/board/'.$img;
				$tmp_name = $_FILES['img']['tmp_name'];
				move_uploaded_file($tmp_name, $target);
				mysqli_query($conn,"UPDATE board_fa SET img = '$target' WHERE no = '$no'");
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
				mysqli_query($conn,"UPDATE board_fa SET title = '$title', position = '$position', adrs = '$adrs', contents = '$contents', age = '$age' WHERE no = '$no'");
				mysqli_close($conn);
				echo "<script>alert('수정 되었습니다.');</script>";
				echo "<script>window.location.replace('board.html?board=fa');</script>";
			}else{
				echo "<script>alert('포지션과 지역이 필요합니다');</script>";
				echo "<script>history.back();</script>";
			}
		}else{
			echo "<script>alert('잘못된 접근입니다.');</script>";
			echo "<script>window.location.replace('index.html');</script>";	
		}
	}else{
		echo "<script>alert('로그인이 필요한 기능입니다');";
		echo "window.location.replace('user.html?user=login');</script>";
	}	
}else if($kind == 'commentfa'){
	if($user_no){
		$contents = $_POST['contents'];
		include "dbconn.php";
		$writer_result = mysqli_query($conn,"SELECT * FROM board_fa_comment WHERE no ='$no'");
		$writer_row = mysqli_fetch_array($writer_result);
		mysqli_close($conn);
		if($user_no == $writer_row['user']){
			if($contents){
				include "dbconn.php";
				mysqli_query($conn,"UPDATE board_fa_comment SET contents = '$contents' WHERE no = '$no'");
				mysqli_close($conn);
				$board = $writer_row['board'];
				echo "<script>alert('수정 되었습니다.');</script>";
				echo "<script>window.location.replace('board.html?board=fa&no=$board');</script>";
			}else{
				echo "<script>alert('내용이 필요합니다');</script>";
				echo "<script>history.back();</script>";	
			}
		}else{
			echo "<script>alert('잘못된 접근입니다.');</script>";
			echo "<script>window.location.replace('index.html');</script>";		
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
		include "dbconn.php";
		$writer_result = mysqli_query($conn,"SELECT * FROM board_fa_recomment WHERE no ='$no'");
		$writer_row = mysqli_fetch_array($writer_result);
		mysqli_close($conn);
		if($user_no == $writer_row['user']){
			if($contents){
				include "dbconn.php";
				mysqli_query($conn,"UPDATE board_fa_recomment SET contents = '$contents' WHERE no = '$no'");
				$comment_no = $writer_row['comment'];
				$comment_result = mysqli_query($conn,"SELECT * FROM board_fa_comment WHERE no ='$comment_no'");
				$comment_row = mysqli_fetch_array($comment_result);
				$board = $comment_row['board'];
				mysqli_close($conn);
				echo "<script>alert('수정 되었습니다.');</script>";
				echo "<script>window.location.replace('board.html?board=fa&no=$board');</script>";
			}else{
				echo "<script>alert('내용이 필요합니다');</script>";
				echo "<script>history.back();</script>";	
			}
		}else{
			echo "<script>alert('잘못된 접근입니다.');</script>";
			echo "<script>window.location.replace('index.html');</script>";				
		}
	}else{
		echo "<script>alert('로그인이 필요한 기능입니다');";
		echo "window.location.replace('user.html?user=login');</script>";
	}
}else if($kind == 'team'){
	$title = $_POST['title'];
	$contents = $_POST['freeedit'];
	$tag = $_POST['tag'];
	if($title != null && $contents != null && $user_no != null){
		include "dbconn.php";
		$writer_result = mysqli_query($conn,"SELECT * FROM board_team WHERE no ='$no'");
		$writer_row = mysqli_fetch_array($writer_result);
		$team_no = $writer_row['team'];
		if($user_no == $writer_row['user']){
			if($_FILES['img']['tmp_name']){
				if($writer_row['img']){
					if($writer_row['img']){ unlink($writer_row['img']); }
				}
				$_FILES['img']['name'] = date("YmdHis").'_'.$name.'_'.$_FILES['img']['name'];
				$img = $_FILES['img']['name'];
				$target = 'images/board/'.$img;
				$tmp_name = $_FILES['img']['tmp_name'];
				move_uploaded_file($tmp_name, $target);
				mysqli_query($conn,"UPDATE board_team SET img = '$target' WHERE no = '$no'");
			}
			mysqli_query($conn,"UPDATE board_team SET  title = '$title', contents = '$contents', tag = '$tag' WHERE no = '$no'");
			mysqli_close($conn);
			echo "<script>alert('수정 되었습니다.');</script>";
			echo "<script>window.location.replace('team.html?team=page&no=$team_no&page=free&read=$no');</script>";
		}else{
			mysqli_close($conn);
			echo "<script>alert('잘못된 접근입니다.');</script>";
			echo "<script>window.location.replace('index.html');</script>";	
		}
	}else{
		mysqli_close($conn);
		echo "<script>alert('제목과 내용이 필요합니다');</script>";
		echo "<script>history.back();</script>";		
	}
}else if($kind == 'commentteam'){
	if($user_no){
		$contents = $_POST['contents'];
		include "dbconn.php";
		$writer_result = mysqli_query($conn,"SELECT * FROM board_team_comment WHERE no ='$no'");
		$writer_row = mysqli_fetch_array($writer_result);
		$board = $writer_row['board'];
		$board_result = mysqli_query($conn,"SELECT * FROM board_team where no='$board'");
		$board_row = mysqli_fetch_array($board_result);
		$team_no = $board_row['team'];
		mysqli_close($conn);
		if($user_no == $writer_row['user']){
			if($contents){
				include "dbconn.php";
				mysqli_query($conn,"UPDATE board_team_comment SET contents = '$contents' WHERE no = '$no'");
				mysqli_close($conn);
				$board = $writer_row['board'];
				echo "<script>alert('수정 되었습니다.');</script>";
				echo "<script>window.location.replace('team.html?team=page&no=$team_no&page=free&read=$board');</script>";
			}else{
				echo "<script>alert('내용이 필요합니다');</script>";
				echo "<script>history.back();</script>";	
			}
		}else{
			echo "<script>alert('잘못된 접근입니다.');</script>";
			echo "<script>window.location.replace('index.html');</script>";		
		}
	}else{
		echo "<script>alert('로그인이 필요한 기능입니다');";
		echo "window.location.replace('user.html?user=login');</script>";
	}
}else if($kind == 'recommentteam'){
	if($user_no){
		$contents = $_POST['contents'];
		include "dbconn.php";
		$writer_result = mysqli_query($conn,"SELECT * FROM board_team_recomment WHERE no ='$no'");
		$writer_row = mysqli_fetch_array($writer_result);
		mysqli_close($conn);
		if($user_no == $writer_row['user']){
			if($contents){
				include "dbconn.php";
				mysqli_query($conn,"UPDATE board_team_recomment SET contents = '$contents' WHERE no = '$no'");
				$comment_no = $writer_row['comment'];
				$comment_result = mysqli_query($conn,"SELECT * FROM board_team_comment WHERE no ='$comment_no'");
				$comment_row = mysqli_fetch_array($comment_result);
				$board = $comment_row['board'];
				$board_result = mysqli_query($conn,"SELECT * FROM board_team where no='$board'");
				$board_row = mysqli_fetch_array($board_result);
				$team_no = $board_row['team'];
				mysqli_close($conn);
				echo "<script>alert('수정 되었습니다.');</script>";
				echo "<script>window.location.replace('team.html?team=page&no=$team_no&page=free&read=$board');</script>";
			}else{
				echo "<script>alert('내용이 필요합니다');</script>";
				echo "<script>history.back();</script>";	
			}
		}else{
			echo "<script>alert('잘못된 접근입니다.');</script>";
			echo "<script>window.location.replace('index.html');</script>";				
		}
	}else{
		echo "<script>alert('로그인이 필요한 기능입니다');";
		echo "window.location.replace('user.html?user=login');</script>";
	}
}else if($kind == 'league'){
	$title = $_POST['title'];
	$contents = $_POST['freeedit'];
	$tag = $_POST['tag'];
	if($title != null && $contents != null && $user_no != null){
		include "dbconn.php";
		$writer_result = mysqli_query($conn,"SELECT * FROM board_league WHERE no ='$no'");
		$writer_row = mysqli_fetch_array($writer_result);
		$league_no = $writer_row['league'];
		if($user_no == $writer_row['user']){
			if($_FILES['img']['tmp_name']){
				if($writer_row['img']){
					if($writer_row['img']){ unlink($writer_row['img']); }
				}
				$_FILES['img']['name'] = date("YmdHis").'_'.$name.'_'.$_FILES['img']['name'];
				$img = $_FILES['img']['name'];
				$target = 'images/board/'.$img;
				$tmp_name = $_FILES['img']['tmp_name'];
				move_uploaded_file($tmp_name, $target);
				mysqli_query($conn,"UPDATE board_league SET img = '$target' WHERE no = '$no'");
			}
			mysqli_query($conn,"UPDATE board_league SET  title = '$title', contents = '$contents', tag = '$tag' WHERE no = '$no'");
			mysqli_close($conn);
			echo "<script>alert('수정 되었습니다.');</script>";
			echo "<script>window.location.replace('league.html?league=page&no=$league_no&page=free&read=$no');</script>";
		}else{
			mysqli_close($conn);
			echo "<script>alert('잘못된 접근입니다.');</script>";
			echo "<script>window.location.replace('index.html');</script>";	
		}
	}else{
		mysqli_close($conn);
		echo "<script>alert('제목과 내용이 필요합니다');</script>";
		echo "<script>history.back();</script>";		
	}
}else if($kind == 'commentleague'){
	if($user_no){
		$contents = $_POST['contents'];
		include "dbconn.php";
		$writer_result = mysqli_query($conn,"SELECT * FROM board_league_comment WHERE no ='$no'");
		$writer_row = mysqli_fetch_array($writer_result);
		$board = $writer_row['board'];
		$board_result = mysqli_query($conn,"SELECT * FROM board_league where no='$board'");
		$board_row = mysqli_fetch_array($board_result);
		$league_no = $board_row['league'];
		mysqli_close($conn);
		if($user_no == $writer_row['user']){
			if($contents){
				include "dbconn.php";
				mysqli_query($conn,"UPDATE board_league_comment SET contents = '$contents' WHERE no = '$no'");
				mysqli_close($conn);
				$board = $writer_row['board'];
				echo "<script>alert('수정 되었습니다.');</script>";
				echo "<script>window.location.replace('league.html?league=page&no=$league_no&page=free&read=$board');</script>";
			}else{
				echo "<script>alert('내용이 필요합니다');</script>";
				echo "<script>history.back();</script>";	
			}
		}else{
			echo "<script>alert('잘못된 접근입니다.');</script>";
			echo "<script>window.location.replace('index.html');</script>";		
		}
	}else{
		echo "<script>alert('로그인이 필요한 기능입니다');";
		echo "window.location.replace('user.html?user=login');</script>";
	}
}else if($kind == 'recommentleague'){
	if($user_no){
		$contents = $_POST['contents'];
		include "dbconn.php";
		$writer_result = mysqli_query($conn,"SELECT * FROM board_league_recomment WHERE no ='$no'");
		$writer_row = mysqli_fetch_array($writer_result);
		mysqli_close($conn);
		if($user_no == $writer_row['user']){
			if($contents){
				include "dbconn.php";
				mysqli_query($conn,"UPDATE board_league_recomment SET contents = '$contents' WHERE no = '$no'");
				$comment_no = $writer_row['comment'];
				$comment_result = mysqli_query($conn,"SELECT * FROM board_league_comment WHERE no ='$comment_no'");
				$comment_row = mysqli_fetch_array($comment_result);
				$board = $comment_row['board'];
				$board_result = mysqli_query($conn,"SELECT * FROM board_league where no='$board'");
				$board_row = mysqli_fetch_array($board_result);
				$league_no = $board_row['league'];
				mysqli_close($conn);
				echo "<script>alert('수정 되었습니다.');</script>";
				echo "<script>window.location.replace('league.html?league=page&no=$league_no&page=free&read=$board');</script>";
			}else{
				echo "<script>alert('내용이 필요합니다');</script>";
				echo "<script>history.back();</script>";	
			}
		}else{
			echo "<script>alert('잘못된 접근입니다.');</script>";
			echo "<script>window.location.replace('index.html');</script>";				
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
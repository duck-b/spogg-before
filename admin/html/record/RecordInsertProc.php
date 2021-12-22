<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	$pos = $_POST['pos'];
	$analy_no = $_POST['analy_no'];
	include "dbconn.php";
	session_start();
	if($_POST['pos'] == 'hit'){
		$team_name = $_POST['team_name'];
		$league_name = $_POST['league_name'];
		$at_game = $_POST['at_game'];
		$at_play = $_POST['at_play'];
		$at_bat = $_POST['at_bat'];
		$player_no = $_SESSION['player_no'];
		$hit1 = $_POST['hit'] - $_POST['hit2'] - $_POST['hit3'] - $_POST['hr'];
		$hit2 = $_POST['hit2'];
		$hit3 = $_POST['hit3'];
		$hr = $_POST['hr'];
		$rs = $_POST['rs'];
		$rbi = $_POST['rbi'];
		$sb=$_POST['sb'];
		$so=$_POST['so'];
		$sh=$_POST['sh'];
		$sf=$_POST['sf'];
		$b4 = $_POST['b4'] - $_POST['hbp'];
		$hbp = $_POST['hbp'];
		if($hit1 < 0){
			$hit1 = "";
		}
		if($b4 < 0){
			$b4 = "";
		}
		mysqli_query($conn,"INSERT INTO data_before_hit (player_no ,team_name, league_name, at_game, at_play, at_bat, hit1, hit2, hit3, hr, rs, rbi, sb, so, sh, sf, b4, hbp) VALUES ('$player_no', '$team_name', '$league_name', '$at_game', '$at_play', '$at_bat', '$hit1', '$hit2', '$hit3', '$hr', '$rs', '$rbi', '$sb', '$so', '$sh', '$sf', '$b4', '$hbp')");
		$record_result = mysqli_query($conn, "SELECT MAX(no) as maxno FROM data_before_hit WHERE player_no = '$player_no'");
		$record_row = mysqli_fetch_array($record_result);
		$no = $record_row['maxno'];
		mysqli_close($conn);
		echo "<script>alert('입력이 완료 되었습니다.');</script>";
		echo "<script>window.location.replace('analy.html?analy_no=".$analy_no."&no=".$no."');</script>";
	}else if($_POST['pos'] == 'pic'){
		$team_name = $_POST['team_name'];
		$league_name = $_POST['league_name'];
		$at_game = $_POST['at_game'];
		if($_POST['inning']){
			$inning = $_POST['inning']*3 + $_POST['inning_2'];
		}else{
			$inning = "";
		}
		$player_no = $_SESSION['player_no'];
		$play_win = $_POST['play_win'];
		$play_lose = $_POST['play_lose'];
		$play_save = $_POST['play_save'];
		$play_hold = $_POST['play_hold'];
		$pitcher_count = $_POST['pitcher_count'];
		$hit1 = $_POST['hit'] - $_POST['hit2'] - $_POST['hit3'] - $_POST['hr'];
		$hit2 = $_POST['hit2'];
		$hit3 = $_POST['hit3'];
		$hr = $_POST['hr'];
		$er = $_POST['er'];
		$so = $_POST['so'];
		$sh = $_POST['sh'];
		$sf = $_POST['sf'];
		$b4 = $_POST['b4'] - $_POST['hbp'];
		$hbp = $_POST['hbp'];
		$at_play = $_POST['at_play'];
		$at_bat = $_POST['at_play'] - $_POST['b4'] - $_POST['hbp'] - $_POST['sh'] - $_POST['sf'];
		if($hit1 < 0){
			$hit1 = "";
		}
		if($b4 < 0){
			$b4 = "";
		}
		if($at_bat < 0){
			$at_bat = "";
		}
		mysqli_query($conn,"INSERT INTO data_before_pic (player_no, team_name, league_name, at_game, inning, play_win, play_lose, play_save, play_hold, pitcher_count, so, hit1, hit2, hit3, hr, er, b4, hbp, at_play, at_bat, sh, sf) VALUES ('$player_no', '$team_name', '$league_name', '$at_game', '$inning', '$play_win', '$play_lose', '$play_save', '$play_hold', '$pitcher_count', '$so', '$hit1', '$hit2', '$hit3', '$hr', '$er', '$b4', '$hbp', '$at_play', '$at_bat', '$sh', '$sf')");
		$record_result = mysqli_query($conn, "SELECT MAX(no) as maxno FROM data_before_pic WHERE player_no = '$player_no'");
		$record_row = mysqli_fetch_array($record_result);
		$no = $record_row['maxno'];
		mysqli_close($conn);
		echo "<script>alert('입력이 완료 되었습니다.');</script>";
		echo "<script>window.location.replace('analy.html?analy_no=".$analy_no."&no=".$no."');</script>";
	}
	mysqli_close($conn);
?>
</html>
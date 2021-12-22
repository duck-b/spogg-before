<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include "dbconn.php";
$pos = $_POST['pos'];
$no = $_POST['no'];
if($_POST['pos'] == 'hit'){
	$record_result = mysqli_query($conn, "SELECT * FROM data_before_hit WHERE no = '$no'");
	$record_row = mysqli_fetch_array($record_result);
	$player_no = $record_row['player_no'];
}else if($_POST['pos'] == 'pic'){
	$record_result = mysqli_query($conn, "SELECT * FROM data_before_pic WHERE no = '$no'");
	$record_row = mysqli_fetch_array($record_result);
	$player_no = $record_row['player_no'];
}
session_start();
if($_SESSION['player_no'] != $player_no){
	echo "<script>alert('잘못된 접근입니다.');";
	echo "history.back()</script>";
}else{
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
		mysqli_query($conn,"UPDATE data_before_hit SET player_no = '$player_no', team_name = '$team_name', league_name = '$league_name', at_game = '$at_game', at_play = '$at_play', at_bat = '$at_bat', hit1 = '$hit1', hit2 = '$hit2', hit3 = '$hit3', hr = '$hr', rs = '$rs', rbi = '$rbi', sb = '$sb', so = '$so', sh = '$sh', sf = '$sf', b4 = '$b4', hbp = '$hbp' WHERE no = '$no'");
		echo "<script>alert('수정이 완료 되었습니다.');</script>";
		echo "<script>window.location.replace('data.html');</script>";
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
		mysqli_query($conn,"UPDATE data_before_pic SET player_no = '$player_no', team_name = '$team_name', league_name = '$league_name', at_game = '$at_game', inning = '$inning', play_win = '$play_win', play_lose = '$play_lose', play_save = '$play_save', play_hold = '$play_hold', pitcher_count = '$pitcher_count', so = '$so', hit1 = '$hit1', hit2 = '$hit2', hit3 = '$hit3', hr = '$hr', er = '$er', b4 = '$b4', hbp = '$hbp', at_play = '$at_play', at_bat = '$at_bat', sh = '$sh', sf = '$sf' WHERE no = '$no'");
		echo "<script>alert('수정이 완료 되었습니다.');</script>";
		echo "<script>window.location.replace('data.html');</script>";
	}
}
mysqli_close($conn);
?>
</html>
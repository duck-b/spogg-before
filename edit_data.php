<?
session_start();
$no = $_POST['no'];
$player = $_SESSION['player_no'];
if($_POST['position'] == '0'){
	include "dbconn.php";
	$result = mysqli_query($conn,"SELECT * FROM none_record_hit WHERE player='$player' AND no='$no'");
	$row = mysqli_fetch_array($result);
	mysqli_close($conn);
	if($row){
		echo str_replace('9999','',$row['years']."|".$row['league_name']."|".$row['team_name']."|".$row['at_game']."|".$row['at_play']."|".$row['at_bat']."|".$row['hit']."|".$row['hit2']."|".$row['hit3']."|".$row['hr']."|".$row['bb']."|".$row['hbp']."|".$row['rbi']."|".$row['rs']."|".$row['sb']."|".$row['so']."|".$row['sf']);
	}
}else if($_POST['position'] == '1'){
	include "dbconn.php";
	$result = mysqli_query($conn,"SELECT * FROM none_record_pit WHERE player='$player' AND no='$no'");
	$row = mysqli_fetch_array($result);
	mysqli_close($conn);
	if($row){
		$h_inning = ($row['inning'] - ($row['inning'] % 3)) / 3;;
		$f_inning = $row['inning'] % 3;
		echo str_replace('9999','',$row['years']."|".$row['league_name']."|".$row['team_name']."|".$row['at_game']."|".$row['win_games']."|".$row['lose_games']."|".$row['save_games']."|".$row['hold_games']."|".$h_inning."|".$f_inning."|".$row['pitcher_count']."|".$row['er']."|".$row['rs']."|".$row['hit']."|".$row['hr']."|".$row['so']."|".$row['bb']."|".$row['hbp']);
	}
}else if($_POST['position'] == '2'){
	include "dbconn.php";
	$result = mysqli_query($conn,"SELECT * FROM test_record_hit WHERE player='$player' AND no='$no'");
	$row = mysqli_fetch_array($result);
	mysqli_close($conn);
	if($row){
		echo str_replace('9999','',$row['game_date']."|".$row['kind']."|".$row['team_name']."|".$row['at_play']."|".$row['at_bat']."|".$row['hit']."|".$row['hit2']."|".$row['hit3']."|".$row['hr']."|".$row['bb']."|".$row['hbp']."|".$row['rbi']."|".$row['rs']."|".$row['sb']."|".$row['so']."|".$row['sf']);
	}
}else if($_POST['position'] == '3'){
	include "dbconn.php";
	$result = mysqli_query($conn,"SELECT * FROM test_record_pit WHERE player='$player' AND no='$no'");
	$row = mysqli_fetch_array($result);
	mysqli_close($conn);
	if($row){
		$h_inning = ($row['inning'] - ($row['inning'] % 3)) / 3;;
		$f_inning = $row['inning'] % 3;
		echo str_replace('9999','',$row['game_date']."|".$row['kind']."|".$row['team_name']."|".$row['game_result']."|".$h_inning."|".$f_inning."|".$row['pitcher_count']."|".$row['er']."|".$row['rs']."|".$row['hit']."|".$row['hr']."|".$row['so']."|".$row['bb']."|".$row['hbp']);
	}
}
?>
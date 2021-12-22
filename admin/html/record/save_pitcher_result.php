<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
	<script>
	history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.go(1);
	};
	</script>
</head>
<?php
include "dbconn.php";
$play_no = $_POST['play'];
$end_result = mysqli_query($conn, "SELECT COUNT(*) as count FROM play_end WHERE no = '$play_no'");
$end_row = mysqli_fetch_array($end_result);
if($end_row['count'] == 0 && $play_no != null){
if($_POST['pitcher_win']){
	$pitcher_win = $_POST['pitcher_win'];
	mysqli_query($conn,"INSERT INTO play_result_picr (play_result_pic, pic_result) VALUES ('$pitcher_win', '1')");
}
if($_POST['pitcher_lose']){
	$pitcher_lose = $_POST['pitcher_lose'];
	mysqli_query($conn,"INSERT INTO play_result_picr (play_result_pic, pic_result) VALUES ('$pitcher_lose', '2')");
}
if($_POST['pitcher_save']){
	$pitcher_save = $_POST['pitcher_save'];
	mysqli_query($conn,"INSERT INTO play_result_picr (play_result_pic, pic_result) VALUES ('$pitcher_save', '3')");
}
if($_POST['pitcher_hold']){
	for($i = 0; $i < count($_POST['pitcher_hold']); $i++) {
		$pitcher_hold = $_POST['pitcher_hold'][$i];
		mysqli_query($conn,"INSERT INTO play_result_picr (play_result_pic, pic_result) VALUES ('$pitcher_hold', '4')");
	}
}
$league_result = mysqli_query($conn, "SELECT * FROM play WHERE no = '$play_no'");
$league_row = mysqli_fetch_array($league_result);
$league_no = $league_row['league'];

$play_pic_result = mysqli_query($conn, "SELECT play_result_pic.*, team_members.no as team_member FROM player JOIN team_members JOIN play_entry JOIN play_result_pic WHERE player.no = team_members.player AND team_members.no = play_entry.team_member AND play_entry.play = '$play_no' AND play_entry.no = play_result_pic.entry");
while($play_pic_row = mysqli_fetch_array($play_pic_result)){
	$play_pic_no = $play_pic_row['no'];
	$play_result_picr_result = mysqli_query($conn, "SELECT * FROM play_result_picr WHERE play_result_pic = '$play_pic_no'");
	$play_result_picr_row = mysqli_fetch_array($play_result_picr_result);
	if($play_result_picr_row['pic_result'] == 1){
		$play_win = 1;
		$play_lose = 0;
		$play_save = 0;
		$play_hold = 0;
	}else if($play_result_picr_row['pic_result'] == 2){
		$play_win = 0;
		$play_lose = 1;
		$play_save = 0;
		$play_hold = 0;
	}else if($play_result_picr_row['pic_result'] == 3){
		$play_win = 0;
		$play_lose = 0;
		$play_save = 1;
		$play_hold = 0;
	}else if($play_result_picr_row['pic_result'] == 4){
		$play_win = 0;
		$play_lose = 0;
		$play_save = 0;
		$play_hold = 1;
	}else{
		$play_win = 0;
		$play_lose = 0;
		$play_save = 0;
		$play_hold = 0;
	}
	$inning = $play_pic_row['inning'];
	$pitcher_count = $play_pic_row['pitcher_count'];
	$so = $play_pic_row['so'];
	$hit = $play_pic_row['hit'];
	$hr = $play_pic_row['hr'];
	$er = $play_pic_row['er'];
	$uer = $play_pic_row['uer'];
	$b4 = $play_pic_row['b4'];
	$hbp = $play_pic_row['hbp'];
	
	$team_member = $play_pic_row['team_member'];
	$team_member_result = mysqli_query($conn, "SELECT COUNT(*) as count FROM player_pic WHERE team_member = '$team_member' AND league = '$league_no'");
	$team_member_row = mysqli_fetch_array($team_member_result);

	if($team_member_row['count'] > 0){
		mysqli_query($conn,"UPDATE player_pic SET at_game = at_game + 1, inning = inning + '$inning', play_win = play_win + '$play_win', play_lose = play_lose + '$play_lose', play_save = play_save + '$play_save', play_hold = play_hold + '$play_hold', pitcher_count = pitcher_count + '$pitcher_count', so = so + '$so', hit = hit + '$hit', hr = hr + '$hr', er = er + '$er', uer = uer + '$uer', b4 = b4 + '$b4', hbp = hbp + '$hbp' WHERE team_member = '$team_member' AND league = '$league_no'");
	}else{
		mysqli_query($conn,"INSERT INTO player_pic (team_member, league, at_game, inning, play_win, play_lose, play_save, play_hold, pitcher_count, so, hit, hr, er, uer, b4, hbp) VALUES ('$team_member', '$league_no', '1', '$inning', '$play_win', '$play_lose', '$play_save', '$play_hold', '$pitcher_count', '$so', '$hit', '$hr', '$er', '$uer', '$b4', '$hbp')");
	}
}
//echo "리그 : ".$league_no."/ 경기 : ".$play_no." / 선수 : ".$team_member." / 이닝(".$inning.") 투구수(".$pitcher_count.") 탈삼진(".$so.") 피안타(".$hit.") 피홈런(".$hr.") 볼넷(".$b4.") 사사구(".$hbp.") 삼진(".$so.") 자책(".$er.") 비자책(".$uer.") 승리(".$play_win.") 패배(".$play_lose.") 세이브(".$play_save.") 홀드(".$play_hold.")";
mysqli_query($conn,"INSERT INTO play_end (play) VALUES ('$play_no')"); // 경기 종료
}
mysqli_close($conn);
echo "<script>window.location.replace('../index.html')</script>";
?>

<body> 
<img src="../images/loading.gif" style="margin:45% 45%" alt="loading">
</html>
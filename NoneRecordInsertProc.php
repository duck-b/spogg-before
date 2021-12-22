<!doctype html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
	<style>
	body
		{
		 text-align: center;
		 margin: 0 auto;
		}


	#box
		{
		 position: absolute;
		 width: 50px;
		 height: 50px;
		 left: 50%;
		 top: 50%;
		 margin-left: -25px;
		 margin-top: -25px;
		}
	</style>
</head>
<?
session_start();
if($_SESSION['player_no']){
	include "dbconn.php";
	$created_at = date('Y-m-d H:i:s',time());
	$player = $_SESSION['player_no'];
	if($_POST['pos'] == '1'){
		$league_name = $_POST['league_name'];
		$years = $_POST['years'];
		$team_name = $_POST['team_name'];
		if($_POST['at_game'] != ""){
			$at_game = $_POST['at_game'];
		}else{
			$at_game = 9999;
		}
		$at_play = $_POST['at_play'];
		$at_bat = $_POST['at_bat'];
		$hit = $_POST['hit'];
		if($_POST['hit2'] != "" && $hit3 = $_POST['hit3'] != ""){
			$hit1 = $_POST['hit'] - $_POST['hit2'] - $_POST['hit3'] - $_POST['hr'];
			$hit2 = $_POST['hit2'];
			$hit3 = $_POST['hit3'];
		}else{
			$hit1 = 9999;
			$hit2 = 9999;
			$hit3 = 9999;
		}
		$hr = $_POST['hr'];
		$rbi = $_POST['rbi'];
		if($_POST['rs'] != ""){
			$rs = $_POST['rs'];
		}else{
			$rs = 9999;
		}
		if($_POST['sb'] != ""){
			$sb = $_POST['sb'];
		}else{
			$sb = 9999;
		}
		$bb = $_POST['bb'];
		if($_POST['hbp'] != ""){
			$hbp = $_POST['hbp'];
		}else{
			$hbp = 9999;
		}
		$so = $_POST['so'];
		if($_POST['sf'] != ""){
			$sf = $_POST['sf'];
		}else{
			$sf = 9999;
		}
		$query = "INSERT INTO none_record_hit   
		(player, league_name, years, team_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
		VALUES ('$player','$league_name','$years','$team_name','$at_game','$at_play','$at_bat','$hit','$hit1','$hit2','$hit3','$hr','$rbi','$rs','$sb','$bb','$hbp','$so','$sf','$created_at')";
		mysqli_query($conn, $query);
		//echo $query."<br>";
	}else if($_POST['pos'] == '2'){
		$league_name = $_POST['league_name'];
		$years = $_POST['years'];
		$team_name = $_POST['team_name'];
		if($_POST['at_game'] != ""){
			$at_game = $_POST['at_game'];
		}else{
			$at_game = 9999;
		}
		$win_games = $_POST['win_games'];
		$lose_games = $_POST['lose_games'];
		if($_POST['hold_games'] != ""){
			$hold_games = $_POST['hold_games'];
		}else{
			$hold_games = 9999;
		}
		$save_games = $_POST['save_games'];
		$inning = $_POST['h_inning']*3 + $_POST['f_inning'];
		if($_POST['pitcher_count'] != ""){
			$pitcher_count = $_POST['pitcher_count'];
		}else{
			$pitcher_count = 9999;
		}
		if($_POST['er'] != ""){
			$er = $_POST['er'];
		}else{
			$er = 9999;
		}
		if($_POST['rs'] != ""){
			$rs = $_POST['rs'];
		}else{
			$rs = 9999;
		}
		if($_POST['hit'] != ""){
			$hit = $_POST['hit'];
		}else{
			$hit = 9999;
		}
		$hr = $_POST['hr'];
		if($_POST['bb'] != ""){
			$bb = $_POST['bb'];
		}else{
			$bb = 9999;
		}
		if($_POST['hbp'] != ""){
			$hbp = $_POST['hbp'];
		}else{
			$hbp = 9999;
		}
		$so = $_POST['so'];
		$query = "INSERT INTO none_record_pit  
		(player, league_name, years, team_name, at_game, win_games, lose_games, hold_games, save_games, pitcher_count, inning, er, rs, hit, hr, bb, hbp, so, created_at) 
		VALUES ('$player','$league_name','$years','$team_name', '$at_game','$win_games','$lose_games','$hold_games','$save_games','$pitcher_count','$inning','$er','$rs','$hit','$hr','$bb','$hbp','$so','$created_at')";
		mysqli_query($conn, $query);
		//echo $query."<br>";
	}
	mysqli_close($conn);
	echo "<script>alert('입력이 완료되었습니다.');</script>";
	echo ("<meta http-equiv='Refresh' content='1; URL=record_none.html'>");
}else{
	echo "<script>alert('로그인이 필요합니다.');</script>";
	echo ("<meta http-equiv='Refresh' content='1; URL=login.html'>");
}
?>
<body>
	<img id="box" src="img/loading.gif" alt="loading">
</body>
</html>
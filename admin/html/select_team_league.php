<?php
include "dbconn.php";

$league = $_POST['league'];
$team = $_POST['team'];

$league_query = "SELECT count(CASE WHEN play_result.playresult = 1 THEN 1 END) AS win, 
 count(CASE WHEN play_result.playresult = 2 THEN 1 END) AS lose,
 count(CASE WHEN play_result.playresult = 3 THEN 1 END) AS draw,
 ROUND((count(CASE WHEN play_result.playresult = 1 THEN 1 END))/(count(CASE WHEN play_result.playresult = 1 THEN 1 END)+count(CASE WHEN play_result.playresult = 2 THEN 1 END)), 3) as mean
 FROM play JOIN play_result WHERE play.league = '$league' AND play_result.play = play.no AND play_result.team = '$team'";
$league_result = mysqli_query($conn, $league_query);
$league_row = mysqli_fetch_array($league_result);
if($league_row['win'] == 0 && $league_row['lose'] == 0 && $league_row['lose'] == 0){
	$league_record = "<hr>경기가 없습니다<br>";
}else{
	if($league_row['lose']+$league_row['win'] == 0){
		$league_record = "<hr>".$league_row['win']."승 ".$league_row['lose']."패 ".$league_row['draw']."무<br>승률 -<hr><a href='javascript:;'>리그보기</a>";
	}else{
		$league_record = "<hr>".$league_row['win']."승 ".$league_row['lose']."패 ".$league_row['draw']."무<br>승률 ".$league_row['mean']."<hr><a href='javascript:;'>리그보기</a>";
	}
}
echo $league_record;
mysqli_close($conn);
?>

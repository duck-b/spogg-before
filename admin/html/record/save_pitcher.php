<?php
include "dbconn.php";

$entry = $_POST['pitcher'];
$inning = $_POST['inning'];
$pitcher_count = $_POST['count'];

$pic_query = "SELECT count(CASE WHEN play_hit.situation_hit BETWEEN 11 AND 37 THEN 1 END) AS play_pic_hit,
 count(CASE WHEN play_hit.situation_hit BETWEEN 41 AND 44 THEN 1 END) AS play_pic_hr,
 count(CASE WHEN play_hit.situation_hit = 51 THEN 1 END) AS play_pic_b4,
 count(CASE WHEN play_hit.situation_hit = 52 THEN 1 END) AS play_pic_hbp,
 count(CASE WHEN play_hit.situation_hit BETWEEN 152 AND 153 THEN 1 END) AS play_hit_so
 FROM play_hit JOIN play_entry WHERE play_entry.no = play_hit.player_pic AND play_hit.player_pic = '$entry'
 GROUP BY play_hit.player_pic";
$play_pic_result = mysqli_query($conn, $pic_query);
$play_pic_row = mysqli_fetch_array($play_pic_result);
$play_pic_hit = $play_pic_row['play_pic_hit'];
$play_pic_hr = $play_pic_row['play_pic_hr'];
$play_pic_b4 = $play_pic_row['play_pic_b4'];
$play_pic_hbp = $play_pic_row['play_pic_hbp'];
$play_hit_so = $play_pic_row['play_hit_so'];

$pic_er_query = "SELECT COUNT(CASE WHEN play_hit.situation_hit != 154 THEN 1 END) AS play_pic_er,
 COUNT(CASE WHEN play_hit.situation_hit = 154 THEN 1 END) AS play_pic_uer
 FROM play_hit JOIN play_run WHERE play_hit.player_pic = '$entry' AND play_hit.no = play_run.play_runner AND play_run.result_base = 4";
$play_er_result = mysqli_query($conn, $pic_er_query);
$play_er_row = mysqli_fetch_array($play_er_result);
$play_pic_er = $play_er_row['play_pic_er'];
$play_pic_uer = $play_er_row['play_pic_uer'];

mysqli_query($conn,"INSERT INTO play_result_pic (entry, inning, pitcher_count, so, hit, hr, er, uer, b4, hbp) VALUES ('$entry', '$inning', '$pitcher_count', '$play_hit_so', '$play_pic_hit', '$play_pic_hr', '$play_pic_er', '$play_pic_uer', '$play_pic_b4', '$play_pic_hbp')");
//echo "피안타(".$play_pic_hit.") 피홈런(".$play_pic_hr.") 볼넷(".$play_pic_b4.") 사사구(".$play_pic_hbp.") 삼진(".$play_hit_so.") 자책(".$play_pic_er.") 비자책(".$play_pic_uer.")";
mysqli_close($conn);
?>

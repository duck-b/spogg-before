<?php
include "dbconn.php";

$entry = $_POST['entry'];
$inning = $_POST['inning'];
$player_pic = $_POST['player_pic'];
$ball_count = $_POST['ball_count'];
$out_count = $_POST['out_count'];
$situation = $_POST['situations'];

mysqli_query($conn,"INSERT INTO play_hit (entry, inning, player_pic, ball_count, out_count, situation_hit) VALUES ('$entry', '$inning', '$player_pic', '$ball_count', '$out_count', '$situation')");
mysqli_close($conn);
?>

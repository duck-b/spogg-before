<?php
include "dbconn.php";

$play_hitter = $_POST['play_hitter'];
$play_hit_result = mysqli_query($conn, "SELECT MAX(no) as maxno FROM play_hit where entry = '$play_hitter'");
$play_hit_row = mysqli_fetch_array($play_hit_result);
$play_hit = $play_hit_row['maxno'];
$entry_runner = $_POST['entry_runner'];
$play_run_result = mysqli_query($conn, "SELECT MAX(no) as maxno FROM play_hit where entry = '$entry_runner'");
$play_run_row = mysqli_fetch_array($play_run_result);
$play_run = $play_run_row['maxno'];
$result_base = $_POST['result_base'];
$situation = $_POST['situations'];

mysqli_query($conn,"INSERT INTO play_run (play_hit, play_runner, result_base, situation_run) VALUES ('$play_hit', '$play_run', '$result_base', '$situation')");
mysqli_close($conn);
//echo $play_hit." ".$play_run." ".$result_base." ".$situation;
?>

<?php
include "dbconn.php";

$game_no = 1;
$entry_no = 1;
$inning = $_POST['inning'];
$hoaw = $_POST['hoaw'];
$ball_count = 'BBBB';
$action = "4B";

mysqli_query($conn,"INSERT INTO recode_hitter (game_no, entry_no, inning, hoaw, ball_count, action) VALUES ('$game_no', '$entry_no', '$inning', '$hoaw', '$ball_count', '$action')");
mysqli_close($conn);
?>

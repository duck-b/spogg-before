<?php
include "dbconn.php";

$play = $_POST['play'];
$team = $_POST['team'];
$position = $_POST['position'];

mysqli_query($conn,"INSERT INTO play_error (play, team, position) VALUES ('$play', '$team', '$position')");
mysqli_close($conn);
?>

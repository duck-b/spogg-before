<?php
include "dbconn.php";

$entry = $_POST['entry'];
$inning = $_POST['inning'];
$situation = $_POST['situations'];

mysqli_query($conn,"UPDATE play_hit SET situation_hit = '$situation' WHERE entry = '$entry' AND inning = '$inning' ORDER BY no DESC LIMIT 1");

mysqli_close($conn);
?>

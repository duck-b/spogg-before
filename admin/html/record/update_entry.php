<?php
include "dbconn.php";

$play = $_POST['play_change'];
$in_player = $_POST['in_player_change'];
$hoaw = $_POST['hoaw_change'];
$turn = $_POST['turn_change'] + 1;
$position = $_POST['position_change'];
$out_player = $_POST['out_player_change'];
$inning = $_POST['inning_change'];

mysqli_query($conn,"INSERT INTO play_entry (play, team_member, hoaw, turn, position) VALUES ('$play', '$in_player', '$hoaw', '$turn', '$position')");
$out_entry_result = mysqli_query($conn, "SELECT * FROM play_entry WHERE no='$out_player'");
$out_entry_row = mysqli_fetch_array($out_entry_result);
$out_entry_no = $out_entry_row['no'];
$in_entry_result = mysqli_query($conn, "SELECT * FROM play_entry WHERE play='$play' AND team_member = '$in_player'");
$in_entry_row = mysqli_fetch_array($in_entry_result);
$in_entry_no = $in_entry_row['no'];
mysqli_query($conn,"INSERT INTO play_entry_change (play_entry, in_out, inning) VALUES ('$out_entry_no', '0', '$inning')");
mysqli_query($conn,"INSERT INTO play_entry_change (play_entry, in_out, inning) VALUES ('$in_entry_no', '1', '$inning')");

$entry_result = mysqli_query($conn, "SELECT play_entry.*, user.name AS name, team_members.back_num FROM play_entry JOIN team_members JOIN player JOIN user WHERE play_entry.no='$in_entry_no' AND play_entry.team_member = team_members.no AND team_members.player = player.no AND player.user = user.no");
$entry_row = mysqli_fetch_array($entry_result);
if(mb_strlen($entry_row['back_num'], 'UTF-8') == 2){
	$back_num = $entry_row['back_num'].". ";
}else{
	$back_num = "0".$entry_row['back_num'].". ";
}

mysqli_close($conn);
echo $in_entry_no."|".$back_num.$entry_row['name'];
?>

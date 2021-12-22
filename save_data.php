<?php
include "dbconn.php";
$player = $_POST['player'];
$record = $_POST['no'];
$position = $_POST['position'];
$save_data_query = "SELECT * FROM user_player_record WHERE player = '$player' AND record = '$record' AND position = '$position'";
$save_data_result = mysqli_query($conn, $save_data_query);
$save_data_row = mysqli_fetch_array($save_data_result);
if(!$save_data_row){
	$created_at = date('Y-m-d H:i:s',time());
	mysqli_query($conn,"INSERT INTO user_player_record (player, record, position, created_at) VALUES ('$player', '$record', '$position', '$created_at')");
	mysqli_close($conn);
	echo "저장 되었습니다. 내 기록 -> 공식 기록에서 확인해 주세요.";
}else{
	mysqli_close($conn);
	echo "이미 저장된 기록입니다. 내 기록 -> 공식 기록에서 확인해 주세요.";
}
?>
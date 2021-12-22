<?
if($_POST['no']){
if($_POST['no'] == '1'){
	$league_record_query = "SELECT league_info.no, league.name as league_name, league.img AS league_img, league_info.years AS league_years, COUNT(*) AS this_record, 'hit_record' as this_title FROM league_record_hit JOIN league_info JOIN league JOIN user_player_record WHERE league_record_hit.league_info = league_info.no AND league_info.league = league.no AND league_record_hit.no = user_player_record.record AND user_player_record.position = 1 GROUP BY league_record_hit.league_info ORDER BY this_record DESC LIMIT 10";
}else if($_POST['no'] == '2'){
	$league_record_query = "SELECT league_info.no, league.name as league_name, league.img AS league_img, league_info.years AS league_years, COUNT(*) AS this_record, 'pit_record' as this_title FROM league_record_pit JOIN league_info JOIN league JOIN user_player_record WHERE league_record_pit.league_info = league_info.no AND league_info.league = league.no AND league_record_pit.no = user_player_record.record AND user_player_record.position = 2 GROUP BY league_record_pit.league_info ORDER BY this_record DESC LIMIT 10";
}else if($_POST['no'] == 3){
	$league_record_query = "SELECT league_info.no, league.name as league_name, league.img AS league_img, league_info.years AS league_years, SUM(hr) AS this_record, 'hr' as this_title  FROM league_record_hit JOIN league_info JOIN league WHERE league_record_hit.league_info = league_info.no AND league_info.league = league.no GROUP BY league_record_hit.league_info ORDER BY this_record DESC LIMIT 10";
}
include "dbconn.php";
$league_record_result = mysqli_query($conn,$league_record_query);
mysqli_close($conn);
$league_record_table = "<table class='table' style='width:100%;text-align:center'>
							<thead>
								<tr><th>No</th><th>리그</th><th>기록</th>
							</thead>
							<tbody>";
$i = 0;							
$before_data = -9999;
while($league_record_row = mysqli_fetch_array($league_record_result)){
	if($before_data != $league_record_row['this_record']){
		$before_data = $league_record_row['this_record'];
		$i++;
	}
	if(mb_strlen($league_record_row['league_name'], 'UTF-8') <= 9){
		$league_name = $league_record_row['league_name'];
	}else{
		$league_name = mb_substr($league_record_row['league_name'], 0, 8, 'UTF-8')."‥";
	}
	$league_record_table .= "<tr><td>$i</td><td style='text-align:left'><a href='league_detail.html?no=".$league_record_row['no']."' style='text-decoration:none;color:#000000'><img src='img/service_1.png' class='d-inline-block align-top rounded-circle' style='width:20px;height:20px;margin-right:3px'>".$league_record_row['years']." ".$league_name."</a></td><td>".$league_record_row['this_record']."</td></tr>";
}
$league_record_table .= "</tbody>
					</table>";
echo $league_record_table;
}else{
	echo "123123";
}
?>
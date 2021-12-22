<?php
$position = $_POST['position'];
$years = $_POST['years'];
$search_text = $_POST['search_text'];
if($position == 1){
	include "dbconn.php";
	$hit_record_query = "SELECT search_table2.*,
		ROUND(SUM(league_record_hit.hit)/SUM(league_record_hit.at_bat),3) AS team_avg,
		COUNT(*) AS count_team 
	FROM (SELECT search_table.*,
				ROUND(SUM(league_record_hit.hit)/SUM(league_record_hit.at_bat),3) AS league_avg,
				COUNT(CASE WHEN at_bat != 0 THEN 1 END) AS count_league,
				COUNT(CASE WHEN league_record_hit.hit/league_record_hit.at_bat = 0 THEN 1 END) AS league_avg0, 
				COUNT(CASE WHEN league_record_hit.hit/league_record_hit.at_bat >= 0 AND league_record_hit.hit/league_record_hit.at_bat <= 0.2 THEN 1 END) AS league_avg02,
				COUNT(CASE WHEN league_record_hit.hit/league_record_hit.at_bat > 0.2 AND league_record_hit.hit/league_record_hit.at_bat <= 0.4 THEN 1 END) AS league_avg04,
				COUNT(CASE WHEN league_record_hit.hit/league_record_hit.at_bat > 0.4 AND league_record_hit.hit/league_record_hit.at_bat <= 0.6 THEN 1 END) AS league_avg06,
				COUNT(CASE WHEN league_record_hit.hit/league_record_hit.at_bat > 0.6 AND league_record_hit.hit/league_record_hit.at_bat <= 0.8 THEN 1 END) AS league_avg08,
				COUNT(CASE WHEN league_record_hit.hit/league_record_hit.at_bat > 0.8 AND league_record_hit.hit/league_record_hit.at_bat <= 1 THEN 1 END) AS league_avg10
		FROM (SELECT league_info.no AS no,
				league_record_hit.no AS record_no,
				league.name AS league_name, 
				league_info.years AS league_years,
				league_record_hit.team_name as team_name,
				ROUND(league_record_hit.hit/league_record_hit.at_bat,3) as avg 
			FROM league_record_hit JOIN league_info JOIN league 
			WHERE player_name = '".$search_text."' AND league_record_hit.league_info = league_info.no AND league_info.league = league.no AND league_info.years = '".$years."') as search_table JOIN league_record_hit 
		WHERE league_record_hit.league_info = search_table.no GROUP BY search_table.no, search_table.team_name) AS search_table2 JOIN league_record_hit
	WHERE league_record_hit.team_name = search_table2.team_name AND league_record_hit.league_info = search_table2.no GROUP BY search_table2.team_name ORDER BY avg DESC";
	$hit_record_result = mysqli_query($conn, $hit_record_query);
	mysqli_close($conn);
	$hit_table_basic = "";
	$veiw_avg_chart = "";
	$avg_chart = "";
	$i = 0;
	while($hit_record_row = mysqli_fetch_array($hit_record_result)){
		$i++;
		$hit_no = $hit_record_row['record_no'];
		// avg
		if($hit_record_row['avg'] == null){
			$avg = "-";
		}else{
			$avg = number_format($hit_record_row['avg'],3);
		}
		if(mb_strlen($hit_record_row['league_name'], 'UTF-8') <= 11){
			$league_name = $hit_record_row['league_name'];
		}else{
			$league_name = mb_substr($hit_record_row['league_name'], 0, 10, 'UTF-8')."‥";
		}
		$hit_table_basic .= "<tr>
			<td title='".$hit_record_row['league_name']."'>".$league_name."</td><td>".$hit_record_row['team_name']."</td><td>".$avg."</td><td id='1_save_data_$hit_no'><a class='btn btn-primary btn-sm' href='javascript:;' role='button' onclick='save_data($hit_no,1);' style='background-color:rgb(83, 131, 232);width:100%'>저장하기</a></td>
		</tr>";
		$veiw_avg_chart .="<div class='col-xs-6'>
							<div class='to_border rounded shadow'>
								<canvas id='change_chart_avg".$i."' height='300'></canvas>
							</div>
						</div>
		";
		$bar_max = (max($hit_record_row['league_avg0'],$hit_record_row['league_avg02'],$hit_record_row['league_avg04'],$hit_record_row['league_avg06'],$hit_record_row['league_avg08'],$hit_record_row['league_avg10']) + 20);
		$bar_max01 = $bar_max /10;
		$bar_floor = floor($bar_max01);
		$bar_floor2 = $bar_max01 - $bar_floor;
		$bar_max = $bar_max - $bar_floor2*10;
		$avg_chart .= $i.",".$avg.",".$bar_max.",".$hit_record_row['league_avg'].",".$hit_record_row['team_avg'].",".$hit_record_row['league_avg0'].",".$hit_record_row['league_avg02'].",".$hit_record_row['league_avg04'].",".$hit_record_row['league_avg06'].",".$hit_record_row['league_avg08'].",".$hit_record_row['league_avg10'].",".$hit_record_row['league_name']."|";
	}
	if($hit_table_basic){
		echo "<div class='table-box-wrap'>
				<div class='to_page_content2 table-responsive-sm table-responsive to_mb_30 rounded shadow'>
					<table class='table table_h_b search_table' id='recode_hitplay1'>
						<thead>
							<tr>
								<th>리그명</th><th>팀명</th><th>AVG</th><th>저장</th>
							</tr>
						</thead>
						<tbody>
							".$hit_table_basic."
						</tbody>					
					</table>
				</div>
			</div>";
		echo "+";
		echo "<div class='search_hr_padding_bottom'>
				<div class='col-xs-12 col-md-6 text-left'>
					<div class='to_titlebar'>
						타율 분포
					</div>
				</div>
				<div class='col-xs-12 col-md-6 search_chart'>
					<table>
						<tr>
							<td><b style='color:#515151;'>-</b></td><td>전체</td>
							<td><b style='color:#e85383;'>-</b></td><td>리그</td>
							<td><b style='color:#83e853;'>-</b></td><td>팀</td>
							<td><b style='color:#5383e8;'>-</b></td><td>선수</td>
						</tr>
					</table>
				</div>
			</div><hr>
			".$veiw_avg_chart;
		echo "+";
		echo $avg_chart;
	}else{
		echo 0;
	}
}else if($position == 2){
	include "dbconn.php";
	$pit_record_query = "SELECT search_table2.*,
		CASE WHEN search_table2.erorrs = 'er' THEN ROUND((SUM(league_record_pit.er) * 7)/(SUM(league_record_pit.inning)/3),2) ELSE ROUND((SUM(league_record_pit.rs) * 7)/(SUM(league_record_pit.inning)/3),2) END AS team_era, 
		COUNT(*) AS count_team 
	FROM (SELECT search_table.*,
				CASE WHEN search_table.erorrs = 'er' THEN ROUND((SUM(league_record_pit.er) * 7)/(SUM(league_record_pit.inning)/3),2) ELSE ROUND((SUM(league_record_pit.rs) * 7)/(SUM(league_record_pit.inning)/3),2) END AS league_era, 
				COUNT(CASE WHEN inning != 0 THEN 1 END) AS count_league,
				COUNT(CASE WHEN search_table.erorrs = 'er' THEN (CASE WHEN (league_record_pit.er * 7)/(league_record_pit.inning/3) > 0 AND (league_record_pit.er * 7)/(league_record_pit.inning/3) < 5 THEN 1 END) ELSE (CASE WHEN (league_record_pit.rs * 7)/(league_record_pit.inning/3) > 0 AND (league_record_pit.rs * 7)/(league_record_pit.inning/3) < 5 THEN 1 END) END) AS league_era0, 
				COUNT(CASE WHEN search_table.erorrs = 'er' THEN (CASE WHEN (league_record_pit.er * 7)/(league_record_pit.inning/3) >= 5 AND (league_record_pit.er * 7)/(league_record_pit.inning/3) < 10 THEN 1 END) ELSE (CASE WHEN (league_record_pit.rs * 7)/(league_record_pit.inning/3) >= 5 AND (league_record_pit.rs * 7)/(league_record_pit.inning/3) < 10 THEN 1 END) END) AS league_era5,
				COUNT(CASE WHEN search_table.erorrs = 'er' THEN (CASE WHEN (league_record_pit.er * 7)/(league_record_pit.inning/3) >= 10 AND (league_record_pit.er * 7)/(league_record_pit.inning/3) < 15 THEN 1 END) ELSE (CASE WHEN (league_record_pit.rs * 7)/(league_record_pit.inning/3) >= 10 AND (league_record_pit.rs * 7)/(league_record_pit.inning/3) < 15 THEN 1 END) END) AS league_era10,
				COUNT(CASE WHEN search_table.erorrs = 'er' THEN (CASE WHEN (league_record_pit.er * 7)/(league_record_pit.inning/3) >= 15 AND (league_record_pit.er * 7)/(league_record_pit.inning/3) < 20 THEN 1 END) ELSE (CASE WHEN (league_record_pit.rs * 7)/(league_record_pit.inning/3) >= 15 AND (league_record_pit.rs * 7)/(league_record_pit.inning/3) < 20 THEN 1 END) END) AS league_era15,
				COUNT(CASE WHEN search_table.erorrs = 'er' THEN (CASE WHEN (league_record_pit.er * 7)/(league_record_pit.inning/3) >= 20 AND (league_record_pit.er * 7)/(league_record_pit.inning/3) < 25 THEN 1 END) ELSE (CASE WHEN (league_record_pit.rs * 7)/(league_record_pit.inning/3) >= 20 AND (league_record_pit.rs * 7)/(league_record_pit.inning/3) < 25 THEN 1 END) END) AS league_era20,
				COUNT(CASE WHEN search_table.erorrs = 'er' THEN (CASE WHEN (league_record_pit.er * 7)/(league_record_pit.inning/3) >= 25 THEN 1 END) ELSE (CASE WHEN (league_record_pit.rs * 7)/(league_record_pit.inning/3) >= 25 THEN 1 END) END) AS league_era25
		FROM (SELECT league_info.no AS no,
				league_record_pit.no AS record_no, 
				league.name AS league_name, 
				league_info.years AS league_years,
				league_record_pit.team_name as team_name,
				CASE WHEN er != '9999' THEN 'er' ELSE 'rs' END AS erorrs, 
				CASE WHEN er != '9999' THEN ROUND((league_record_pit.er * 7)/(league_record_pit.inning/3),2) ELSE ROUND((league_record_pit.rs * 7)/(league_record_pit.inning/3),2) END AS era 
			FROM league_record_pit JOIN league_info JOIN league 
			WHERE player_name = '".$search_text."' AND league_record_pit.league_info = league_info.no AND league_info.league = league.no AND league_info.years = '".$years."') as search_table JOIN league_record_pit 
		WHERE league_record_pit.league_info = search_table.no GROUP BY search_table.no, search_table.team_name) AS search_table2 JOIN league_record_pit
	WHERE league_record_pit.team_name = search_table2.team_name AND league_record_pit.league_info = search_table2.no GROUP BY search_table2.team_name ORDER BY era is null ASC, era ASC";
	$pit_record_result = mysqli_query($conn,$pit_record_query);
	mysqli_close($conn);
	$pit_table_basic = "";
	$era_chart = "";
	$veiw_era_chart = "";
	$i = 0;
	while($pit_record_row = mysqli_fetch_array($pit_record_result)){
		$i++;
		$pit_no = $pit_record_row['record_no'];
		if($pit_record_row['era'] == null){
			$era = "-";
		}else{
			$era = number_format($pit_record_row['era'],2);
		}
		if(mb_strlen($pit_record_row['league_name'], 'UTF-8') <= 11){
			$league_name = $pit_record_row['league_name'];
		}else{
			$league_name = mb_substr($pit_record_row['league_name'], 0, 10, 'UTF-8')."‥";
		}
		$pit_table_basic = $pit_table_basic."<tr>
			<td title='".$pit_record_row['league_name']."'>".$league_name."</td><td>".$pit_record_row['team_name']."</td><td>".$era."</td><td id='2_save_data_$pit_no'><a class='btn btn-primary btn-sm' href='javascript:;' role='button' onclick='save_data($pit_no,2);' style='background-color:rgb(83, 131, 232);width:100%'>저장하기</a></td>
		</tr>";
		$veiw_era_chart .="<div class='col-xs-6'>
							<div class='to_border rounded shadow'>
								<canvas id='change_chart_era".$i."' height='300'></canvas>
							</div>
						</div>
						";
		$bar_max = (max($pit_record_row['league_era0'],$pit_record_row['league_era5'],$pit_record_row['league_era10'],$pit_record_row['league_era15'],$pit_record_row['league_era20'],$pit_record_row['league_era25']) + 10);
		$bar_max01 = $bar_max /10;
		$bar_floor = floor($bar_max01);
		$bar_floor2 = $bar_max01 - $bar_floor;
		$bar_max = $bar_max - $bar_floor2*10;
		$era_chart .= $i.",".$era.",".$bar_max.",".$pit_record_row['league_era'].",".$pit_record_row['team_era'].",".$pit_record_row['league_era0'].",".$pit_record_row['league_era5'].",".$pit_record_row['league_era10'].",".$pit_record_row['league_era15'].",".$pit_record_row['league_era20'].",".$pit_record_row['league_era25'].",".$pit_record_row['league_name']."|";
	}
	if($pit_table_basic){
		echo "<div class='table-box-wrap'>
				<div class='to_page_content2 table-responsive-sm table-responsive to_mb_30 rounded shadow'>
					<table class='table table_h_b search_table' id='recode_pitchplay'>
						<thead>
							<tr>
								<th>리그명</th><th>팀명</th><th>ERA</th><th>저장</th>
							</tr>
						</thead>
						<tbody>
							".$pit_table_basic."
						</tbody>				
					</table>
				</div>
			</div>";
		echo "+";
		echo "<div class='search_hr_padding_bottom'>
				<div class='col-xs-12 col-md-6 text-left'>
					<div class='to_titlebar'>
						방어율 분포
					</div>
				</div>
				<div class='col-xs-12 col-md-6 search_chart'>
					<table>
						<tr>
							<td><b style='color:#515151;'>-</b></td><td>전체</td>
							<td><b style='color:#e85383;'>-</b></td><td>리그</td>
							<td><b style='color:#83e853;'>-</b></td><td>팀</td>
							<td><b style='color:#5383e8;'>-</b></td><td>선수</td>
						</tr>
					</table>
				</div>
			</div><hr>
			".$veiw_era_chart;
		echo "+";
		echo $era_chart;
	}else{
		echo 0;
	}
}
?>

<!doctype html>
<html lang="ko">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<?
include "../dbconn.php";
$hit_record_query = "SELECT league.no, league.name, league_info.years ,league_record_hit.league_info, COUNT(league_record_hit.league_info) AS counts FROM league_record_hit JOIN league_info JOIN league WHERE league_info.no = league_record_hit.league_info AND league_info.league = league.no GROUP BY league_record_hit.league_info ORDER BY league.no";
$hit_record_result = mysqli_query($conn,$hit_record_query);
$hit_table_basic = "";
$pit_record_query = "SELECT league.no, league.name, league_info.years ,league_record_pit.league_info, COUNT(league_record_pit.league_info) AS counts FROM league_record_pit JOIN league_info JOIN league WHERE league_info.no = league_record_pit.league_info AND league_info.league = league.no GROUP BY league_record_pit.league_info ORDER BY league.no";
$pit_record_result = mysqli_query($conn,$pit_record_query);
$table_basic = "";
$i=0;
$hitter=0;
$picter=0;
while($hit_record_row = mysqli_fetch_array($hit_record_result)){
	$i++;
	$hitter+=$hit_record_row['counts'];
	$table_basic .= "<tr>
			<td>".$i."</td>
			<td>".$hit_record_row['name']."-타자</td>
			<td>".$hit_record_row['years']."</td>
			<td>".$hit_record_row['counts']."</td>
		</tr>";
}
while($pit_record_row = mysqli_fetch_array($pit_record_result)){
	$i++;
	$picter += $pit_record_row['counts'];
	$table_basic .= "<tr>
			<td>".$i."</td>
			<td>".$pit_record_row['name']."-투수</td>
			<td>".$pit_record_row['years']."</td>
			<td>".$pit_record_row['counts']."</td>
		</tr>";
}
$league_count_result = mysqli_query($conn,"SELECT COUNT(*) AS counts FROM league WHERE 1");
$league_count = mysqli_fetch_array($league_count_result);
$league_info_count_result = mysqli_query($conn,"SELECT COUNT(*) AS counts FROM league_info WHERE 1");
$league_info_count = mysqli_fetch_array($league_info_count_result);
/* 리그 등록 되어있지만, 데이터가 없는 리그
$league_result = mysqli_query($conn,"SELECT league.no as league_no, league_info.no as league_info_no, league.name as league_name, league_info.years as years FROM league JOIN league_info WHERE league.no = league_info.league");
while($league_row = mysqli_fetch_array($league_result)){
	$league_hit_result = mysqli_query($conn,"SELECT count(*) AS counts FROM league_record_hit where league_info =".$league_row['league_info_no']);
	$league_hit_row = mysqli_fetch_array($league_hit_result);
	if($league_hit_row['counts'] == 0){
		echo "타자".$league_row['league_no']." ".$league_row['league_info_no']." ".$league_row['league_name']." ".$league_row['years']."<br>";
	}
	$league_pit_result = mysqli_query($conn,"SELECT count(*) AS counts FROM league_record_pit where league_info =".$league_row['league_info_no']);
	$league_pit_row = mysqli_fetch_array($league_pit_result);
	if($league_pit_row['counts'] == 0){
		echo "투수".$league_row['league_no']." ".$league_row['league_info_no']." ".$league_row['league_name']." ".$league_row['years']."<br>";
	}
		
}
*/
mysqli_close($conn);

?>
<div class="row" style="margin:0px">
	<div class="col-6">
		<table class="table" style="text-align:left;">
			<tr>
				<th>No</th>
				<th>LEAGUE</th>
				<th>YEARS</th>
				<th>DATA</th>
			</tr>
			<?=$table_basic?>
		</table>
	</div>
	<div class="col-6">
		<table class="table" style="text-align:left;">
			<thead>
				<tr>
					<th colspan="4" style="text-align:center">DATA 개수 요약</th>
				</tr>
				<tr>
					<th>리그</th>
					<th>리그(년도별)</th>
					<th>타자</th>
					<th>투수</th>
				</tr>
			</thead>
			<tbody>
				</tr>
					<td><?=$league_count['counts']?></td>
					<td><?=$league_info_count['counts']?></td>
					<td><?=$hitter++;?></td>
					<td><?=$picter++;?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>

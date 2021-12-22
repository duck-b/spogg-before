<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php
	include "inc/_head.html";
	include "inc/_script.html";
	include "dbconn.php";
	$no = $_GET['no'];
	$league_result = mysqli_query($conn,"SELECT * FROM league WHERE no = '$no'");
	$league_row = mysqli_fetch_array($league_result);
	if($league_row['pro'] == 1){
		$pro = "사회인 1부";
	}else if($league_row['pro'] == 2){
		$pro = "사회인 2부";
	}else if($league_row['pro'] == 3){
		$pro = "사회인 3부";
	}else if($league_row['pro'] == 4){
		$pro = "사회인 4부";
	}
	if($league_row['kinds'] == 1){
		$kind = "리그";
	}else if($league_row['kinds'] == 2){
		$kind = "토너먼트";
	}
?>

	<script type="text/javascript">
	function league_insert(no){ 
		window.open("LeagueTeamInsertProc.php?no=" + no,
					"League_Insert","left=200, top=200, width=500, height=300, scrollbars=no,resizable=yes");
					//document.getElementById("id").disabled = true;
	}
	function cancle(){
		window.close();
	}
	</script>
	<body style="margin: 30px 20px 0px 20px">
		<div style="text-align:center">
			<? if($league_row['img']){?>
			<img src="<? echo $league_row['img'];?>" style="width:50%" class="img-thumbnail" alt="<? echo $league_row['name']?>">
			<? } else {?>
			<img class="img-thumbnail" style="width:50%" src="images/none_team_img.png" alt="<? echo $league_row['name']?>">
			<? } ?>
		</div>
		<br>
		<table class="table">
			<thead>
				<tr>
					<th style="width:30%">리그 명</th>
					<th style="width:70%"><? echo $league_row['name'];?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th style="width:30%">리그 수준</th>
					<td style="width:70%"><? echo $pro;?></td>
				</tr>
				<tr>
					<th style="width:30%">연고지</th>
					<td style="width:70%"><? echo $league_row['adrs'];?></td>
				</tr>
				<tr>
					<th style="width:30%">개최일</th>
					<td style="width:70%"><? echo $league_row['found'];?></td>
				</tr>
				<tr>
					<th style="width:30%">경기 형식</th>
					<td style="width:70%"><? echo $kind;?></td>
				</tr>
			</tbody>
		</table>
		<hr>
		<div style="text-align:center">
			<a class="btn btn-primary btn-sm" href="javascript:;" onClick="league_insert(<? echo $no?>)" role="button">&nbsp;&nbsp;신&nbsp;&nbsp;청&nbsp;&nbsp;</a>
			<a class="btn btn-primary btn-sm" href="javascript:;" onclick="cancle()" role="button">&nbsp;&nbsp;취&nbsp;&nbsp;소&nbsp;&nbsp;</a>
		</div>
	</body>
</html>
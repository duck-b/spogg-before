<?php
include "../dbconn.php";
$record = $_POST['no'];
$position = $_POST['position'];
if($position == 1){
	$table = "league_record_hit";
}else if($position == 2){
	$table = "league_record_pit";
}
$record_query = "SELECT * FROM ".$table." WHERE no = $record";
$record_result = mysqli_query($conn, $record_query);
$record_row = mysqli_fetch_array($record_result);
mysqli_close($conn);
if($record_row){
	if($position == 1){
		if($record_row['at_game'] == 9999){
			$at_game = "-";
		}else{
			$at_game = $record_row['at_game'];
		}
		$at_play = $record_row['at_play'];
		$at_bat = $record_row['at_bat'];
		$hit = $record_row['hit'];
		if($record_row['hit1'] == 9999){
			$hit1 = "-";
		}else{
			$hit1 = $record_row['hit1'];
		}
		if($record_row['hit2'] == 9999){
			$hit2 = "-";
		}else{
			$hit2 = $record_row['hit2'];
		}
		if($record_row['hit3'] == 9999){
			$hit3 = "-";
		}else{
			$hit3 = $record_row['hit3'];
		}
		$hr = $record_row['hr'];
		$rbi = $record_row['rbi'];
		if($record_row['rs'] == 9999){
			$rs = "-";
		}else{
			$rs = $record_row['rs'];
		}
		if($record_row['sb'] == 9999){
			$sb = "-";
		}else{
			$sb = $record_row['sb'];
		}
		$bb = $record_row['bb'];
		if($record_row['hbp'] == 9999){
			$hbp = "-";
			if($record_row['sf'] == 9999){
				$sf = "-";
				$obp = "-";
			}else{
				$sf = $record_row['sf'];
				if($record_row['at_bat'] + $record_row['bb'] + $record_row['sf'] != 0){
					$obp = number_format(round(($record_row['hit'] + $record_row['bb'])/($record_row['at_bat'] + $record_row['bb'] + $record_row['sf']),3),3);
				}else{
					$obp = "-";
				}
			}
		}else{
			$hbp = $record_row['hbp'];
			if($record_row['sf'] == 9999){
				$sf = "-";
				$obp = "-";
			}else{
				$sf = $record_row['sf'];
				if($record_row['at_bat'] + $record_row['bb'] + $record_row['hbp'] + $record_row['sf'] != 0){
					$obp = number_format(round(($record_row['hit'] + $record_row['bb'] + $record_row['hbp'])/($record_row['at_bat'] + $record_row['bb'] + $record_row['hbp'] + $record_row['sf']),3),3);
				}else{
					$obp = "-";
				}
			}
		}
		$so = $record_row['so'];
		if($record_row['at_bat'] != 0){
			$avg = number_format(round($record_row['hit']/$record_row['at_bat'],3),3);
		}else{
			$avg = "-";
		}
		if($record_row['hit2'] != 9999 && $record_row['hit3'] != 9999){
			$tb = $record_row['hit1'] + $record_row['hit2']*2 + $record_row['hit3']*3 + $record_row['hr']*4;
			$xbh = $record_row['hit2'] + $record_row['hit3'] + $record_row['hr'];
			if($record_row['at_bat'] != 0){
				$slg = number_format(round(($record_row['hit1'] + $record_row['hit2']*2 + $record_row['hit3']*3 + $record_row['hr']*4) / $record_row['at_bat'],3),3);
			}else{
				$slg = "-";
			}
		}else{
			$tb = "-";
			$xbh = "-";
			$slg = "-";
		}
		if($slg != "-" && $obp != "-"){
			$ops = number_format($slg+$obp,3);
		}else{
			$ops = "-";
		}
		echo "<table class='table table_h_g'>
			<tr>
				<th>경기수</th><td id='at_game'>$at_game</td><th>타석</th><td id='at_play'>$at_play</td><th>타수</th><td id='at_bat'>$at_bat</td><th>타율</th><td id='avg'>$avg</td><th>안타</th><td id='hit'>$hit</td>
			</tr>
			<tr>
				<th>2루타</th><td id='hit2'>$hit2</td><th>3루타</th><td id='hit3'>$hit3</td><th>홈런</th><td id='hr'>$hr</td><th>타점</th><td id='rbi'>$rbi</td><th>득점</th><td id='rs'>$rs</td>
			</tr>
			<tr>
				<th>도루</th><td id='sb'>$sb</td><th>볼넷</th><td id='bb'>$bb</td><th>사사구</th><td id='hbp'>$hbp</td><th>삼진</th><td id='so'>$so</td><th>희생</th><td id='sf'>$sf</td>
			</tr>
			<tr>
				<th>루타</th><td id='tb'>$tb</td><th>장타</th><td id='xbh'>$xbh</td><th>출루율</th><td id='obp'>$obp</td><th>장타율</th><td id='slg'>$slg</td><th>OPS</th><td id='ops'>$ops</td>
			</tr>
		</table>";
	}else{
		
	}
}else{
	echo "Error";
}
?>
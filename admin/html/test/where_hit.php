<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="main.css">
<?php
$how = $_GET['how'];
if($how == 'hr'){
	echo "홈런";
}elseif($how == 'lf'){
	echo "좌익수 쪽";
}elseif($how == 'cf'){
	echo "중견수 쪽";
}elseif($how == 'rf'){
	echo "우익수 쪽";
}elseif($how =='ss'){
	echo "유격수 쪽";
}elseif($how =='b2'){
	echo "2루수 쪽";
}elseif($how =='b3'){
	echo "3루수 쪽";
}elseif($how =='b1'){
	echo "1루수 쪽";
}elseif($how =='p'){
	echo "투수 쪽";
}elseif($how =='c'){
	echo "포수 쪽";
}
?>

<body onload="base_check()">
<script>
	function base_check(){
		var now_1base = opener.document.getElementById("base1").textContent;
		var now_2base = opener.document.getElementById("base2").textContent;
		var now_3base = opener.document.getElementById("base3").textContent;
		if(now_1base == "1루"){
			document.getElementById('base1').style.display = "none";
		}
		if(now_2base == "2루"){
			document.getElementById('base2').style.display = "none";
		}
		if(now_3base == "3루"){
			document.getElementById('base3').style.display = "none";
		}
	}
</script>
	<form>
		<table class="hitmap">
			<tr>
				<th>상좌</th>
				<th>상</th>
				<th>상우</th>
			</tr>
			<tr>
				<th>중좌</th>
				<th>중</th>
				<th>중우</th>
			</tr>
			<tr>
				<th>하좌</th>
				<th>하</th>
				<th>하우</th>
			</tr>
		</table>
		<div id="hitter" style="margin-left:20px">
			<h4>타자 진루 상황</h4>
			<div class="row">
				<input type="radio" id="hitter_radio_1" name="hitter_radio" value="1">
				<label for="hitter_radio_2">1루 진루</label>
				<input type="radio" id="hitter_radio_2" name="hitter_radio" value="2">
				<label for="hitter_radio_2">2루 진루</label>
				<input type="radio" id="hitter_radio_3" name="hitter_radio" value="3">
				<label for="hitter_radio_3">3루 진루</label>
				<input type="radio" id="hitter_radio_h" name="hitter_radio" value="h">
				<label for="hitter_radio_h">Ground-HomeRun</label>
			</div>
		</div>
		<div id="base1" style="margin-left:20px">
			<h4>1루 주자 상황</h4>
			<div class="row">
				<input type="radio" id="base1_radio_2" name="base1_radio" value="2">
				<label for="base1_radio_2">2루 진루</label>
				<input type="radio" id="base1_radio_3" name="base1_radio" value="3">
				<label for="base1_radio_3">3루 진루</label>
				<input type="radio" id="base1_radio_h" name="base1_radio" value="h">
				<label for="base1_radio_h">Home-In</label>
				<input type="radio" id="base1_radio_o" name="base1_radio" value="o">
				<label for="base1_radio_o">Out</label>
			</div>
		</div>
		<div id="base2" style="margin-left:20px">
			<h4>2루 주자 상황</h4>
			<div class="row">
				<input type="radio" id="base2_radio_3" name="base2_radio" value="3">
				<label for="base2_radio_3">3루 진루</label>
				<input type="radio" id="base2_radio_h" name="base2_radio" value="h">
				<label for="base2_radio_h">Home-In</label>
				<input type="radio" id="base2_radio_o" name="base2_radio" value="o">
				<label for="base2_radio_o">Out</label>
			</div>
		</div>
		<div id="base3" style="margin-left:20px">
			<h4>3루 주자 상황</h4>
			<div class="row">
				<input type="radio" id="base3_radio_h" name="base3_radio" value="h">
				<label for="base3_radio_h">Home-In</label>
				<input type="radio" id="base3_radio_o" name="base3_radio" value="o">
				<label for="base3_radio_o">Out</label>
			</div>
		</div>
	</form>
	<h1 id="test">test</h1>
</body>
</html>
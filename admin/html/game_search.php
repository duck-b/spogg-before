<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php
	include "inc/_head.html";
	include "inc/_script.html";
?>

	<script type="text/javascript">
	var game = "<? echo $_GET['kind']?>";
	function search_bt(){
		adrs = document.game_search_option.adrs.value;
		sdate = document.game_search_option.s_game_date.value;
		edate = document.game_search_option.e_game_date.value;
		opener.location.href="game.html?game="+ game +"&option=search&adrs=" + adrs + "&sdate=" + sdate + "&edate=" + edate;
		self.close();
	}
	function cancle(){
		window.close();
	}
	</script>
	<body>
	<form name="game_search_option" method="post" style="margin-left:30px;margin-right:30px">
		<p style="font-size:150%">상세 검색</p>
		<div class="row">
			<div class="col-md-2 form-group">
				<label for="adrs">지역</label>
			</div>
			<div class="col-md-10 form-group">
				<select class="custom-select" id="adrs" name="adrs">
					<option value="" selected>선택해 주세요</option>
					<option value="1">서울</option>
					<option value="2">경기</option>
					<option value="3">강원</option>
					<option value="4">충청</option>
					<option value="5">전라</option>
					<option value="6">경상</option>
					<option value="7">제주</option>
				</select>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-2 form-group">
				<label>경기날짜</label>
			</div>
			<div class="col-md-4 form-group">
				<input type="date" name="s_game_date" id="s_game_date" class="form-control " min="1900-01-01" max="2200-12-31" required>
			</div>
			<div class="col-md-2" style="text-align:center">~</div>
			<div class="col-md-4 form-group">
				<input type="date" name="e_game_date" id="e_game_date" class="form-control " min="1900-01-01" max="2200-12-31" required>
			</div>
		</div>	
		<hr>
		<div class="row">
			<div class="col-xs-2">
				<input class="btn btn-primary" type="button" onclick="search_bt()" style="margin-right:5px" value="검색">
			</div>
			<div class="col-xs-2">
				<input class="btn btn-primary" type="button" onclick="cancle()" style="margin-right:5px" value="취소">
			</div>
		</div>
	</form>
	</body>
</html>
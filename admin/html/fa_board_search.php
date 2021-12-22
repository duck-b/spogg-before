<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php
	include "inc/_head.html";
	include "inc/_script.html";
?>

	<script type="text/javascript">
	function search_bt(){
		//window.opener.document.search-form.pos_option.value = document.fa_search_option.position.value;
		//window.opener.document.search-form.adrs_option.value = document.fa_search_option.adrs.value;
		//window.opener.document.search-form.age_option.value = document.fa_search_option.age.value;
		//window.opener.document.search-form.option.value = "search";
		position = document.fa_search_option.positions.value;
		age = document.fa_search_option.age.value;
		adrs = document.fa_search_option.adrs.value;
		opener.location.href="board.html?board=fa&option=search&position=" + position + "&age=" + age + "&adrs=" + adrs;
		self.close();
	}
	function cancle(){
		window.close();
	}
	function postion_check(pos){
		positions = document.getElementById("positions").value;
		if(positions){
			positions = positions + "|" + pos;
			document.getElementById("positions").value = positions;
		}else{
			document.getElementById("positions").value = pos;
		}
	}
	</script>
	<body>
	<form name="fa_search_option" method="post" style="margin-left:30px;margin-right:30px">
		<p style="font-size:150%">상세 검색</p>
		<div class="row">
			<div class="col-md-2 form-group">
				포지션
			</div>
			<div class="row col-md-10 form-group" style="padding-left:30px">
				<div class="col-md-4 custom-control custom-checkbox">
					<input type="checkbox" id="position_p" name="position[]" value="1" onclick="postion_check(1)"  class="custom-control-input">
					<label class="custom-control-label" for="position_p">투수</label>
				</div>
				<div class="col-md-4 custom-control custom-checkbox">
					<input type="checkbox" id="position_c" name="position[]" value="2" onclick="postion_check(2)" class="custom-control-input">
					<label class="custom-control-label" for="position_c">포수</label>
				</div>
				<div class="col-md-4 custom-control custom-checkbox">
					<input type="checkbox" id="position_1b" name="position[]" value="3" onclick="postion_check(3)" class="custom-control-input">
					<label class="custom-control-label" for="position_1b">1루수</label>
				</div>
			</div>
			<div class="col-md-2 form-group"> </div>
			<div class="row col-md-10 form-group" style="padding-left:30px">
				<div class="col-md-4 custom-control custom-checkbox">
					<input type="checkbox" id="position_2b" name="position[]" value="4" onclick="postion_check(4)" class="custom-control-input">
					<label class="custom-control-label" for="position_2b">2루수</label>
				</div>
				<div class="col-md-4 custom-control custom-checkbox">
					<input type="checkbox" id="position_3b" name="position[]" value="5" onclick="postion_check(5)" class="custom-control-input">
					<label class="custom-control-label" for="position_3b">3루수</label>
				</div>
				<div class="col-md-4 custom-control custom-checkbox">
					<input type="checkbox" id="position_ss" name="position[]" value="6" onclick="postion_check(6)" class="custom-control-input">
					<label class="custom-control-label" for="position_ss">유격수</label>
				</div>
			</div>
			<div class="col-md-2 form-group"> </div>
			<div class="row col-md-10 form-group" style="padding-left:30px">
				<div class="col-md-4 custom-control custom-checkbox">
					<input type="checkbox" id="position_lf" name="position[]" value="7" onclick="postion_check(7)" class="custom-control-input">
					<label class="custom-control-label" for="position_lf">좌익수</label>
				</div>
				<div class="col-md-4 custom-control custom-checkbox">
					<input type="checkbox" id="position_cf" name="position[]" value="8" onclick="postion_check(8)" class="custom-control-input">
					<label class="custom-control-label" for="position_cf">중익수</label>
				</div>
				<div class="col-md-4 custom-control custom-checkbox">
					<input type="checkbox" id="position_rf" name="position[]" value="9" onclick="postion_check(9)" class="custom-control-input">
					<label class="custom-control-label" for="position_rf">우익수</label>
				</div>
			</div>
		</div>
		<input type="hidden" value="" id="positions" name="position">
		<hr>
		<div class="row">
			<div class="col-md-2 form-group">
				<label for="adrs">지역</label>
			</div>
			<div class="col-md-10 form-group">
				<select class="custom-select" id="adrs" name="adrs">
					<option value="" selected>선택해 주세요</option>
					<option value="1">서울</option>
					<option value="2">부산</option>
					<option value="3">대구</option>
					<option value="4">인천</option>
					<option value="5">광주</option>
					<option value="6">대전</option>
					<option value="7">울산</option>
				</select>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-2 form-group">
				<label for="age">연령대</label>
			</div>
			<div class="col-md-10 form-group">
				<select class="custom-select" id="age" name="age">
					<option value="" selected>선택해 주세요</option>
					<option value="20">10대</option>
					<option value="30">20대</option>
					<option value="40">30대</option>
					<option value="50">40대</option>
					<option value="51">50대 이상</option>
				</select>
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
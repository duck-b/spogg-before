<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php
	include "inc/_head.html";
	include "inc/_script.html";
	include "dbconn.php";
	$user_no = $_SESSION['user_no'];
	$game_no = $_GET['no'];
	$game_result = mysqli_query($conn,"SELECT * FROM game WHERE no ='$game_no'");
	$game_row = mysqli_fetch_array($game_result);
	if($user_no == $game_row['user']){
		$pos = $_GET['pos'];
		if($pos == 1){
			$pos_name = "홈 선발투수";
		}else if($pos == 2){
			$pos_name = "홈 포수";
		}else if($pos == 3){
			$pos_name = "홈 1루수";
		}else if($pos == 4){
			$pos_name = "홈 2루수";
		}else if($pos == 5){
			$pos_name = "홈 3루수";			
		}else if($pos == 6){
			$pos_name = "홈 유격수";
		}else if($pos == 7){
			$pos_name = "홈 좌익수";
		}else if($pos == 8){
			$pos_name = "홈 중익수";
		}else if($pos == 9){
			$pos_name = "홈 우익수";
		}else if($pos == 10){
			$pos_name = "홈 구원/지명";
		}else if($pos == 11){
			$pos_name = "원정 선발투수";
		}else if($pos == 12){
			$pos_name = "원정 포수";
		}else if($pos == 13){
			$pos_name = "원정 1루수";
		}else if($pos == 14){
			$pos_name = "원정 2루수";
		}else if($pos == 15){
			$pos_name = "원정 3루수";
		}else if($pos == 16){
			$pos_name = "원정 유격수";
		}else if($pos == 17){
			$pos_name = "원정 좌익수";
		}else if($pos == 18){
			$pos_name = "원정 중익수";
		}else if($pos == 19){
			$pos_name = "원정 우익수";
		}else if($pos == 20){
			$pos_name = "원정 구원/지명";
		}
		$merc_result = mysqli_query($conn,"SELECT * FROM game_merc WHERE game ='$game_no' AND position = '$pos' ORDER BY created_at ASC");
		$now_result = mysqli_query($conn,"SELECT * FROM game_merc WHERE game ='$game_no' AND position = '$pos' AND states = '1'");
		$now_row = mysqli_fetch_array($now_result);
	}
?>

	<script type="text/javascript">
	var now_no = "<? echo $now_row['no'];?>";
	function search_bt(){
		merc_no = document.user_merc.game.value;
		if(merc_no != 0){
			opener.location.href="GameUpdateProc.php?kind=mercplayer&no=" + merc_no;
			self.close();
		}else{
			window.close();
		}
	}
	function cancle(){
		window.close();
	}
	function change_user(){
		game_search_no = document.user_merc.game.value;
		if(game_search_no != 0){
			if(game_search_no != now_no){
				search_user_no = document.getElementById("game_" + game_search_no).value;
				document.getElementById("user_info").innerHTML = "<a class='btn btn-primary btn-sm' href='javascript:;' onclick='new_page("+ search_user_no +")' role='button'>정보</a>";
			}else{
				document.getElementById("user_info").innerHTML = "<a class='btn btn-secondary btn-sm disabled' href='javascript:;' role='button'>정보</a>";
			}
		}else{
			document.getElementById("user_info").innerHTML = "<a class='btn btn-secondary btn-sm disabled' href='javascript:;' role='button'>정보</a>";
		}
	}
	function new_page(no){
			window.open("user.html?user=info&no=" + no,
			"user-info","left=200, top=200, width=1200, height=700, scrollbars=no,resizable=yes");
	}
	</script>
	<body>
	<? if($user_no == $game_row['user']){?>
	<form name="user_merc" method="post" style="margin-left:30px;margin-right:30px;margin-top:10px">
		<p style="font-size:150%">용병 경기 관리 (<? echo $pos_name;?>)</p>
		<div class="row">
			<div class="col-md-1 form-group">
				<label for="game">선수</label>
			</div>
			<div class="col-md-9 form-group">
				<select class="custom-select" id="game" name="game" onchange='change_user()'>
					<? if($now_row){ ?>
					<option value="<? echo $now_row['no']?>">취소</option>
						<? while($merc_row = mysqli_fetch_array($merc_result)){
						$merc_user_no = $merc_row['user'];
						$merc_user_result = mysqli_query($conn,"SELECT * FROM user WHERE no ='$merc_user_no'");
						$merc_user_row = mysqli_fetch_array($merc_user_result); ?>
							<? if($merc_user_no == $now_row['user']){?>
					<option value="<? echo $merc_row['no']?>" selected><? echo $merc_user_row['name']?> / <? echo $merc_row['created_at'];?></option>
							<? } else { ?>
					<option value="<? echo $merc_row['no']?>"><? echo $merc_user_row['name']?> / <? echo $merc_row['created_at'];?></option>
							<? } ?>
						<? } ?>
					<? } else { ?>
					<option value="0" selected>선택해 주세요</option>
						<? while($merc_row = mysqli_fetch_array($merc_result)){
						$merc_user_no = $merc_row['user'];
						$merc_user_result = mysqli_query($conn,"SELECT * FROM user WHERE no ='$merc_user_no'");
						$merc_user_row = mysqli_fetch_array($merc_user_result); ?>
					<option value="<? echo $merc_row['no']?>"><? echo $merc_user_row['name']?> / <? echo $merc_row['created_at'];?></option>
						<? } ?>
					<? } ?>
				</select>
			</div>
			<?$merc_result = mysqli_query($conn,"SELECT * FROM game_merc WHERE game ='$game_no' AND position = '$pos' ORDER BY created_at ASC");
				while($merc_row = mysqli_fetch_array($merc_result)){ ?>
				<input type="hidden" id="game_<? echo $merc_row['no'];?>" name="game_<? echo $merc_row['no'];?>" value="<? echo $merc_row['user'];?>">
			<? } ?>
			<div class="col-md-2" style="text-align:center;vertical-align:middle;" id="user_info">
				<? if(!$now_row['user']){?>
				<a class="btn btn-secondary btn-sm disabled" href="javascript:;" role="button">정보</a>
				<? } else {?>
				<a class="btn btn-primary btn-sm" href="javascript:;" onclick="new_page(<? echo $now_row['user']?>)" role="button">정보</a>
				<? } ?>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-xs-2">
				<input class="btn btn-primary" type="button" onclick="search_bt()" style="margin-right:5px" value="수정">
			</div>
			<div class="col-xs-2">
				<input class="btn btn-primary" type="button" onclick="cancle()" style="margin-right:5px" value="취소">
			</div>
		</div>
	</form>
	<? } ?>
	</body>
</html>
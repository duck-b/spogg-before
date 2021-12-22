<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php
	include "inc/_head.html";
	include "inc/_script.html";
	$event_true = 1;
	$no = $_GET['no'];
	$pos = $_GET['pos'];
	
	include "dbconn.php";
	session_start();
	if($_POST['insert']){
		if($_POST['pos'] == 'hit'){
			$team_name = $_POST['team_name'];
			$league_name = $_POST['league_name'];
			$at_game = $_POST['at_game'];
			$at_play = $_POST['at_play'];
			$at_bat = $_POST['at_bat'];
			if($team_name != null && $league_name != null && $at_game != null && $at_play != null && $at_bat != null ){
				$player_no = $_SESSION['player_no'];
				$hit1 = $_POST['hit'] - $_POST['hit2'] - $_POST['hit3'] - $_POST['hr'];
				$hit2 = $_POST['hit2'];
				$hit3 = $_POST['hit3'];
				$hr = $_POST['hr'];
				$rs = $_POST['rs'];
				$rbi = $_POST['rbi'];
				$sb = $_POST['sb'];
				$so = $_POST['so'];
				$sh = $_POST['sh'];
				$sf = $_POST['sf'];
				$b4 = $_POST['b4'] - $_POST['hbp'];
				$hbp = $_POST['hbp'];
				mysqli_query($conn,"INSERT INTO data_before_hit (player_no ,team_name, league_name, at_game, at_play, at_bat, hit1, hit2, hit3, hr, rs, rbi, sb, so, sh, sf, b4, hbp) VALUES ('$player_no', '$team_name', '$league_name', '$at_game', '$at_play', '$at_bat', '$hit1', '$hit2', '$hit3', '$hr', '$rs', '$rbi', '$sb', '$so', '$sh', '$sf', '$b4', '$hbp')");
				echo "<script>alert('입력이 완료 되었습니다.');</script>";
				echo "<script>opener.document.location.reload();</script>";
				echo "<script>self.close();</script>";
			}else{
				echo "<script>alert('모두 입력되어야 합니다.');</script>";
				echo "<script>history.back();</script>";
			}
		}else if($_POST['pos'] == 'pic'){
			$team_name = $_POST['team_name'];
			$league_name = $_POST['league_name'];
			$at_game = $_POST['at_game'];
			$inning = $_POST['inning']*3 + $_POST['inning_2'];
			if($team_name != null && $league_name != null && $at_game != null && $inning != 0){
				$player_no = $_SESSION['player_no'];
				$play_win = $_POST['play_win'];
				$play_lose = $_POST['play_lose'];
				$play_save = $_POST['play_save'];
				$play_hold = $_POST['play_hold'];
				$pitcher_count = $_POST['pitcher_count'];
				$hit1 = $_POST['hit'] - $_POST['hit2'] - $_POST['hit3'] - $_POST['hr'];
				$hit2 = $_POST['hit2'];
				$hit3 = $_POST['hit3'];
				$hr = $_POST['hr'];
				$er = $_POST['er'];
				$so = $_POST['so'];
				$sh = $_POST['sh'];
				$sf = $_POST['sf'];
				$b4 = $_POST['b4'] - $_POST['hbp'];
				$hbp = $_POST['hbp'];
				$at_play = $_POST['at_play'];
				$at_bat = $_POST['at_play'] - $_POST['b4'] - $_POST['hbp'] - $_POST['sh'] - $_POST['sf'];
				mysqli_query($conn,"INSERT INTO data_before_pic (player_no, team_name, league_name, at_game, inning, play_win, play_lose, play_save, play_hold, pitcher_count, so, hit1, hit2, hit3, hr, er, b4, hbp, at_play, at_bat, sh, sf) VALUES ('$player_no', '$team_name', '$league_name', '$at_game', '$inning', '$play_win', '$play_lose', '$play_save', '$play_hold', '$pitcher_count', '$so', '$hit1', '$hit2', '$hit3', '$hr', '$er', '$b4', '$hbp', '$at_play', '$at_bat', '$sh', '$sf')");
				echo "<script>alert('입력이 완료 되었습니다.');</script>";
				echo "<script>opener.document.location.reload();</script>";
				echo "<script>self.close();</script>";
			}
		}
	}else{
		$player_no = $_SESSION['player_no'];
		$team_count_result = mysqli_query($conn,"SELECT COUNT(*) as count FROM team_members WHERE player='$player_no' AND states='1'");
		$team_count_row = mysqli_fetch_array($team_count_result);
		if($team_count_row['count'] >= 1){
			$team_result = mysqli_query($conn,"SELECT team.name as team_name FROM team_members JOIN team WHERE team_members.player='$player_no' AND team_members.states='1' AND team_members.team = team.no");
		}
	}
	mysqli_close($conn);
?>

	<script type="text/javascript">
		function cancle(){
			window.close();
		}
	</script>
	<body>
		<? if($no == $_SESSION['user_no']){?>
		<form name="search_id_form" style="text-align: center;margin:5%" action="insert_record.php" method="post">
			<h3>기록 입력</h3>
			<? if($event_true == 1){?>
			<h6>(기록 입력 기간 : 2019-05-08 ~ 2020-05-09)</h6>
			<p style="color:red">※ 잘못된 정보 입력시 경고 없이 삭제 될 수 있습니다.</p>
			<div class="row">
				<div class="col-2 form-group">
					<label for="team">팀</label>
				</div>
				<div class="col-4 form-group">
					<select class="custom-select" id="team_name" name="team_name">
						<? if($team_count_row['count'] == 0){?>
						<option value="0" selected>소속된 팀이 없습니다</option>
						<? } else { ?>
						<option value="0" selected>선택해 주세요 / 필수 선택</option>
							<?while ($team_row = mysqli_fetch_array($team_result)){?>
						<option value="<?=$team_row['team_name']?>"><?=$team_row['team_name']?></option>							
							<? } ?>
						<? } ?>
					</select>
				</div>
				<div class="col-2 form-group">
					<label for="league_name">리그 명</label>
				</div>
				<div class="col-4 form-group">
					<input type="text" name="league_name" id="league_name" class="form-control " placeholder="리그명을 입력해 주세요 / 필수 입력" required>
				</div>
			</div><hr>
			<p>※ 필수 입력인 기록을 제외하고 기록을 알 수 없는 경우는 <b style="color:red">0이 아닌 공백</b>입력, 기록 모두 <b style="color:red">숫자만 입력</b></p>
				<?if($pos == 'hit'){?>
				<div class="row">
					<div class="col-1 form-group">
						<label for="at_game">경기 수</label>
					</div>
					<div class="col-3 form-group">
						<input type="text" name="at_game" id="at_game" class="form-control " placeholder="필수 입력" pattern="\d{1,3}" required>
					</div>
					<div class="col-1 form-group">
						<label for="at_play">타석</label>
					</div>
					<div class="col-3 form-group">
						<input type="text" name="at_play" id="at_play" class="form-control " placeholder="필수 입력" pattern="\d{1,3}" required>
					</div>
					<div class="col-1 form-group">
						<label for="at_bat">타수</label>
					</div>
					<div class="col-3 form-group">
						<input type="text" name="at_bat" id="at_bat" class="form-control " placeholder="필수 입력" pattern="\d{1,3}" required>
					</div>
				</div>
				<div class="row">
					<div class="col-1 form-group">
						<label for="rbi">타점</label>
					</div>
					<div class="col-3 form-group">
						<input type="text" name="rbi" id="rbi" class="form-control " placeholder="필수 입력" pattern="\d{1,3}" required>
					</div>
					<div class="col-1 form-group">
						<label for="rs">득점</label>
					</div>
					<div class="col-3 form-group">
						<input type="text" name="rs" id="rs" class="form-control " placeholder="필수 입력" pattern="\d{1,3}" required>
					</div>
					<div class="col-1 form-group">
						<label for="hit">안타</label>
					</div>
					<div class="col-3 form-group">
						<input type="text" name="hit" id="hit" class="form-control " placeholder="1, 2, 3루타 홈런 전체 개수 / 필수 입력" pattern="\d{1,3}" required>
					</div>
				</div>
				<div class="row">
					<div class="col-1 form-group">
						<label for="hit2">2루타</label>
					</div>
					<div class="col-3 form-group">
						<input type="text" name="hit2" id="hit2" class="form-control " placeholder="필수 입력" pattern="\d{1,3}" required>
					</div>
					<div class="col-1 form-group">
						<label for="hit3">3루타</label>
					</div>
					<div class="col-3 form-group">
						<input type="text" name="hit3" id="hit3" class="form-control " placeholder="필수 입력" pattern="\d{1,3}" required>
					</div>
					<div class="col-1 form-group">
						<label for="hr">홈런</label>
					</div>
					<div class="col-3 form-group">
						<input type="text" name="hr" id="hr" class="form-control " placeholder="필수 입력" pattern="\d{1,3}" required>
					</div>
				</div>
				<div class="row">
					<div class="col-1 form-group">
						<label for="sh">번트</label>
					</div>
					<div class="col-3 form-group">
						<input type="text" name="sh" id="sh" class="form-control " placeholder="" pattern="\d{1,3}">
					</div>
					<div class="col-1 form-group">
						<label for="sf">희생타</label>
					</div>
					<div class="col-3 form-group">
						<input type="text" name="sf" id="sf" class="form-control " placeholder="" pattern="\d{1,3}">
					</div>
					<div class="col-1 form-group">
						<label for="so">삼진</label>
					</div>
					<div class="col-3 form-group">
						<input type="text" name="so" id="so" class="form-control " placeholder="필수 입력" pattern="\d{1,3}" required>
					</div>
				</div>
				<div class="row">
					<div class="col-1 form-group">
						<label for="b4">볼넷</label>
					</div>
					<div class="col-3 form-group">
						<input type="text" name="b4" id="b4" class="form-control " placeholder="사사구 포함 / 필수 입력" pattern="\d{1,3}" required>
					</div>
					<div class="col-1 form-group">
						<label for="hbp">사사구</label>
					</div>
					<div class="col-3 form-group">
						<input type="text" name="hbp" id="hbp" class="form-control " placeholder="" pattern="\d{1,3}">
					</div>
					<div class="col-1 form-group">
						<label for="sb">도루</label>
					</div>
					<div class="col-3 form-group">
						<input type="text" name="sb" id="sb" class="form-control " placeholder="필수 입력" pattern="\d{1,3}" required>
					</div>
				</div>
				<? } else if($pos == 'pic'){ ?>
				<div class="row">
					<div class="col-1 form-group">
						<label for="at_game">경기 수</label>
					</div>
					<div class="col-3 form-group">
						<input type="text" name="at_game" id="at_game" class="form-control " placeholder="필수 입력" pattern="\d{1,3}" required>
					</div>
					<div class="col-1 form-group">
						<label for="inning">이닝</label>
					</div>
					<div class="col-2 form-group">
						<input type="text" name="inning" id="inning" class="form-control " placeholder="필수 입력" pattern="\d{1,3}" required>
					</div>
					<div class="col-1 form-group">
						<select class="custom-select" id="inning_2" name="inning_2">
							<option value="0" selected>0</option>
							<option value="1" style="font-size:130%">⅓</option>
							<option value="2" style="font-size:130%">⅔</option>
						</select>
					</div>
					<div class="col-1 form-group">
						<label for="pitcher_count">투구 수</label>
					</div>
					<div class="col-3 form-group">
						<input type="text" name="pitcher_count" id="pitcher_count" class="form-control " placeholder="" pattern="\d{1,4}">
					</div>
				</div>
				<div class="row">
					<div class="col-1 form-group">
						<label for="play_win">승리</label>
					</div>
					<div class="col-3 form-group">
						<input type="text" name="play_win" id="play_win" class="form-control " placeholder="필수 입력" pattern="\d{1,3}" required>
					</div>
					<div class="col-1 form-group">
						<label for="play_lose">패배</label>
					</div>
					<div class="col-3 form-group">
						<input type="text" name="play_lose" id="play_lose" class="form-control " placeholder="필수 입력" pattern="\d{1,3}" required>
					</div>
					<div class="col-1 form-group">
						<label for="play_save">세이브</label>
					</div>
					<div class="col-3 form-group">
						<input type="text" name="play_save" id="play_save" class="form-control " placeholder="필수 입력" pattern="\d{1,3}" required>
					</div>
				</div>
				<div class="row">
					<div class="col-1 form-group">
						<label for="play_hold">홀드</label>
					</div>
					<div class="col-3 form-group">
						<input type="text" name="play_hold" id="play_hold" class="form-control " placeholder="필수 입력" pattern="\d{1,3}" required>
					</div>
					<div class="col-1 form-group">
						<label for="hit">피안타</label>
					</div>
					<div class="col-3 form-group">
						<input type="text" name="hit" id="hit" class="form-control " placeholder="1, 2, 3루타 홈런 전체 개수 / 필수 입력" pattern="\d{1,3}" required>
					</div>
					<div class="col-1 form-group">
						<label for="hr">피홈런</label>
					</div>
					<div class="col-3 form-group">
						<input type="text" name="hr" id="hr" class="form-control " placeholder="필수 입력" pattern="\d{1,3}" required>
					</div>
				</div>
				<div class="row">
					<div class="col-1 form-group">
						<label for="hit2">2루타</label>
					</div>
					<div class="col-3 form-group">
						<input type="text" name="hit2" id="hit2" class="form-control " placeholder="" pattern="\d{1,3}">
					</div>
					<div class="col-1 form-group">
						<label for="hit3">3루타</label>
					</div>
					<div class="col-3 form-group">
						<input type="text" name="hit3" id="hit3" class="form-control " placeholder="" pattern="\d{1,3}">
					</div>
					<div class="col-1 form-group">
						<label for="so">탈삼진</label>
					</div>
					<div class="col-3 form-group">
						<input type="text" name="so" id="so" class="form-control " placeholder="" pattern="\d{1,3}" required>
					</div>
				</div>
				<div class="row">
					<div class="col-1 form-group">
						<label for="b4">볼넷</label>
					</div>
					<div class="col-3 form-group">
						<input type="text" name="b4" id="b4" class="form-control " placeholder="사사구 포함 / 필수 입력" pattern="\d{1,3}" required>
					</div>
					<div class="col-1 form-group">
						<label for="hbp">사사구</label>
					</div>
					<div class="col-3 form-group">
						<input type="text" name="hbp" id="hbp" class="form-control " placeholder="" pattern="\d{1,3}">
					</div>
					<div class="col-1 form-group">
						<label for="er">실점</label>
					</div>
					<div class="col-3 form-group">
						<input type="text" name="er" id="er" class="form-control " placeholder="실점 또는 자책점 / 필수 입력" pattern="\d{1,3}" required>
					</div>
				</div>
				<div class="row">
					<div class="col-1 form-group">
						<label for="at_play">타자수</label>
					</div>
					<div class="col-3 form-group">
						<input type="text" name="at_play" id="at_play" class="form-control " placeholder="상대한 타자 수(타석)" pattern="\d{1,3}">
					</div>
					<div class="col-1 form-group">
						<label for="sh">번트</label>
					</div>
					<div class="col-3 form-group">
						<input type="text" name="sh" id="sh" class="form-control " placeholder="" pattern="\d{1,3}">
					</div>
					<div class="col-1 form-group">
						<label for="sf">희생타</label>
					</div>
					<div class="col-3 form-group">
						<input type="text" name="sf" id="sf" class="form-control " placeholder="" pattern="\d{1,3}">
					</div>
				</div>
				<? } ?>
			<hr>
			<input type="hidden" name="pos" value="<?=$pos?>">
			<input type="hidden" name="no" value="<?=$no?>">
			<input type="hidden" name="insert" value="yes">
			<div class="row">
				<div class="col-6">
					<input type="submit" value="등록" class="btn btn-primary" style="width:100%">
				</div>
				<div class="col-6">
					<input class="btn btn-primary" style="width:100%" type="button" onclick="cancle()" value="취소">
				</div>
			</div>
			<? } else {?>
			<h6>(기록 입력 기간이 아닙디다)</h6>
			<hr>
			<div class="row">
				<div class="col-3"></div>
				<div class="col-6">
					<input class="btn btn-primary" style="width:100%" type="button" onclick="cancle()" value="취소">
				</div>
				<div class="col-3"></div>
			</div>
			<? } ?>
		</form>
		<? } else { ?>
		<? echo $no.",".$_SESSION['user_no']?>
		<h3 style="text-align:center;margin-top:5px">잘못된 접근입니다</h3>
		<hr>
		<div class="row">
			<div class="col-3"></div>
			<div class="col-6">
				<input class="btn btn-primary" style="width:100%" type="button" onclick="cancle()" value="취소">
			</div>
			<div class="col-3"></div>
		</div>
		<? } ?>
	</body>
</html>
<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php
	include "inc/_head.html";
	include "inc/_script.html";
	session_start();
	if(strtotime(date("Y-m-d H:i:s")) < strtotime($play_row['play_datetime'])){
		echo "<script>alert('경기가 시작되어 변경이 불가능 합니다.');</script>";
		echo "<script>window.close();</script>";
	}
	$player_no = $_SESSION['player_no'];
	$user_no = $_SESSION['user_no'];
	$no = $_GET['no'];
	if($no){
		$hoaw = $_GET['hoaw'];
		include "dbconn.php";
		$play_result = mysqli_query($conn, "SELECT * FROM play WHERE no='$no'");
		$play_row = mysqli_fetch_array($play_result);
		if($hoaw == 1){
			$team_no = $play_row['home_team'];
			$hoaw_text = 'Home 경기';
		}else if($hoaw == 0){
			$team_no = $play_row['away_team'];
			$hoaw_text = 'Away 경기';
		}
		$team_result = mysqli_query($conn, "SELECT * FROM team WHERE no='$team_no'");
		$team_row = mysqli_fetch_array($team_result);
		
		$entry_result = mysqli_query($conn, "SELECT * FROM play_entry WHERE play='$no' AND hoaw = '$hoaw'");
		$entry_row = mysqli_fetch_array($entry_result);
		if(!$entry_row){
			$insert = "yes";
			$button_txt = "완료";
			$member_select = "<option value='' selected>선수 선택</option>";
			$members_result = mysqli_query($conn,"SELECT * FROM team_members WHERE team='$team_no' AND states = '1'");
			while($members_row = mysqli_fetch_array($members_result)){
				$members_player_no = $members_row['player'];
				$members_player_result = mysqli_query($conn,"SELECT * FROM player where no='$members_player_no'");
				$members_player_row = mysqli_fetch_array($members_player_result);
				$members_user_no = $members_player_row['user'];
				$members_user_result = mysqli_query($conn,"SELECT * FROM user where no='$members_user_no'");
				$members_user_row = mysqli_fetch_array($members_user_result);
				if(mb_strlen($members_row['back_num'], 'UTF-8') == 2){
					$back_num = $members_row['back_num'].". ";
				}else{
					$back_num = "0".$members_row['back_num'].". ";
				}
				$member_select = $member_select."<option value='".$members_row['no']."'>".$back_num.$members_user_row['name']."</option>";
			}
			$pos_select = "<option value='' selected>포지션 선택</option>
							<option value='1'>투수</option>
							<option value='2'>포수</option>
							<option value='3'>1루수</option>
							<option value='4'>2루수</option>
							<option value='5'>3루수</option>
							<option value='6'>유격수</option>
							<option value='7'>좌익수</option>
							<option value='8'>중견수</option>
							<option value='9'>우익수</option>
							<option value='10'>지명타자</option>";
		}else{
			$insert = "edit";
			$button_txt = "수정";
			$entry_pic_result = mysqli_query($conn, "SELECT * FROM play_entry WHERE play='$no' AND hoaw = '$hoaw' AND position = '1'");
			$entry_pic_row = mysqli_fetch_array($entry_pic_result);
			if(!$entry_pic_row){
				$members_result = mysqli_query($conn,"SELECT * FROM team_members WHERE team='$team_no' AND states = '1'");
				$pic_select = "<option value='0' selected>선수 선택</option>";
				while($members_row = mysqli_fetch_array($members_result)){
					$members_player_no = $members_row['player'];
					$members_player_result = mysqli_query($conn,"SELECT * FROM player where no='$members_player_no'");
					$members_player_row = mysqli_fetch_array($members_player_result);
					$members_user_no = $members_player_row['user'];
					$members_user_result = mysqli_query($conn,"SELECT * FROM user where no='$members_user_no'");
					$members_user_row = mysqli_fetch_array($members_user_result);
					if(mb_strlen($members_row['back_num'], 'UTF-8') == 2){
						$back_num = $members_row['back_num'].". ";
					}else{
						$back_num = "0".$members_row['back_num'].". ";
					}
					$pic_select = $pic_select."<option value='".$members_row['no']."'>".$back_num.$members_user_row['name']."</option>";
				}
			}else{
				$members_result = mysqli_query($conn,"SELECT * FROM team_members WHERE team='$team_no' AND states = '1'");
				while($members_row = mysqli_fetch_array($members_result)){
					$members_player_no = $members_row['player'];
					$members_player_result = mysqli_query($conn,"SELECT * FROM player where no='$members_player_no'");
					$members_player_row = mysqli_fetch_array($members_player_result);
					$members_user_no = $members_player_row['user'];
					$members_user_result = mysqli_query($conn,"SELECT * FROM user where no='$members_user_no'");
					$members_user_row = mysqli_fetch_array($members_user_result);
					if(mb_strlen($members_row['back_num'], 'UTF-8') == 2){
						$back_num = $members_row['back_num'].". ";
					}else{
						$back_num = "0".$members_row['back_num'].". ";
					}
					if($members_row['no'] == $entry_pic_row['team_member']){
						$pic_select = $pic_select."<option value='".$members_row['no']."' selected>".$back_num.$members_user_row['name']."</option>";
					}else{
						$pic_select = $pic_select."<option value='".$members_row['no']."'>".$back_num.$members_user_row['name']."</option>";
					}
				}
			}
			for ($i=1; $i<=9; $i++){
				$select1 = "";
				$select2 = "";
				$select3 = "";
				$select4 = "";
				$select5 = "";
				$select6 = "";
				$select7 = "";
				$select8 = "";
				$select9 = "";
				$select10 = "";
				$members_result = mysqli_query($conn,"SELECT * FROM team_members WHERE team='$team_no' AND states = '1'");
				$entry_result = mysqli_query($conn, "SELECT * FROM play_entry WHERE play='$no' AND hoaw = '$hoaw' AND turn = '$i'");
				$entry_row[$i] = mysqli_fetch_array($entry_result);
				if($entry_row[$i]['position'] != 0){
					if($entry_row[$i]['position'] == 1){
						$select1 = "selected";
					}else if($entry_row[$i]['position'] == 2){
						$select2 = "selected";
					}else if($entry_row[$i]['position'] == 3){
						$select3 = "selected";
					}else if($entry_row[$i]['position'] == 4){
						$select4 = "selected";
					}else if($entry_row[$i]['position'] == 5){
						$select5 = "selected";
					}else if($entry_row[$i]['position'] == 6){
						$select6 = "selected";
					}else if($entry_row[$i]['position'] == 7){
						$select7 = "selected";
					}else if($entry_row[$i]['position'] == 8){
						$select8 = "selected";
					}else if($entry_row[$i]['position'] == 9){
						$select9 = "selected";
					}else if($entry_row[$i]['position'] == 10){
						$select10 = "selected";
					}
					$pos_select[$i] = "<option value='1' $select1>투수</option>
							<option value='2' $select2>포수</option>
							<option value='3' $select3>1루수</option>
							<option value='4' $select4>2루수</option>
							<option value='5' $select5>3루수</option>
							<option value='6' $select6>유격수</option>
							<option value='7' $select7>좌익수</option>
							<option value='8' $select8>중견수</option>
							<option value='9' $select9>우익수</option>
							<option value='10' $select10>지명타자</option>";
					$member_select[$i] = "";
					while($members_row = mysqli_fetch_array($members_result)){
						$members_player_no = $members_row['player'];
						$members_player_result = mysqli_query($conn,"SELECT * FROM player where no='$members_player_no'");
						$members_player_row = mysqli_fetch_array($members_player_result);
						$members_user_no = $members_player_row['user'];
						$members_user_result = mysqli_query($conn,"SELECT * FROM user where no='$members_user_no'");
						$members_user_row = mysqli_fetch_array($members_user_result);
						if(mb_strlen($members_row['back_num'], 'UTF-8') == 2){
							$back_num = $members_row['back_num'].". ";
						}else{
							$back_num = "0".$members_row['back_num'].". ";
						}
						if($members_row['no'] == $entry_row[$i]['team_member']){
							$member_select[$i] = $member_select[$i]."<option value='".$members_row['no']."' selected>".$back_num.$members_user_row['name']."</option>";
						}else{
							$member_select[$i] = $member_select[$i]."<option value='".$members_row['no']."'>".$back_num.$members_user_row['name']."</option>";
						}
					}
				}else{
					$member_select[$i] = "<option value='' selected>선수 선택</option>";
					while($members_row = mysqli_fetch_array($members_result)){
						$members_player_no = $members_row['player'];
						$members_player_result = mysqli_query($conn,"SELECT * FROM player where no='$members_player_no'");
						$members_player_row = mysqli_fetch_array($members_player_result);
						$members_user_no = $members_player_row['user'];
						$members_user_result = mysqli_query($conn,"SELECT * FROM user where no='$members_user_no'");
						$members_user_row = mysqli_fetch_array($members_user_result);
						if(mb_strlen($members_row['back_num'], 'UTF-8') == 2){
							$back_num = $members_row['back_num'].". ";
						}else{
							$back_num = "0".$members_row['back_num'].". ";
						}
						$member_select[$i] = $member_select[$i]."<option value='".$members_row['no']."'>".$back_num.$members_user_row['name']."</option>";
					}
					$pos_select[$i] = "<option value='' selected>포지션 선택</option>
							<option value='1'>투수</option>
							<option value='2'>포수</option>
							<option value='3'>1루수</option>
							<option value='4'>2루수</option>
							<option value='5'>3루수</option>
							<option value='6'>유격수</option>
							<option value='7'>좌익수</option>
							<option value='8'>중견수</option>
							<option value='9'>우익수</option>
							<option value='10'>지명타자</option>";
				}
			}
		}
		
		if(!$user_no){
			echo "<script>alert('로그인이 필요한 기능입니다');</script>";
			echo "<script>window.close();</script>";
		}
		$class_result = mysqli_query($conn,"SELECT * FROM team_members WHERE player='$player_no' AND (class = '1' OR class = '2')");
		$class_row = mysqli_fetch_array($class_result);
		if(!$class_row){
			echo "<script>alert('감독 또는 코치만 가능한 기능입니다');</script>";
			echo "<script>window.close();</script>";
		}
		mysqli_close($conn);
	}
	if($_POST['insert'] == 'yes'){
		$no = $_POST['play'];
		$hoaw = $_POST['hoaw'];
		include "dbconn.php";
		$pic_save = "";
		for ($i=1; $i<=9; $i++){
			if($_POST['pos_turn'.$i] != 1){
				$team_members = $_POST['player_turn'.$i];
				$pos = $_POST['pos_turn'.$i];
				mysqli_query($conn,"INSERT INTO play_entry (play, team_member, hoaw, turn, position) VALUES ('$no', '$team_members', '$hoaw', '$i', '$pos')");
			}else if($_POST['pos_turn'.$i] == 1){
				$pic_save = "1";
				$team_members = $_POST['player_turn'.$i];
				mysqli_query($conn,"INSERT INTO play_entry (play, team_member, hoaw, turn, position) VALUES ('$no', '$team_members', '$hoaw', '$i', '1')");
			}
		}
		if($pic_save == ""){
			$player_pic = $_POST['player_pic'];
			mysqli_query($conn,"INSERT INTO play_entry (play, team_member, hoaw, turn, position) VALUES ('$no', '$player_pic', '$hoaw', '0', '1')");
		}
		mysqli_close($conn);
		echo "<script>alert('작성이 완료 되었습니다.');</script>";
		echo "<script>window.location.replace('entry_edit.php?no=$no&hoaw=$hoaw');</script>";
	}else if($_POST['insert'] == 'edit'){
		$no = $_POST['play'];
		$hoaw = $_POST['hoaw'];
		include "dbconn.php";
		$pic_save = "";
		for ($i=1; $i<=9; $i++){
			if($_POST['pos_turn'.$i] != 1){
				$team_members = $_POST['player_turn'.$i];
				$pos = $_POST['pos_turn'.$i];
				$entry_check_result = mysqli_query($conn,"SELECT * FROM play_entry WHERE play = '$no' AND turn = '$i' AND hoaw = '$hoaw'");
				$entry_check_row = mysqli_fetch_array($entry_check_result);
				if($entry_check_row){
					mysqli_query($conn,"UPDATE play_entry SET  team_member = '$team_members', position = '$pos' WHERE play = '$no' AND turn = '$i' AND hoaw = '$hoaw'");
				}else{
					mysqli_query($conn,"INSERT INTO play_entry (play, team_member, hoaw, turn, position) VALUES ('$no', '$team_members', '$hoaw', '$i', '$pos')");
				}
			}else if($_POST['pos_turn'.$i] == 1){
				$pic_save = "1";
				$team_members = $_POST['player_turn'.$i];
				$entry_check_result = mysqli_query($conn,"SELECT * FROM play_entry WHERE play = '$no' AND turn = '$i' AND hoaw = '$hoaw'");
				$entry_check_row = mysqli_fetch_array($entry_check_result);
				if($entry_check_row){
					mysqli_query($conn,"UPDATE play_entry SET  team_member = '$team_members', position = '1' WHERE play = '$no' AND turn = '$i' AND hoaw = '$hoaw'");
				}else{
					mysqli_query($conn,"INSERT INTO play_entry (play, team_member, hoaw, turn, position) VALUES ('$no', '$team_members', '$hoaw', '$i', '1')");
				}
			}
		}
		if($pic_save == ""){
			$player_pic = $_POST['player_pic'];
			$entry_check_result = mysqli_query($conn,"SELECT * FROM play_entry WHERE play = '$no' AND turn = '0' AND hoaw = '$hoaw'");
			$entry_check_row = mysqli_fetch_array($entry_check_result);
			if($entry_check_row){
				mysqli_query($conn,"UPDATE play_entry SET  team_member = '$player_pic', position = '1' WHERE play = '$no' AND turn = '0' AND hoaw = '$hoaw'");
			}else{
				mysqli_query($conn,"INSERT INTO play_entry (play, team_member, hoaw, turn, position) VALUES ('$no', '$player_pic', '$hoaw', '0', '1')");
			}
		}
		mysqli_close($conn);
		echo "<script>alert('수정 되었습니다.');</script>";
		echo "<script>window.location.replace('entry_edit.php?no=$no&hoaw=$hoaw');</script>";
	}
?>

	<script type="text/javascript">
	function cancle(){
		window.close();
	}
	</script>
	<body>
		<? if($user_no && $class_row){?>
		<form action = "entry_edit.php" style="text-align: center;margin-top:5%;width:100%" method="post">
			<p style="font-size:150%">Team : <? echo $team_row['name']?> (<? echo $hoaw_text; ?>)</p>
			<div class="row">
				<div class = "col-1"></div>
				<div class = "col-10">
					<table class="table table-bordered" style="text-align:center;">
						<thead>
							<tr>
								<th colspan="3" style="width:100%;vertical-align: middle;"><? echo $play_row['name'];?> (<? echo date( 'Y년 m월 d일 H시 i분', strtotime($play_row['play_datetime']));?> 경기)</th>
							</tr>
							<tr>
								<th colspan="1" style="width:20%;vertical-align: middle;">선발투수</th>
								<th colspan="2" style="width:80%;vertical-align: middle;">
									<select class="custom-select" id="player_pic" name="player_pic">
										<? if(!$entry_row){
											echo $member_select;
										}else{
											echo $pic_select;
										}
										?>
									</select>
								</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th colspan="1" style="width:20%;vertical-align: middle;">타순</th>
								<th colspan="1" style="width:40%;vertical-align: middle;">포지션</th>
								<th colspan="1" style="width:40%;vertical-align: middle;">선수</th>
							</tr>
							<? for ($i=1; $i<=9; $i++){?>
							<tr>
								<th colspan="1" style="width:20%;vertical-align: middle;"><? echo $i;?>번 타자</th>
								<th colspan="1" style="width:40%;vertical-align: middle;">
									<select class="custom-select" id="pos_turn<? echo $i;?>" name="pos_turn<? echo $i;?>">
										<? if(!$entry_row){
											echo $pos_select;
										}else{
											echo $pos_select[$i];
										}?>
									</select>
								</th>
								<th colspan="1" style="width:40%;vertical-align: middle;">
									<select class="custom-select" id="player_turn<? echo $i;?>" name="player_turn<? echo $i;?>">
										<? if(!$entry_row){
											echo $member_select;
										}else{
											echo $member_select[$i];
										}?>
									</select>
								</th>
							</tr>
							<? } ?>
						</tbody>
					</table>
					<p style="text-align:center"><b>주의 : </b>타순 포지션에 투수가 선택되어 있으면 <a style="color:red">선발투수 변경이 불가능</a> 합니다.<br>(다른 포지션으로 변경 후에 변경이 가능합니다.)</p>
				</div>
				<input type="hidden" name="play" value="<? echo $no;?>">
				<input type="hidden" name="hoaw" value="<? echo $hoaw;?>">
				<input type="hidden" name="insert" value="<? echo $insert;?>">
				<div class = "col-1"></div>
				<br><br>
				<div class = "col-1"></div>
				<div class = "col-5">
					<input class="btn btn-primary" style="width:100%" type="submit" value="<? echo $button_txt;?>"><br><br>
				</div>
				<div class = "col-5">
					<input class="btn btn-primary" style="width:100%" type="button" onclick="cancle()" value="취소">
				</div>
				<div class = "col-1"></div>
			</div>
		</form>
		<? } ?>
	</body>
</html>
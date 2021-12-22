<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php
	include "inc/_head.html";
	include "inc/_script.html";
	session_start();
	$player_no = $_SESSION['player_no'];
	$user_no = $_SESSION['user_no'];
	$no = $_GET['no'];
	if(!$user_no){
		echo "<script>alert('로그인이 필요한 기능입니다');</script>";
		echo "<script>window.close();</script>";
	}
	if($_GET['team']){
		$no = $_GET['no'];
		$team = $_GET['team'];
		include "dbconn.php";
		$league_result = mysqli_query($conn,"SELECT * FROM league_team WHERE league = '$no' AND team = '$team'");
		$league_row = mysqli_fetch_array($league_result);
		if(!$league_row){
			mysqli_query($conn,"INSERT INTO league_team (league, team, user, states) VALUES ('$no', '$team', '$user_no', '2')");
			mysqli_close($conn);
			echo "<script>alert('신청이 완료 되었습니다. 활동내역에서 확인해 주세요');</script>";
			echo "<script>window.close();</script>";
		}else{
			mysqli_close($conn);
			echo "<script>alert('이미 신청 되어있습니다. 활동내역에서 확인해 주세요');</script>";
			echo "<script>window.close();</script>";
		}
	}
?>

	<script type="text/javascript">
	function cancle(){
		window.close();
	}
	</script>
	<body>
		<? if($user_no){?>
		<form action = "LeagueTeamInsertProc.php" style="text-align: center;margin-top:5%;width:100%">
			<p style="font-size:150%">팀 선택</p><br>
			<div class="row">
				<div class = "col-1"></div>
				<div class = "col-10">
					<select class="custom-select" id="team" name="team">
						<option value="0" selected>신청할 팀을 선택해 주세요</option>
							<? include "dbconn.php";
							$class_check_result = mysqli_query($conn,"SELECT * FROM team_members WHERE player='$player_no' AND (class = '1' OR class = '2')");
							while ($team_list_row = mysqli_fetch_array($class_check_result)){
							$team_no = $team_list_row['team'];
							$team_result = mysqli_query($conn,"SELECT * FROM team where no='$team_no'");
							$team_row = mysqli_fetch_array($team_result);?>
						<option value="<? echo $team_no; ?>"><? echo $team_row['name']; ?></option>
							<? } 
							mysqli_close($conn);?>
					</select>
				</div>
				<input type="hidden" name="no" value="<? echo $no;?>">
				<div class = "col-1"></div>
				<br><br>
				<div class = "col-6">
					<input class="btn btn-primary" style="width:60%" type="submit" value="확인"><br><br>
				</div>
				<div class = "col-6">
					<input class="btn btn-primary" style="width:60%" type="button" onclick="cancle()" value="취소">
				</div>
			</div>
		</form>
		<? } ?>
	</body>
</html>
<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php
	include "inc/_head.html";
	include "inc/_script.html";
	include "dbconn.php";
	$no = $_GET['no'];
	$member_info_result = mysqli_query($conn,"SELECT * FROM team_members WHERE no = '$no'");
	$member_info_row = mysqli_fetch_array($member_info_result);
	$team_no = $member_info_row['team'];
	$member_player_no = $member_info_row['player'];
	$member_user_result = mysqli_query($conn,"SELECT * FROM player WHERE no = '$member_player_no'");
	$member_user_row = mysqli_fetch_array($member_user_result);
	$member_user_no = $member_user_row['user'];
	$user_result = mysqli_query($conn,"SELECT * FROM user WHERE no = '$member_user_no'");
	$user_row = mysqli_fetch_array($user_result);
	if($member_info_row['position'] == 1){
		$pos = "투수";
	}else if($member_info_row['position'] == 2){
		$pos = "포수";
	}else if($member_info_row['position'] == 3){
		$pos = "1루수";
	}else if($member_info_row['position'] == 4){
		$pos = "2루수";
	}else if($member_info_row['position'] == 5){
		$pos = "3루수";
	}else if($member_info_row['position'] == 6){
		$pos = "유격수";
	}else if($member_info_row['position'] == 7){
		$pos = "좌익수";
	}else if($member_info_row['position'] == 8){
		$pos = "중견수";
	}else if($member_info_row['position'] == 9){
		$pos = "우익수";
	}else if($member_info_row['position'] == 10){
		$pos = "지명타자";
	}
?>

	<script type="text/javascript">
	function read_contents(){
		var str = document.getElementById("contents").textContent;
		str = str.replaceAll("<br>", "\r\n");
		document.getElementById("contents").textContent = str;
	}
	function cancle(){
		window.close();
	}
	</script>
	<body onload="read_contents()" style="margin: 30px 20px 0px 20px">
		<? if($member_user_row['img']){?>
		<img src="<? echo $member_user_row['img'];?>" style="width:40%" class="img-thumbnail" alt="<? echo $member_user_row['name']?>">
		<? } else {?>
		<img class="img-thumbnail" style="width:40%" src="images/none_team_img.png" alt="<? echo $member_user_row['name']?>">
		<? } ?>
		<table class="table">
			<thead>
				<tr>
					<th style="width:30%">이름</th>
					<th style="width:70%"><? echo $user_row['name'];?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th style="width:30%">주 포지션</th>
					<td style="width:70%"><? echo $pos;?></td>
				</tr>
				<tr>
					<th style="width:30%">연락처</th>
					<td style="width:70%"><? echo $member_info_row['phone'];?></td>
				</tr>
				<tr>
					<th style="width:30%">이메일</th>
					<td style="width:70%"><? echo $member_info_row['email'];?></td>
				</tr>
				<tr>
					<th style="width:30%">자유글</th>
					<td style="width:70%">
						<p id="contents" style="margin-bottom:0px"><? echo $member_info_row['contents'];?></p>
					</td>
				</tr>
			</tbody>
		</table>
		<hr>
		<a class="btn btn-primary" href="javascript:;" onclick="cancle()" role="button">취소</a>
	</body>
</html>
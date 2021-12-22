<?php
include "dbconn.php";

$play = $_POST['play'];
$home_team_no = $_POST['home_team_no'];
$home_team_score = $_POST['home_team_score'];
$home_team_hit = $_POST['home_team_hit'];
$home_team_b4 = $_POST['home_team_b4'];
$home_team_error = $_POST['home_team_error'];
$away_team_no = $_POST['away_team_no'];
$away_team_score = $_POST['away_team_score'];
$away_team_hit = $_POST['away_team_hit'];
$away_team_b4 = $_POST['away_team_b4'];
$away_team_error = $_POST['away_team_error'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$inning = $_POST['inning'];
$states = $_POST['states'];
$league_result = mysqli_query($conn, "SELECT * FROM play WHERE no = '$play'");
$league_row = mysqli_fetch_array($league_result);
$league_no = $league_row['league'];

if($states == 7){
	$home_play_result = 4;
	$away_play_result = 4;
}else if($states == 6){
	$home_play_result = 2;
	$away_play_result = 1;
}else if($states == 5){
	$home_play_result = 1;
	$away_play_result = 2;
}else{
	if($home_team_score > $away_team_score){
		$home_play_result = 1;
		$away_play_result = 2;
	}else if($home_team_score < $away_team_score){
		$home_play_result = 2;
		$away_play_result = 1;
	}else{
		$home_play_result = 3;
		$away_play_result = 3;
	}
}
//홈런 개수
$home_team_hr_result = mysqli_query($conn, "SELECT COUNT(*) as count FROM play_hit JOIN play_entry WHERE (situation_hit BETWEEN 41 AND 44) AND play_entry.play = '$play' AND play_entry.no = play_hit.entry AND play_entry.hoaw = '1'");
$home_team_hr_row = mysqli_fetch_array($home_team_hr_result);
$home_team_hr = $home_team_hr_row['count'];
$away_team_hr_result = mysqli_query($conn, "SELECT COUNT(*) as count FROM play_hit JOIN play_entry WHERE (situation_hit BETWEEN 41 AND 44) AND play_entry.play = '$play' AND play_entry.no = play_hit.entry AND play_entry.hoaw = '0'");
$away_team_hr_row = mysqli_fetch_array($away_team_hr_result);
$away_team_hr = $away_team_hr_row['count'];

//볼넷 개수
$home_team_b4_result = mysqli_query($conn, "SELECT COUNT(*) as count FROM play_hit JOIN play_entry WHERE situation_hit = 51 AND play_entry.play = '$play' AND play_entry.no = play_hit.entry AND play_entry.hoaw = '1'");
$home_team_b4_row = mysqli_fetch_array($home_team_b4_result);
$home_team_b4 = $home_team_b4_row['count'];
$away_team_b4_result = mysqli_query($conn, "SELECT COUNT(*) as count FROM play_hit JOIN play_entry WHERE situation_hit = 51 AND play_entry.play = '$play' AND play_entry.no = play_hit.entry AND play_entry.hoaw = '0'");
$away_team_b4_row = mysqli_fetch_array($away_team_b4_result);
$away_team_b4 = $away_team_b4_row['count'];

//사사구 개수
$home_team_hbp_result = mysqli_query($conn, "SELECT COUNT(*) as count FROM play_hit JOIN play_entry WHERE situation_hit = 52 AND play_entry.play = '$play' AND play_entry.no = play_hit.entry AND play_entry.hoaw = '1'");
$home_team_hbp_row = mysqli_fetch_array($home_team_hbp_result);
$home_team_hbp = $home_team_hbp_row['count'];
$away_team_hbp_result = mysqli_query($conn, "SELECT COUNT(*) as count FROM play_hit JOIN play_entry WHERE situation_hit = 52 AND play_entry.play = '$play' AND play_entry.no = play_hit.entry AND play_entry.hoaw = '0'");
$away_team_hbp_row = mysqli_fetch_array($away_team_hbp_result);
$away_team_hbp = $away_team_hbp_row['count'];

//탈삼진 개수
$home_team_so_result = mysqli_query($conn, "SELECT COUNT(*) as count FROM play_hit JOIN play_entry WHERE (situation_hit BETWEEN 152 AND 153) AND play_entry.play = '$play' AND play_entry.no = play_hit.entry AND play_entry.hoaw = '0'");
$home_team_so_row = mysqli_fetch_array($home_team_so_result);
$home_team_so = $home_team_so_row['count'];
$away_team_so_result = mysqli_query($conn, "SELECT COUNT(*) as count FROM play_hit JOIN play_entry WHERE (situation_hit BETWEEN 152 AND 153) AND play_entry.play = '$play' AND play_entry.no = play_hit.entry AND play_entry.hoaw = '1'");
$away_team_so_row = mysqli_fetch_array($away_team_so_result);
$away_team_so = $away_team_so_row['count'];

//도루 개수
$home_team_sb_result = mysqli_query($conn, "SELECT COUNT(*) as count FROM play_hit JOIN play_run JOIN play_entry WHERE (situation_run BETWEEN 71 AND 73) AND play_entry.play = '$play' AND play_entry.no = play_hit.entry AND play_hit.no = play_run.play_runner AND play_entry.hoaw = '1'");
$home_team_sb_row = mysqli_fetch_array($home_team_sb_result);
$home_team_sb = $home_team_sb_row['count'];
$away_team_sb_result = mysqli_query($conn, "SELECT COUNT(*) as count FROM play_hit JOIN play_run JOIN play_entry WHERE (situation_run BETWEEN 71 AND 73) AND play_entry.play = '$play' AND play_entry.no = play_hit.entry AND play_hit.no = play_run.play_runner AND play_entry.hoaw = '0'");
$away_team_sb_row = mysqli_fetch_array($away_team_sb_result);
$away_team_sb = $away_team_sb_row['count'];

// 경기 기록 저장
mysqli_query($conn,"INSERT INTO play_result (play, team, hoaw, score, playresult, hit, hr, sb, so, error, b4, hbp, start_play, end_play, inning, states) VALUES ('$play', '$home_team_no', '1', '$home_team_score', '$home_play_result', '$home_team_hit', '$home_team_hr', '$home_team_sb', '$home_team_so', '$home_team_error', '$home_team_b4', '$home_team_hbp', '$start_time', '$end_time', '$inning', '$states')");
mysqli_query($conn,"INSERT INTO play_result (play, team, hoaw, score, playresult, hit, hr, sb, so, error, b4, hbp, start_play, end_play, inning, states) VALUES ('$play', '$away_team_no', '0', '$away_team_score', '$away_play_result', '$away_team_hit', '$away_team_hr', '$away_team_sb', '$away_team_so', '$away_team_error', '$away_team_b4', '$away_team_hbp', '$start_time', '$end_time', '$inning', '$states')");

// 타자 기록 저장
$hit_query = "SELECT play_entry.team_member as team_member,
 play_hit.entry AS play_entry_no,
 count(CASE WHEN play_hit.situation_hit != 56 AND play_hit.situation_hit != 57 THEN 1 END) AS play_at_play,
 count(CASE WHEN play_hit.situation_hit != 56 AND play_hit.situation_hit != 57 AND play_hit.situation_hit != 151 AND (play_hit.situation_hit NOT BETWEEN 161 AND 174) AND (play_hit.situation_hit NOT BETWEEN 51 AND 52) THEN 1 END) AS play_at_bat,
 count(CASE WHEN play_hit.situation_hit BETWEEN 11 AND 17 THEN 1 END) AS play_hit_hit1,
 count(CASE WHEN play_hit.situation_hit BETWEEN 21 AND 27 THEN 1 END) AS play_hit_hit2,
 count(CASE WHEN play_hit.situation_hit BETWEEN 31 AND 37 THEN 1 END) AS play_hit_hit3,
 count(CASE WHEN play_hit.situation_hit BETWEEN 41 AND 44 THEN 1 END) AS play_hit_hr,
 count(CASE WHEN play_hit.situation_hit = 51 THEN 1 END) AS play_hit_b4,
 count(CASE WHEN play_hit.situation_hit = 52 THEN 1 END) AS play_hit_hbp,
 count(CASE WHEN play_hit.situation_hit BETWEEN 152 AND 153 THEN 1 END) AS play_hit_so
 FROM play_hit JOIN play_entry WHERE play_entry.play = '$play' AND play_entry.no = play_hit.entry AND play_entry.turn != '0'
 GROUP BY play_hit.entry";
$play_hit_result = mysqli_query($conn, $hit_query);
while($play_hit_row = mysqli_fetch_array($play_hit_result)){
	$play_entry_no = $play_hit_row['play_entry_no'];
	$play_at_play = $play_hit_row['play_at_play'];
	$play_at_bat = $play_hit_row['play_at_bat'];
	$play_hit_hit1 = $play_hit_row['play_hit_hit1'];
	$play_hit_hit2 = $play_hit_row['play_hit_hit2'];
	$play_hit_hit3 = $play_hit_row['play_hit_hit3'];
	$play_hit_hr = $play_hit_row['play_hit_hr'];
	$play_hit_b4 = $play_hit_row['play_hit_b4'];
	$play_hit_hbp = $play_hit_row['play_hit_hbp'];
	$play_hit_so = $play_hit_row['play_hit_so'];
	// 타점
	$play_hit_rbi_result = mysqli_query($conn, "SELECT COUNT(*) as count FROM play_hit JOIN play_run WHERE play_hit.entry = '$play_entry_no' AND play_hit.no = play_run.play_hit AND play_run.result_base = 4");
	$play_hit_rbi_row = mysqli_fetch_array($play_hit_rbi_result);
	$play_hit_rbi = $play_hit_rbi_row['count'];
	
	// 득점 && 도루
	$play_run_result = mysqli_query($conn, "SELECT count(CASE WHEN play_run.situation_run BETWEEN 71 AND 73 THEN 1 END) AS play_run_sb, count(CASE WHEN play_run.result_base = 4 THEN 1 END) AS play_run_rs FROM play_hit JOIN play_run WHERE play_hit.entry = '$play_entry_no' AND play_hit.no = play_run.play_runner");
	$play_run_row = mysqli_fetch_array($play_run_result);
	$play_run_rs = $play_run_row['play_run_rs'];
	$play_run_sb = $play_run_row['play_run_sb'];
	
	// 타자 경기 기록 저장
	mysqli_query($conn,"INSERT INTO play_result_hit (entry, at_play, at_bat, hit1, hit2, hit3, hr, rbi, rs, sb, b4, hbp, so) VALUES ('$play_entry_no', '$play_at_play', '$play_at_bat', '$play_hit_hit1', '$play_hit_hit2', '$play_hit_hit3', '$play_hit_hr', '$play_hit_rbi', '$play_run_rs', '$play_run_sb', '$play_hit_b4', '$play_hit_hbp', '$play_hit_so')");
	
	// 타자 기록 갱신
		$team_member = $play_hit_row['team_member'];
		$team_member_result = mysqli_query($conn, "SELECT COUNT(*) as count FROM player_hit WHERE team_member = '$team_member' AND league = '$league_no'");
		$team_member_row = mysqli_fetch_array($team_member_result);
		if($team_member_row['count'] > 0){
			mysqli_query($conn,"UPDATE player_hit SET at_game = at_game + 1, at_play = at_play + '$play_at_play', at_bat = at_bat + '$play_at_bat', hit1 = hit1 + '$play_hit_hit1', hit2 = hit2 + '$play_hit_hit2', hit3 = hit3 + '$play_hit_hit3', hr = hr + '$play_hit_hr', rbi = rbi + '$play_hit_rbi', rs = rs + '$play_run_rs', sb = sb + '$play_run_sb', b4 = b4 + '$play_hit_b4', hbp = hbp + '$play_hit_hbp', so = so + '$play_hit_so' WHERE team_member = '$team_member' AND league = '$league_no'");
		}else{
			mysqli_query($conn,"INSERT INTO player_hit (team_member, league, at_game, at_play, at_bat, hit1, hit2, hit3, hr, rbi, rs, sb, b4, hbp, so) VALUES ('$team_member', '$league_no', '1', '$play_at_play', '$play_at_bat', '$play_hit_hit1', '$play_hit_hit2', '$play_hit_hit3', '$play_hit_hr', '$play_hit_rbi', '$play_run_rs', '$play_run_sb', '$play_hit_b4', '$play_hit_hbp', '$play_hit_so')");
		}
}

// 투수 정보 전달
$pitcher_result = mysqli_query($conn, "SELECT play_result_pic.no as no, team_members.back_num as back_num, user.name as name, play_entry.hoaw as hoaw FROM play_result_pic JOIN play_entry JOIN team_members JOIN player JOIN user WHERE play_result_pic.entry = play_entry.no AND play_entry.team_member = team_members.no AND team_members.player = player.no AND player.user = user.no AND play_entry.play = '$play'");
$pitcher_list = "";
while($pitcher_list_row = mysqli_fetch_array($pitcher_result)){
	if(mb_strlen($pitcher_list_row['back_num'], 'UTF-8') == 2){
		$back_num = $pitcher_list_row['back_num'].". ";
	}else if($pitcher_list_row['back_num'] != null){
		$back_num = "0".$pitcher_list_row['back_num'].". ";
	}else{
		$back_num = "00. ";
	}
	if($pitcher_list == ""){
		$pitcher_list = $pitcher_list_row['no']."/".$back_num.$pitcher_list_row['name']."/".$pitcher_list_row['hoaw'];
	}else{
		$pitcher_list = $pitcher_list."|".$pitcher_list_row['no']."/".$back_num.$pitcher_list_row['name']."/".$pitcher_list_row['hoaw'];
	}
}
echo $pitcher_list;
mysqli_close($conn);
?>

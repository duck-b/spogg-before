<!doctype html>
<html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, minimum-scale=1">
	<style>
	body
		{
		 text-align: center;
		 margin: 0 auto;
		}
	#box
		{
		 position: absolute;
		 width: 50px;
		 height: 50px;
		 left: 50%;
		 top: 50%;
		 margin-left: -25px;
		 margin-top: -25px;
		}
	</style>
</head>
<?
session_start();
if($_SESSION['admin']){
	$created_at = date('Y-m-d H:i:s',time());
	include "../dbconn.php";
	require_once('lib/Snoopy.class.php');
	$snoopy = new Snoopy;
	// 헤더값에 따라 403 에러가 발생 할 경우 셋팅
	$snoopy->agent = $_SERVER['HTTP_USER_AGENT'];
	if($_GET['league'] == '매직'){
	// 1 매직리그 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%매직%' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://www.gdbl.or.kr";
		$main_url = "http://www.gdbl.or.kr/teamRankDetail.asp?yy=".$_GET['year']."&groupCode=29&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=302";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"  class="tblTopBorder">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/teamCode=(.*?)groupCode/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<(count($matches2[0])-21)/22; $i++){
			$x = $i * 22;
			$query= "INSERT INTO league_record_team  
			(league_info, num, team_name, team_code, games, win_games, lose_games, draw_games, win_point, created_at) 
			VALUES ('".$league_row['no']."', '".strip_tags($matches2[0][$x])."', '".trim(strip_tags($matches2[0][$x+1]))."', '".str_replace('&','',strip_tags($matches3[1][$i]))."', '".strip_tags($matches2[0][$x+2])."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+5])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+6])."','$created_at')";
			mysqli_query($conn, $query);
		}
	// 1 매직리그 끝
	}else if($_GET['league'] == '금정'){
	// 2 금정리그 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%금정%' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://http://www.gjba.kr";
		$main_url = "http://www.gjba.kr/teamRankDetail.asp?yy=".$_GET['year']."&groupCode=21&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=241";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="rankTitle">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/teamCode=(.*?)groupCode/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		$table_body = "";
		for($i=0; $i<(count($matches2[0])-21)/22; $i++){
			$x = $i * 22;
			$query= "INSERT INTO league_record_team  
			(league_info, num, team_name, team_code, games, win_games, lose_games, draw_games, win_point, created_at) 
			VALUES ('".$league_row['no']."', '".strip_tags($matches2[0][$x])."', '".trim(strip_tags($matches2[0][$x+1]))."', '".str_replace('&','',strip_tags($matches3[1][$i]))."', '".strip_tags($matches2[0][$x+2])."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+5])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+6])."','$created_at')";
			mysqli_query($conn, $query);
		}
	// 2 금정리그 끝		
	}else if($_GET['league'] == '안양'){
	// 3 안양리그 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%안양%' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://www.alb.or.kr";
		if($_GET['year'] == '2016' || $_GET['year'] == '2015'){
			$main_url = "http://www.alb.or.kr/s/stand_team/index.php?id=stats&league=%BF%AC%C7%D5%C8%B8%C0%E5%B1%E2&sc=2&gyear=".$_GET['year']."&division=".$_GET['year']."B&order=twp&sort=desc";	
		}else{
			$main_url = "http://www.alb.or.kr/s/stand_team/index.php?id=stats&league=%BF%AC%C7%D5%C8%B8%C0%E5%B1%E2&sc=2&gyear=".$_GET['year']."&division=".$_GET['year']."A&wc=on&order=twp&sort=desc&flag=t232";
		}
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table cellspacing=0 cellpadding=0 width=98% align=center border=0>(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/team=(.*?)order=/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		$table_body = "";
		for($i=0; $i<(count($matches2[0])-27)/25; $i++){
			$x = $i * 25 + 27;
			$query= "INSERT INTO league_record_team  
			(league_info, num, team_name, team_code, games, win_games, lose_games, draw_games, win_point, created_at) 
			VALUES ('".$league_row['no']."', '".strip_tags($matches2[0][$x])."', '".trim(strip_tags($matches2[0][$x+1]))."', '".str_replace('&','',strip_tags($matches3[1][$i]))."', '".strip_tags($matches2[0][$x+2])."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+5])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+7])."','$created_at')";
			mysqli_query($conn, $query);
		}
	// 3 안양리그 끝		
	}
	mysqli_close($conn);
}else{
	echo "<script>alert('잘못된 경로입니다.');</script>";
}
echo ("<meta http-equiv='Refresh' content='1; URL=../main.html'>");
?>
<html lang="ko">
<body>
	<img id="box" src="../img/loading.gif" alt="loading">
</body>
</html>
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
	if($_GET['league'] == '골드매직'){
	// 1 골드매직리그 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%골드-매직%' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://www.gdbl.or.kr";
		$main_url = "http://www.gdbl.or.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=29&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B8%C5%C1%F7%B8%AE%B1%D7&limitCount=16&mGubun=4";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/memID=(.*?)teamName/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<count($matches2[0])/22; $i++){
			$x = $i * 22;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$x/11]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+7])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
			mysqli_query($conn, $query);
		}
	// 1 골드매직리그 끝
	}else if($_GET['league'] == '금정'){
	// 2 금정리그 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%금정%' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://http://www.gjba.kr";
		$main_url = "http://www.gjba.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=21&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B1%DD%C1%A4%B8%AE%B1%D7&limitCount=35&mGubun=4";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:10px;">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/memID=(.*?)teamName/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<(count($matches2[0])-22)/22; $i++){
			$x = $i * 22 + 22;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+7])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."','$created_at')";
			mysqli_query($conn, $query);
		}
	// 2 금정리그 끝		
	}else if($_GET['league'] == '안양'){
	// 3 안양리그 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%안양%' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://www.alb.or.kr";
		$main_url = "http://www.alb.or.kr/s/stand_bat/index.php?id=stats&league=%BF%AC%C7%D5%C8%B8%C0%E5%B1%E2&sc=2&gyear=".$_GET['year']."&division=&order=avg&sort=desc&mode=total";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table cellspacing=0 cellpadding=0 width=98% align=center border=0>(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/no=(.*?)target=/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		$plus_num = 0;
		for($i=0; $i<(count($matches2[0])-29)/26; $i++){
			$x = $i * 26 + 29;
			if(strip_tags($matches2[0][$x]) > strip_tags($matches2[0][$x+26])){
				$plus_num = strip_tags($matches2[0][$x]);
			}
			$num = strip_tags($matches2[0][$x]) + $plus_num;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".trim(strip_tags($matches3[1][$i]))."', '$num', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+9])."', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".(strip_tags($matches2[0][$x+11])-strip_tags($matches2[0][$x+12])-strip_tags($matches2[0][$x+13])-strip_tags($matches2[0][$x+14]))."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+17])."', '$created_at')";
			mysqli_query($conn, $query);
		}
	// 3 안양리그 끝		
	}else if($_GET['league'] == '골드아메리칸'){
	// 4 골드아메리칸리그 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%골드-아메리칸%' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://www.gdbl.or.kr";
		$main_url = "http://www.gdbl.or.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=29&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%BE%C6%B8%DE%B8%AE%C4%AD%B8%AE%B1%D7&limitCount=28&mGubun=4";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/memID=(.*?)teamName/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<count($matches2[0])/22; $i++){
			$x = $i * 22;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$x/11]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+7])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
			mysqli_query($conn, $query);
			//echo $query."<br>";
		}
	// 4 골드아메리칸리그 끝
	}else if($_GET['league'] == '골드내셔널'){
	// 5 골드내셔널리그 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%골드-내셔널%' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://www.gdbl.or.kr";
		$main_url = "http://www.gdbl.or.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=29&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B3%BB%BC%C5%B3%CE%B8%AE%B1%D7&limitCount=28&mGubun=4";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/memID=(.*?)teamName/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<count($matches2[0])/22; $i++){
			$x = $i * 22;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$x/11]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+7])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
			mysqli_query($conn, $query);
			//echo $query."<br>";
		}
	// 5 골드내셔널리그 끝
	}else if($_GET['league'] == '골드드림'){
	// 6 골드드림 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%골드-드림%' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://www.gdbl.or.kr";
		$main_url = "http://www.gdbl.or.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=29&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B5%E5%B8%B2%B8%AE%B1%D7&limitCount=28&mGubun=4";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/memID=(.*?)teamName/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<count($matches2[0])/22; $i++){
			$x = $i * 22;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$x/11]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+7])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
			mysqli_query($conn, $query);
			//echo $query."<br>";
		}
	// 6 골드드림 끝
	}else if($_GET['league'] == '상동내셔널'){
	// 7 상동내셔널 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%상동-내셔널%' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://sdbl.or.kr";
		$main_url = "http://sdbl.or.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=30&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B3%BB%BC%C5%B3%CE%B8%AE%B1%D7&limitCount=28&mGubun=4";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/memID=(.*?)teamName/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<count($matches2[0])/22; $i++){
			$x = $i * 22;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$x/11]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+7])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
			mysqli_query($conn, $query);
			//echo $query."<br>";
		}
	// 7 상동내셔널 끝
	}else if($_GET['league'] == '상동매직'){
	// 8 상동매직 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%상동-매직%' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://sdbl.or.kr";
		$main_url = "http://sdbl.or.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=30&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B8%C5%C1%F7%B8%AE%B1%D7&limitCount=28&mGubun=4";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/memID=(.*?)teamName/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<count($matches2[0])/22; $i++){
			$x = $i * 22;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$x/11]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+7])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
			mysqli_query($conn, $query);
			//echo $query."<br>";
		}
	// 8 상동매직 끝
	}else if($_GET['league'] == '상동드림'){
	// 9 상동드림 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%상동-드림%' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://sdbl.or.kr";
		$main_url = "http://sdbl.or.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=30&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B5%E5%B8%B2%B8%AE%B1%D7&limitCount=28&mGubun=4";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/memID=(.*?)teamName/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<count($matches2[0])/22; $i++){
			$x = $i * 22;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$x/11]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+7])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
			mysqli_query($conn, $query);
			//echo $query."<br>";
		}
	// 9 상동드림 끝
	}else if($_GET['league'] == '상동첼린지'){
	// 10 상동첼린지 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%상동-첼린지%' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://sdbl.or.kr";
		$main_url = "http://sdbl.or.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=30&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C3%BF%B8%B0%C1%F6%B8%AE%B1%D7&limitCount=20&mGubun=4";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/memID=(.*?)teamName/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<count($matches2[0])/22; $i++){
			$x = $i * 22;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$x/11]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+7])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
			mysqli_query($conn, $query);
			//echo $query."<br>";
		}
	// 10 상동첼린지 끝
	}else if($_GET['league'] == '상동아메리칸'){
	// 11 상동아메리칸 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%상동-아메리칸%' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://sdbl.or.kr";
		$main_url = "http://sdbl.or.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=30&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%BE%C6%B8%DE%B8%AE%C4%AD%B8%AE%B1%D7&limitCount=30&mGubun=4";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/memID=(.*?)teamName/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<count($matches2[0])/22; $i++){
			$x = $i * 22;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$x/11]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+7])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
			mysqli_query($conn, $query);
			//echo $query."<br>";
		}
	// 11 상동아메리칸 끝
	}else if($_GET['league'] == '개성'){
	// 12 개성리그 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%개성리그%' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://www.ksbbl.kr";
		$main_url = "http://www.ksbbl.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=17&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=201&limitCount=22&mGubun=4";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/memID=(.*?)teamName/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<(count($matches2[0])-22)/22; $i++){
			$x = $i * 22 + 22;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+7])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."','$created_at')";
			mysqli_query($conn, $query);
			//echo $query."<br>";
			//echo str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."<br>"; //player_code
		}
	// 12 개성리그 끝
	}else if($_GET['league'] == '개성1부'){
	// 13 개성1부리그 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%개성-1부리그%' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://www.ksbbl.kr";
		$main_url = "http://www.ksbbl.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=17&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=202&limitCount=26&mGubun=4";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/memID=(.*?)teamName/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<(count($matches2[0])-22)/22; $i++){
			$x = $i * 22 + 22;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+7])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."','$created_at')";
			mysqli_query($conn, $query);
			//echo $query."<br>";
			//echo str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."<br>"; //player_code
		}
	// 13 개성1부리그 끝
	}else if($_GET['league'] == '개성2부'){
	// 14 개성2부리그 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%개성-2부리그%' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://www.ksbbl.kr";
		$main_url = "http://www.ksbbl.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=17&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=203&limitCount=24&mGubun=4";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/memID=(.*?)teamName/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<(count($matches2[0])-22)/22; $i++){
			$x = $i * 22 + 22;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+7])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."','$created_at')";
			mysqli_query($conn, $query);
			//echo $query."<br>";
			//echo str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."<br>"; //player_code
		}
	// 14 개성2부리그 끝
	}else if($_GET['league'] == '거제토요'){
	// 15 거제토요리그 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%거제-토요리그%' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://www.kjba.kr";
		$main_url = "http://www.kjba.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=38&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C5%E4%BF%E4%B8%AE%B1%D7&limitCount=28&mGubun=4";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/memID=(.*?)teamName/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<(count($matches2[0]))/22; $i++){
			$x = $i * 22;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+7])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '9999', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
			mysqli_query($conn, $query);
			//echo $query."<br>";
			//echo str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."<br>"; //player_code
		}
	// 15 거제토요리그 끝
	}else if($_GET['league'] == '거제일요1부'){
	// 16 거제일요1부리그 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%거제-일요1부리그%' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://www.kjba.kr";
		$main_url = "http://www.kjba.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=37&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=1%BA%CE%B8%AE%B1%D7&limitCount=28&mGubun=4";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/memID=(.*?)teamName/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<(count($matches2[0]))/22; $i++){
			$x = $i * 22;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+7])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '9999', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
			mysqli_query($conn, $query);
			//echo $query."<br>";
			//echo str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."<br>"; //player_code
		}
	// 16 거제일요1부리그 끝
	}else if($_GET['league'] == '거제일요2부'){
	// 17 거제일요2부리그 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%거제-일요2부리그%' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://www.kjba.kr";
		$main_url = "http://www.kjba.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=37&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=2%BA%CE%B8%AE%B1%D7&limitCount=26&mGubun=4";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/memID=(.*?)teamName/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<(count($matches2[0]))/22; $i++){
			$x = $i * 22;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+7])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '9999', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
			mysqli_query($conn, $query);
			//echo $query."<br>";
			//echo str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."<br>"; //player_code
		}
	// 17 거제일요2부리그 끝
	}else if($_GET['league'] == '거제일요3부'){
	// 18 거제일요3부 리그 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%거제-일요3부리그%' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://www.kjba.kr";
		$main_url = "http://www.kjba.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=37&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=3%BA%CE%B8%AE%B1%D7&limitCount=28&mGubun=4";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/memID=(.*?)teamName/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<(count($matches2[0]))/22; $i++){
			$x = $i * 22;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+7])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '9999', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
			mysqli_query($conn, $query);
			//echo $query."<br>";
			//echo str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."<br>"; //player_code
		}
	// 18 거제일요3부 리그 끝
	}else if($_GET['league'] == '거제일요루키'){
	// 19 거제일요루키 리그 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%거제-일요루키리그%' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://www.kjba.kr";
		$main_url = "http://www.kjba.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=37&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B7%E7%C5%B0%B8%AE%B1%D7&limitCount=28&mGubun=4";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/memID=(.*?)teamName/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<(count($matches2[0]))/22; $i++){
			$x = $i * 22;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+7])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '9999', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
			mysqli_query($conn, $query);
			//echo $query."<br>";
			//echo str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."<br>"; //player_code
		}
	// 19 거제일요루키 리그 끝
	}else if($_GET['league'] == '밀양'){
	// 20 밀양 리그 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%밀양리그%' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://www.mybl.or.kr";
		$main_url = "http://www.mybl.or.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=23&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B9%D0%BE%E7%B8%AE%B1%D7&limitCount=20&mGubun=4";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/memID=(.*?)teamName/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<(count($matches2[0]) - 21)/22; $i++){
			$x = $i * 22 + 21;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+3]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x+1])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+2])))."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+5])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+9])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
			mysqli_query($conn, $query);
			//echo $query."<br>";
			//echo str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."<br>"; //player_code
		}
	// 20 밀양 리그 끝
	}else if($_GET['league'] == '밀양토요'){
	// 21 밀양토요 리그 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%밀양-토요리그%' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://www.mybl.or.kr";
		$main_url = "http://www.mybl.or.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=25&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C5%E4%BF%E4%B3%AA%B3%EB%B8%AE%B1%D7&limitCount=24&mGubun=4";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/memID=(.*?)teamName/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<(count($matches2[0]) - 21)/22; $i++){
			$x = $i * 22 + 21;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+3]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x+1])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+2])))."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+5])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+9])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
			mysqli_query($conn, $query);
			//echo $query."<br>";
			//echo str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."<br>"; //player_code
		}
	// 21 밀양토요 리그 끝
	}else if($_GET['league'] == '밀양평일'){
	// 22 밀양평일 리그 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%밀양-평일리그%' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://www.mybl.or.kr";
		$main_url = "http://www.mybl.or.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=36&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C6%F2%C0%CF%BE%DF%B0%A3%B8%AE%B1%D7&limitCount=24&mGubun=4";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/memID=(.*?)teamName/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<(count($matches2[0]) - 21)/22; $i++){
			$x = $i * 22 + 21;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+3]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x+1])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+2])))."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+5])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+9])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
			mysqli_query($conn, $query);
			//echo $query."<br>";
			//echo str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."<br>"; //player_code
		}
	// 22 밀양평일 리그 끝
	}else if($_GET['league'] == '밀양일요1부'){
	// 23 밀양일요1부 리그 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%밀양-일요1부리그%' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://www.mybl.or.kr";
		$main_url = "http://www.mybl.or.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=23&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C0%CF%BF%E41%BA%CE&limitCount=28&mGubun=4";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/memID=(.*?)teamName/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<(count($matches2[0]) - 21)/22; $i++){
			$x = $i * 22 + 21;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+3]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x+1])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+2])))."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+5])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+9])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
			mysqli_query($conn, $query);
			//echo $query."<br>";
			//echo str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."<br>"; //player_code
		}
	// 23 밀양일요1부 리그 끝
	}else if($_GET['league'] == '밀양일요2부'){
	// 24 밀양일요2부 리그 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%밀양-일요2부리그%' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://www.mybl.or.kr";
		$main_url = "http://www.mybl.or.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=23&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C0%CF%BF%E4%B5%E5%B8%B2%B8%AE%B1%D7&limitCount=28&mGubun=4";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/memID=(.*?)teamName/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<(count($matches2[0]) - 21)/22; $i++){
			$x = $i * 22 + 21;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+3]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x+1])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+2])))."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+5])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+9])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
			mysqli_query($conn, $query);
			echo $query."<br>";
			//echo str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."<br>"; //player_code
		}
	// 24 밀양일요2부 리그 끝
	}else if($_GET['league'] == '밀양일요3부'){
	// 25 밀양일요3부 리그 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%밀양-일요3부리그%' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://www.mybl.or.kr";
		$main_url = "http://www.mybl.or.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=23&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C0%CF%BF%E4%B8%C5%C1%F7%B8%AE%B1%D7&limitCount=28&mGubun=4";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/memID=(.*?)teamName/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<(count($matches2[0]) - 21)/22; $i++){
			$x = $i * 22 + 21;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+3]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x+1])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+2])))."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+5])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+9])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
			mysqli_query($conn, $query);
			echo $query."<br>";
			//echo str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."<br>"; //player_code
		}
	// 25 밀양일요3부 리그 끝
	}else if($_GET['league'] == '밀양일요3부드림'){
	// 26 밀양일요3부드림 리그 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%밀양-일요3부-드림리그%' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://www.mybl.or.kr";
		$main_url = "http://www.mybl.or.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=23&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C0%CF%BF%E43%BA%CE%20%B5%E5%B8%B2&limitCount=26&mGubun=4";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/memID=(.*?)teamName/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<(count($matches2[0]) - 21)/22; $i++){
			$x = $i * 22 + 21;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+3]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x+1])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+2])))."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+5])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+9])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
			mysqli_query($conn, $query);
			echo $query."<br>";
			//echo str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."<br>"; //player_code
		}
	// 26 밀양일요3부드림 리그 끝
	}else if($_GET['league'] == '밀양일요3부매직'){
	// 27 밀양일요3부매직 리그 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%밀양-일요3부-매직리그%' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://www.mybl.or.kr";
		$main_url = "http://www.mybl.or.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=23&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C0%CF%BF%E43%BA%CE%20%B8%C5%C1%F7&limitCount=26&mGubun=4";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/memID=(.*?)teamName/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<(count($matches2[0]) - 21)/22; $i++){
			$x = $i * 22 + 21;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+3]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x+1])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+2])))."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+5])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+9])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
			mysqli_query($conn, $query);
			echo $query."<br>";
			//echo str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."<br>"; //player_code
		}
	// 27 밀양일요3부매직 리그 끝
	}else if($_GET['league'] == '백양선수'){
	// 28 백양선수 리그 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%백양리그-선수%' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://www.byba.or.kr";
		$main_url = "http://www.byba.or.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=06&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B9%E9%BE%E7%B8%AE%B1%D7&limitCount=34&mGubun=1";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/memID=(.*?)teamName/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<(count($matches2[0]) - 21)/22; $i++){
			$x = $i * 22 + 21;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+3]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x+1])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+2])))."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+5])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+9])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
			mysqli_query($conn, $query);
			echo $query."<br>";
			//echo str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."<br>"; //player_code
		}
	// 28 백양선수 리그 끝
	}else if($_GET['league'] == '백양비선수'){
	// 29 백양비선수 리그 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%백양리그-비선수%' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://www.byba.or.kr";
		$main_url = "http://www.byba.or.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=06&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B9%E9%BE%E7%B8%AE%B1%D7&limitCount=28&mGubun=2";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/memID=(.*?)teamName/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<(count($matches2[0]) - 21)/22; $i++){
			$x = $i * 22 + 21;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+3]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x+1])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+2])))."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+5])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+9])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
			mysqli_query($conn, $query);
			echo $query."<br>";
			//echo str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."<br>"; //player_code
		}
	// 29 백양비선수 리그 끝
	}else if($_GET['league'] == '삼성'){
	// 31 삼성 리그 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%삼성중공업%' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://shi-baseball.kr";
		$main_url = "http://shi-baseball.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=24&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C1%DF%BF%EC%C8%B8%C0%E5%B9%E8%B8%AE%B1%D7&limitCount=36&mGubun=4";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/memID=(.*?)teamName/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<(count($matches2[0])-22)/22; $i++){
			$x = $i * 22 + 22;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+7])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."','$created_at')";
			mysqli_query($conn, $query);
			echo $query."<br>";
			//echo str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."<br>"; //player_code
		}
	// 31 삼성 리그 끝
	}else if($_GET['league'] == '부산평일'){
	// 32 부산평일 리그 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%부산평일리그%' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://www.bspil.net";
		$main_url = "http://www.bspil.net/batRankDetail.asp?yy=".$_GET['year']."&groupCode=11&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C6%F2%C0%CF%B8%AE%B1%D7&limitCount=28&mGubun=4";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/memID=(.*?)teamName/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<(count($matches2[0])-22)/22; $i++){
			$x = $i * 22 + 22;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+7])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."','$created_at')";
			mysqli_query($conn, $query);
			echo $query."<br>";
			//echo str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."<br>"; //player_code
		}
	// 32 부산평일 리그 끝
	}else if($_GET['league']=="UBBA"){
		// 33 ~ UBBA 리그 시작
		if($_GET['league2'] == "무룡A"){
			$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-무룡리그A' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
			$main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=15&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B9%AB%B7%E6%B8%AE%B1%D7%20A&limitCount=36&mGubun=4";
		}else if($_GET['league2'] == "무룡B"){
			$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-무룡리그B' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
			$main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=15&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B9%AB%B7%E6%B8%AE%B1%D7%20B&limitCount=37&mGubun=4";
		}else if($_GET['league2'] == "무룡"){
			$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-무룡리그' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
			$main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=15&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B9%AB%B7%E6%B8%AE%B1%D7&limitCount=36&mGubun=4";
		}else if($_GET['league2'] == "서부"){
			$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-서부리그' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
			$main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=15&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%BC%AD%BA%CE%B8%AE%B1%D7&limitCount=36&mGubun=4";
		}else if($_GET['league2'] == "북부"){
			$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-북부리그' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
			$main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=15&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%BA%CF%BA%CE%B8%AE%B1%D7&limitCount=36&mGubun=4";
		}else if($_GET['league2'] == "처용A"){
			$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-처용리그A' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
			$main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=16&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C3%B3%BF%EB%B8%AE%B1%D7%20A&limitCount=38&mGubun=4";
		}else if($_GET['league2'] == "처용B"){
			$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-처용리그B' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
			$main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=16&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C3%B3%BF%EB%B8%AE%B1%D7%20B&limitCount=34&mGubun=4";
		}else if($_GET['league2'] == "처용"){
			$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-처용리그' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
			$main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=16&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C3%B3%BF%EB%B8%AE%B1%D7&limitCount=36&mGubun=4";
		}else if($_GET['league2'] == "문수"){
			$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-문수리그' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
			$main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=16&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B9%AE%BC%F6%B8%AE%B1%D7&limitCount=36&mGubun=4";
		}else if($_GET['league2'] == "태화"){
			$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-태화리그' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
			$main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=16&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C5%C2%C8%AD%B8%AE%B1%D7&limitCount=36&mGubun=4";
		}else if($_GET['league2'] == "동부"){
			$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-동부리그' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
			$main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=16&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B5%BF%BA%CE%B8%AE%B1%D7&limitCount=36&mGubun=4";
		}else if($_GET['league2'] == "남부"){
			$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-남부리그' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
			$main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=16&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B3%B2%BA%CE%B8%AE%B1%D7&limitCount=36&mGubun=4";
		}
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://www.usba.kr";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/memID=(.*?)teamName/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<(count($matches2[0])-21)/22; $i++){
			$x = $i * 22 + 21;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+3]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x+1])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+2])))."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+5])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+9])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
			mysqli_query($conn, $query);
			echo $query."<br>";
			//echo str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."<br>"; //player_code
		}
		// 33~ UBBA 리그 끝
	}else if($_GET['league']=="울산MS"){
		// 55 ~ 울산MS 리그 시작
		if($_GET['league2'] == "내셔널"){
			$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = '울산MS-내셔널리그' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
			$main_url = "http://www.usmlb.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=32&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B3%BB%BC%C5%B3%CE%B8%AE%B1%D7&limitCount=45&mGubun=4";
		}else if($_GET['league2'] == "아메리칸"){
			$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = '울산MS-아메리칸리그' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
			$main_url = "http://www.usmlb.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=33&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%BE%C6%B8%DE%B8%AE%C4%AD%B8%AE%B1%D7&limitCount=45&mGubun=4";
		}else if($_GET['league2'] == "아메리칸A"){
			$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = '울산MS-아메리칸리그A' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
			$main_url = "http://www.usmlb.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=33&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%BE%C6%B8%DE%B8%AE%C4%AD%B8%AE%B1%D7A&limitCount=44&mGubun=4";
		}else if($_GET['league2'] == "아메리칸B"){
			$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = '울산MS-아메리칸리그B' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
			$main_url = "http://www.usmlb.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=33&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%BE%C6%B8%DE%B8%AE%C4%AD%B8%AE%B1%D7B&limitCount=45&mGubun=4";
		}
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://www.usmlb.kr";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/memID=(.*?)teamName/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<(count($matches2[0]))/22; $i++){
			$x = $i * 22;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+7])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
			mysqli_query($conn, $query);
			echo $query."<br>";
			//echo str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."<br>"; //player_code
		}
		// 55 ~ 울산MS 리그 끝
	}else if($_GET['league']=="한새벌"){
		// 59 한새벌 리그 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = '한새벌리그' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$main_url = "http://www.sukdaeba.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=12&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C7%D1%BB%F5%B9%FA%B8%AE%B1%D7&limitCount=40&mGubun=4";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://www.sukdaeba.kr";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/memID=(.*?)teamName/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<(count($matches2[0])-21)/22; $i++){
			$x = $i * 22 + 21;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+3]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x+1])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+2])))."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+5])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+9])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
			mysqli_query($conn, $query);
			echo $query."<br>";
			//echo str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."<br>"; //player_code
		}
		// 59 한새벌 리그 끝
	}else if($_GET['league']=="BPA"){
		// 60 BPA 리그 시작
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'BPA리그' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
		$main_url = "http://www.bpabaseball.kr/batRankDetail.asp?yy=".$_GET['year']."&groupCode=27&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=BPA%B8%AE%B1%D7&limitCount=17&mGubun=4";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://www.bpabaseball.kr";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/memID=(.*?)teamName/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<(count($matches2[0]))/22; $i++){
			$x = $i * 22;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+3]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x+1])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+2])))."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+5])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+9])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
			mysqli_query($conn, $query);
			echo $query."<br>";
			//echo str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."<br>"; //player_code
		}
		// 60 BPA 리그 끝
	}else if($_GET['league']=="PSBA"){
		// 61 ~ PSBA 리그 시작
		if($_GET['league2'] == '매직선수'){
			$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'PSBA-매직리그-선수' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
			$main_url = "http://www.psba.or.kr/detailBatRank.asp?gubun=1&yy=".$_GET['year']."&league=%B8%C5%C1%F7%B8%AE%B1%D7&kind=Sun";
		}else if($_GET['league2'] == '매직비선수'){
			$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'PSBA-매직리그-비선수' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
			$main_url = "http://www.psba.or.kr/detailBatRank.asp?gubun=2&yy=".$_GET['year']."&league=%B8%C5%C1%F7%B8%AE%B1%D7&kind=Sun";
		}else if($_GET['league2'] == '드림'){
			$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'PSBA-드림리그' AND league_info.years = '".$_GET['year']."' AND league_info.league= league.no";
			$main_url = "http://www.psba.or.kr/detailBatRank.asp?gubun=4&yy=".$_GET['year']."&league=%B5%E5%B8%B2%B8%AE%B1%D7&kind=Sun";
		}
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$snoopy->referer = "http://www.psba.or.kr";
		$snoopy->fetch($main_url);
		$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
		$pattern = '/<table width="750" border="0" align="center" cellpadding="0" cellspacing="1"  class="tablecss">(.*?)<\/table>/is';
		preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
		$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
		preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
		$pattern3 = '/memID=(.*?)teamName/is';
		preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
		for($i=0; $i<(count($matches2[0])-17)/17; $i++){
			$x = $i * 17 + 17;
			$query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+7])."', '".strip_tags($matches2[0][$x+8])."', '9999', '9999', '9999', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '9999', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."','$created_at')";
			mysqli_query($conn, $query);
			echo $query."<br>";
			//echo str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."<br>"; //player_code
		}
		// 61 ~ PSBA 리그 끝
	}
	mysqli_close($conn);
}else{
	echo "<script>alert('잘못된 경로입니다.');</script>";
}
echo ("<meta http-equiv='Refresh' content='1; URL=../main.html'>");
?>
<html lang="ko">
<body>
	<!--<img id="box" src="../img/loading.gif" alt="loading">-->
</body>
</html>
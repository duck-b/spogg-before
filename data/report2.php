<?
if($item != 1){
    include("header/header.html");
    $user_no = $_GET['user'];
}else{
    $user_no = $_POST['user'];
}
?>
<?
include "dbconn.php";

$user_result = mysqli_query($conn,"SELECT user.*, user_player.no as player_no FROM user JOIN user_player WHERE user.no='$user_no' AND user_player.user = '$user_no'");
$user_row = mysqli_fetch_array($user_result);
if($user_row['img']){
    if($user_row['sns_login'] == 0){
        $user_img = "/".$user_row['img'];
    }else{
        $user_img = $user_row['img'];
    }
}else{
    $user_img = "/img/button/none_img.jpg";
}
$player_no = $user_row['player_no'];

$isMobile = 0;

$mobileos = ["iPhone","iPod","Android","BlackBerry","Windows CE","Nokia","Webos","Opera Mini","SonyEricsson","Opera Mobi","IEMobile"];

for($i=0 ; $i<sizeof($mobileos); $i++) {
	if(strpos($_SERVER['HTTP_USER_AGENT'],$mobileos[$i]) !== false) {
		$isMobile = 1;
		break;
	}
}
if($isMobile){
	//모바일
	$years_5_height = "100%";
	$total_height = "100%";
	$now_league = "100%";
	$model_bar = "60%";
	$model_pie = "60%";
}else{
	//PC
	$years_5_height = "50%";
	$total_height = "50%";
	$now_league = "50%";
	$model_bar = "49%";
	$model_pie = "100%";
}

$player_result = mysqli_query($conn,"SELECT * FROM user_player JOIN user WHERE user_player.user='$user_no' AND user.no = '$user_no'");
$player_row = mysqli_fetch_array($player_result);
if($player_row['playercheck'] == 1){
    $playercheck = "선출";
}else if($player_row['playercheck'] == 2){
    $playercheck = "비선출";
}else{
    $playercheck = "-";
}
if($player_row['playerclass'] == 1){
    $playerclass = "사회인 1부";
}else if($player_row['playerclass'] == 2){
    $playerclass = "사회인 2부";
}else if($player_row['playerclass'] == 3){
    $playerclass = "사회인 3부";
}else if($player_row['playerclass'] == 4){
    $playerclass = "사회인 4부";
}else{
    $playerclass = "-";
}
if($player_row['position'] == 1){
    $position = "내야수";
}else if($player_row['position'] == 2){
    $position = "외야수";
}else if($player_row['position'] == 3){
    $position = "투수";
}else{
    $position = "-";
}
if($player_row['hitpitch'] == 1){
    $hitpitch = "우투우타";
}else if($player_row['hitpitch'] == 2){
    $hitpitch = "우투좌타";
}else if($player_row['hitpitch'] == 3){
    $hitpitch = "좌투우타";
}else if($player_row['hitpitch'] == 4){
    $hitpitch = "좌투좌타";
}else{
    $hitpitch = "-";
}
if($player_row['birth'] != "0000-00-00"){
    $birth_time   = strtotime($player_row['birth']);
    $now          = date('Ymd');
    $birthday     = date('Ymd' , $birth_time);
    $age           = "만 ".floor(($now - $birthday) / 10000)."세";
}else{
    $age = "-";
}
if($player_row['playertall'] == 0){
    $playertall = "-";
}else{
    $playertall = $player_row['playertall']."cm";
}
if($player_row['playerweight'] == 0){
    $playerweight = "-";
}else{
    $playerweight = $player_row['playerweight']."kg";
}
if($player_row['address']){
    $address = $player_row['address'];
}else{
    $address = "-";
}
if($player_row['team']){
    $team = explode('|' , $player_row['team']);
    $team_name = $team[0];
}else{
    $team_name = "-";
}
//타자
$hit_record_query = "SELECT * FROM none_record_hit WHERE player='$player_no' ORDER BY years DESC, created_at";
$hit_record_result = mysqli_query($conn,$hit_record_query);
$hit_table_basic = "";
$i = 0;
$years_count = 0;
$now_years = 0;
while($hit_record_row = mysqli_fetch_array($hit_record_result)){
    $i++;
    if($now_years != $hit_record_row['years']){
        $now_years = $hit_record_row['years'];
        $years_count++;
    }
    $hit_no = $hit_record_row['no'];
    // avg
    if($hit_record_row['at_bat'] == '0'){
        $avg = "-";
    }else{
        $avg = number_format(round($hit_record_row['hit']/$hit_record_row['at_bat'],3),3);
    }
    //hbp
    if($hit_record_row['hbp'] == '9999'){
        $hbp = 0;
        $hbp_text = "-";
    }else{
        $hbp = $hit_record_row['hbp'];
        $hbp_text = $hit_record_row['hbp'];
    }
    // obp
    if($hit_record_row['at_bat'] + $hit_record_row['bb'] + $hbp != 0){
        $obp = number_format(round(($hit_record_row['hit'] + $hit_record_row['bb'] + $hbp)/($hit_record_row['at_bat'] + $hit_record_row['bb'] + $hbp),3),3);
    }else{
        $obp = "-";
    }
    // slg, tb, xbh
    if($hit_record_row['hit2'] == '9999' || $hit_record_row['hit3'] == '9999'){
        $hit2 = "-";
        $hit3 = "-";
        $slg = "-";
        $tb = "-";
        $xbh = "-";
    }else{
        $hit2 = $hit_record_row['hit2'];
        $hit3 = $hit_record_row['hit3'];
        if($hit_record_row['at_bat'] != 0){
            $slg = number_format(round(($hit_record_row['hit1'] + $hit2*2 + $hit3*3 +$hit_record_row['hr']*4)/$hit_record_row['at_bat'],3),3);
        }else{
            $slg = "-";
        }
        $tb = $hit_record_row['hit1'] + $hit2*2 + $hit3*3 + $hit_record_row['hr']*4;
        $xbh = $hit2 + $hit3 + $hit_record_row['hr'];
    }
    // ops
    if($slg == "-" || $obp == "-"){
        $ops = "-";
    }else{
        $ops = number_format($obp + $slg,3);
    }
    if($hit_record_row['at_game'] == '9999'){
        $at_game = "-";
    }else{
        $at_game = $hit_record_row['at_game'];
    }
    if($hit_record_row['rs'] == '9999'){
        $rs = "-";
    }else{
        $rs = $hit_record_row['rs'];
    }
    if($hit_record_row['sb'] == '9999'){
        $sb = "-";
    }else{
        $sb = $hit_record_row['sb'];
    }
    if($hit_record_row['sf'] == '9999'){
        $sf = "-";
    }else{
        $sf = $hit_record_row['sf'];
    }
    if($hit_record_row['hbp'] == '9999'){
        $hbp = "-";
    }else{
        $hbp = $hit_record_row['hbp'];
    }
    if(mb_strlen($hit_record_row['league_name'], 'UTF-8') <= 11){
        $league_name = "<td>".$hit_record_row['league_name']."</td>";
    }else{
        $league_name = "<td title='".$hit_record_row['league_name']."'>".mb_substr($hit_record_row['league_name'], 0, 10, 'UTF-8')."‥</td>";
    }
    $hit_table_basic = $hit_table_basic."<tr>
        <td>".$i."</td><td>".$hit_record_row['years']."</td>".$league_name."<td>".$hit_record_row['team_name']."</td><td>".$avg."</td><td>".$at_game."</td><td>".$hit_record_row['at_play']."</td><td>".$hit_record_row['at_bat']."</td><td>".$hit_record_row['hit']."</td><td>".$hit2."</td><td>".$hit3."</td><td>".$hit_record_row['hr']."</td><td>".$hit_record_row['rbi']."</td><td>".$rs."</td><td>".$sb."</td><td>".$hit_record_row['bb']."</td><td>".$hbp_text."</td><td>".$hit_record_row['so']."</td><td>".$sf."</td><td>".$tb."</td><td>".$xbh."</td><td>".$obp."</td><td>".$slg."</td><td>".$ops."</td><td><a href='javascript:;' onclick='onclick=updaterecodeform(0,$hit_no)'><i class='fa fa-edit' style='color:green'></i></a></td><td><a href='javascript:;' onclick='delete_event($hit_no,1)'><i class='fa fa-trash' style='color:red'></i></a></td>
    </tr>";
}
if($i > 0){
    $hit_summary_query = "SELECT user_record.*, league_record.years_avg FROM 
                            (SELECT years AS league_years,
                                COUNT(*) AS league_count,
                                SUM(CASE WHEN at_game != '9999' THEN at_game END) AS at_game,
                                COUNT(CASE WHEN at_game != '9999' THEN 1 END) AS at_game_count,
                                SUM(CASE WHEN at_bat != '9999' THEN at_bat END) AS at_bat,
                                SUM(CASE WHEN hit != '9999' THEN hit END) AS hit,
                                SUM(CASE WHEN hit1 != '9999' THEN hit1 END) AS hit1,
                                COUNT(CASE WHEN hit1 != '9999' THEN 1 END) AS hit1_count,
                                SUM(CASE WHEN hit2 != '9999' THEN hit2 END) AS hit2,
                                COUNT(CASE WHEN hit2 != '9999' THEN 1 END) AS hit2_count,
                                SUM(CASE WHEN hit3 != '9999' THEN hit3 END) AS hit3,
                                COUNT(CASE WHEN hit3 != '9999' THEN 1 END) AS hit3_count,
                                SUM(CASE WHEN hr != '9999' THEN hr END) AS hr,
                                SUM(CASE WHEN bb != '9999' THEN bb END) AS bb,
                                SUM(CASE WHEN hit1 != '9999' THEN at_bat END) AS at_bat_ops,
                                SUM(CASE WHEN hit1 != '9999' THEN hit END) AS hit_ops,
                                SUM(CASE WHEN hit1 != '9999' THEN bb END) AS bb_ops,
                                SUM(CASE WHEN rs != '9999' THEN rs END) AS rs,
                                COUNT(CASE WHEN rs != '9999' THEN 1 END) AS rs_count,
                                SUM(CASE WHEN rbi != '9999' THEN rbi END) AS rbi,
                                SUM(CASE WHEN sb != '9999' THEN sb END) AS sb,
                                COUNT(CASE WHEN sb != '9999' THEN 1 END) AS sb_count,
                                SUM(CASE WHEN so != '9999' THEN so END) AS so,
                                SUM(CASE WHEN hbp != '9999' THEN hbp END) AS hbp,
                                COUNT(CASE WHEN hbp != '9999' THEN 1 END) AS hbp_count,
                                SUM(CASE WHEN sf != '9999' THEN sf END) AS sf,
                                COUNT(CASE WHEN sf != '9999' THEN 1 END) AS sf_count
                            FROM none_record_hit  
                            WHERE player='$player_no'
                            GROUP BY years) AS user_record 
                        JOIN 
                            (SELECT league_info.years AS years, 
                                    ROUND(SUM(hit)/SUM(at_bat),3) AS years_avg 
                            FROM league_record_hit JOIN league_info
                            WHERE league_record_hit.league_info = league_info.no GROUP BY league_info.years) AS league_record
                        WHERE user_record.league_years = league_record.years
                        UNION
                        (SELECT 0 AS league_years,
                                COUNT(*) AS league_count,
                                SUM(CASE WHEN at_game != '9999' THEN at_game END) AS at_game,
                                COUNT(CASE WHEN at_game != '9999' THEN 1 END) AS at_game_count,
                                SUM(CASE WHEN at_bat != '9999' THEN at_bat END) AS at_bat,
                                SUM(CASE WHEN hit != '9999' THEN hit END) AS hit,
                                SUM(CASE WHEN hit1 != '9999' THEN hit1 END) AS hit1,
                                COUNT(CASE WHEN hit1 != '9999' THEN 1 END) AS hit1_count,
                                SUM(CASE WHEN hit2 != '9999' THEN hit2 END) AS hit2,
                                COUNT(CASE WHEN hit2 != '9999' THEN 1 END) AS hit2_count,
                                SUM(CASE WHEN hit3 != '9999' THEN hit3 END) AS hit3,
                                COUNT(CASE WHEN hit3 != '9999' THEN 1 END) AS hit3_count,
                                SUM(CASE WHEN hr != '9999' THEN hr END) AS hr,
                                SUM(CASE WHEN bb != '9999' THEN bb END) AS bb,
                                SUM(CASE WHEN hit1 != '9999' THEN at_bat END) AS at_bat_ops,
                                SUM(CASE WHEN hit1 != '9999' THEN hit END) AS hit_ops,
                                SUM(CASE WHEN hit1 != '9999' THEN bb END) AS bb_ops,
                                SUM(CASE WHEN rs != '9999' THEN rs END) AS rs,
                                COUNT(CASE WHEN rs != '9999' THEN 1 END) AS rs_count,
                                SUM(CASE WHEN rbi != '9999' THEN rbi END) AS rbi,
                                SUM(CASE WHEN sb != '9999' THEN sb END) AS sb,
                                COUNT(CASE WHEN sb != '9999' THEN 1 END) AS sb_count,
                                SUM(CASE WHEN so != '9999' THEN so END) AS so,
                                SUM(CASE WHEN hbp != '9999' THEN hbp END) AS hbp,
                                COUNT(CASE WHEN hbp != '9999' THEN 1 END) AS hbp_count,
                                SUM(CASE WHEN sf != '9999' THEN sf END) AS sf,
                                COUNT(CASE WHEN sf != '9999' THEN 1 END) AS sf_count,
                                0 AS years_avg 
                        FROM none_record_hit  
                        WHERE player='$player_no') ORDER BY league_years DESC";
    $hit_summary_result = mysqli_query($conn,$hit_summary_query);
    $hit_table_5years = "";
    $year_chart_5years = "";
    $avg_chart_5years = "";
    $obp_chart_5years = "";
    $slg_chart_5years = "";
    $ops_chart_5years = "";
    $j=0;
    while($hit_summary_row = mysqli_fetch_array($hit_summary_result)){
        if($hit_summary_row['at_bat'] != 0){
            $avg = number_format(round($hit_summary_row['hit']/$hit_summary_row['at_bat'],3),3);
            $avg_text = $avg;
        }else{
            $avg = 0;
            $avg_text = "-";
        }
        if($hit_summary_row['at_game'] == null){
            $at_game = "-";
        }else{
            if($hit_summary_row['at_game_count'] == $hit_summary_row['league_count']){
                $at_game = $hit_summary_row['at_game'];
            }else{
                $at_game = $hit_summary_row['at_game']." (".$hit_summary_row['at_game_count'].")";
            }
        }
        if($hit_summary_row['rs'] == null){
            $rs = "-";
        }else{
            if($hit_summary_row['rs_count'] == $hit_summary_row['league_count']){
                $rs = $hit_summary_row['rs'];
            }else{
                $rs = $hit_summary_row['rs']." (".$hit_summary_row['rs_count'].")";
            }
        }
        if($hit_summary_row['sb'] == null){
            $sb = "-";
        }else{
            if($hit_summary_row['sb_count'] == $hit_summary_row['league_count']){
                $sb = $hit_summary_row['sb'];
            }else{
                $sb = $hit_summary_row['sb']." (".$hit_summary_row['sb_count'].")";
            }
        }
        if($hit_summary_row['at_bat'] + $hit_summary_row['bb'] + $hit_summary_row['hbp'] != 0){
            $obp = number_format(round(($hit_summary_row['hit'] + $hit_summary_row['bb'] + $hit_summary_row['hbp'])/($hit_summary_row['at_bat'] + $hit_summary_row['bb'] + $hit_summary_row['hbp']),3),3);
            $obp_text = $obp;
        }else{
            $obp = 0.000;
            $obp_text = "-";
        }
        if($hit_summary_row['hit1'] == null ||$hit_summary_row['hit2'] == null || $hit_summary_row['hit3'] == null){
            $slg = 0;
            $slg_text = "-";
            $ops = 0;
            $ops_text = "-";
        }else{
            if($hit_summary_row['hit1_count'] == $hit_summary_row['league_count']){
                if($hit_summary_row['at_bat'] != 0){
                    $slg = number_format(round(($hit_summary_row['hit1'] + $hit_summary_row['hit2']*2 + $hit_summary_row['hit3']*3 +$hit_summary_row['hr']*4)/$hit_summary_row['at_bat_ops'],3),3);
                    $slg_text = $slg;
                    $obp_ops = number_format(round(($hit_summary_row['hit_ops'] + $hit_summary_row['bb_ops'] + $hit_summary_row['hbp_ops'])/($hit_summary_row['at_bat_ops'] + $hit_summary_row['bb_ops'] + $hit_summary_row['hbp_ops']),3),3);
                    $ops = number_format($slg+$obp_ops,3);
                    $ops_text = $ops;
                }else{
                    $slg = 0;
                    $slg_text = "-";
                    $ops = 0;
                    $ops_text = "-";
                }
            }else{
                if($hit_summary_row['at_bat'] != 0){
                    $slg = number_format(round(($hit_summary_row['hit1'] + $hit_summary_row['hit2']*2 + $hit_summary_row['hit3']*3 +$hit_summary_row['hr']*4)/$hit_summary_row['at_bat_ops'],3),3);
                    $slg_text = $slg." (".$hit_summary_row['hit1_count'].")";
                    $obp_ops = number_format(round(($hit_summary_row['hit_ops'] + $hit_summary_row['bb_ops'] + $hit_summary_row['hbp_ops'])/($hit_summary_row['at_bat_ops'] + $hit_summary_row['bb_ops'] + $hit_summary_row['hbp_ops']),3),3);
                    $ops = number_format($slg+$obp_ops,3);
                    $ops_text = $ops." (".$hit_summary_row['hit1_count'].")";
                }else{
                    $slg = 0;
                    $slg_text = "-";
                    $ops = 0;
                    $ops_text = "-";
                }
            }
        }
        if($hit_summary_row['league_years'] != 0){
            $hit_table_5years .= "<tr><td>".$hit_summary_row['league_years']."</td><td>".$hit_summary_row['league_count']."</td><td>".$avg_text."</td><td>".$at_game."</td><td>".$hit_summary_row['at_bat']."</td><td>".$hit_summary_row['hit']."</td><td>".$hit_summary_row['hr']."</td><td>".$hit_summary_row['bb']."</td><td>".$rs."</td><td>".$hit_summary_row['rbi']."</td><td>".$sb."</td><td>".$obp_text."</td><td>".$slg_text."</td><td>".$ops_text."</td></tr>";
            if($j > 4){

            }else if($j == 4 || $j == $years_count-1){
                $year_chart_5years = "'".$hit_summary_row['league_years']."년'".$year_chart_5years;
                $avg_chart_5years = $avg.$avg_chart_5years;
                $league_avg_chart_5years = $hit_summary_row['years_avg'].$league_avg_chart_5years;
                $obp_chart_5years = $obp.$obp_chart_5years;
                $slg_chart_5years = $slg.$slg_chart_5years;
                $ops_chart_5years = $ops.$ops_chart_5years;
            }else{
                $year_chart_5years = ",'".$hit_summary_row['league_years']."년'".$year_chart_5years;
                $avg_chart_5years = ",".$avg.$avg_chart_5years;
                $league_avg_chart_5years = ",".$hit_summary_row['years_avg'].$league_avg_chart_5years;
                $obp_chart_5years = ",".$obp.$obp_chart_5years;;
                $slg_chart_5years = ",".$slg.$slg_chart_5years;
                $ops_chart_5years = ",".$ops.$ops_chart_5years;
            }
        }else{
            $hit_table_summary = "<td>".$hit_summary_row['league_count']."</td><td>".$avg_text."</td><td>".$at_game."</td><td>".$hit_summary_row['at_bat']."</td><td>".$hit_summary_row['hit']."</td><td>".$hit_summary_row['hr']."</td><td>".$hit_summary_row['bb']."</td><td>".$rs."</td><td>".$hit_summary_row['rbi']."</td><td>".$sb."</td><td>".$obp_text."</td><td>".$slg_text."</td><td>".$ops_text."</td>";
            if($hit_summary_row['so'] != 0){
                $bbk = round(($hit_summary_row['bb']+$hit_summary_row['hbp'])/$hit_summary_row['so'],2);
            }else{
                $bbk = 0;
            }
            if($hit_summary_row['at_bat'] - $hit_summary_row['hit'] != 0){
                $sop = round($hit_summary_row['so']/($hit_summary_row['at_bat'] - $hit_summary_row['hit']),3);
            }else{
                $sop = 0;
            }
            if($hit_summary_row['at_bat'] != 0){
                $csp = round(1 - $hit_summary_row['so']/$hit_summary_row['at_bat'],3);
            }else{
                $csp = 0;
            }
            $hit_chart_summary = $avg.",".$ops.",".$bbk.",".$sop.",".$csp;
            if($hit_summary_row['at_game_count'] != 0){
                $heatmap_at_game = $hit_summary_row['at_game']/$hit_summary_row['at_game_count'];
            }else{
                $heatmap_at_game = 0;
            }
            if($hit_summary_row['hit2_count'] != 0){
                $heatmap_hit2 = $hit_summary_row['hit2']/$hit_summary_row['hit2_count'];
                $heatmap_xbh = ($hit_summary_row['hit2']+$hit_summary_row['hit3']+$hit_summary_row['hr'])/$hit_summary_row['hit2_count'];
                $iso = $slg - $avg;

            }else{

            }
            if($hit_summary_row['hit3_count'] != 0){
                $heatmap_hit3 = $hit_summary_row['hit3']/$hit_summary_row['hit3_count'];
            }else{
                $heatmap_hit3 = 0;
            }
            if($hit_summary_row['sf_count'] != 0){
                $heatmap_sf = $hit_summary_row['sf']/$hit_summary_row['sf_count'];
            }else{
                $heatmap_sf = 0;
            }
            if($hit_summary_row['sb_count'] != 0){
                $heatmap_sb = $hit_summary_row['sb']/$hit_summary_row['sb_count'];
            }else{
                $heatmap_sb = 0;
            }
            if($hit_summary_row['rs_count'] != 0){
                $heatmap_rs = $hit_summary_row['rs']/$hit_summary_row['rs_count'];
            }else{
                $heatmap_rs = 0;
            }
            $heatmap_hit = $hit_summary_row['hit']/$i;
            $heatmap_bb = $hit_summary_row['bb']/$i;
            $heatmap_so = $hit_summary_row['so']/$i;
            $heatmap_rbi = $hit_summary_row['rbi']/$i;
            $heatmap_hr = $hit_summary_row['hr']/$i;
            $player_rank = $slg + $obp + $bbk + $csp + $heatmap_at_game*0.15;
            $hit_heatmap_query ="SELECT COUNT(*) AS data_count,
                COUNT(CASE WHEN hit2 >= $heatmap_hit2 AND hit2 != 9999 THEN 1 END) AS hit2,
                COUNT(case WHEN hit2 + hit3 + hr >= $heatmap_xbh AND hit2 != 9999 THEN 1 END) AS xbh,
                COUNT(case WHEN (hit1 + hit2*2 + hit3*3 + hr*4)/at_bat >= $slg AND hit2 != 9999 AND at_bat != 0 THEN 1 END) AS slg,
                COUNT(case WHEN (hit2 + hit3*2 + hr*3)/at_bat >= $iso AND hit2 != 9999 AND at_bat != 0 THEN 1 END) AS iso,
                COUNT(CASE WHEN hit >= $heatmap_hit THEN 1 END) AS hit,
                COUNT(CASE WHEN hit/at_bat >= $avg AND at_bat != 0 THEN 1 END) AS avg,
                COUNT(CASE WHEN sf >= $heatmap_sf AND sf != 9999 THEN 1 END) AS sf,
                COUNT(CASE WHEN 1 - so/at_bat >= $csp AND at_bat != 0 THEN 1 END) AS csp,
                COUNT(CASE WHEN bb >= $heatmap_bb THEN 1 END) AS bb,
                COUNT(CASE WHEN so < $heatmap_so THEN 1 END) AS so,
                COUNT(CASE WHEN bb/so >= $bbk AND so != 0 THEN 1 END) AS bbk,
                COUNT(CASE WHEN so / (at_bat - hit) <= $sop AND at_bat != hit THEN 1 END) AS sop,
                COUNT(CASE WHEN sb >= $heatmap_sb AND sb != 9999 THEN 1 END) AS sb,
                COUNT(CASE WHEN hit3 >= $heatmap_hit3 AND hit3 != 9999 THEN 1 END) AS hit3,
                COUNT(CASE WHEN rs >= $heatmap_rs AND rs != 9999 THEN 1 END) AS rs,
                COUNT(CASE WHEN (CASE WHEN hbp != 9999 THEN (hit + bb + hbp)/(at_bat + bb + hbp) ELSE (hit + bb)/(at_bat + bb) END) >= $obp THEN 1 END) AS obp,
                COUNT(CASE WHEN at_game >= $heatmap_at_game AND at_game != 9999 THEN 1 END) AS at_game,
                COUNT(CASE WHEN rbi >= $heatmap_rbi THEN 1 END) AS rbi,
                COUNT(CASE WHEN hr >= $heatmap_hr THEN 1 END) AS hr,
                COUNT(CASE WHEN (CASE WHEN hit2 != 9999 THEN (hit1 + hit2*2 + hit3*3 + hr*4)/at_bat ELSE 0 END) + (CASE WHEN hbp != 9999 THEN (hit + bb + hbp)/(at_bat + bb + hbp) ELSE (hit + bb)/(at_bat + bb) END) >= $ops THEN 1 END) AS ops,
                COUNT(CASE WHEN (CASE WHEN hit2 != 9999 THEN (hit1 + hit2*2 + hit3*3 + hr*4)/at_bat ELSE 0 END) + (CASE WHEN hbp != 9999 THEN (hit + bb + hbp)/(at_bat + bb + hbp) ELSE (hit + bb)/(at_bat + bb) END) + (CASE WHEN so != 0 THEN (bb/so)/2 ELSE 0 END) + (CASE WHEN at_bat != 0 THEN 1 - so/at_bat ELSE 0 END) + (CASE WHEN at_game != 9999 THEN at_game*0.15 ELSE 0 END) >= $player_rank THEN 1 END) AS player 
            FROM league_record_hit WHERE 1";
            $hit_heatmap_result = mysqli_query($conn,$hit_heatmap_query);
            $hit_heatmap_row = mysqli_fetch_array($hit_heatmap_result);
            $heatmap_point = [0.02, 0.07, 0.16, 0.30, 0.50, 0.70, 0.84, 0.93, 0.98, 1.00];
            $heatmap_text = ["SSS", "SS", "S", "A+", "A", "B+", "B", "C", "D", "F"];
            $heatmap_color = ["#28497f", "#305899", "#3866b2", "#4075cc", "#4884e5", "#5093ff", "#619dff", "#72a8ff", "#84b3ff", "#96beff"];
            for($u = 0; $u < 20; $u++){
                for($k = 0; $k < count($heatmap_point); $k++){
                    if($hit_heatmap_row[$u+1]/$hit_heatmap_row[0] <= $heatmap_point[$k]){
                        $heatmap_text_table[$u] = $heatmap_text[$k];
                        $heatmap_color_table[$u] = $heatmap_color[$k];
                        $heatmap_point_chart[$u] = 10 - $k;
                        break;
                    }
                }
            }
            $lader_chart_data = (($heatmap_point_chart[0] + $heatmap_point_chart[1] + $heatmap_point_chart[2] + $heatmap_point_chart[3])/4).",".(($heatmap_point_chart[4] + $heatmap_point_chart[5] + $heatmap_point_chart[6] + $heatmap_point_chart[7])/4).",".(($heatmap_point_chart[8] + $heatmap_point_chart[9] + $heatmap_point_chart[10] + $heatmap_point_chart[11])/4).",".(($heatmap_point_chart[12] + $heatmap_point_chart[13] + $heatmap_point_chart[14] + $heatmap_point_chart[15])/4).",".(($heatmap_point_chart[16] + $heatmap_point_chart[17] + $heatmap_point_chart[18] + $heatmap_point_chart[19])/4);
            $pie_chart_data = round(($hit_heatmap_row['player']/$hit_heatmap_row['data_count'])*100,1);
        }
        $j++;
    }
}
//투수
$pit_record_query = "SELECT none_record_pit.*, 
    ROUND((er * 7)/(inning/3),2) as era, 
    ROUND((rs * 7)/(inning/3),2) as rsa, 
    ROUND((so)/(hbp + bb),2) as kbb, 
    ROUND((win_games)/(win_games + lose_games),3) as pct, 
    ROUND((hit + hr + bb + hbp)/(inning/3),2) as whip 
FROM none_record_pit 
WHERE player='$player_no' ORDER BY years DESC, created_at";
$pit_record_result = mysqli_query($conn,$pit_record_query);
$pit_table_basic = "";
$i = 0;
while($pit_record_row = mysqli_fetch_array($pit_record_result)){
    $i++;
    if($pit_record_row['pitcher_count'] == ''){
        $pitcher_count = "-";
    }else{
        $pitcher_count = $pit_record_row['pitcher_count'];
    }
    if($pit_record_row['rs'] == ''){
        $rs = "-";
        $rsa = "-";
    }else{
        $rs = $pit_record_row['rs'];
        $rsa = $pit_record_row['rsa'];
    }
    if($pit_record_row['er'] == ''){
        $er = "-";
        $era = "-";
    }else{
        $er = $pit_record_row['er'];
        $era = $pit_record_row['era'];
    }
    if($pit_record_row['pct']){
        $pct = $pit_record_row['pct'];
    }else{
        $pct = "-";
    }
    $h_inning = ($pit_record_row['inning'] - ($pit_record_row['inning'] % 3)) / 3;
    if($pit_record_row['inning'] % 3 == 0){
        $f_inning = "";
    }else if($pit_record_row['inning'] % 3 == 1){
        $f_inning = "⅓";
    }else if($pit_record_row['inning'] % 3 == 2){
        $f_inning = "⅔";
    }
    $pit_no = $pit_record_row['no'];
    $pit_table_basic = $pit_table_basic."<tr>
        <td>".$i."</td><td>".$pit_record_row['years']."</td><td>".$pit_record_row['league_name']."</td><td>".$pit_record_row['team_name']."</td><td>".$era."</td><td>".$rsa."</td><td>".$pit_record_row['at_game']."</td><td>".$pit_record_row['win_games']."</td><td>".$pit_record_row['lose_games']."</td><td>".$pit_record_row['hold_games']."</td><td>".$pit_record_row['save_games']."</td><td>".$pitcher_count."</td><td>".$h_inning.$f_inning."</td><td>".$er."</td><td>".$rs."</td><td>".$pit_record_row['hit']."</td><td>".$pit_record_row['hr']."</td><td>".$pit_record_row['bb']."</td><td>".$pit_record_row['hbp']."</td><td>".$pit_record_row['so']."</td><td>".$pct."</td><td>".$pit_record_row['whip']."</td><td><a href='javascript:;' onclick='onclick=updaterecodeform(1,$pit_no)'><i class='fa fa-edit' style='color:green'></i></a></td><td><a href='javascript:;' onclick='delete_event($pit_no,2)'><i class='fa fa-trash' style='color:red'></i></a></td>
    </tr>";
}
if($pit_table_basic){
    $pit_record_summary_query = "SELECT COUNT(CASE WHEN player='$player_no' THEN 1 END) AS record_count, 
            SUM(at_game) AS at_game,
            SUM(win_games) AS win_games,
            SUM(lose_games) AS lose_games,
            SUM(inning) AS inning, 
            SUM(hit) AS hit, 
            SUM(so) AS so, 
            SUM(CASE WHEN er IS NOT NULL THEN er END) AS er, 
            SUM(CASE WHEN rs IS NOT NULL THEN rs END) AS rs, 
            COUNT(CASE WHEN er IS NOT NULL THEN 1 END) AS er_c, 
            COUNT(CASE WHEN rs IS NOT NULL THEN 1 END) AS rs_c, 
            sum(CASE WHEN rs IS NOT NULL THEN inning END) as rs_in, 
            sum(CASE WHEN er IS NOT NULL THEN inning END) as er_in,
            ROUND((sum(win_games))/(sum(win_games) + sum(lose_games)),3) as pct, 
        ROUND((sum(hit) + sum(hr) + sum(bb) + sum(hbp))/(sum(inning)/3),2) as whip 
        FROM none_record_pit WHERE player='$player_no'";
    $pit_record_summary_result = mysqli_query($conn,$pit_record_summary_query);
    $pit_record_summary_row = mysqli_fetch_array($pit_record_summary_result);
    if($pit_record_summary_row['rs_in'] == ''){
        $rs = "-";
        $rsa = "-";
    }else{
        $rs = $pit_record_summary_row['rs'];
        $rsa = number_format(round(($pit_record_summary_row['rs']*7)/($pit_record_summary_row['rs_in']/3),2),2);
    }
    if($pit_record_summary_row['er_in'] == ''){
        $er = "-";
        $era = "-";
    }else{
        $er = $pit_record_summary_row['er'];
        $era = number_format(round(($pit_record_summary_row['er']*7)/($pit_record_summary_row['er_in']/3),2),2);
    }
    if($pit_record_summary_row['pct']){
        $pct = $pit_record_summary_row['pct'];
    }else{
        $pct = "-";
    }
    $h_inning = ($pit_record_summary_row['inning'] - ($pit_record_summary_row['inning'] % 3)) / 3;
    if($pit_record_summary_row['inning'] % 3 == 0){
        $f_inning = "";
    }else if($pit_record_summary_row['inning'] % 3 == 1){
        $f_inning = "⅓";
    }else if($pit_record_summary_row['inning'] % 3 == 2){
        $f_inning = "⅔";
    }
    $pit_table_summary = "<td>".$pit_record_summary_row['record_count']."</td><td>".$era." (".$pit_record_summary_row['er_c'].")</td><td>".$rsa." (".$pit_record_summary_row['rs_c'].")</td><td>".$pit_record_summary_row['at_game']."</td><td>".$pit_record_summary_row['win_games']."</td><td>".$pit_record_summary_row['lose_games']."</td><td>".$pct."</td><td>".$pit_record_summary_row['er']." (".$pit_record_summary_row['er_c'].")</td><td>".$pit_record_summary_row['rs']." (".$pit_record_summary_row['rs_c'].")</td><td>".$h_inning.$f_inning."</td><td>".$pit_record_summary_row['hit']."</td><td>".$pit_record_summary_row['so']."</td><td>".$pit_record_summary_row['whip']."</td>";
}
mysqli_close($conn);

?>
<?if($item != 1){?>
<!-- IE8 에서 HTML5 요소와 미디어 쿼리를 위한 HTML5 shim 와 Respond.js -->
<!-- WARNING: Respond.js 는 당신이 file:// 을 통해 페이지를 볼 때는 동작하지 않습니다. -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<link href="css/dataTables.bootstrap.min.css" rel="stylesheet">

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.3.0/js/dataTables.fixedColumns.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#recode_hitplay1').DataTable({
    	// 표시 건수기능 숨기기
        lengthChange: false,
        // 검색 기능 숨기기
        searching: false,
        // 페이징 기능 숨기기
        paging: false,

    });
    $('#recode_pitchplay').DataTable({
        // 표시 건수기능 숨기기
        lengthChange: false,
        // 검색 기능 숨기기
        searching: false,
        // 페이징 기능 숨기기
        paging: false,
    });
} );
</script>

<div class="ro_subpage">	
	<div class="container record_contents">
		<div class="to_mb_40">
			<div class="col-xs-12 col-md-6 text-left">
				<div class="to_titlebar">
					선수정보
				</div>
			</div>
			<!-- 모달창 -->
			<div class="modal fade" id="defaultModal_inputrecode">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header" id="modal_header_inputrecode">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						</div>
						<div class="modal-body" id="modal_body_inputrecode"></div>
						<div class="modal-footer" id="modal_footer_inputrecode"></div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
			<!--// 모달창 -->
			<div class="col-xs-12 col-md-3"></div>
			<div class="col-xs-12 col-md-3 text-right record_select_kinds">
				<form>
					<select class="rounded shadow" id="select_kind" onchange="change_kind()">
						<option value="1">공식기록</option>
						<option value="" selected>비공식기록</option>
						<option value="3">연습·용병기록</option>
					</select>
				</form>
			</div>
		</div>
		<hr>
		<div class="to_page_content2 to_mb_30 table-responsive rounded shadow">
			<table class="table recode_player_table">
				<tr>
					<td>
						<div class="recode_player"><img src="<?=$user_img?>" class="d-inline-block align-top rounded-circle" style=""> No. <span><?=$player_row['back_num']?></span><?=$user_row['name']?><a href="javascript:;" onclick="inputrecode()">기록입력</a></div>
						<div class="recode_player_info_table table-responsive">
							<table class="table">
								<tr>
									<th>소속팀</th><td><?=$team_name?></td>
									<th>주활동지역</th><td><?=$address?></td>
									<th>주활동리그</th><td><?=$playerclass?></td>
									
								</tr>
								<tr>
									<th>나이</th><td><?=$age?></td>
									<th>신장/체중</th><td><?=$playertall?> / <?=$playerweight?></td>
									<th>주포지션</th><td><?=$position?></td>
								</tr>
								<tr>
									<th>선출여부</th><td><?=$playercheck?></td>
									<th>투/타</th><td><?=$hitpitch?></td>
								</tr>
							</table>
						</div>
					</td>
				</tr>
			</table>
		</div><!-- 선수 정보 끝 -->
		<?if($hit_table_basic){ ?>
        <div class="row">
            <div class="to_titlebar to_mb_10">
                타자 - 평점모형
            </div>
            <hr>
            <div class="table-responsive to_mb_30 rounded shadow">
                <table class="table table_h_g record_table">
                    <tr>
                        <th>리그</th><th>타율</th><th>경기</th><th>타수</th><th>안타</th><th>홈런</th><th>볼넷</th><th>득점</th><th>타점</th><th>도루</th><th>출루율</th><th>장타율</th><th>OPS</th>
                    </tr>
                    <tr>
                        <?=$hit_table_summary;?>
                    </tr>
                </table>
            </div>
            <div class="to_mb_30">
                <div class="col-md-3 col-xs-12">
                    <div class="to_border rounded shadow">
                        <canvas id="model_pie" width="100%" height="<?=$model_pie?>"></canvas>
                    </div>
                </div>
                <div class="col-md-3 col-xs-12">
                    <div class="to_border rounded shadow">
                        <canvas id="model_radar" width="100%" height="100%"></canvas>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12">
                    <div class="to_border rounded shadow">
                        <canvas id="model_bar" width="100%" height="<?=$model_bar?>"></canvas>
                    </div>
                </div>
                <div class="col-md-12 col-xs-12">
                    <div class="to_border rounded shadow" style="padding:20px">
                         '<?=$user_row['name']?>'님은 스포지지가 보유한 리그 기록 중 상위 <?=$pie_chart_data?>%에 속합니다.
                    </div>
                </div>
                <div class="col-md-12 col-xs-12">
                    <div class="to_border heatmap_chart rounded shadow">
                        <table>
                            <thead>
                                <tr>
                                    <th>파워</th><th>정확성</th><th>선구안</th><th>주루</th><th>스타성</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td style="background-color:<?=$heatmap_color_table[0]?>;">2루타<br><br><br><?=$heatmap_text_table[0]?></td><td style="background-color:<?=$heatmap_color_table[4]?>;">안타<br><br><br><?=$heatmap_text_table[4]?></td><td style="background-color:<?=$heatmap_color_table[8]?>;">볼넷<br><br><br><?=$heatmap_text_table[8]?></td><td style="background-color:<?=$heatmap_color_table[12]?>;">도루<br><br><br><?=$heatmap_text_table[12]?></td><td style="background-color:<?=$heatmap_color_table[16]?>;">경기<br><br><br><?=$heatmap_text_table[16]?></td></tr>
                                <tr><td style="background-color:<?=$heatmap_color_table[1]?>;">장타<br><br><br><?=$heatmap_text_table[1]?></td><td style="background-color:<?=$heatmap_color_table[5]?>;">타율<br><br><br><?=$heatmap_text_table[5]?></td><td style="background-color:<?=$heatmap_color_table[9]?>;">삼진<br><br><br><?=$heatmap_text_table[9]?></td><td style="background-color:<?=$heatmap_color_table[13]?>;">3루타<br><br><br><?=$heatmap_text_table[13]?></td><td style="background-color:<?=$heatmap_color_table[17]?>;">타점<br><br><br><?=$heatmap_text_table[17]?></td></tr>
                                <tr><td style="background-color:<?=$heatmap_color_table[2]?>;">장타율<br><br><br><?=$heatmap_text_table[2]?></td><td style="background-color:<?=$heatmap_color_table[6]?>;">희생타<br><br><br><?=$heatmap_text_table[6]?></td><td style="background-color:<?=$heatmap_color_table[10]?>;">볼넷/삼진<br><br><br><?=$heatmap_text_table[10]?></td><td style="background-color:<?=$heatmap_color_table[14]?>;">득점<br><br><br><?=$heatmap_text_table[14]?></td><td style="background-color:<?=$heatmap_color_table[18]?>;">홈런<br><br><br><?=$heatmap_text_table[18]?></td></tr>
                                <tr><td style="background-color:<?=$heatmap_color_table[3]?>;">순장타율<br><br><br><?=$heatmap_text_table[3]?></td><td style="background-color:<?=$heatmap_color_table[7]?>;">컨택성공율<br><br><br><?=$heatmap_text_table[7]?></td><td style="background-color:<?=$heatmap_color_table[11]?>;">삼진율<br><br><br><?=$heatmap_text_table[11]?></td><td style="background-color:<?=$heatmap_color_table[15]?>;">출루율<br><br><br><?=$heatmap_text_table[15]?></td><td style="background-color:<?=$heatmap_color_table[19]?>;">OPS<br><br><br><?=$heatmap_text_table[19]?></td></tr>
                            </tbody>
                        </table>
                        <table class="heatmap_color_table">
                            <tr>
                                <td style="background-color:<?=$heatmap_color[0]?>;">SSS</td>
                                <td style="background-color:<?=$heatmap_color[1]?>;">SS</td>
                                <td style="background-color:<?=$heatmap_color[2]?>;">S</td>
                                <td style="background-color:<?=$heatmap_color[3]?>;">A+</td>
                                <td style="background-color:<?=$heatmap_color[4]?>;">A</td>
                                <td style="background-color:<?=$heatmap_color[5]?>;">B+</td>
                                <td style="background-color:<?=$heatmap_color[6]?>;">B</td>
                                <td style="background-color:<?=$heatmap_color[7]?>;">C</td>
                                <td style="background-color:<?=$heatmap_color[8]?>;">D</td>
                                <td style="background-color:<?=$heatmap_color[9]?>;">F</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
		<?if($year_chart_5years){?>
        <div class="row">
            <div class="to_titlebar to_mb_10">
                최근 5년 기록 요약
            </div>
            <hr>
            <div class="table-responsive to_mb_30 rounded shadow">
                <table class="table table_h_g">
                    <tr>
                        <th>년도</th><th>리그</th><th>타율</th><th>경기</th><th>타수</th><th>안타</th><th>홈런</th><th>볼넷</th><th>득점</th><th>타점</th><th>도루</th><th>출루율</th><th>장타율</th><th>OPS</th>
                    </tr>
                    <?=$hit_table_5years?>
                </table>
            </div>
            <div class="to_mb_30">
                <div class="col-md-8 col-xs-12">
                    <div class="to_border rounded shadow">
                        <canvas id="years_5_avg" width="100%" height="<?=$years_5_height;?>"></canvas>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12 to_border rounded shadow">
                123123
                </div>
                <div class="col-md-8 col-xs-12">
                    <div class="to_border rounded shadow">
                        <canvas id="years_5_ops" width="100%" height="<?=$years_5_height;?>"></canvas>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12 to_border rounded shadow">
                123123
                </div>
            </div>
        </div>
		<? } ?>
		<? } ?>
		<?if($hit_table_basic){ ?>
            <div class="to_titlebar">
                누적 기록
            </div>
            <hr>
            <div class="table-box-wrap">
                <div class="table-responsive to_mb_30 table-box rounded shadow">
                    <table class="table table_h_g recode_hitplay ro_table_12" id="recode_hitplay1">
                        <thead>
                            <tr>
                                <th>No</th><th>년도</th><th>리그명</th><th>팀명</th><th>타율</th><th>경기</th><th>타석</th><th>타수</th><th>안타</th><th>2루타</th><th>3루타</th><th>홈런</th><th>타점</th><th>득점</th><th>도루</th><th>볼넷</th><th>사사구</th><th>삼진</th><th>희생</th><th>루타</th><th>장타</th><th>출루율</th><th>장타율</th><th>OPS</th><th>수정</th><th>삭제</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?=$hit_table_basic;?>
                        </tbody>				
                    </table>
                </div>
            </div>
            <?}?>
            <?if($pit_table_basic){ ?>
            <div class="to_titlebar">
                기록요약 - 투수
            </div>
            <hr>
            <div class="table-responsive to_mb_30 ">
                <table class="table table_h_g">
                    <thead>
                        <tr>
                            <th>리그</th><th>평균자책점</th><th>실점율</th><th>경기</th><th>승</th><th>패</th><th>승률</th><th>자책</th><th>실점</th><th>이닝</th><th>피안타</th><th>탈삼진</th><th>출루허용율</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?=$pit_table_summary;?>
                        </tr>							
                    </tbody>
                </table>
            </div>
		<? } ?>
		<?if($pit_table_basic){ ?>
		<div class="to_titlebar">
			기본기록 - 투수
		</div>
		<hr>
		<div class="table-box-wrap">
			<div class="table-responsive to_mb_30 table-box">
				<table class="table table_h_g recode_pitcherplay ro_table_12" id="recode_pitchplay">
					<thead>
						<tr>
							<th>No</th><th>년도</th><th>리그명</th><th>팀명</th><th>평균자책점</th><th>실점율</th><th>경기</th><th>승</th><th>패</th><th>홀</th><th>세</th><th>투구</th><th>이닝</th><th>자책</th><th>실점</th><th>피안타</th><th>피홈런</th><th>볼넷</th><th>사사구</th><th>탈삼진</th><th>승률</th><th>출루허용율</th><th>수정</th><th>삭제</th>
						</tr>
					</thead>
					<tbody>
						<?=$pit_table_basic;?>
					</tbody>				
				</table>
			</div>
		</div>
		<? } ?>	
	</div>
</div>
<script>
var defaultModal_inputrecode = $("#defaultModal_inputrecode");
var modal_header_inputrecode = $("#modal_header_inputrecode");
var modal_body_inputrecode = $("#modal_body_inputrecode");
var modal_footer_inputrecode = $("#modal_footer_inputrecode");

var append_title;
var append_content;
var append_btn;

var thisDate = new Date();
var thisYear = thisDate.getFullYear();		//올해년도

function inputrecode() {

	modal_body_inputrecode.empty();
	modal_footer_inputrecode.empty();
	append_content ="<div class='to_titlebar'>비공식 기록</div><hr>" 
					+"<div class='nrecode_choice row'>"
					+"<div class='col-xs-6 col-sm-6 col-md-6 nrecode_choice_btn' onclick=inputrecodeform(0)>"
					+"	<img src='/img/button/nrecodechoice_btn_hit.jpg'>"
					+"</div>"
					+"<div class='col-xs-6 col-sm-6 col-md-6 nrecode_choice_btn' onclick=inputrecodeform(1)>"
					+"	<img src='/img/button/nrecodechoice_btn_pitch.jpg'>"
					+"</div>"
					+"</div>";
	modal_body_inputrecode.append(append_content);
	
	defaultModal_inputrecode.modal('show');
}

function inputrecodeform(check) {
	console.log("=======check : "+check);
	
	var selectbox;
	
	for(var y=thisYear; y>thisYear-15 ; y--){		//기록표에 들어갈 년도 선택 (y:변수 / thisYear:올해년도 / 올해년도부터 15년 전 기록까지 반복 )
		selectbox += "<option value='"+y+"'>"+y+"</option>"; 
	}
	
	modal_body_inputrecode.empty();
	modal_footer_inputrecode.empty();
	if(check==0){				//타자 - 비공식 기록 입력
		append_content = "<div class='inputrecodeform' >"
						+"	<div class='to_titlebar'>"
						+"		비공식 기록 - 타자"
						+"	</div>"
						+"	<hr>"
						+"	<form action='NoneRecordInsertProc.php' method='post'>"
						+"		<div class='form-group' id='divLeagueYear'>"
						+"	        <div class='col-xs-3 control-label'><label for='inputLeagueYear'>년도</label></div>"
						+"	        <div class='col-xs-9 input_record_form'>"
						+"	            <select class='form-control' name='years'>"
						+				selectbox	
						+"	           	</select>" 
						+"	        </div>"
						+"	    </div>"
						+"	    <div class='form-group' id='divLeaguename'>"
						+"	        <div class='col-xs-3 control-label'><label for='inputLeaguename'>리그이름</label></div>"
						+"	        <div class='col-xs-9 input_record_form'>"
						+"	            <input type='text' class='form-control' name='league_name' id='' maxlength='20'>"
						+"	        </div>"
						+"	    </div>"
						+"	    <div class='form-group' id='divTeamname'>"
						+"	        <div class='col-xs-3 control-label'><label for='inputTeamname'>팀이름</label></div>"
						+"	        <div class='col-xs-9 input_record_form'>"
						+"	            <input type='text' class='form-control' name='team_name' id='' maxlength='20'>"
						+"	        </div>"
						+"	    </div>"
						+"	    <div class='form-group' id='divPlayCnt'>"
						+"	        <div class='col-xs-3 control-label'><label for='inputPlayCnt'>경기수</label></div>"
						+"	        <div class='col-xs-9 input_record_form'>"
						+"	            <input type='text' class='form-control' name='at_game' id='' maxlength='10'>"
						+"	        </div>"
						+"	    </div>"
						+"	    <div class='form-group' id='divPlayBatter'>"
						+"	        <div class='col-xs-3 control-label'><label for='inputPlayBatter'>타석</label></div>"
						+"	        <div class='col-xs-9 input_record_form'>"
						+"	            <input type='text' class='form-control' name='at_play' id='' maxlength='10'>"
						+"	        </div>"
						+"	    </div>"
						+"	    <div class='form-group' id='divPlayBat'>"
						+"	        <div class='col-xs-3 control-label'><label for='inputPlayBat'>타수</label></div>"
						+"	        <div class='col-xs-9 input_record_form'>"
						+"	            <input type='text' class='form-control' name='at_bat' id='' maxlength='10'>"
						+"	        </div>"
						+"	    </div>"
						+"	    <div class='form-group' id='divPlayHit'>"
						+"	        <div class='col-xs-3 control-label'><label for='inputPlayHit'>안타</label></div>"
						+"	        <div class='col-xs-9 input_record_form'>"
						+"	            <input type='text' class='form-control' name='hit' id='' maxlength='10'  placeholder='1루타 + 2루타 + 3루타 + 홈런'>"
						+"	        </div>"
						+"	    </div>"
						+"	    <div class='form-group' id='divTwobase'>"
						+"	        <div class='col-xs-3 control-label'><label for='inputTwobase'>2루타</label></div>"
						+"	        <div class='col-xs-9 input_record_form'>"
						+"	            <input type='text' class='form-control' name='hit2' id='' maxlength='10'>"
						+"	        </div>"
						+"	    </div>"
						+"	    <div class='form-group' id='divThreebase'>"
						+"	        <div class='col-xs-3 control-label'><label for='inputThreebase'>3루타</label></div>"
						+"	        <div class='col-xs-9 input_record_form'>"
						+"	            <input type='text' class='form-control' name='hit3' id='' maxlength='10'>"
						+"	        </div>"
						+"	    </div>"
						+"	    <div class='form-group' id='divHomerun'>"
						+"	        <div class='col-xs-3 control-label'><label for='inputHomerun'>홈런</label></div>"
						+"	        <div class='col-xs-9 input_record_form'>"
						+"	            <input type='text' class='form-control' name='hr' id='' maxlength='10'>"
						+"	        </div>"
						+"	    </div>"
						+"	    <div class='form-group' id='divFourball'>"
						+"	        <div class='col-xs-3 control-label'><label for='inputFourball'>볼넷</label></div>"
						+"	        <div class='col-xs-9 input_record_form'>"
						+"	            <input type='text' class='form-control' name='bb' id='' maxlength='10'>"
						+"	        </div>"
						+"	    </div>"
						+"	    <div class='form-group' id='divDeadball'>"
						+"	        <div class='col-xs-3 control-label'><label for='inputDeadball'>사사구</label></div>"
						+"	        <div class='col-xs-9 input_record_form'>"
						+"	            <input type='text' class='form-control' name='hbp' id='' maxlength='10'>"
						+"	        </div>"
						+"	    </div>"
						+"	    <div class='form-group' id='divPlaypoint'>"
						+"	        <div class='col-xs-3 control-label'><label for='inputPlaypoint'>타점</label></div>"
						+"	        <div class='col-xs-9 input_record_form'>"
						+"	            <input type='text' class='form-control' name='rbi' id='' maxlength='10'>"
						+"	        </div>"
						+"	    </div>"
						+"	    <div class='form-group' id='divPlayrbi'>"
						+"	        <div class='col-xs-3 control-label'><label for='inputPlayrbi'>득점</label></div>"
						+"	        <div class='col-xs-9 input_record_form'>"
						+"	            <input type='text' class='form-control' name='rs' id='' maxlength='10'>"
						+"	        </div>"
						+"	    </div>"
						+"	    <div class='form-group' id='divPlayrbi'>"
						+"	        <div class='col-xs-3 control-label'><label for='inputPlayrbi'>도루</label></div>"
						+"	        <div class='col-xs-9 input_record_form'>"
						+"	            <input type='text' class='form-control' name='sb' id='' maxlength='10'>"
						+"	        </div>"
						+"	    </div>"
						+"	    <div class='form-group' id='divThreeout'>"
						+"	        <div class='col-xs-3 control-label'><label for='inputThreeout'>삼진</label></div>"
						+"	        <div class='col-xs-9 input_record_form'>"
						+"	            <input type='text' class='form-control' name='so' id='' maxlength='10'>"
						+"	        </div>"
						+"	    </div>"
						+"	    <div class='form-group' id='divSacrifice'>"
						+"	        <div class='col-xs-3 control-label'><label for='inputSacrifice'>희생타</label></div>"
						+"	        <div class='col-xs-9 input_record_form'>"
						+"	            <input type='text' class='form-control' name='sf' id='' maxlength='10'>"
						+"	        </div>"
						+"	    </div>"
						+"	    <div>"
						+"	    	<input type='hidden' value='1' name='pos'>"	
						+"	    	<input type='submit' class='btn btn-default' value='저장'>"
						+"	    </div>"
						+"	</form>"
						+"</div>";		
	}else{
		append_content = "<div class='inputrecodeform' >"
						+"	<div class='to_titlebar'>"
						+"		비공식 기록 - 투수"
						+"	</div>"
						+"	<hr>"
						+"	<form action='NoneRecordInsertProc.php' method='post'>"
						+"		<div class='form-group' id='divLeagueYear'>"
						+"	        <div class='col-xs-3 control-label'><label for='inputBunt'>년도</label></div>"
						+"	        <div class='col-xs-9 input_record_form'>"
						+"	            <select class='form-control' name='years'>"
						+				selectbox	
						+"	           	</select>" 
						+"	        </div>"
						+"	    </div>"
						+"	    <div class='form-group' id='divLeaguename'>"
						+"	        <div class='col-xs-3 control-label'><label for='inputBunt'>리그이름</label></div>"
						+"	        <div class='col-xs-9 input_record_form'>"
						+"	            <input type='text' class='form-control' name='league_name' id='' maxlength='20'>"
						+"	        </div>"
						+"	    </div>"
						+"	    <div class='form-group' id='divTeamname'>"
						+"	        <div class='col-xs-3 control-label'><label for='inputBunt'>팀이름</label></div>"
						+"	        <div class='col-xs-9 input_record_form'>"
						+"	            <input type='text' class='form-control' name='team_name' id='' maxlength='20'>"
						+"	        </div>"
						+"	    </div>"
						+"	    <div class='form-group' id='divPlayCnt'>"
						+"	        <div class='col-xs-3 control-label'><label for='inputBunt'>경기수</label></div>"
						+"	        <div class='col-xs-9 input_record_form'>"
						+"	            <input type='text' class='form-control' name='at_game' id='' maxlength='10'>"
						+"	        </div>"
						+"	    </div>"
						+"	    <div class='form-group' id='divWin'>"
						+"	        <div class='col-xs-3 control-label'><label for='inputWin'>승리</label></div>"
						+"	        <div class='col-xs-9 input_record_form'>"
						+"	            <input type='text' class='form-control' name='win_games' id='' maxlength='10'>"
						+"	        </div>"
						+"	    </div>"
						+"	    <div class='form-group' id='divLoss'>"
						+"	        <div class='col-xs-3 control-label'><label for='inputLoss'>패배</label></div>"
						+"	        <div class='col-xs-9 input_record_form'>"
						+"	            <input type='text' class='form-control' name='lose_games' id='' maxlength='10'>"
						+"	        </div>"
						+"	    </div>"
						+"	    <div class='form-group' id='divSave'>"
						+"	        <div class='col-xs-3 control-label'><label for='inputSave'>세이브</label></div>"
						+"	        <div class='col-xs-9 input_record_form'>"
						+"	            <input type='text' class='form-control' name='save_games' id='' maxlength='10'>"
						+"	        </div>"
						+"	    </div>"
						+"	    <div class='form-group' id='divHold'>"
						+"	        <div class='col-xs-3 control-label'><label for='inputHold'>홀드</label></div>"
						+"	        <div class='col-xs-9 input_record_form'>"
						+"	            <input type='text' class='form-control' name='hold_games' id='' maxlength='10'>"
						+"	        </div>"
						+"	    </div>"
						+"	    <div class='form-group' id='divInning'>"
						+"	        <div class='col-xs-3 control-label'><label for='inputInning'>이닝</label></div>"
						+"	        <div class='col-xs-6 input_record_form'>"
						+"	            <input type='text' class='form-control' name='h_inning' id='' maxlength='10'>"
						+"	        </div>"
						+"	        <div class='col-xs-3 input_record_form'>"
						+"	            <select class='form-control' name='f_inning'>"
						+"	            	<option value='0'>0</option>"
						+"	            	<option value='1' style='font-size:150%'>⅓</option>"
						+"	            	<option value='2' style='font-size:150%'>⅔</option>"
						+"	            </select>"
						+"	        </div>"
						+"	    </div>"
						+"	    <div class='form-group' id='divPitch'>"
						+"	        <div class='col-xs-3 control-label'><label for='inputPitch'>투구수</label></div>"
						+"	        <div class='col-xs-9 input_record_form'>"
						+"	            <input type='text' class='form-control' name='pitcher_count' id='' maxlength='10'>"
						+"	        </div>"
						+"	    </div>"
						+"	    <div class='form-group' id='divErpoint' >"
						+"			<div class='col-xs-3 control-label'><label for='divErpoint'>자책점</label></div>"
						+"	        <div class='col-xs-9 input_record_form'>"
						+"	            <input type='text' class='form-control' name='er' id='' maxlength='10'>"
						+"	        </div>"
						+"	    </div>"
						+"	    <div class='form-group' id='divLosepoint' >"
						+"			<div class='col-xs-3 control-label'><label for='inputLosepoint'>실점</label></div>"
						+"	        <div class='col-xs-9 input_record_form'>"
						+"	            <input type='text' class='form-control' name='rs' id='' maxlength='10'>"
						+"	        </div>"
						+"	    </div>"
						+"	    <div class='form-group' id='divHits'>"
						+"	        <div class='col-xs-3 control-label'><label for='inputHits'>피안타</label></div>"
						+"	        <div class='col-xs-9 input_record_form'>"
						+"	            <input type='text' class='form-control' name='hit' id='' maxlength='10'>"
						+"	        </div>"
						+"	    </div>"
						+"	    <div class='form-group' id='divHomeruns'>"
						+"	        <div class='col-xs-3 control-label'><label for='inputHomeruns'>피홈런</label></div>"
						+"	        <div class='col-xs-9 input_record_form'>"
						+"	            <input type='text' class='form-control' name='hr' id='' maxlength='10'>"
						+"	        </div>"
						+"	    </div>"
						+"	    <div class='form-group' id='divThreeouts'>"
						+"	        <div class='col-xs-3 control-label'><label for='inputThreeouts'>탈삼진</label></div>"
						+"	        <div class='col-xs-9 input_record_form'>"
						+"	            <input type='text' class='form-control' name='so' id='' maxlength='10'>"
						+"	        </div>"
						+"	    </div>"
						+"	    <div class='form-group' id='divFourballs'>"
						+"	        <div class='col-xs-3 control-label'><label for='inputFourballs'>볼넷</label></div>"
						+"	        <div class='col-xs-9 input_record_form'>"
						+"	            <input type='text' class='form-control' name='bb' id='' maxlength='10'>"
						+"	        </div>"
						+"	    </div>"
						+"	    <div class='form-group' id='divDeadballs' >"
						+"			<div class='col-xs-3 control-label'><label for='inputDeadballs'>사사구</label></div>"
						+"	        <div class='col-xs-9 input_record_form'>"
						+"	            <input type='text' class='form-control' name='hbp' id='' maxlength='10'>"
						+"	        </div>"
						+"	    </div>"
						+"	    <div>"
						+"	    	<input type='hidden' value='2' name='pos'>"	
						+"	    	<input type='submit' class='btn btn-default' value='저장'>"
						+"	    </div>"
						+"	</form>"
						+"</div>";	
	}
	
	modal_body_inputrecode.append(append_content);		//<form>
	defaultModal_inputrecode.modal('show');
}
function updaterecodeform(check,num) {
	console.log("=======check : "+check);

	$.ajax({
		type: 'POST',
		url: 'edit_data.php',
		data: {
			no : num,
			position : check
		},
		dataTpye: 'text',
		success: function(data){
			select_data = data.split('|');
			var selectbox;
			for(var y=thisYear; y>thisYear-15 ; y--){	//기록표에 들어갈 년도 선택 (y:변수 / thisYear:올해년도 / 올해년도부터 15년 전 기록까지 반복 )
				if(select_data[0] == y){
					selectbox += "<option value='"+y+"' selected>"+y+"</option>"; 
				}else{
					selectbox += "<option value='"+y+"'>"+y+"</option>"; 
				}
			}
			
			modal_body_inputrecode.empty();
			modal_footer_inputrecode.empty();
			if(check==0){
				append_content = "<div class='inputrecodeform' >"
								+"	<div class='to_titlebar'>"
								+"		비공식 기록 - 타자"
								+"	</div>"
								+"	<hr>"
								+"	<form action='NoneRecordUpdateProc.php' method='post'>"
								+"		<div class='form-group' id='divLeagueYear'>"
								+"	        <div class='col-xs-3 control-label'><label for='inputLeagueYear'>년도</label></div>"
								+"	        <div class='col-xs-9 input_record_form'>"
								+"	            <select class='form-control' name='years'>"
								+				selectbox	
								+"	           	</select>" 
								+"	        </div>"
								+"	    </div>"
								+"	    <div class='form-group' id='divLeaguename'>"
								+"	        <div class='col-xs-3 control-label'><label for='inputLeaguename'>리그이름</label></div>"
								+"	        <div class='col-xs-9 input_record_form'>"
								+"	            <input type='text' class='form-control' name='league_name' id='' maxlength='20' value="+select_data[1]+">"
								+"	        </div>"
								+"	    </div>"
								+"	    <div class='form-group' id='divTeamname'>"
								+"	        <div class='col-xs-3 control-label'><label for='inputTeamname'>팀이름</label></div>"
								+"	        <div class='col-xs-9 input_record_form'>"
								+"	            <input type='text' class='form-control' name='team_name' id='' maxlength='20' value="+select_data[2]+">"
								+"	        </div>"
								+"	    </div>"
								+"	    <div class='form-group' id='divPlayCnt'>"
								+"	        <div class='col-xs-3 control-label'><label for='inputPlayCnt'>경기수</label></div>"
								+"	        <div class='col-xs-9 input_record_form'>"
								+"	            <input type='text' class='form-control' name='at_game' id='' maxlength='10' value="+select_data[3]+">"
								+"	        </div>"
								+"	    </div>"
								+"	    <div class='form-group' id='divPlayBatter'>"
								+"	        <div class='col-xs-3 control-label'><label for='inputPlayBatter'>타석</label></div>"
								+"	        <div class='col-xs-9 input_record_form'>"
								+"	            <input type='text' class='form-control' name='at_play' id='' maxlength='10' value="+select_data[4]+">"
								+"	        </div>"
								+"	    </div>"
								+"	    <div class='form-group' id='divPlayBat'>"
								+"	        <div class='col-xs-3 control-label'><label for='inputPlayBat'>타수</label></div>"
								+"	        <div class='col-xs-9 input_record_form'>"
								+"	            <input type='text' class='form-control' name='at_bat' id='' maxlength='10' value="+select_data[5]+">"
								+"	        </div>"
								+"	    </div>"
								+"	    <div class='form-group' id='divPlayHit'>"
								+"	        <div class='col-xs-3 control-label'><label for='inputPlayHit'>안타</label></div>"
								+"	        <div class='col-xs-9 input_record_form'>"
								+"	            <input type='text' class='form-control' name='hit' id='' maxlength='10'  placeholder='1루타 + 2루타 + 3루타 + 홈런' value="+select_data[6]+">"
								+"	        </div>"
								+"	    </div>"
								+"	    <div class='form-group' id='divTwobase'>"
								+"	        <div class='col-xs-3 control-label'><label for='inputTwobase'>2루타</label></div>"
								+"	        <div class='col-xs-9 input_record_form'>"
								+"	            <input type='text' class='form-control' name='hit2' id='' maxlength='10' value="+select_data[7]+">"
								+"	        </div>"
								+"	    </div>"
								+"	    <div class='form-group' id='divThreebase'>"
								+"	        <div class='col-xs-3 control-label'><label for='inputThreebase'>3루타</label></div>"
								+"	        <div class='col-xs-9 input_record_form'>"
								+"	            <input type='text' class='form-control' name='hit3' id='' maxlength='10' value="+select_data[8]+">"
								+"	        </div>"
								+"	    </div>"
								+"	    <div class='form-group' id='divHomerun'>"
								+"	        <div class='col-xs-3 control-label'><label for='inputHomerun'>홈런</label></div>"
								+"	        <div class='col-xs-9 input_record_form'>"
								+"	            <input type='text' class='form-control' name='hr' id='' maxlength='10' value="+select_data[9]+">"
								+"	        </div>"
								+"	    </div>"
								+"	    <div class='form-group' id='divFourball'>"
								+"	        <div class='col-xs-3 control-label'><label for='inputFourball'>볼넷</label></div>"
								+"	        <div class='col-xs-9 input_record_form'>"
								+"	            <input type='text' class='form-control' name='bb' id='' maxlength='10' value="+select_data[10]+">"
								+"	        </div>"
								+"	    </div>"
								+"	    <div class='form-group' id='divDeadball'>"
								+"	        <div class='col-xs-3 control-label'><label for='inputDeadball'>사사구</label></div>"
								+"	        <div class='col-xs-9 input_record_form'>"
								+"	            <input type='text' class='form-control' name='hbp' id='' maxlength='10' value="+select_data[11]+">"
								+"	        </div>"
								+"	    </div>"
								+"	    <div class='form-group' id='divPlaypoint'>"
								+"	        <div class='col-xs-3 control-label'><label for='inputPlaypoint'>타점</label></div>"
								+"	        <div class='col-xs-9 input_record_form'>"
								+"	            <input type='text' class='form-control' name='rbi' id='' maxlength='10' value="+select_data[12]+">"
								+"	        </div>"
								+"	    </div>"
								+"	    <div class='form-group' id='divPlayrbi'>"
								+"	        <div class='col-xs-3 control-label'><label for='inputPlayrbi'>득점</label></div>"
								+"	        <div class='col-xs-9 input_record_form'>"
								+"	            <input type='text' class='form-control' name='rs' id='' maxlength='10' value="+select_data[13]+">"
								+"	        </div>"
								+"	    </div>"
								+"	    <div class='form-group' id='divPlayrbi'>"
								+"	        <div class='col-xs-3 control-label'><label for='inputPlayrbi'>도루</label></div>"
								+"	        <div class='col-xs-9 input_record_form'>"
								+"	            <input type='text' class='form-control' name='sb' id='' maxlength='10' value="+select_data[14]+">"
								+"	        </div>"
								+"	    </div>"
								+"	    <div class='form-group' id='divThreeout'>"
								+"	        <div class='col-xs-3 control-label'><label for='inputThreeout'>삼진</label></div>"
								+"	        <div class='col-xs-9 input_record_form'>"
								+"	            <input type='text' class='form-control' name='so' id='' maxlength='10' value="+select_data[15]+">"
								+"	        </div>"
								+"	    </div>"
								+"	    <div class='form-group' id='divSacrifice'>"
								+"	        <div class='col-xs-3 control-label'><label for='inputSacrifice'>희생타</label></div>"
								+"	        <div class='col-xs-9 input_record_form'>"
								+"	            <input type='text' class='form-control' name='sf' id='' maxlength='10' value="+select_data[16]+">"
								+"	        </div>"
								+"	    </div>"
								+"	    <div>"
								+"	    	<input type='hidden' value='"+num+"' name='no'>"		
								+"	    	<input type='hidden' value='1' name='pos'>"	
								+"	    	<input type='submit' class='btn btn-default' value='저장'>"
								+"	    </div>"
								+"	</form>"
								+"</div>";		
			}else{
				if(select_data[9] == 1){
					selected_0 = "";
					selected_1 = "selected";
					selected_2 = "";
				}else if(select_data[9] == 2){
					selected_0 = "";
					selected_1 = "";
					selected_2 = "selected";
				}else{
					selected_0 = "selected";
					selected_1 = "";
					selected_2 = "";
				}
				append_content = "<div class='inputrecodeform' >"
								+"	<div class='to_titlebar'>"
								+"		비공식 기록 - 투수"
								+"	</div>"
								+"	<hr>"
								+"	<form action='NoneRecordUpdateProc.php' method='post'>"
								+"		<div class='form-group' id='divLeagueYear'>"
								+"	        <div class='col-xs-3 control-label'><label for='inputBunt'>년도</label></div>"
								+"	        <div class='col-xs-9 input_record_form'>"
								+"	            <select class='form-control' name='years'>"
								+				selectbox	
								+"	           	</select>" 
								+"	        </div>"
								+"	    </div>"
								+"	    <div class='form-group' id='divLeaguename'>"
								+"	        <div class='col-xs-3 control-label'><label for='inputBunt'>리그이름</label></div>"
								+"	        <div class='col-xs-9 input_record_form'>"
								+"	            <input type='text' class='form-control' name='league_name' id='' maxlength='20' value="+select_data[1]+">"
								+"	        </div>"
								+"	    </div>"
								+"	    <div class='form-group' id='divTeamname'>"
								+"	        <div class='col-xs-3 control-label'><label for='inputBunt'>팀이름</label></div>"
								+"	        <div class='col-xs-9 input_record_form'>"
								+"	            <input type='text' class='form-control' name='team_name' id='' maxlength='20' value="+select_data[2]+">"
								+"	        </div>"
								+"	    </div>"
								+"	    <div class='form-group' id='divPlayCnt'>"
								+"	        <div class='col-xs-3 control-label'><label for='inputBunt'>경기수</label></div>"
								+"	        <div class='col-xs-9 input_record_form'>"
								+"	            <input type='text' class='form-control' name='at_game' id='' maxlength='10' value="+select_data[3]+">"
								+"	        </div>"
								+"	    </div>"
								+"	    <div class='form-group' id='divWin'>"
								+"	        <div class='col-xs-3 control-label'><label for='inputWin'>승리</label></div>"
								+"	        <div class='col-xs-9 input_record_form'>"
								+"	            <input type='text' class='form-control' name='win_games' id='' maxlength='10' value="+select_data[4]+">"
								+"	        </div>"
								+"	    </div>"
								+"	    <div class='form-group' id='divLoss'>"
								+"	        <div class='col-xs-3 control-label'><label for='inputLoss'>패배</label></div>"
								+"	        <div class='col-xs-9 input_record_form'>"
								+"	            <input type='text' class='form-control' name='lose_games' id='' maxlength='10' value="+select_data[5]+">"
								+"	        </div>"
								+"	    </div>"
								+"	    <div class='form-group' id='divSave'>"
								+"	        <div class='col-xs-3 control-label'><label for='inputSave'>세이브</label></div>"
								+"	        <div class='col-xs-9 input_record_form'>"
								+"	            <input type='text' class='form-control' name='save_games' id='' maxlength='10' value="+select_data[6]+">"
								+"	        </div>"
								+"	    </div>"
								+"	    <div class='form-group' id='divHold'>"
								+"	        <div class='col-xs-3 control-label'><label for='inputHold'>홀드</label></div>"
								+"	        <div class='col-xs-9 input_record_form'>"
								+"	            <input type='text' class='form-control' name='hold_games' id='' maxlength='10' value="+select_data[7]+">"
								+"	        </div>"
								+"	    </div>"
								+"	    <div class='form-group' id='divInning'>"
								+"	        <div class='col-xs-3 control-label'><label for='inputInning'>이닝</label></div>"
								+"	        <div class='col-xs-6 input_record_form'>"
								+"	            <input type='text' class='form-control' name='h_inning' id='' maxlength='10' value="+select_data[8]+">"
								+"	        </div>"
								+"	        <div class='col-xs-3 input_record_form'>"
								+"	            <select class='form-control' name='f_inning'>"
								+"	            	<option value='0' "+selected_0+">0</option>"
								+"	            	<option value='1' style='font-size:150%' "+selected_1+">⅓</option>"
								+"	            	<option value='2' style='font-size:150%' "+selected_2+">⅔</option>"
								+"	            </select>"
								+"	        </div>"
								+"	    </div>"
								+"	    <div class='form-group' id='divPitch'>"
								+"	        <div class='col-xs-3 control-label'><label for='inputPitch'>투구수</label></div>"
								+"	        <div class='col-xs-9 input_record_form'>"
								+"	            <input type='text' class='form-control' name='pitcher_count' id='' maxlength='10' value="+select_data[10]+">"
								+"	        </div>"
								+"	    </div>"
								+"	    <div class='form-group' id='divErpoint' >"
								+"			<div class='col-xs-3 control-label'><label for='divErpoint'>자책점</label></div>"
								+"	        <div class='col-xs-9 input_record_form'>"
								+"	            <input type='text' class='form-control' name='er' id='' maxlength='10' value="+select_data[11]+">"
								+"	        </div>"
								+"	    </div>"
								+"	    <div class='form-group' id='divLosepoint' >"
								+"			<div class='col-xs-3 control-label'><label for='inputLosepoint'>실점</label></div>"
								+"	        <div class='col-xs-9 input_record_form'>"
								+"	            <input type='text' class='form-control' name='rs' id='' maxlength='10' value="+select_data[12]+">"
								+"	        </div>"
								+"	    </div>"
								+"	    <div class='form-group' id='divHits'>"
								+"	        <div class='col-xs-3 control-label'><label for='inputHits'>피안타</label></div>"
								+"	        <div class='col-xs-9 input_record_form'>"
								+"	            <input type='text' class='form-control' name='hit' id='' maxlength='10' value="+select_data[13]+">"
								+"	        </div>"
								+"	    </div>"
								+"	    <div class='form-group' id='divHomeruns'>"
								+"	        <div class='col-xs-3 control-label'><label for='inputHomeruns'>피홈런</label></div>"
								+"	        <div class='col-xs-9 input_record_form'>"
								+"	            <input type='text' class='form-control' name='hr' id='' maxlength='10' value="+select_data[14]+">"
								+"	        </div>"
								+"	    </div>"
								+"	    <div class='form-group' id='divThreeouts'>"
								+"	        <div class='col-xs-3 control-label'><label for='inputThreeouts'>탈삼진</label></div>"
								+"	        <div class='col-xs-9 input_record_form'>"
								+"	            <input type='text' class='form-control' name='so' id='' maxlength='10' value="+select_data[15]+">"
								+"	        </div>"
								+"	    </div>"
								+"	    <div class='form-group' id='divFourballs'>"
								+"	        <div class='col-xs-3 control-label'><label for='inputFourballs'>볼넷</label></div>"
								+"	        <div class='col-xs-9 input_record_form'>"
								+"	            <input type='text' class='form-control' name='bb' id='' maxlength='10' value="+select_data[16]+">"
								+"	        </div>"
								+"	    </div>"
								+"	    <div class='form-group' id='divDeadballs' >"
								+"			<div class='col-xs-3 control-label'><label for='inputDeadballs'>사사구</label></div>"
								+"	        <div class='col-xs-9 input_record_form'>"
								+"	            <input type='text' class='form-control' name='hbp' id='' maxlength='10' value="+select_data[17]+">"
								+"	        </div>"
								+"	    </div>"
								+"	    <div>"
								+"	    	<input type='hidden' value='"+num+"' name='no'>"	
								+"	    	<input type='hidden' value='2' name='pos'>"	
								+"	    	<input type='submit' class='btn btn-default' value='저장'>"
								+"	    </div>"
								+"	</form>"
								+"</div>";	
			}
			
			modal_body_inputrecode.append(append_content);		//<form>
			if(data){
				defaultModal_inputrecode.modal('show');
			}
		},
		error: function() {
			alert('Error');
		}
	});	
}
</script>
<script>
function delete_event(no){
	if (confirm("정말 삭제하시겠습니까?") == true){
		location.href="LeagueRecordDeleteProc.php?no="+no;
	}else{ 
		return;
	}
}
function change_kind(){
	var selectkind = document.getElementById("select_kind");
	var selectedValue = selectkind.options[selectkind.selectedIndex].value;
	if(selectedValue == 1){
		location.href = "test.php?user=<?=$_GET['user']?>";
	}else if(selectedValue == 2){
		location.href = "test2.php?user=<?=$_GET['user']?>";
	}else if(selectedValue == 3){
		location.href = "test3.php?user=<?=$_GET['user']?>";
	}
}
Chart.pluginService.register({
	beforeDraw: function (chart) {
		if (chart.config.options.elements.center) {
			//Get ctx from string
			var ctx = chart.chart.ctx;

			//Get options from the center object in options
			var centerConfig = chart.config.options.elements.center;
			var fontStyle = centerConfig.fontStyle || 'Arial';
			var txt = centerConfig.text;
			var color = centerConfig.color || '#000';
			var sidePadding = centerConfig.sidePadding || 20;
			var sidePaddingCalculated = (sidePadding/100) * (chart.innerRadius * 2)
			//Start with a base font of 30px
			ctx.font = "30px " + fontStyle;

			//Get the width of the string and also the width of the element minus 10 to give it 5px side padding
			var stringWidth = ctx.measureText(txt).width;
			var elementWidth = (chart.innerRadius * 2) - sidePaddingCalculated;

			// Find out how much the font can grow in width.
			var widthRatio = elementWidth / stringWidth;
			var newFontSize = Math.floor(30 * widthRatio);
			var elementHeight = (chart.innerRadius * 2);

			// Pick a new font size so it will not be larger than the height of label.
			var fontSizeToUse = Math.min(newFontSize, elementHeight);

			//Set font settings to draw it correctly.
			ctx.textAlign = 'center';
			ctx.textBaseline = 'middle';
			var centerX = ((chart.chartArea.left + chart.chartArea.right) / 2);
			var centerY = ((chart.chartArea.top + chart.chartArea.bottom) / 2);
			ctx.font = fontSizeToUse+"px " + fontStyle;
			ctx.fillStyle = color;

			//Draw text in center
			ctx.fillText(txt, centerX, centerY);
		}
	}
});
var ctx2 = document.getElementById('model_radar');
var myRadarChart = new Chart(ctx2, {
    type: 'radar',
    data: {
		labels: ['파워', '정확성', '선구안', '주루', '스타성'],
		datasets: [{
			label: '내 기록',
			data: [<?=$lader_chart_data?>],
			backgroundColor : 'rgba(0, 0, 255, 0.3)',
			borderColor: 'rgba(0, 0, 255, 0.7)',
			pointBackgroundColor: 'rgba(0, 0, 255, 0.7)',
			pointBorderColor: '#fff'
			
		},{
			label: '리그 평균',
			data: [6.5, 4.5, 5.5, 5.5, 4.75],
			backgroundColor: 'rgba(179, 181, 198, 0.2)',
            borderColor: 'rgba(179, 181, 198, 0.7)',
            pointBackgroundColor: 'rgba(179, 181, 198, 0.7)',
            pointBorderColor: '#fff'
		}]
	},
    options : {
		scale: {
			ticks: {
				suggestedMin: 0,
				suggestedMax: 10,
				fontFamily: 'Do Hyeon',
				fontSize: 15
			},pointLabels: {
				fontFamily: 'Do Hyeon',
				fontSize: 17
			}
		},
		title: {
            display: false,
            text: '그래프1',
			fontFamily: 'Do Hyeon',
			position: 'top',
			fontSize: 20
        },
		elements: {
			line: {
				tension:0,
				borderWidth:3
			}
		},
		tooltips: {
			enabled: false
		}
	}
});
var ctx2 = document.getElementById('model_bar');
var myBarChart = new Chart(ctx2, {
    type: 'horizontalBar',
    data: {
		labels: ['타율', 'OPS', '볼넷/삼진', '삼진율', '컨택성공율'],
		datasets: [{
			data: [<?=$hit_chart_summary?>],
			label: '내 기록',
			backgroundColor : 'rgba(0, 0, 255, 0.7)'
		},{
			data: [0.376, 0.999, 1.12, 0.29, 0.819],
			label: '리그 평균',
			backgroundColor: 'rgba(179, 181, 198, 0.7)'
		}]
	},
	options: {
		title: {
            display: false,
            text: '그래프2',
			fontFamily: 'Do Hyeon',
			position: 'top',
			fontSize: 20
        }
	}
});
var ctx = document.getElementById('model_pie');
var myDoughnutChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
		datasets: [{
			data: [<?=(100-$pie_chart_data)?>, <?=$pie_chart_data?>],
			backgroundColor: [
                'rgba(0, 0, 255, 0.6)'
            ],
		}]
	},
	options: {
        legend: {
            display: false
		},
		responsive: true,
		display : "inline-block",
		tooltips: {
			enabled: false
		},
		elements: {
			center: {
			text: '<?=($pie_chart_data)?>%',
			color: 'rgba(0, 0, 255, 0.6)', //Default black
			fontStyle: 'Do Hyeon', //Default Arial
			sidePadding: 15 //Default 20 (as a percentage)
			}
		},
		title: {
            display: false,
            text: '그래프3',
			fontFamily: 'Do Hyeon',
			position: 'top',
			fontSize: 20
        }
	}
});
<?if($year_chart_5years){?>
var ctx2 = document.getElementById('years_5_avg');
var myLineChart = new Chart(ctx2, {
    type: 'line',
    data: {
		labels : [<?=$year_chart_5years?>],
		datasets : [{
			data : [<?=$avg_chart_5years?>],
			label: '타율',
			backgroundColor : 'rgba(0, 0, 255, 0.8)',
			borderColor: 'rgba(0, 0, 255, 0.6)',
			fill : false
		},{
			data : [<?=$league_avg_chart_5years?>],
			label: '리그평균',
			backgroundColor: 'rgba(179, 181, 198, 0.8)',
			borderColor: 'rgba(179, 181, 198, 0.6)',
			fill : false
		}]
	},
	options: {
		title: {
            display: false,
            text: '최근 5년 타율',
			fontFamily: 'Do Hyeon',
			position: 'top',
			fontSize: 20
        },
		tooltips: {
			mode: 'index',
			intersect: false
		}
	}
});
var ctx2 = document.getElementById('years_5_ops');
var myBarChart = new Chart(ctx2, {
    type: 'bar',
    data: {
		labels : [<?=$year_chart_5years?>],
		datasets: [{
			data: [<?=$ops_chart_5years?>],
			stack: 'Stack 1',
			label: 'OPS',
			type: 'line',
			fill: false,
			backgroundColor : 'rgba(255, 99, 132, 1)',
			borderColor: 'rgba(255, 99, 132, 0.7)'
		},{
			data: [<?=$slg_chart_5years?>],
			stack: 'Stack 0',
			label: '장타율',
			backgroundColor : 'rgba(54, 162, 235, 1)'
		},{
			data: [<?=$obp_chart_5years?>],
			stack: 'Stack 0',
			label: '출루율',
			backgroundColor : 'rgba(75, 192, 192, 1)'
		}]
	},
	options: {
		scales: {
		   xAxes: [{
				stacked: true
		   }]
	   },
		title: {
            display: false,
            text: '그래프5',
			fontFamily: 'Do Hyeon',
			position: 'top',
			fontSize: 20
        },
		tooltips: {
			mode: 'index',
			intersect: false
		}
	}
});
<? } ?>
</script>
</body>
</html>
<? } ?>
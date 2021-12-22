<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8">
</head>
<body>
    <?
    $user_no = $_GET['user'];
    include "dbconn.php";
    $user_result = mysqli_query($conn,"SELECT * FROM user WHERE no = '$user_no'");
    $user_row = mysqli_fetch_array($user_result);
    echo "user<br>";
    print_r($user_row);
    $user_player_result = mysqli_query($conn,"SELECT * FROM user_player WHERE user = '".$user_row['no']."'");
    $user_player_row = mysqli_fetch_array($user_player_result);
    echo "<br><br>user_player<br>";
    print_r($user_player_row);
    $user_player_record_result = mysqli_query($conn,"SELECT * FROM user_player_record WHERE player = '".$user_player_row['no']."'");
    echo "<br><br>user_player_record<br>";
    while($user_player_record_row = mysqli_fetch_array($user_player_record_result)){
        print_r($user_player_record_row);
        echo "<br>";
    }
    $hit_record_query = "SELECT league_record_hit.* FROM user_player_record JOIN league_record_hit WHERE user_player_record.player='".$user_player_row['no']."' AND position='1' AND league_record_hit.no = user_player_record.record";
    $hit_record_result = mysqli_query($conn,$hit_record_query);
    echo "<br>league_record_hit<br>";
    while($hit_record_row = mysqli_fetch_array($hit_record_result)){
        print_r($hit_record_row);
        echo "<br>";
    }
    $hit_record_league_info_query = "SELECT league_info.* 
    FROM user_player_record JOIN league_record_hit JOIN league_info 
    WHERE user_player_record.player='".$user_player_row['no']."' AND position='1' AND league_record_hit.no = user_player_record.record AND league_record_hit.league_info = league_info.no 
    ORDER BY league_info.years DESC";
    $hit_record_league_info_result = mysqli_query($conn,$hit_record_league_info_query);
    echo "<br>league_info (hit)<br>";
    while($hit_record_league_info_row = mysqli_fetch_array($hit_record_league_info_result)){
        print_r($hit_record_league_info_row);
        echo "<br>";
    }
    $hit_record_league_query = "SELECT league.* 
    FROM user_player_record JOIN league_record_hit JOIN league_info JOIN league 
    WHERE user_player_record.player='".$user_player_row['no']."' AND position='1' AND league_record_hit.no = user_player_record.record AND league_record_hit.league_info = league_info.no AND league_info.league = league.no 
    ORDER BY league_info.years DESC, league.created_at";
    $hit_record_league_result = mysqli_query($conn,$hit_record_league_query);
    echo "<br>league (hit)<br>";
    while($hit_record_league_row = mysqli_fetch_array($hit_record_league_result)){
        print_r($hit_record_league_row);
        echo "<br>";
    }
    $pit_record_query = "SELECT league_record_pit.* FROM user_player_record JOIN league_record_pit WHERE user_player_record.player='".$user_player_row['no']."' AND position='2' AND league_record_pit.no = user_player_record.record";
    $pit_record_result = mysqli_query($conn,$pit_record_query);
    echo "<br>league_record_pit<br>";
    while($pit_record_row = mysqli_fetch_array($pit_record_result)){
        print_r($pit_record_row);
        echo "<br>";
    }
    $pit_record_league_info_query = "SELECT league_info.* 
    FROM user_player_record JOIN league_record_pit JOIN league_info 
    WHERE user_player_record.player='".$user_player_row['no']."' AND position='2' AND league_record_pit.no = user_player_record.record AND league_record_pit.league_info = league_info.no 
    ORDER BY league_info.years DESC";
    $pit_record_league_info_result = mysqli_query($conn,$pit_record_league_info_query);
    echo "<br>league_info (pit)<br>";
    while($pit_record_league_info_row = mysqli_fetch_array($pit_record_league_info_result)){
        print_r($pit_record_league_info_row);
        echo "<br>";
    }
    $pit_record_league_query = "SELECT league.* 
    FROM user_player_record JOIN league_record_pit JOIN league_info JOIN league 
    WHERE user_player_record.player='".$user_player_row['no']."' AND position='2' AND league_record_pit.no = user_player_record.record AND league_record_pit.league_info = league_info.no AND league_info.league = league.no 
    ORDER BY league_info.years DESC, league.created_at";
    $pit_record_league_result = mysqli_query($conn,$pit_record_league_query);
    echo "<br>league (pit)<br>";
    while($pit_record_league_row = mysqli_fetch_array($pit_record_league_result)){
        print_r($pit_record_league_row);
        echo "<br>";
    }
    $hit_none_record_query = "SELECT * FROM none_record_hit WHERE player = '".$user_player_row['no']."'";
    $hit_none_record_result = mysqli_query($conn,$hit_none_record_query);
    echo "<br>none_record_hit<br>";
    while($hit_none_record_row = mysqli_fetch_array($hit_none_record_result)){
        print_r($hit_none_record_row);
        echo "<br>";
    }
    $pit_none_record_query = "SELECT * FROM none_record_pit WHERE player = '".$user_player_row['no']."'";
    $pit_none_record_result = mysqli_query($conn,$pit_none_record_query);
    echo "<br>none_record_pit<br>";
    while($pit_none_record_row = mysqli_fetch_array($pit_none_record_result)){
        print_r($pit_none_record_row);
        echo "<br>";
    }
    $hit_test_record_query = "SELECT * FROM test_record_hit WHERE player = '".$user_player_row['no']."'";
    $hit_test_record_result = mysqli_query($conn,$hit_test_record_query);
    echo "<br>test_record_hit<br>";
    while($hit_test_record_row = mysqli_fetch_array($hit_test_record_result)){
        print_r($hit_test_record_row);
        echo "<br>";
    }
    $pit_test_record_query = "SELECT * FROM test_record_pit WHERE player = '".$user_player_row['no']."'";
    $pit_test_record_result = mysqli_query($conn,$pit_test_record_query);
    echo "<br>test_record_pit<br>";
    while($pit_test_record_row = mysqli_fetch_array($pit_test_record_result)){
        print_r($pit_test_record_row);
        echo "<br>";
    }
    ?>
</body>
</html>
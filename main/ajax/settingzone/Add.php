<?php
    session_start();
    include("../../../config/main_function.php");
    date_default_timezone_set("Asia/Bangkok");

    $secure = "LM=VjfQ{6rsm&/h`";
    $connection = connectDB($secure);
    $zone_id = getRandomID(10,'tbl_zone' ,'zone_id');
    // $zone_id = mysqli_real_escape_string($connection, $_POST['zone_id']);
    $zone_name = mysqli_real_escape_string($connection, $_POST['zone_name']);

    $datetime = date('Y-m-d H:i:s');

    if ($connection) {

        $sql_insert = "INSERT INTO tbl_zone SET 
               zone_id = '$zone_id', 
            zone_name = '$zone_name', 
            active_status = '1' ";
        $insert = mysqli_query($connection, $sql_insert);
        if($insert){
            $result = 1;
        }else{
            $result = 0;
        }
    } else {
        $result = 0;
    }

    mysqli_close($connection);
    $arr['result'] = $result;
    echo json_encode($arr);
?>
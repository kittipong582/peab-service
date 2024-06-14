<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$create_user_id = $_SESSION['user_id'];
$job_select = $_POST['job_select'];
$start_datetime =  $_POST['start_datetime'];

$mainjob_id = $_POST['mainjob_id'];

if (array_search('2', $_POST['type']) !== false) {

    $i = 1;
    foreach ($_POST['job_id'] as $key => $value) {
        $temp_array_u[$i]['job_id'] = $value;
        $i++;
    }

    $i = 1;
    foreach ($_POST['type'] as $key => $value) {
        $temp_array_u[$i]['type'] = $value;
        $i++;
    }

    $array_list = array();
    for ($a = 1; $a < $i; $a++) {

        $type = $temp_array_u[$a]['type'];
        $job_id = $temp_array_u[$a]['job_id'];
        $temp = array(
            "job_id" => $job_id,
            "type" => $type
        );
        array_push($array_list, $temp);
    }


    $key = array_search('2', array_column($array_list, 'type'));

    $main_group_id = $array_list[$key]['job_id'];



    for ($b = 0; $b < count($array_list); $b++) {

        if ($key != $b) {

            $job_id = $array_list[$b]['job_id'];
            $sql_service = "INSERT INTO tbl_group_pm_detail
                SET  job_id = '$job_id'
                    , group_pm_id = '$main_group_id'
                ";
            $rs_service = mysqli_query($connect_db, $sql_service);
        }
    }

    $sql_service = "INSERT INTO tbl_group_pm_detail
    SET  job_id = '$mainjob_id'
        , group_pm_id = '$main_group_id'
    ";
    if (mysqli_query($connect_db, $sql_service)) {

        $arr['result'] = 1;
    }
} else {
    $sql_res = "SELECT responsible_user_id,appointment_date FROM tbl_job WHERE job_id = '$mainjob_id'";
    $rs_res = mysqli_query($connect_db, $sql_res) or die($connect_db->error);
    $row_res = mysqli_fetch_assoc($rs_res);
    $responsible_user_id = $row_res['responsible_user_id'];
    $group_date = $row_res['appointment_date'];
    $group_pm_id = getRandomID(10, 'tbl_group_pm', 'group_pm_id');

    $sql = "INSERT INTO tbl_group_pm
                SET  group_date = '$group_date'
                    ,create_user_id = '$create_user_id'
                    ,responsible_user_id = '$responsible_user_id'
                    ,group_pm_id = '$group_pm_id'
              ";

    //   echo $sql;
    if ($rs = mysqli_query($connect_db, $sql)) {


        $i = 1;
        foreach ($_POST['job_id'] as $key => $value) {
            $temp_array_u[$i]['job_id'] = $value;
            $i++;
        }

        for ($a = 1; $a < $i; $a++) {

            $job_id = $temp_array_u[$a]['job_id'];

            $sql_service = "INSERT INTO tbl_group_pm_detail
                    SET  job_id = '$job_id'
                        , group_pm_id = '$group_pm_id'
                    ";

            $rs_service = mysqli_query($connect_db, $sql_service);
        }

        $sql_service = "INSERT INTO tbl_group_pm_detail
                    SET  job_id = '$mainjob_id'
                        , group_pm_id = '$group_pm_id'
                    ";
        if (mysqli_query($connect_db, $sql_service)) {

            $arr['result'] = 1;
        }
    }
}



// $arr['result'] = 1;
echo json_encode($arr);

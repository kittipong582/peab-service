<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");



$type = $_POST['type'];

$datetime = date("Y-m-d H:i:s", strtotime("NOW"));

$remark = "";
if ($type == 1) {

    $job_id = $_POST['job_id'];

    $sql_chk = "SELECT hold_status FROM tbl_job WHERE job_id = '$job_id'";
    $result_chk = mysqli_query($connect_db, $sql_chk);
    $row_chk = mysqli_fetch_array($result_chk);
    if ($row_chk['hold_status'] == 0) {

        $new_status = 1;
        $remark = $_POST['remark'];
    } else {

        $new_status = 0;
    }


    $sql_up = "UPDATE tbl_job 
SET hold_status = '$new_status'
WHERE job_id = '$job_id'";
    $result_up = mysqli_query($connect_db, $sql_up);


    $sql_log = "INSERT INTO tbl_hold_log 
    SET job_id = '$job_id'
    ,log_type = '$new_status'
    ,remark = '$remark'
    ,datetime = '$datetime'";
    mysqli_query($connect_db, $sql_log);
} else {


    $group_pm_id = $_POST['job_id'];

    $sql_detail = "SELECT * FROM tbl_group_pm_detail WHERE group_pm_id = '$group_pm_id'";
    $rs_detail = mysqli_query($connect_db, $sql_detail);
    while ($row_detail = mysqli_fetch_array($rs_detail)) {
        $job_id = $row_detail['job_id'];


        $sql_chk = "SELECT hold_status FROM tbl_job WHERE job_id = '$job_id'";
        $result_chk = mysqli_query($connect_db, $sql_chk);
        $row_chk = mysqli_fetch_array($result_chk);
        if ($row_chk['hold_status'] == 0) {

            $new_status = 1;
            $remark = $_POST['remark'];
        } else {

            $new_status = 0;
        }

        $sql_up = "UPDATE tbl_job 
        SET hold_status = '$new_status'
        WHERE job_id = '$job_id'";
        $result_up = mysqli_query($connect_db, $sql_up);

        $sql_log = "INSERT INTO tbl_hold_log 
        SET job_id = '$job_id'
        ,log_type = '$new_status'
        ,remark = '$remark'
        ,datetime = '$datetime'";
        mysqli_query($connect_db, $sql_log);
    }


    $sql_up = "UPDATE tbl_group_pm 
SET hold_status = '$new_status'
WHERE group_pm_id = '$group_pm_id'";
    $result_up = mysqli_query($connect_db, $sql_up);
}

// echo $sql_up;
if ($result_up) {


    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$job_id = $_POST['job_id'];
$apply = $_POST['apply'];
$close_approve_id = $_POST['close_approve_id'];
$approve_remark = $_POST['approve_remark'];
$approve_datetime = date("y-m-d H:i:s", strtotime('NOW'));


$sql_update = "UPDATE tbl_job_close_approve
                SET  approve_result = '$apply'
                ,approve_remark = '$approve_remark'
                ,approve_datetime ='$approve_datetime'
                WHERE job_id = '$job_id' and approve_result = 0";

$rs_update = mysqli_query($connect_db, $sql_update) or die($connect_db->error);

if ($apply == 1) {
    $sql_update = "UPDATE tbl_job
    SET  close_approve_id = '$close_approve_id'
    WHERE job_id = '$job_id'";

    $rs_update = mysqli_query($connect_db, $sql_update) or die($connect_db->error);
}


if ($rs_update) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

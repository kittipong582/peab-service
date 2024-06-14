<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$create_user_id = $_SESSION['user_id'];
$close_approve_id = getRandomID(10, 'tbl_job_close_approve', 'close_approve_id');
$job_id = $_POST['job_id'];
$approve_user_id = $_POST['approve_id'];
$send_remark = $_POST['send_remark'];
$create_datetime = date("y-m-d H:i:s", strtotime('NOW'));


$sql_job = "SELECT * FROM tbl_job WHERE job_id = '$job_id'";
$rs_job = mysqli_query($connect_db, $sql_job) or die($connect_db->error);
$row_job = mysqli_fetch_assoc($rs_job);



$sql_check = "SELECT approve_result FROM tbl_job_close_approve WHERE job_id = '$job_id' ORDER BY create_datetime DESC";
$rs_check = mysqli_query($connect_db, $sql_check) or die($connect_db->error);
$row_check = mysqli_fetch_assoc($rs_check);
if ($row_check['approve_result'] != 1) {

    $sql_update = "UPDATE tbl_job_close_approve
                SET  approve_result = '3'
                WHERE job_id = '$job_id' and approve_result = 0";

    $rs_update = mysqli_query($connect_db, $sql_update) or die($connect_db->error);


    $sql_cancel = "INSERT INTO tbl_job_close_approve
                SET  close_approve_id = '$close_approve_id'
                    , create_user_id = '$create_user_id'
                    ,create_datetime = '$create_datetime'
                    ,job_id = '$job_id'
                    ,approve_user_id = '$approve_user_id'
                    , send_remark = '$send_remark'
                ";

    $rs_cancel = mysqli_query($connect_db, $sql_cancel) or die($connect_db->error);




    if ($rs_cancel) {
        $arr['result'] = 1;
    } else {
        $arr['result'] = 0;
    }
} else {
    $arr['result'] = 0;
}
echo json_encode($arr);

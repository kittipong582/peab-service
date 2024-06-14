<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$create_user_id = $_SESSION['user_id'];
$receive_result = $_POST['receive_result'];
$oh_transfer_id = mysqli_real_escape_string($connect_db, $_POST['oh_transfer_id']);
$receive_remark = $_POST['receive_remark'];
$overhaul_id = $_POST['overhaul_id'];
$branch_id = $_POST['to_branch_id'];
$date_now = date("Y-m-d H:i:s", strtotime("now"));

$sql3 = "UPDATE tbl_overhaul_transfer
SET   receive_user_id = '$create_user_id'
,receive_datetime = '$date_now'
,receive_result = '$receive_result'
,receive_remark = '$receive_remark'
WHERE  oh_transfer_id = '$oh_transfer_id' ";
$rs3 = mysqli_query($connect_db, $sql3) or die($connect_db->error);

if ($receive_result == 1) {
    $sql_update = "UPDATE tbl_overhaul 
    SET current_branch_id = '$branch_id'
    WHERE overhaul_id = '$overhaul_id'";
    $rs_update = mysqli_query($connect_db, $sql_update) or die($connect_db->error);
}


// echo $sql_update;

if ($rs3) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}
echo json_encode($arr);

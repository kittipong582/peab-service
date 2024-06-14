<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$create_user_id = $_SESSION['user_id'];
$job_id = $_POST['job_id'];
$overhaul_id = $_POST['overhaul_id'];
$datetime = date('Y-m-d H:i:s', strtotime("now"));

$sql_update = "UPDATE tbl_job
    SET overhaul_id = null
    WHERE job_id = '$job_id'";
$result_update  = mysqli_query($connect_db, $sql_update);

////////////////////////LOG///////////////////////
$sql_log = "UPDATE tbl_overhaul_log
SET return_datetime = '$datetime'
WHERE job_id = '$job_id' AND overhaul_id = '$overhaul_id'";
$result_log  = mysqli_query($connect_db, $sql_log);


/////////////////////////////////////////สาขาของ overhaul////////////////////////

$sql_up_oh = "UPDATE tbl_overhaul 
SET current_customer_branch_id = null
WHERE overhaul_id = '$overhaul_id'";
$result_up_oh  = mysqli_query($connect_db, $sql_up_oh);


if ($result_update && $result_up_oh) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}


echo json_encode($arr);

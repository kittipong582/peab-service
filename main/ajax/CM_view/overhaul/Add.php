<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$create_user_id = $_SESSION['user_id'];
$job_id = $_POST['job_id'];
$overhaul_id = $_POST['overhaul_id'];


$sql = "SELECT * FROM tbl_job WHERE job_id = '$job_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);


$sql_update = "UPDATE tbl_job
    SET overhaul_id = '$overhaul_id'
    WHERE job_id = '$job_id'";
$result_update  = mysqli_query($connect_db, $sql_update);


////////////////////////LOG///////////////////////
$sql_log = "INSERT INTO tbl_overhaul_log
SET job_id = '$job_id'
,overhaul_id = '$overhaul_id'
,create_user_id = '$create_user_id'";
$result_log  = mysqli_query($connect_db, $sql_log);


/////////////////////////////////////////สาขาของ overhaul////////////////////////
$current_customer_branch_id = $row['customer_branch_id'];
$sql_up_oh = "UPDATE tbl_overhaul 
SET current_customer_branch_id = '$current_customer_branch_id'
WHERE overhaul_id = '$overhaul_id'";
$result_up_oh  = mysqli_query($connect_db, $sql_up_oh);

if ($result_update && $result_up_oh) {
    $arr['result'] = 1;
    $arr['id'] = $overhaul_id;
} else {
    $arr['result'] = 0;
}


echo json_encode($arr);

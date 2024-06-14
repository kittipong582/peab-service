<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$create_user_id = $_SESSION['user_id'];
$job_id = $_POST['job_id'];
$create_datetime = date("y-m-d H:i:s", strtotime('NOW'));



$sql_up_job = "UPDATE tbl_job 
    SET qc_active_datetime = '$create_datetime'
    WHERE job_id = '$job_id'";
$rs_job = mysqli_query($connect_db, $sql_up_job) or die($connect_db->error);


if ($rs_job) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

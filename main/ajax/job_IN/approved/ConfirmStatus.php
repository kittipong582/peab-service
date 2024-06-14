<?php
include("../../../../config/main_function.php");
session_start();
$create_user_id = $_SESSION['user_id'];
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$job_id = mysqli_real_escape_string($connect_db, $_POST['job_id']);
$status = mysqli_real_escape_string($connect_db, $_POST['status']);
$create_datetime = date('Y-m-d H:i:s', strtotime("now"));


$sql_update_user = "UPDATE tbl_job SET 
				IN_PM_check = '$status',
                IN_PM_check_user_id = '$create_user_id',
                IN_PM_check_datetime = '$create_datetime'
				WHERE job_id = '$job_id'";


if (mysqli_query($connect_db, $sql_update_user)) {
    $arr['result'] = 1;
    $arr['status'] = $status;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

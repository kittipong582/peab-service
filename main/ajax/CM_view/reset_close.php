<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];

$sql = "UPDATE tbl_job 
SET close_user_id = null,
close_datetime = null,
cancel_datetime = null,
cancel_user_id = null,
cancel_note = null
WHERE job_id = '$job_id'";
$result = mysqli_query($connect_db, $sql) or die($connect_db->error);


if ($result) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}
echo json_encode($arr);

<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$create_user_id = $_SESSION['user_id'];
$job_id = $_POST['job_id'];
$repair_detail = $_POST['repair_detail'];


$sql_update = "UPDATE tbl_job 
SET repair_detail = '$repair_detail'
WHERE job_id = '$job_id'";
$rs_update = mysqli_query($connect_db, $sql_update) or die($connect_db->error);

if ($rs_update) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

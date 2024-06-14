<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$oh_expire_date = date("Y-m-d", strtotime($_POST['oh_expire_date']));
$job_id = $_POST['job_id'];


$sql_update = "UPDATE tbl_job
                SET  oh_expire_date = '$oh_expire_date'
               
                WHERE job_id = '$job_id'";

$rs_update = mysqli_query($connect_db, $sql_update) or die($connect_db->error);


if ($rs_update) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

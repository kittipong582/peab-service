<?php
session_start();
include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_image_id = $_POST['job_image_id'];


$sql_del = "DELETE  FROM tbl_job_image WHERE job_image_id = '$job_image_id'";
$result_del = mysqli_query($connect_db, $sql_del) or die($connect_db->error);


if ($result_del) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}
$arr['result'] = 1;
echo json_encode($arr);

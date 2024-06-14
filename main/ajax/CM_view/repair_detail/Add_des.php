<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$image_id = $_POST['image_id'];
$description = $_POST['des'];


$sql_update = "UPDATE tbl_job_process_image 
SET description = '$description'
WHERE image_id = '$image_id'";
$rs_update = mysqli_query($connect_db, $sql_update) or die($connect_db->error);

if ($rs_update) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

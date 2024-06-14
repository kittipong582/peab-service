<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];
$sql = "SELECT * FROM tbl_job WHERE job_id = '$job_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

$arr['job_no'] = $row['job_no'];
$arr['job_id'] = $row['job_id'];

echo json_encode($arr);

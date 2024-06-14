<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$daily_id = $_POST['daily_id'];


$sql_del = "DELETE  FROM tbl_job_daily WHERE daily_id = '$daily_id'";
$result_del = mysqli_query($connect_db, $sql_del) or die($connect_db->error);



if ($result_del) {
    $arr['result'] = 1;

} else {
    $arr['result'] = 0;
}
echo json_encode($arr);
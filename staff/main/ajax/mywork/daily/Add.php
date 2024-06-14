<?php
session_start();
include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$create_user_id = $_SESSION['user_id'];
$job_id = $_POST['job_id'];
$daily_detail = $_POST['daily_detail'];
$date = date("Y-m-d H:i");
$i = 1;


$sql_daily = "INSERT INTO tbl_job_daily
                SET   create_user_id = '$create_user_id'
                    ,job_id = '$job_id'
                    ,daily_detail = '$daily_detail'
                    ,create_datetime = '$date'
                ";

$rs_daily = mysqli_query($connect_db, $sql_daily) or die($connect_db->error);


if ($rs_daily) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}
// $arr['result'] = 1;
echo json_encode($arr);

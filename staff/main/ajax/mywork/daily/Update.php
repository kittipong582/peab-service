<?php
session_start();
include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$create_user_id = $_SESSION['user_id'];
$daily_detail = $_POST['daily_detail'];
$daily_id = $_POST['daily_id'];
$date = date("Y-m-d");
$i = 1;


$sql_daily = "UPDATE tbl_job_daily
                SET   daily_detail = '$daily_detail'
                    WHERE daily_id = '$daily_id'
                ";

$rs_daily = mysqli_query($connect_db, $sql_daily) or die($connect_db->error);


if ($rs_daily) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}
// $arr['result'] = 1;
echo json_encode($arr);

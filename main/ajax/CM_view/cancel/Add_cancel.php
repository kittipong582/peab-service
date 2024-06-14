<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$create_user_id = $_SESSION['user_id'];
$job_id = $_POST['job_id'];
$cancel_datetime = date("Y-m-d H:i", strtotime("NOW"));
$cancel_note = $_POST['cancel_note'];
// echo $cancal_note;


$sql_cancel = "UPDATE tbl_job
                SET  cancel_user_id = '$create_user_id'
                ,cancel_datetime = '$cancel_datetime'
                ,cancel_note = '$cancel_note'
                WHERE job_id = '$job_id'";

$rs_cancel = mysqli_query($connect_db, $sql_cancel) or die($connect_db->error);
// echo $sql_cancel;


if ($rs_cancel) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

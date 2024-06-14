<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$quotation_approve_result = $_POST['result'];
$job_id = $_POST['job_id'];


$sql_update = "UPDATE tbl_job
                SET  quotation_approve_result = '$quotation_approve_result'
               
                WHERE job_id = '$job_id'";

$rs_update = mysqli_query($connect_db, $sql_update) or die($connect_db->error);

// if ($apply == 1) {
//     $sql_update = "UPDATE tbl_job
//     SET  close_approve_id = '$close_approve_id'
//     WHERE job_id = '$job_id'";

//     $rs_update = mysqli_query($connect_db, $sql_update) or die($connect_db->error);
// }


if ($rs_update) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

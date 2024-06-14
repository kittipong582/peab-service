<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$appointment_date = date("Y-m-d", strtotime($_POST['appointment_date']));
$job_id = $_POST['job_id'];


$sql = "SELECT COUNT(*) as check_num FROM tbl_job_ref a 
LEFT JOIN tbl_job b ON a.ref_job_id = b.job_id
WHERE a.job_id = '$job_id' and close_approve_id is null";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);


if ($row['check_num'] > 0) {
    $arr['check_result'] = 1;
    $arr['check_num'] = 1;
} else {
    $arr['check_result'] = 0;
    $arr['check_num'] = 0;
}

echo json_encode($arr);

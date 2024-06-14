<?php
session_start();
include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$create_user_id = $_SESSION['user_id'];

$job_id = $_POST['job_id'];

$sql = "SELECT overhaul_id FROM tbl_job WHERE job_id = '$job_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

$overhaul_id = $row['overhaul_id'];
$date = date('Y-m-d H:i:s');

////////////////////////////////////////////////////////////////////////////////////////

$sql_job = "UPDATE tbl_job 
            SET overhaul_id = NULL
            WHERE job_id = '$job_id'
            ;";

$rs_job = mysqli_query($connect_db, $sql_job) or die($connect_db->error);

////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////////

$sql_overhaul = "UPDATE tbl_overhaul
                SET  current_customer_branch_id = NULL
                WHERE overhaul_id = '$overhaul_id'
                ;";

$rs_overhaul = mysqli_query($connect_db, $sql_overhaul) or die($connect_db->error);

////////////////////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////////////////

$sql_log = "UPDATE tbl_overhaul_log
                SET  return_datetime = '$date'
                WHERE overhaul_id = '$overhaul_id' AND return_datetime IS NULL
                ;";

$rs_log = mysqli_query($connect_db, $sql_log) or die($connect_db->error);

//////////////////////////////////////////////////////////////////////////////////////





if ($rs_job && $rs_overhaul && $rs_log) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

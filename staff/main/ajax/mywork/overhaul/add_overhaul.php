<?php
session_start();
include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$create_user_id = $_SESSION['user_id'];

$job_id = $_POST['job_id'];

$current_customer_branch_id = $_POST['customer_branch_id'];
$overhaul_id = $_POST['overhaul'];

$date = date('Y-m-d H:i:s');

////////////////////////////////////////////////////////////////////////////////////////

$sql = "SELECT * FROM tbl_job WHERE job_id = '$job_id' ;";
$rs  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($rs);

// echo $sql;

if($row['overhaul_id'] != ""){

$sql_log = "UPDATE tbl_overhaul_log
                SET  return_datetime = '$date'
                WHERE overhaul_id = '{$row['overhaul_id']}' AND return_datetime IS NULL
                ;";

// echo $sql_log;

$rs_log = mysqli_query($connect_db, $sql_log) or die($connect_db->error);
}

////////////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////////////

$sql_job = "UPDATE tbl_job 
            SET overhaul_id = '$overhaul_id'
            WHERE job_id = '$job_id'
            ;";

$rs_job = mysqli_query($connect_db, $sql_job) or die($connect_db->error);

////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////////

$sql_overhaul = "UPDATE tbl_overhaul
                SET  current_customer_branch_id = '$current_customer_branch_id'
                WHERE overhaul_id = '$overhaul_id'
                ;";

$rs_overhaul = mysqli_query($connect_db, $sql_overhaul) or die($connect_db->error);

////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////////

$sql_newlog = "INSERT INTO tbl_overhaul_log
                SET  job_id = '$job_id'
                    ,overhaul_id = '$overhaul_id'
                    ,create_user_id = '$create_user_id'
                ;";

$rs_newlog = mysqli_query($connect_db, $sql_newlog) or die($connect_db->error);

////////////////////////////////////////////////////////////////////////////////////////



if ($rs_job && $rs_overhaul && $rs_newlog) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

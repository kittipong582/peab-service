<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$create_user_id = $_SESSION['user_id'];
$overhaul_id = $_POST['overhaul_id'];
$branch_id = mysqli_real_escape_string($connect_db, $_POST['to_branch_id']);
$ax_ref_no = mysqli_real_escape_string($connect_db, $_POST['ax_ref_no']);
$oh_transfer_id = mysqli_real_escape_string($connect_db, $_POST['oh_transfer_id']);
$note = mysqli_real_escape_string($connect_db, $_POST['note']);
$date_now = date("Y-m-d H:i:s", strtotime("now"));
$sql = "SELECT * FROM tbl_overhaul WHERE overhaul_id = '$overhaul_id'";
$rs  = mysqli_query($connect_db, $sql) or die($connect_db->error);
$row = mysqli_fetch_assoc($rs);

$from_branch_id = $row['current_branch_id'];

/////////////transfer_no////////////////
$pre_job_no = "OT";
$mid_job_no = substr(date("Y") + 543, 2);

$sql_count = "SELECT COUNT(job_id) AS num FROM tbl_job";
$result_count  = mysqli_query($connect_db, $sql_count);
$row_count = mysqli_fetch_array($result_count);

// 6504xxxxx
$year = date('y') + 43;
$month = date('m');
$job_ex = $year . $month;

$sql_conut = "SELECT count(*) as count1 FROM tbl_overhaul_transfer WHERE oh_transfer_no LIKE '$pre_job_no$job_ex%'";
$rs_conut  = mysqli_query($connect_db, $sql_conut) or die($connect_db->error);
$row_conut = mysqli_fetch_assoc($rs_conut);

// echo $sql_conut;
$count_no = $row_conut['count1'] + 1;
$oh_transfer_no = $pre_job_no. $year . $month . str_pad($count_no, 4, "0", STR_PAD_LEFT);

$sql3 = "INSERT INTO tbl_overhaul_transfer
SET  oh_transfer_id = '$oh_transfer_id'   
,from_branch_id = '$from_branch_id'
,create_datetime = '$date_now'
,to_branch_id = '$branch_id'
,ax_ref_no = '$ax_ref_no'
,oh_transfer_no = '$oh_transfer_no'
,create_user_id = '$create_user_id'
,note = '$note'
,overhaul_id = '$overhaul_id'
";
$rs3 = mysqli_query($connect_db, $sql3) or die($connect_db->error);

if ($rs3) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}
echo json_encode($arr);

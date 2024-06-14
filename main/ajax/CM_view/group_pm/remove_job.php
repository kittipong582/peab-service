<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$create_user_id = $_SESSION['user_id'];

$job_id = $_POST['job_id'];

$sql_detail = "SELECT group_pm_id FROM tbl_group_pm_detail WHERE job_id = '$job_id'";
$rs_detail = mysqli_query($connect_db, $sql_detail);
$row_detail = mysqli_fetch_assoc($rs_detail);

$sql_chk = "SELECT * FROM tbl_group_pm_detail WHERE group_pm_id = '{$row_detail['group_pm_id']}'";
$rs_chk = mysqli_query($connect_db, $sql_chk);
$num_chk = mysqli_num_rows($rs_chk);

$type_chk = 1;
// echo $num_chk;
if ($num_chk == 1) {

    $sql_del = "DELETE FROM tbl_group_pm WHERE group_pm_id in(SELECT group_pm_id FROM tbl_group_pm_detail WHERE job_id = '$job_id')";
    $rs_del = mysqli_query($connect_db, $sql_del);

    $type_chk = 2;
}
$sql_remove = "DELETE FROM tbl_group_pm_detail WHERE job_id = '$job_id'";
$rs = mysqli_query($connect_db, $sql_remove);


$sql_spare = "SELECT SUM(unit_price) AS totall FROM tbl_job_spare_used WHERE job_id = '$job_id'";
$result_spare  = mysqli_query($connect_db, $sql_spare);
$row_spare = mysqli_fetch_array($result_spare);

$sql_income = "SELECT * FROM tbl_job_income WHERE job_id = '$job_id'";
$result_income  = mysqli_query($connect_db, $sql_income);
while ($row_income = mysqli_fetch_array($result_income)) {

    $income_total += $row_income['quantity'] * $row_income['income_amount'];
}

$service_total = $income_total;



if ($rs) {
    $arr['result'] = 1;
    $arr['total_service'] = $service_total;
    $arr['total_spare'] = $row_spare['totall'];
    $arr['type_chk'] = $type_chk;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

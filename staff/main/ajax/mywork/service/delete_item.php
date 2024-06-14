<?php
session_start();
include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_income_id = $_POST['job_income_id'];


$sql = "SELECT * FROM tbl_job_income a
LEFT JOIN tbl_income_type b ON a.income_type_id = b.income_type_id
 WHERE a.job_income_id = '$job_income_id'";

$rs = mysqli_query($connect_db, $sql) or die($connect_db->error);
$row = mysqli_fetch_assoc($rs);

$id_job = $row['job_id'];

$sql_del = "DELETE  FROM tbl_job_income WHERE job_income_id = '$job_income_id'";
$result_del = mysqli_query($connect_db, $sql_del) or die($connect_db->error);

$sql_spare = "SELECT SUM(unit_price) AS total FROM tbl_job_spare_used WHERE job_id = '$id_job'";
$result_spare  = mysqli_query($connect_db, $sql_spare);
$row_spare = mysqli_fetch_array($result_spare);

$sql_income = "SELECT * FROM tbl_job_income WHERE job_id = '$id_job'";
$result_income  = mysqli_query($connect_db, $sql_income);
while ($row_income = mysqli_fetch_array($result_income)) {

    $income_total += $row_income['quantity'] * $row_income['income_amount'];
}

$service_total = $income_total + $row_spare['total'];


if ($result_del) {
    $arr['result'] = 1;
    $arr['total_service'] = number_format($service_total) . ' บาท';
} else {
    $arr['result'] = 0;
}
$arr['result'] = 1;
echo json_encode($arr);

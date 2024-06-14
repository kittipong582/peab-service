<?php
session_start();
include("../../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$customer_branch_id = $_POST['customer_branch_id'];
$date = $_POST['date'];

$date_first =  date('Y-m-d', strtotime('-30 days', strtotime($date)));

$date_last =  date('Y-m-d', strtotime('+30 days', strtotime($date)));

$sql_check = "SELECT * FROM tbl_job WHERE customer_branch_id = '$customer_branch_id' and appointment_date BETWEEN '$date_first' AND '$date_last'";
$rs_check  = mysqli_query($connection, $sql_check);
while ($row_check = mysqli_fetch_array($rs_check)) {
   
    if ($row_check['job_id'] != "" || $row_check['job_id'] != null) {
        $alert_text .= "<font color=red>" . 'เลขที่ ' . $row_check['job_no'] . ' วันที่ ' . date("d-m-Y", strtotime($row_check['appointment_date'])) . "</font>" . "<br>";
    }
}
$arr['alert_text'] = $alert_text;

echo json_encode($arr);

<?php
session_start();
include("../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);
$date = $_POST['date'];

$date_first =  date('Y-m-d', strtotime($date));
$alert_active = 0;

$sql_check = "SELECT * FROM tbl_holiday WHERE  holiday_datetime LIKE '$date_first%'";
$rs_check  = mysqli_query($connection, $sql_check);
$num_chk = mysqli_num_rows($rs_check);
$row_check = mysqli_fetch_array($rs_check);

if($num_chk > 0){
    $alert_text = $row_check['holiday_name'];
    $alert_active = 1;
}

$arr['alert_text'] = $alert_text;
$arr['alert_active'] = $alert_active;
echo json_encode($arr);

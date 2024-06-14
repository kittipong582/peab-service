<?php
session_start();
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$cancel_user_id = $_SESSION['user_id'];
$contract_id = $_POST['contract_id'];
$cancel_remark = $_POST['cancel_remark'];
$cancel_datetime = date('Y-m-d', strtotime('today'));


$sql = "UPDATE tbl_customer_contract
SET 
cancel_user_id = '$cancel_user_id'
,cancel_date = '$cancel_datetime'
,cancel_remark = '$cancel_remark'
WHERE contract_id = '$contract_id'";

if (mysqli_query($connect_db, $sql)) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}
echo json_encode($arr);

<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$start_contract_date = date('Y-m-d', strtotime($_POST['start_contract_date']));
$end_contract_date = date('Y-m-d', strtotime($_POST['end_contract_date']));
$contract_id = $_POST['contract_id'];
$remark = $_POST['remark'];


$sql = "UPDATE tbl_customer_contract
SET 
start_contract_date = '$start_contract_date'
,end_contract_date = '$end_contract_date'
,remark = '$remark'
WHERE contract_id = '$contract_id'";

if (mysqli_query($connect_db, $sql)) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

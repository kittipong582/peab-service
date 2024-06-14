<?php
session_start();
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$create_user_id = $_SESSION['user_id'];
$start_contract_date = date('Y-m-d', strtotime($_POST['start_contract_date']));
$end_contract_date = date('Y-m-d', strtotime($_POST['end_contract_date']));
$contract_number = $_POST['contract_number'];
$contract_id = $_POST['contract_id'];
$customer_id = $_POST['customer_id'];
$remark = $_POST['remark'];

$sql_check = "SELECT COUNT(*) as num FROM tbl_customer_contract WHERE contract_number = '$contract_number'";
$result_check  = mysqli_query($connect_db, $sql_check);
$row_check = mysqli_fetch_array($result_check);

if ($row_check['num'] == 0) {
    $sql = "INSERT INTO tbl_customer_contract
SET contract_id = '$contract_id'
,customer_id = '$customer_id'
,create_user_id = '$create_user_id'
,start_contract_date = '$start_contract_date'
,end_contract_date = '$end_contract_date'
,contract_number = '$contract_number'
,remark = '$remark'";

    if (mysqli_query($connect_db, $sql)) {
        $arr['result'] = 1;
    } else {
        $arr['result'] = 0;
    }
} else {
    $arr['result'] = 2;
}
echo json_encode($arr);

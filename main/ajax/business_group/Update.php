<?php
session_start();
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$group_id = $_POST['group_id'];
$group_name = $_POST['group_name'];
$invoice_name = $_POST['invoice_name'];
$tax_no = $_POST['tax_no'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$invoice_address = $_POST['invoice_address'];
$create_datetime = date("Y-m-d", strtotime("NOW"));
$create_user_id = $_SESSION['user_id'];

$sql = "UPDATE tbl_business_group
    
    SET group_name = '$group_name'
    ,invoice_name = '$invoice_name'
    ,tax_no = '$tax_no'
    ,phone = '$phone'
    ,email = '$email'
    ,invoice_address = '$invoice_address'
    ,create_datetime = '$create_datetime'
    ,create_user_id = '$create_user_id'
    WHERE group_id = '$group_id'";

if (mysqli_query($connect_db, $sql)) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

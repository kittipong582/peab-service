<?php

include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$customer_id = mysqli_real_escape_string($connect_db, $_POST['customer_id']);
$customer_name = mysqli_real_escape_string($connect_db, $_POST['customer_name']);
$customer_code = mysqli_real_escape_string($connect_db, $_POST['customer_code']);
$customer_type = mysqli_real_escape_string($connect_db, $_POST['customer_type']);
$invoice_name = mysqli_real_escape_string($connect_db, $_POST['invoice_name']);
$tax_no = mysqli_real_escape_string($connect_db, $_POST['tax_no']);
$email = mysqli_real_escape_string($connect_db, $_POST['email']);
$phone = mysqli_real_escape_string($connect_db, $_POST['phone']);
$invoice_address = mysqli_real_escape_string($connect_db, $_POST['invoice_address']);
$bill_type = mysqli_real_escape_string($connect_db, $_POST['bill_type']);
$customer_group = mysqli_real_escape_string($connect_db, $_POST['customer_group']);

$sql_update_user = "UPDATE tbl_customer 
SET 
customer_name = '$customer_name',
customer_code = '$customer_code',
customer_type = '$customer_type',
tax_no = '$tax_no',
invoice_name = '$invoice_name',
invoice_address = '$invoice_address',
email = '$email',
bill_type = '$bill_type',
phone = '$phone' ,
customer_group = '$customer_group' 
WHERE customer_id = '$customer_id'";


if (mysqli_query($connect_db, $sql_update_user)) {


    if ($bill_type == 2) {
        $business_group = mysqli_real_escape_string($connect_db, $_POST['business_group']);
        $sql_business = "UPDATE tbl_customer 
        SET business_group_id = '$business_group'
        WHERE customer_id = '$customer_id'";
        mysqli_query($connect_db, $sql_business);
    }
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);
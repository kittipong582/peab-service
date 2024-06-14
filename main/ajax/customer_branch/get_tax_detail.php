<?php

include("../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$customer_id = $_POST['customer_id'];



$sql = "SELECT invoice_name,tax_no,invoice_address FROM tbl_customer WHERE customer_id = '$customer_id'";
$result  = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($result);
// echo $sql;

$arr['billing_name'] = $row['invoice_name'];
$arr['billing_tax_no'] = $row['tax_no'];
$arr['billing_address'] = $row['invoice_address'];

echo json_encode($arr);

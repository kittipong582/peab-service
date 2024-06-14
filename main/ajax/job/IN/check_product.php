<?php
session_start();
include("../../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connect_db = connectDB($secure);

$i = $_POST['rowCount'];
$serial_no = $_POST['product_id'];
$customer_branch_id = $_POST['customer_branch_id'];

// $sql_customer = "SELECT customer_id FROM tbl_customer_branch WHERE customer_branch_id = '$customer_branch_id'";
// $result_customer  = mysqli_query($connect_db, $sql_customer);
// $row_customer = mysqli_fetch_array($result_customer);
// $customer_id = $row_customer['customer_id'];

$sql_chk = "SELECT product_id FROM tbl_product a
LEFT JOIN tbl_customer_branch b ON a.current_branch_id = b.customer_branch_id
 WHERE a.serial_no = '$serial_no'";
$result_chk  = mysqli_query($connect_db, $sql_chk);
$row_chk = mysqli_fetch_array($result_chk);
// echo $sql_chk;
if (mysqli_num_rows($result_chk) == 1) {

    $arr['result'] = 1;
    $arr['product_id'] = $row_chk['product_id'];
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

<?php

include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$customer_branch_id = $_POST['customer_branch_id'];

$sql_product = "SELECT a.branch_name,c.contact_name,c.contact_position,c.contact_phone FROM tbl_customer_branch a
LEFT JOIN tbl_customer b ON a.customer_id = b.customer_id
LEFT JOIN tbl_customer_contact c ON a.customer_branch_id = c.customer_branch_id 
WHERE a.customer_branch_id = '$customer_branch_id'";
$result_product  = mysqli_query($connect_db, $sql_product);
$row_product = mysqli_fetch_array($result_product);


$arr['branch_name'] = $row_product['branch_name'];
$arr['contact_name'] = $row_product['contact_name'];
$arr['contact_position'] = $row_product['contact_position'];
$arr['contact_phone'] = $row_product['contact_phone'];

echo json_encode($arr);
?>
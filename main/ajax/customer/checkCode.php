<?php

include('../../../config/main_function.php');
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$customer_code = $_POST['customer_code'];

$sql = "SELECT count(*) as check_code FROM tbl_customer WHERE customer_code = '$customer_code'";
$rs = mysqli_query($connection, $sql) or die($connection->error);
$row = mysqli_fetch_array($rs);

$check_code = $row['check_code'];

$status = ($check_code == 0) ? 1 : 0 ;

echo json_encode($status);
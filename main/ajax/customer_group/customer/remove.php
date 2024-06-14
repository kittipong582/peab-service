<?php
session_start();
include("../../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$customer_id = $_POST['customer_id'];


$sql = "UPDATE tbl_customer
SET customer_group = null
WHERE customer_id = '$customer_id'
";

if (mysqli_query($connect_db, $sql)) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);
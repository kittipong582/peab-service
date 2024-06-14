<?php
session_start();
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$customer_group_type_id = $_POST['customer_group_type_id'];
$customer_group_type_name = $_POST['customer_group_type_name'];


$sql = "UPDATE tbl_customer_group_type
SET customer_group_type_name = '$customer_group_type_name'
WHERE customer_group_type_id = '$customer_group_type_id'
";

if (mysqli_query($connect_db, $sql)) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);
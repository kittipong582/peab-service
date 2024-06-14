<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$customer_group_id = $_POST['customer_group_id'];
$spare_part_id = $_POST['spare_part_id'];

$sql = "SELECT * FROM tbl_customer_group_part_price WHERE customer_group_id = '$customer_group_id' AND spare_part_id = '$spare_part_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);


$arr['price'] = $row['unit_price'];
$arr['spare_part_id'] = $spare_part_id;
echo json_encode($arr);

<?php
session_start();
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$customer_group_id = $_POST['customer_group_id'];
$spare_part_id = $_POST['spare_part_id'];
$unit_price = $_POST['unit_price'];


$sql = "UPDATE tbl_customer_group_part_price
SET unit_price = '$unit_price'
WHERE  customer_group_id = '$customer_group_id' AND spare_part_id = '$spare_part_id'
";
// echo $sql;
if (mysqli_query($connect_db, $sql)) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

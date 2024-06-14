<?php
session_start();
include ("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$customer_group_id = $_POST['customer_group_id'];
$spare_part_id = $_POST['spare_part_id'];
$unit_price = $_POST['unit_price'];

$user_id = $_SESSION['user_id'];


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
$sql_log = "INSERT INTO tbl_customer_group_part_price_log SET 
create_user_id = '$user_id',
customer_group_id = '$customer_group_id',
spare_part_id = '$spare_part_id',
spare_part_price = '$unit_price',
log_type = '2'";
$res_log = mysqli_query($connect_db, $sql_log) or die($connect_db->error);

echo json_encode($arr);

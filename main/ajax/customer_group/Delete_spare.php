<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$customer_group_id = $_POST['customer_group_id'];
$spare_part_id = $_POST['spare_part_id'];


$sql_del = "DELETE  FROM tbl_customer_group_part_price WHERE customer_group_id = '$customer_group_id' AND spare_part_id = '$spare_part_id'";
$result_del = mysqli_query($connect_db, $sql_del) or die($connect_db->error);

if ($result_del) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}
echo json_encode($arr);

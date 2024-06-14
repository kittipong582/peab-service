<?php
session_start();
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$branch_id = $_POST['branch_id_new'];
$spare_part_id = $_POST['spare_part_id_new'];
$default_quantity = $_POST['quantity_new'];

$arr = array();

$sql = "UPDATE tbl_branch_stock_setting
SET default_quantity = '$default_quantity'
WHERE branch_id = '$branch_id' AND spare_part_id = '$spare_part_id' 
;";

if (mysqli_query($connect_db, $sql)) {
    $arr['result'] = 1;
    $arr['branch_id'] = $branch_id;
    $arr['spare_part_id'] = $spare_part_id;
    $arr['default_quantity'] = $default_quantity;
} else {
    $arr['result'] = 0;
    $arr['branch_id'] = $branch_id;
    $arr['spare_part_id'] = $spare_part_id;
    $arr['default_quantity'] = $default_quantity;
}
echo json_encode($arr);

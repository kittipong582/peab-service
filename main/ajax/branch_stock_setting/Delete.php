<?php
session_start();
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$branch_id = $_POST['branch_id'];
$spare_part_id = $_POST['spare_part_id'];

$sql = "DELETE FROM tbl_branch_stock_setting WHERE branch_id = '$branch_id' AND spare_part_id = '$spare_part_id' ;";

if (mysqli_query($connect_db, $sql)) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

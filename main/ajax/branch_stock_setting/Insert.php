<?php
session_start();
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$branch_id = $_POST['branch_id'];
$spare_part_id = $_POST['ax'];
$default_quantity = $_POST['quantity'];

$sql = "SELECT * FROM tbl_branch_stock_setting 
        WHERE branch_id = '$branch_id' AND spare_part_id = '$spare_part_id'";
$result  = mysqli_query($connect_db, $sql);
$rowcount = mysqli_num_rows($result);

$arr = array();

if ($rowcount == 0) {

    $sql = "INSERT INTO tbl_branch_stock_setting
            SET branch_id = '$branch_id',
            spare_part_id = '$spare_part_id',
            default_quantity = '$default_quantity'";

    if (mysqli_query($connect_db, $sql)) {
        $arr['result'] = 1;
    } else {
        $arr['result'] = 0;
    }
} else {
    $arr['result'] = 2; // spare part ซ้ำ
}

echo json_encode($arr);


<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$part_id = $_POST['part_id'];
$group_id = $_POST['group_id'];
$branch_id = $_POST['branch_id'];
$today = date("Y-m-d", strtotime("TODAY"));

$sql_service = "SELECT * FROM tbl_branch_stock a 
LEFT JOIN tbl_spare_part b ON a.spare_part_id = b.spare_part_id WHERE a.branch_id = '$branch_id' and a.spare_part_id = '$part_id'";
$result_service  = mysqli_query($connect_db, $sql_service);
$row_service = mysqli_fetch_array($result_service);

$arr['remain_stock'] = $row_service['remain_stock'];


$sql_chk = "SELECT * FROM tbl_customer_group_part_price WHERE customer_group_id = '$group_id' AND spare_part_id = '$part_id'";
$result_chk  = mysqli_query($connect_db, $sql_chk);
$row_chk = mysqli_num_rows($result_chk);

// echo $row_chk;
if ($row_chk > 0) {

    $sql_group_part = "SELECT expire_date FROM tbl_customer_group WHERE customer_group_id = '$group_id' AND active_status = 1";
    $result_group_part  = mysqli_query($connect_db, $sql_group_part);
    $row_group_part = mysqli_fetch_array($result_group_part);

    if ($today < $row_group_part['expire_date']) {

        $sql = "SELECT *  FROM tbl_customer_group_part_price WHERE customer_group_id = '$group_id' AND spare_part_id = '$part_id' ";
        $result  = mysqli_query($connect_db, $sql);
        $row = mysqli_fetch_array($result);

        $arr['unit_price'] = round($row['unit_price'], 2);
    } else {
        $arr['unit_price'] = round($row_service['default_cost'], 2);
    }
} else {
    $arr['unit_price'] = round($row_service['default_cost'], 2);
}

// echo $sql_service;
echo json_encode($arr);

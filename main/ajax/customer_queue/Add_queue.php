<?php
session_start();
include ("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$create_user_id = $_SESSION['user_id'];


$customer_id = mysqli_real_escape_string($connect_db, $_POST['customer_id']);
$customer_branch_id = mysqli_real_escape_string($connect_db, $_POST['customer_branch_id']);
$area_id = mysqli_real_escape_string($connect_db, $_POST['area_id']);
$branch_code = mysqli_real_escape_string($connect_db, $_POST['branch_code']);

$sql = "SELECT MAX(queue_no) AS Max_listorder FROM tbl_customer_queue ";
$res = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_assoc($res);

if ($row >= 1) {
    $list_order = $row['Max_listorder'] + 1;
} else {
    $list_order = 1;
}


if ($connect_db) {

    $queue_id = getRandomID(10, 'tbl_customer_queue', 'queue_id');
    $sql_insert = "INSERT INTO tbl_customer_queue SET  
    queue_id  = '$queue_id',
    create_user_id  = '$create_user_id',
    area_id  = '$area_id',
    branch_code  = '$branch_code',
    customer_branch_id  = '$customer_branch_id',
    queue_no = '$list_order'";

    $res_insert = mysqli_query($connect_db, $sql_insert) or die($connect_db->error);

    if ($res_insert) {
        $arr['result'] = 1;
    } else {
        $arr['result'] = 0;
    }
} else {
    $arr['result'] = 9;
}

echo json_encode($arr);





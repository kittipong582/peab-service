<?php
include("../../../config/main_function.php");
session_start();
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$record_user_id = $_SESSION['user_id'];
$spare_used_id = $_POST['spare_used_id'];
$ax_date = date("Y-m-d", strtotime($_POST['ax_date']));
$quantity = $_POST['quantity'];
$ref_ax = $_POST['ref_ax'];

// echo $ax_date;

$sql_check = "SELECT * FROM tbl_job_spare_used WHERE spare_used_id = '$spare_used_id'";
$result_check  = mysqli_query($connect_db, $sql_check);
$row_check = mysqli_fetch_array($result_check);

$sql_spare_ax = "SELECT SUM(quantity) AS total FROM tbl_spare_used_ax WHERE spare_used_id = '$spare_used_id'";
$result_spare_ax  = mysqli_query($connect_db, $sql_spare_ax);
$row_spare_ax = mysqli_fetch_array($result_spare_ax);
$remain = $row_check['quantity'] - $row_spare_ax['total'];

if ($quantity <= $remain) {

    $sql_insert = "INSERT INTO tbl_spare_used_ax
    SET  spare_used_id ='$spare_used_id'
    ,ax_ref_no = '$ref_ax'
    ,ax_date = '$ax_date'
    ,quantity = '$quantity'
    ,record_user_id = '$record_user_id'";


    if (mysqli_query($connect_db, $sql_insert)) {
        $arr['result'] = 1;
        $arr['spare_used_id'] = $spare_used_id;
    } else {
        $arr['result'] = 0;
    }
} else {
    $arr['result'] = 2;
}

echo json_encode($arr);

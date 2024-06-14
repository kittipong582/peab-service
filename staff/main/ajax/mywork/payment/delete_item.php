<?php
include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$payment_id = $_POST['payment_id'];


$sql_delete = "DELETE FROM tbl_job_payment_file WHERE payment_id = '$payment_id'";
$rs_delete = mysqli_query($connect_db, $sql_delete) or die($connect_db->error);


$sql_del_img = "DELETE FROM tbl_job_payment_img WHERE payment_id = '$payment_id'";
$rs_del_img = mysqli_query($connect_db, $sql_del_img) or die($connect_db->error);


if ($rs_delete) {

    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}
echo json_encode($arr);

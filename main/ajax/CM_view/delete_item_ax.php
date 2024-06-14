<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$id = $_POST['id'];

$sql_spare_ax = "SELECT * FROM tbl_spare_used_ax WHERE id = '$id'";
$result_spare_ax  = mysqli_query($connect_db, $sql_spare_ax);
$row_spare_ax = mysqli_fetch_array($result_spare_ax);

$spare_used_id = $row_spare_ax['spare_used_id'];



$sql_del = "DELETE  FROM tbl_spare_used_ax WHERE id = '$id'";
$result_del = mysqli_query($connect_db, $sql_del) or die($connect_db->error);



if ($result_del) {
    $arr['result'] = 1;
    $arr['spare_used_id'] = $spare_used_id;
} else {
    $arr['result'] = 0;
}
echo json_encode($arr);

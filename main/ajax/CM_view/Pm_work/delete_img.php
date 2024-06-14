<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$img_id = $_POST['img_id'];

$sql_del = "DELETE FROM tbl_pm_image WHERE img_id = '$img_id'";
$rs_del = mysqli_query($connect_db, $sql_del) or die($connect_db->error);


if ($rs_del) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}
// $arr['result'] = 1;
echo json_encode($arr);

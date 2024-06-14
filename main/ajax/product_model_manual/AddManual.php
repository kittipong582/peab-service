<?php
include ("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$manual_name = mysqli_real_escape_string($connect_db, $_POST['manual_name']);
$remark = mysqli_real_escape_string($connect_db, $_POST['remark']);
$manual_id = mysqli_real_escape_string($connect_db, $_POST['manual_id']);
$model_id = mysqli_real_escape_string($connect_db, $_POST['model_id']);

$sql_insert = "INSERT INTO tbl_spare_part_manual SET 
manual_name = '$manual_name', 
remark = '$remark',
model_id = '$model_id',
manual_id = '$manual_id'";

if (mysqli_query($connect_db, $sql_insert)) {
    $arr['sql'] = $sql_insert;
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}



echo json_encode($arr);

<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$qs_id = $_POST['qs_id'];
$qs_name = $_POST['qs_name'];

$sql_insert = "UPDATE tbl_quotation_setting SET 
qs_name = '$qs_name'
WHERE qs_id = '$qs_id'";

if (mysqli_query($connect_db, $sql_insert)) {
    $arr['sql'] = $sql_insert;
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}



echo json_encode($arr);

<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$warranty_type_id = $_POST['warranty_type_id'];
$warranty_type_name = $_POST['warranty_type_name'];

$sql_insert = "UPDATE tbl_warranty_type SET 
warranty_type_name = '$warranty_type_name'
WHERE warranty_type_id = '$warranty_type_id'";

if (mysqli_query($connect_db, $sql_insert)) {
    $arr['sql'] = $sql_insert;
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}



echo json_encode($arr);

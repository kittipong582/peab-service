<?php
session_start();
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$type_code = $_POST['type_code'];
$type_name = $_POST['type_name'];



$sql = "INSERT INTO tbl_product_type 
SET type_code = '$type_code'
,type_name = '$type_name'";
$rs = mysqli_query($connect_db, $sql) or die($connect_db->error);

if ($rs) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}




echo json_encode($arr);

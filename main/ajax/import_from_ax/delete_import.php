<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$import_id = $_POST['import_id'];


$sql_del = "DELETE FROM tbl_import_stock WHERE import_id = '$import_id'";
$result_del  = mysqli_query($connect_db, $sql_del);

$sql_del2 = "DELETE FROM tbl_import_stock_detail WHERE import_id = '$import_id'";
$result_del2  = mysqli_query($connect_db, $sql_del2);


if($result_del && $result_del2){
    $arr['result'] = 1;
}else{
    $arr['result'] = 2;
}
echo json_encode($arr);

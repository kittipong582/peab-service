<?php
session_start(); 
include("../../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$import_id = mysqli_real_escape_string($connection, $_POST['import_id']);
$remark = mysqli_real_escape_string($connection, $_POST['remark']);


$sql = "UPDATE tbl_import_stock
    SET  receive_result = '0'
        ,receive_remark = '$remark'
    WHERE import_id = '$import_id' ;";

$rs = mysqli_query($connection, $sql) or die($connection->error);


if ($rs) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);
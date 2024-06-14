<?php 
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$brand_id = mysqli_real_escape_string($connect_db, $_POST['brand_id']);
$model_name = mysqli_real_escape_string($connect_db, $_POST['model_name']);
$model_code = mysqli_real_escape_string($connect_db, $_POST['model_code']);

$sql_insert = "INSERT INTO tbl_product_model SET 
brand_id = '$brand_id', 
model_code = '$model_code',
model_name = '$model_name'";

if (mysqli_query($connect_db, $sql_insert)) {
    $arr['sql'] = $sql_insert;
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}



echo json_encode($arr);
?>
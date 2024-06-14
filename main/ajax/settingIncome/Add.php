<?php
session_start();
include("../../../config/main_function.php");
date_default_timezone_set("Asia/Bangkok");

$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$income_type_name = mysqli_real_escape_string($connection, $_POST['income_type_name']);
$income_code = mysqli_real_escape_string($connection, $_POST['income_code']);
$description = mysqli_real_escape_string($connection, $_POST['description']);
$unit_cost = str_replace(",", "", $_POST['unit_cost']);
$unit = $_POST['unit'];

$datetime = date('Y-m-d H:i:s');

if ($connection) {

    $sql_insert = "INSERT INTO tbl_income_type SET 
            income_type_name = '$income_type_name', 
            income_code = '$income_code', 
            description = '$description',
            unit_cost = '$unit_cost',
            active_status = '1',
            unit = '$unit' ";
    $insert = mysqli_query($connection, $sql_insert);
    // echo $sql_insert;
    if ($insert) {
        $result = 1;
    } else {
        $result = 0;
    }
} else {
    $result = 0;
}

mysqli_close($connection);
$arr['result'] = $result;
echo json_encode($arr);

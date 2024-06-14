<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$service_id = $_POST['service_id'];

$sql_service = "SELECT * FROM tbl_income_type WHERE income_type_id = '$service_id'";
$result_service  = mysqli_query($connect_db, $sql_service);
$row_service = mysqli_fetch_array($result_service);

$arr['unit'] = $row_service['unit'];
$arr['unit_cost'] = $row_service['unit_cost'];
echo json_encode($arr);

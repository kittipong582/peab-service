<?php
session_start();
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$holiday_name = $_POST['holiday_name'];
$holiday_datetime = date("Y-m-d",strtotime($_POST['holiday_datetime']));
$note = $_POST['note'];

$sql = "INSERT INTO tbl_holiday
SET holiday_name = '$holiday_name',
holiday_datetime = '$holiday_datetime',
note = '$note'
";

if (mysqli_query($connect_db, $sql)) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

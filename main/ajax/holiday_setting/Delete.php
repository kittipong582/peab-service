<?php
session_start();
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$holiday_id = $_POST['holiday_id'];

$sql = "DELETE FROM tbl_holiday WHERE holiday_id = '$holiday_id'";

if (mysqli_query($connect_db, $sql)) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

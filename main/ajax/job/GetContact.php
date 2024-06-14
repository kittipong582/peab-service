<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$contact_id = $_POST['contact_id'];
$sql = "SELECT * FROM tbl_customer_contact WHERE contact_id = '$contact_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

$arr['contact_name'] = $row['contact_name'];
$arr['contact_phone'] = $row['contact_phone'];
$arr['contact_position'] = $row['contact_position'];

echo json_encode($arr);

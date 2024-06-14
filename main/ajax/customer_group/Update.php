<?php
session_start();
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


    $customer_group_id = $_POST['customer_group_id'];
$group_name = $_POST['group_name'];
$expire_date = date("Y-m-d",strtotime($_POST['expire_date']));


$sql = "UPDATE tbl_customer_group
SET expire_date = '$expire_date'
,customer_group_name = '$group_name'
WHERE customer_group_id = '$customer_group_id'
";

if (mysqli_query($connect_db, $sql)) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

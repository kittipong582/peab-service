<?php
session_start();

include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$create_user_id = $_SESSION['user_id'];
$product_type_id = mysqli_real_escape_string($connect_db, $_POST['type_id']);
$setting_name = mysqli_real_escape_string($connect_db, $_POST['setting_name']);
$pm_setting_id = mysqli_real_escape_string($connect_db, $_POST['pm_setting_id']);
$year = mysqli_real_escape_string($connect_db, $_POST['year_list']);
$date = date('Y-m-d H:i:s');

$sql = "SELECT * FROM tbl_pm_setting WHERE product_type_id = '$product_type_id'";
$res = mysqli_query($connect_db, $sql);
$row = mysqli_num_rows($res);
if ($row > 0) {
    $list_order = $row + 1;
} else {
    $list_order = 1;
}
$sql_insert = "INSERT INTO tbl_pm_setting SET 
pm_setting_id = '$pm_setting_id',
product_type_id = '$product_type_id',
list_order = '$list_order',
setting_name = '$setting_name',
create_datetime = '$date',
year_list = '$year',
create_user_id  = '$create_user_id'
";

// echo"$sql_insert";
if (mysqli_query($connect_db, $sql_insert)) {
    $arr['sql'] = $sql_insert;
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}



echo json_encode($arr);
?>
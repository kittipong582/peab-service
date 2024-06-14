<?php

include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$pm_setting_id = mysqli_real_escape_string($connect_db, $_POST['pm_setting_id']);
$product_type_id = mysqli_real_escape_string($connect_db, $_POST['type_id']);
$setting_name = mysqli_real_escape_string($connect_db, $_POST['setting_name']);
$date = date('Y-m-d H:i:s');
$year = mysqli_real_escape_string($connect_db, $_POST['year_list']);


$sql_update = "UPDATE tbl_pm_setting SET 
product_type_id = '$product_type_id',
setting_name = '$setting_name',
create_datetime = '$date',
year_list = '$year'
WHERE pm_setting_id = '$pm_setting_id'";


if (mysqli_query($connect_db, $sql_update)) {
    $arr['sql'] = $sql_update;
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}
// echo "$sql_insert";
echo json_encode($arr);
?>
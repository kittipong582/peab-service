<?php

include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$pm_setting_detail_id = mysqli_real_escape_string($connect_db, $_POST['pm_setting_detail_id']);
$detail = mysqli_real_escape_string($connect_db, $_POST['detail']);
$remark = mysqli_real_escape_string($connect_db, $_POST['remark']);


$sql_update = "UPDATE tbl_pm_setting_detail SET 
    detail = '$detail',
    remark = '$remark'
    WHERE pm_setting_detail_id = '$pm_setting_detail_id'";


if (mysqli_query($connect_db, $sql_update)) {
    $arr['sql'] = $sql_update;
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}
// echo "$sql_insert";
echo json_encode($arr);
?>
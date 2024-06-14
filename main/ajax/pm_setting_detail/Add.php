<?php

include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$pm_setting_id = mysqli_real_escape_string($connect_db, $_POST['pm_setting_id']);
$detail = mysqli_real_escape_string($connect_db, $_POST['detail']);
$remark = mysqli_real_escape_string($connect_db, $_POST['remark']);

$sql = "SELECT * FROM tbl_pm_setting_detail";
$res = mysqli_query($connect_db, $sql);
$row = mysqli_num_rows($res);
if ($row > 0) {
    $list_order = $row + 1;
} else {
    $list_order = 1;
}

$sql_insert = "INSERT INTO tbl_pm_setting_detail SET 
    pm_setting_id = '$pm_setting_id',  
    list_order = '$list_order',
    detail = '$detail',
    remark = '$remark'
    ";


if (mysqli_query($connect_db, $sql_insert)) {
    $arr['sql'] = $sql_insert;
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}
// echo "$sql_insert";
echo json_encode($arr);
?>
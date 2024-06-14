<?php 

include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$expend_type_id = mysqli_real_escape_string($connect_db, $_POST['expend_type_id']);
$expend_code = mysqli_real_escape_string($connect_db, $_POST['expend_code']);
$expend_type_name = mysqli_real_escape_string($connect_db, $_POST['expend_type_name']);
$description = mysqli_real_escape_string($connect_db, $_POST['description']);

$sql_update = "UPDATE tbl_expend_type SET 
expend_code = '$expend_code',
expend_type_name = '$expend_type_name',
description = '$description' 
WHERE expend_type_id = '$expend_type_id'";
$arr['sql'] = $sql_update;
if (mysqli_query($connect_db, $sql_update)) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

?>
<?php 
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$spare_type_id = mysqli_real_escape_string($connect_db, $_POST['spare_type_id']);
$spare_type_name = mysqli_real_escape_string($connect_db, $_POST['spare_type_name']);

$sql_insert = "INSERT INTO `tbl_spare_type` (`spare_type_id`, `spare_type_name`, `active_status`) VALUES ('$spare_type_id', '$spare_type_name', '1')";

if (mysqli_query($connect_db, $sql_insert)) {
    $arr['sql'] = $sql_insert;
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

$arr['user_id'] = $user_id;

echo json_encode($arr);
?>
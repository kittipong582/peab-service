<?php 

include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$service_id = mysqli_real_escape_string($connect_db, $_POST['service_id']);
$service_name = mysqli_real_escape_string($connect_db, $_POST['service_name']);
$unit = mysqli_real_escape_string($connect_db, $_POST['unit']);
$unit_cost = mysqli_real_escape_string($connect_db, $_POST['unit_cost']);

$sql_update = "UPDATE tbl_oth_open_job_service SET 
service_name = '$service_name',
unit = '$unit',
unit_cost = '$unit_cost' 
WHERE service_id = '$service_id'";
$arr['sql'] = $sql_update;
if (mysqli_query($connect_db, $sql_update)) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

?>
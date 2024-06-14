<?php 

include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$zone_id = mysqli_real_escape_string($connect_db, $_POST['zone_id']);
$zone_name = mysqli_real_escape_string($connect_db, $_POST['zone_name']);

$sql_update = "UPDATE tbl_zone SET zone_name = '$zone_name' WHERE zone_id = '$zone_id'";
$arr['sql'] = $sql_update;
if (mysqli_query($connect_db, $sql_update)) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

?>
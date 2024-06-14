<?php
session_start();
include ("../../../config/main_function.php");

$connection = connectDB("LM=VjfQ{6rsm&/h`");


$spare_broken_id = mysqli_real_escape_string($connection, $_POST['spare_broken_id']);
$spare_type_id = mysqli_real_escape_string($connection, $_POST['spare_type_id']);
$spare_part_id = mysqli_real_escape_string($connection, $_POST['spare_part_id']);
$manual_id  = mysqli_real_escape_string($connection, $_POST['manual_id']);
$model_id = mysqli_real_escape_string($connection, $_POST['model_id']);
$manual_sub_id = mysqli_real_escape_string($connection, $_POST['manual_sub_id']);

if ($connection) {

    $sql_insert = "INSERT INTO tbl_spare_broken SET  
        spare_broken_id = '$spare_broken_id',
        spare_type_id = '$spare_type_id',
        manual_id = '$manual_id',
        model_id = '$model_id',
        manual_sub_id = '$manual_sub_id',
        spare_part_id = '$spare_part_id'";

    $res_insert = mysqli_query($connection, $sql_insert) or die($connection->error);

    if ($res_insert) {
        $arr['result'] = 1;
    } else {
        $arr['result'] = 0;
    }
} else {
    $arr['result'] = 9;
}

mysqli_close($connection);
echo json_encode($arr);
?>
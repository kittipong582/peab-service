<?php
session_start();
include ("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

$area_name = mysqli_real_escape_string($connection, $_POST['area_name']);
$area_id = mysqli_real_escape_string($connection, $_POST['area_id']);

if ($connection) {

    $sql_insert = "INSERT INTO tbl_zone_oh SET  
        area_id = '$area_id',
        active_status = '1',
        area_name = '$area_name'";

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
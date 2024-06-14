<?php
session_start();
include ("../../../config/main_function.php");

$connection = connectDB("LM=VjfQ{6rsm&/h`");

$arr = array();

if ($connection) {
    $manual_id = mysqli_real_escape_string($connection, $_POST['manual_id']);

    $sql_delete = "DELETE FROM tbl_spare_part_manual WHERE manual_id = '$manual_id'";
    $res_delete = mysqli_query($connection, $sql_delete);
    if ($arr['result'] = 1) {
        $sql_delete2 = "DELETE FROM tbl_spare_part_manual_sub WHERE manual_id = '$manual_id'";
        $res_delete2 = mysqli_query($connection, $sql_delete2);
    }

    if ($res_delete && $res_delete2) {
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
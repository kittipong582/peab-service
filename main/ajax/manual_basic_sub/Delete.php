<?php
session_start();
include ("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

$spare_broken_id = mysqli_real_escape_string($connection, $_POST['spare_broken_id']);

if ($connection) {

    $sql_delete = "DELETE FROM tbl_spare_broken WHERE spare_broken_id = '$spare_broken_id'";

    $res_delete = mysqli_query($connection, $sql_delete) or die($connection->error);

    if ($res_delete) {
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
<?php
session_start();
include("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");


$status_id = mysqli_real_escape_string($connection, $_POST['status_id']);
$status_name = mysqli_real_escape_string($connection, $_POST['status_name']);
if ($connection) {

        $sql_update = "UPDATE tbl_machine_status SET  
        status_name = '$status_name'
        WHERE status_id = '$status_id'";

    $res_update = mysqli_query($connection, $sql_update) or die($connection->error);

    if ($res_update) {
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
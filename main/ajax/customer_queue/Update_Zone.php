<?php
session_start();
include ("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

$queue_id = mysqli_real_escape_string($connection, $_POST['queue_id']);
$area_id = mysqli_real_escape_string($connection, $_POST['area_id']);

if ($connection) {

        $sql_update = "UPDATE tbl_customer_queue SET  
        area_id = '$area_id' 
        WHERE queue_id = '$queue_id'";

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
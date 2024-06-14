<?php
session_start();
include ("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

$manual_sub_id = mysqli_real_escape_string($connection, $_POST['manual_sub_id']);

if ($connection) {

    $sql_update = "UPDATE tbl_manual_sub SET  
        file_name = NULL 
        WHERE manual_sub_id = '$manual_sub_id'";

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
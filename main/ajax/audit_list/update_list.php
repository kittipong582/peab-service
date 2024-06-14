<?php
session_start();
include("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");


$audit_id = mysqli_real_escape_string($connection, $_POST['audit_id']);
$audit_name = mysqli_real_escape_string($connection, $_POST['audit_name']);
$description = mysqli_real_escape_string($connection, $_POST['description']);
$checklist_id = mysqli_real_escape_string($connection, $_POST['checklist_id']);
if ($connection) {

        $sql_update = "UPDATE tbl_audit_form SET  
        audit_name = '$audit_name',
        description = '$description'
        WHERE audit_id = '$audit_id'";

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
<?php
session_start();
include("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");


$audit_id = getRandomID2(10, 'tbl_audit_form', 'audit_id');
$audit_name = mysqli_real_escape_string($connection, $_POST['audit_name']);
$description = mysqli_real_escape_string($connection, $_POST['description']);


if ($connection) {

    $sql_insert = "INSERT INTO tbl_audit_form SET  
        audit_id = '$audit_id',
        description = '$description',
        audit_name = '$audit_name'";

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
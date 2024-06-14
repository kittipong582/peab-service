<?php
session_start();
include("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");


$qc_id = getRandomID2(10, 'tbl_qc_form', 'qc_id');
$qc_name = mysqli_real_escape_string($connection, $_POST['qc_name']);
$description = mysqli_real_escape_string($connection, $_POST['description']);
$type_id = mysqli_real_escape_string($connection, $_POST['type_id']);


if ($connection) {

    $sql_insert = "INSERT INTO tbl_qc_form SET  
        qc_id = '$qc_id',
        product_type_id = '$type_id',
        description = '$description',
        qc_name = '$qc_name'";

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
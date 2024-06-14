<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$oth_type_name = $_POST['oth_type_name'];

$sql_insert = "INSERT INTO tbl_oth_job_type SET 
oth_type_name = '$oth_type_name'";

if (mysqli_query($connect_db, $sql_insert)) {
    $arr['sql'] = $sql_insert;
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}



echo json_encode($arr);

<?php 
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$job_type = mysqli_real_escape_string($connect_db, $_POST['job_type']);
$sub_type_name = mysqli_real_escape_string($connect_db, $_POST['sub_type_name']);

$sql_insert = "INSERT INTO tbl_sub_job_type SET 
job_type = '$job_type', 
sub_type_name = '$sub_type_name'";

if (mysqli_query($connect_db, $sql_insert)) {
    $arr['sql'] = $sql_insert;
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}



echo json_encode($arr);
?>
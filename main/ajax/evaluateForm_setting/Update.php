<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$evaluate_id = $_POST['evaluate_id'];
$detail = $_POST['detail'];



$sql_insert = "UPDATE tbl_job_evaluate SET 
detail = '$detail'
WHERE evaluate_id = '$evaluate_id'";
// echo $sql_insert;
if (mysqli_query($connect_db, $sql_insert)) {
    $arr['sql'] = $sql_insert;
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}


$arr['sql'] = $sql_insert;
echo json_encode($arr);
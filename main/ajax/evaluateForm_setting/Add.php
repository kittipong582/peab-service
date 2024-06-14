<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$list_order = $_POST['list_order'];
$job_type = $_POST['job_type'];
$detail = $_POST['detail'];



$sql_insert = "INSERT INTO tbl_job_evaluate SET 
job_type = '$job_type'
,detail = '$detail'
,list_order = '$list_order'";
// echo $sql_insert;
if (mysqli_query($connect_db, $sql_insert)) {
    $arr['sql'] = $sql_insert;
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}



echo json_encode($arr);
<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$list_order = 0;
foreach ($_POST['evaluate_id'] as $evaluate_id) {
    $list_order++;
    $sql_set = "UPDATE tbl_job_evaluate SET list_order ='$list_order' WHERE evaluate_id = '$evaluate_id'";
    $rs_set  = mysqli_query($connect_db, $sql_set) or die($connect_db->error);
}


// echo $sql_insert;
$arr['result'] = 1;
$arr['sql'] = $sql_set;
echo json_encode($arr);
mysqli_close($connect_db);
<?php

include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$oth_type_id = mysqli_real_escape_string($connect_db, $_POST['oth_type_id']);
$oth_type_name = mysqli_real_escape_string($connect_db, $_POST['oth_type_name']);


$sql_update = "UPDATE tbl_oth_job_type SET 
            oth_type_name = '$oth_type_name'
            WHERE oth_type_id = '$oth_type_id'";
$arr['sql'] = $sql_update;
if (mysqli_query($connect_db, $sql_update)) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

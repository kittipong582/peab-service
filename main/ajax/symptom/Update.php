<?php

include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$symptom_type_id = mysqli_real_escape_string($connect_db, $_POST['symptom_type_id']);
$symptom_type_name = mysqli_real_escape_string($connect_db, $_POST['symptom_type_name']);


$sql_update = "UPDATE tbl_symptom_type SET 
            type_name = '$symptom_type_name'
            WHERE symptom_type_id = '$symptom_type_id'";
$arr['sql'] = $sql_update;
if (mysqli_query($connect_db, $sql_update)) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

<?php 

include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$sub_job_type_id = mysqli_real_escape_string($connect_db, $_POST['sub_job_type_id']);
$sub_type_name = mysqli_real_escape_string($connect_db, $_POST['sub_type_name']);
$job_type = mysqli_real_escape_string($connect_db, $_POST['job_type']);

$sql_update = "UPDATE tbl_sub_job_type SET 
            sub_type_name = '$sub_type_name',
            job_type = '$job_type' 
            WHERE sub_job_type_id = '$sub_job_type_id'";
$arr['sql'] = $sql_update;
if (mysqli_query($connect_db, $sql_update)) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

?>
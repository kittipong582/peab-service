<?php
session_start();
include ("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$staff_id = mysqli_real_escape_string($connect_db, $_POST['staff_id']);
$j_id = mysqli_real_escape_string($connect_db, $_POST['j_id']);

if ($connect_db) {

    $sql_insert = "INSERT INTO tbl_job_staff SET  
        staff_id = '$staff_id',
        job_id = '$j_id'";

    $res_insert = mysqli_query($connect_db, $sql_insert) or die ($connect_db->error);

    if ($res_insert) {
        $arr['result'] = 1;
    } else {
        $arr['result'] = 0;
    }
} else {
    $arr['result'] = 9;
}

mysqli_close($connect_db);
echo json_encode($arr);
?>
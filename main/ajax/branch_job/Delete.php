<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];
$type = $_POST['type'];
$chk_del = 0;
if ($type == 1) {

    $sql_del = "DELETE FROM tbl_job WHERE job_id = '$job_id'";
    if (mysqli_query($connect_db, $sql_del)) {
        $arr['result'] = 1;
    } else {
        $arr['result'] = 2;
    }
} else if ($type == 2) {

    $chk_del_group = 0;
    $chk_del_detail = 0;


    $sql_detail = "SELECT * FROM tbl_group_pm_detail WHERE group_pm_id = '$job_id'";
    $rs_detail = mysqli_query($connect_db, $sql_detail);
    $num_detail = mysqli_num_rows($rs_detail);
    while ($row_detail = mysqli_fetch_assoc($rs_detail)) {


        $sql_del = "DELETE FROM tbl_job WHERE job_id = '{$row_detail['job_id']}'";
        if (mysqli_query($connect_db, $sql_del)) {
            $chk_del_detail++;
        } else {
            $arr['result'] = 2;
        }
    }

    if ($chk_del_detail == $num_detail) {
        $sql_del = "DELETE FROM tbl_group_pm WHERE group_pm_id = '$job_id'";
        if (mysqli_query($connect_db, $sql_del)) {
            $arr['result'] = 1;
        } else {
            $arr['result'] = 2;
        }
    }
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

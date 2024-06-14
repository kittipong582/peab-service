<?php

session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$job_id = $_POST['job_id'];

$file = $_POST['canvas_img_data'];
// echo $_POST['canvas_img_data'];
// $img = str_replace('data:image/png;base64,', '', $img);
// $img = str_replace(' ', '+', $img);
// $data = base64_decode($img);
// $file = uniqid() . '.png';

$sql_group = "SELECT * FROM tbl_group_pm_detail WHERE job_id = '$job_id'";
$rs_group  = mysqli_query($connect_db, $sql_group) or die($connect_db->error);
$num_group = mysqli_num_rows($rs_group);
$row_group = mysqli_fetch_array($rs_group);

// echo $sql_group;

if ($num_group > 0) {

    $group_pm_id = $row_group['group_pm_id'];

    $sql = "UPDATE tbl_group_pm 
    SET signature_image = '$file'
    WHERE group_pm_id = '$group_pm_id'";
} else {


    $sql = "UPDATE tbl_job 
    SET signature_image = '$file'
    WHERE job_id = '$job_id'";
}
// echo $sql;

$rs = mysqli_query($connect_db, $sql) or die($connect_db->error);
if ($rs) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

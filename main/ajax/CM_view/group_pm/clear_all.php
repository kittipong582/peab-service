<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$create_user_id = $_SESSION['user_id'];

$group_pm_id = $_POST['group_pm_id'];



// echo $job_select;
$sql = "DELETE FROM tbl_group_pm WHERE group_pm_id = '$group_pm_id';
              ";

$rs = mysqli_query($connect_db, $sql) or die($connect_db->error);





if ($rs) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}
// $arr['result'] = 1;
echo json_encode($arr);

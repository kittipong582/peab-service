<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$create_user_id = $_SESSION['user_id'];
$group_pm_id = $_POST['group_pm_id'];
$pm_date = date("Y-m-d", strtotime($_POST['pm_date']));


$sql = "UPDATE tbl_group_pm
                SET  group_date = '$pm_date'
                    WHERE group_pm_id = '$group_pm_id'
              ";

$rs = mysqli_query($connect_db, $sql) or die($connect_db->error);


$sql_job = "SELECT job_id FROM tbl_group_pm_detail WHERE group_pm_id = '$group_pm_id'";
$rs_job = mysqli_query($connect_db, $sql_job);
while ($row_job = mysqli_fetch_assoc($rs_job)) {

    $sql_update = "UPDATE tbl_job SET  appointment_date = '$pm_date' WHERE job_id = '{$row_job['job_id']}'";
    $rs_update = mysqli_query($connect_db, $sql_update);
  
}



if ($rs) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}
// $arr['result'] = 1;
echo json_encode($arr);

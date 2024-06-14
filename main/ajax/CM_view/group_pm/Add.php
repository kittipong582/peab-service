<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$create_user_id = $_SESSION['user_id'];
$job_select = $_POST['job_select'];
$start_datetime =  $_POST['start_datetime'];
$consql = "";
if ($start_datetime != "" ) {
    $start_datetime =  date("Y-m-d H:i:s", strtotime($_POST['start_datetime']));
    $consql = ',start_service_time = "' . $start_datetime . '"';
}
$job_id = $_POST['job_id'];
$have_data = $_POST['have_data'];
$group_pm_id = $_POST['group_pm_id'];
$pm_date = date("Y-m-d", strtotime($_POST['pm_date']));

if ($have_data == 1) {
    $sql_res = "SELECT responsible_user_id FROM tbl_job WHERE job_id = '$job_id'";
    $rs_res = mysqli_query($connect_db, $sql_res) or die($connect_db->error);
    $row_res = mysqli_fetch_assoc($rs_res);

    $responsible_user_id = $row_res['responsible_user_id'];

    $job_id_select = array_push($job_select, $job_id);


    $sql = "INSERT INTO tbl_group_pm
                SET  group_date = '$pm_date'
                    ,create_user_id = '$create_user_id'
                    ,responsible_user_id = '$responsible_user_id'
                    ,group_pm_id = '$group_pm_id'
                    $consql
              ";

    $rs = mysqli_query($connect_db, $sql);

    // echo $sql;
} else {

    $sql = "UPDATE tbl_group_pm
    SET  group_date = '$pm_date'
        WHERE group_pm_id = '$group_pm_id'
  ";

    $rs = mysqli_query($connect_db, $sql);
}

foreach ($job_select as $r) {
    $job_id_select = $r;

    $sql_detail = "INSERT INTO tbl_group_pm_detail
    SET  job_id = '$job_id_select'
        ,group_pm_id = '$group_pm_id'
  ";

    $rs_detail = mysqli_query($connect_db, $sql_detail);
}

$sql_job = "SELECT job_id FROM tbl_group_pm_detail WHERE group_pm_id = '$group_pm_id'";
$rs_job = mysqli_query($connect_db, $sql_job);
while ($row_job = mysqli_fetch_assoc($rs_job)) {

    $sql_update = "UPDATE tbl_job SET appointment_date = '$pm_date' $consql WHERE job_id = '{$row_job['job_id']}'";
    $rs_update = mysqli_query($connect_db, $sql_update);
    // echo $sql_update;
}



if ($rs || $rs_detail) {
    $arr['result'] = 1;
    $arr['sql'] = $sql;
} else {
    $arr['result'] = 0;
}
// $arr['result'] = 1;
echo json_encode($arr);

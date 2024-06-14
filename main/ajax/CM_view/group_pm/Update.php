<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$create_user_id = $_SESSION['user_id'];
$job_select = $_POST['job_select'];

foreach ($job_select as $r) {
    $job_id_select .= $r . ",";
}
$job_id = $_POST['job_id'];
$job_id_select = $job_id_select . $job_id;
$group_pm_id = $_POST['group_pm_id'];

$pm_date = date("Y-m-d", strtotime($_POST['pm_date']));

// echo $job_select;
$sql = "UPDATE tbl_group_pm
                SET  group_date = '$pm_date'
                    ,job_id = '$job_id_select'
                    WHERE group_pm_id = '$group_pm_id'
              ";

$rs = mysqli_query($connect_db, $sql) or die($connect_db->error);

foreach ($job_select as $r) {
    $job_id_select = $r;

    $sql_detail = "INSERT INTO tbl_group_pm_detail
    SET  job_id = '$job_id_select'
        ,group_pm_id = '$group_pm_id'
  ";

    $rs_detail = mysqli_query($connect_db, $sql_detail);

    $sql_update = "UPDATE tbl_job SET start_service_time = '$start_datetime' and appointment_date = '$pm_date' WHERE job_id = '$job_id_select'";
    $rs_update = mysqli_query($connect_db, $sql_update);

    // echo $sql_detail;
}






if ($rs) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}
// $arr['result'] = 1;
echo json_encode($arr);

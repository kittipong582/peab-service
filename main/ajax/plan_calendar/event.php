<?php

session_start();
header("Content-type:text/json; charset=UTF-8");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

include('../../../config/main_function.php');
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$event_array = array();
$condition = "";
$condition2 = "";


$job_type = $_POST['job_type'];
$user_id = $_POST['user_id'];
$team_id = $_POST['team_id'];
$status = $_POST['status'];

if ($job_type != 'x') {
    $condition .= "AND a.job_type = '$job_type'";
}

// if ($job_type != 'x') {
//     $condition .= "AND a.job_type = '$job_type'";
// }

if ($team_id != 'x') {
    $condition .= "AND c.branch_id = '$team_id'";
}

if ($user_id != 'x') {
    $condition .= "AND a.responsible_user_id = '$user_id'";
}

if ($status == 'x') {
    $condition .= '';
    $condition2 .= '';
} else if ($status == '1') {
    $condition .= ' AND a.appointment_date IS NOT NULL AND a.start_service_time IS NULL AND a.finish_service_time IS NULL';
    $condition2 .= ' AND a.appointment_date IS NOT NULL AND a.start_service_time IS NULL AND a.finish_service_time IS NULL';
} else if ($status == '2') {
    $condition .= ' AND a.start_service_time IS NOT NULL and a.finish_service_time IS NULL';
    $condition2 .= ' AND a.start_service_time IS NOT NULL and a.finish_service_time IS NULL';
} else if ($status == '3') {
    $condition .= ' AND hold_status = 1';
    $condition2 .= ' AND hold_status = 1';
} else if ($status == '4') {

    $condition .= ' AND a.finish_service_time IS NOT NULL and a.close_datetime IS NULL';
    $condition2 .= ' AND a.finish_service_time IS NOT NULL and a.close_datetime IS NULL';

} else if ($status == '5') {

    $condition .= ' AND a.close_datetime IS NOT NULL ';
    $condition2 .= ' AND a.close_datetime IS NOT NULL ';
} else if ($status == '6') {
    $condition .= 'AND DATE(a.appointment_date) != CURDATE() AND a.finish_service_time IS NULL ';
    $condition2 .= 'AND DATE(a.appointment_date) != CURDATE() AND a.finish_service_time IS NULL ';
}



$i = 0;
$sql = "SELECT a.*,b.branch_name AS cus_branch FROM tbl_job a 
LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id
LEFT JOIN tbl_user c ON c.user_id = a.responsible_user_id
WHERE a.cancel_datetime IS NULL AND a.appointment_date IS NOT NULL AND a.job_id NOT IN (SELECT job_id FROM tbl_group_pm_detail ) $condition  GROUP BY job_id;";
$rs = mysqli_query($connection, $sql) or die($connection->error);
//echo $sql;
while ($row = mysqli_fetch_assoc($rs)) {

    $event_array[$i]['url'] = "view_cm.php?id=" . $row['job_id'] . "&&type=1";
    $event_array[$i]['title'] = "(" . $row['job_no'] . ") " . $row['cus_branch'];
    $event_array[$i]['start'] = $row['appointment_date'];
    $event_array[$i]['end'] = $row['appointment_date'];

    $i++;
}


// $sql = "SELECT * FROM tbl_group_pm 
// WHERE group_pm_id IN (select group_pm_id from tbl_group_pm_detail)
// ";
// $rs = mysqli_query($connection, $sql) or die($connection->error);

// while ($row = mysqli_fetch_assoc($rs)) {

//         $event_array[$i]['url'] = "view_cm.php?id=" . $row['group_pm_id'] . "&&type=2";
//         $event_array[$i]['title'] = "( งานกลุ่ม PM ) " . $row['cus_branch'];
//         $event_array[$i]['start'] = $row['group_date'];
//         $event_array[$i]['end'] = $row['group_date'];

//     $i++;
// }

echo json_encode($event_array);

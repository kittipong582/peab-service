<?php
session_start();
include("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

$create_user_id = $_SESSION['user_id'];

$branch_id = mysqli_real_escape_string($connection, $_POST['customer_branch_id']);
$customer_id = mysqli_real_escape_string($connection, $_POST['customer_id']);
$total_score = mysqli_real_escape_string($connection, $_POST['total_score'] == "" ? 0 : $_POST['total_score']);

$appointment_date = $_POST['appointment_date'];
$appointment_date = explode('/', $_POST['appointment_date']);
$appointment_date = date('Y-m-d', strtotime($appointment_date['0'] . "-" . $appointment_date['1'] . "-" . $appointment_date['2']));

$sql = "SELECT * FROM tbl_job_audit";
$res = mysqli_query($connection, $sql);
$row = mysqli_num_rows($res);

if ($row >= 1) {
    $list_order = $row + 1;
} else {
    $list_order = 1;
}


if ($connection) {

    $group_id  = getRandomID(10, 'tbl_job_audit_group', 'group_id');


    $sql_insert_group = "INSERT INTO tbl_job_audit_group SET 
    group_id = '$group_id'";
    $res_insert_group = mysqli_query($connection, $sql_insert_group) or die($connection->error);

    $sql_topic = "SELECT * FROM tbl_audit_form WHERE active_status ='1' ";
    $res_topic = mysqli_query($connection, $sql_topic);
    while ($row_topic = mysqli_fetch_assoc($res_topic)) {
        $job_id = getRandomID2(10, 'tbl_job_audit', 'job_id');

        $topic_id = $row_topic['topic_id'];
        $audit_id = $row_topic['audit_id'];

        $sql_insert = "INSERT INTO tbl_job_audit SET  
        job_id = '$job_id',
        create_user_id = '$create_user_id',
        group_id = '$group_id',
        audit_id = '$audit_id',
        list_order = '$list_order',
        branch_id = '$branch_id',
        customer_id = '$customer_id',
        total_score = '$total_score',
        appointment_date= '$appointment_date'";
        $res_insert = mysqli_query($connection, $sql_insert) or die($connection->error);
    }
    if ($res_insert) {
        $arr['result'] = 1;
    } else {
        $arr['result'] = 0;
    }
} else {
    $arr['result'] = 9;
}

echo json_encode($arr);

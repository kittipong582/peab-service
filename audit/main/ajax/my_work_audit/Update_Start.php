<?php
session_start();
include("../../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

// $create_user_id = $_SESSION['user_id'];
$job_id = mysqli_real_escape_string($connection, $_POST['job_id']);
$start_audit = date("Y-m-d H:i:s");
$audit_id = mysqli_real_escape_string($connection, $_POST['audit_id']);
$group_id = mysqli_real_escape_string($connection, $_POST['group_id']);

if ($connection) {

    $sql_update = "UPDATE tbl_job_audit SET  
        start_audit = '$start_audit', 
        audit_id = '$audit_id' 
        WHERE job_id = '$job_id'";

    $res_update = mysqli_query($connection, $sql_update) or die($connection->error);

    if ($res_update) {

        $sql_group_chk = "SELECT start_datetime FROM tbl_job_audit_group
        WHERE group_id = '$group_id'";
        $res_group_chk = mysqli_query($connection, $sql_group_chk) or die($connection->error);
        $row_chk = mysqli_fetch_assoc($res_group_chk);
        if ($row_chk['start_datetime'] == "") {
            $sql_update_group = "UPDATE tbl_job_audit_group SET  
            start_datetime = '$start_audit'
            WHERE group_id = '$group_id'";

            $res_update_group = mysqli_query($connection, $sql_update_group) or die($connection->error);
            if ($res_update_group) {
                $arr['result'] = 1;
            } else {
                $arr['result'] = 0;
            }
        }else{
            $arr['result'] = 1;
        }
    } else {
        $arr['result'] = 0;
    }
} else {
    $arr['result'] = 9;
}

mysqli_close($connection);
echo json_encode($arr);

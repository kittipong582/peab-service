<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$create_user_id = $_SESSION['user_id'];
$so_no = $_POST['so_no'];
$job_id = $_POST['mainjob_id'];
$group_type = $_POST['group_type'];

if ($group_type == 1) {
    $sql = "UPDATE tbl_job
                SET  so_no = '$so_no'    
                    WHERE job_id = '$job_id'
              ";

    $rs = mysqli_query($connect_db, $sql) or die($connect_db->error);
} else if ($group_type == 2) {

    $sql = "UPDATE tbl_group_pm
    SET  so_no = '$so_no'    
        WHERE group_pm_id = '$job_id'
  ";

    $rs = mysqli_query($connect_db, $sql) or die($connect_db->error);

    if ($rs) {

        $sql_detail = "SELECT job_id FROM tbl_group_pm_detail WHERE group_pm_id = '$job_id'";
        $result_detail  = mysqli_query($connect_db, $sql_detail);
        while ($row_detail = mysqli_fetch_array($result_detail)) {

            $sql_update = "UPDATE tbl_job SET so_no = '$so_no' WHERE job_id = '{$row_detail['job_id']}'";
            $rs_update = mysqli_query($connect_db, $sql_update) or die($connect_db->error);
        }
    }
}




if ($rs) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}
// $arr['result'] = 1;
echo json_encode($arr);

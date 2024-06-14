<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$responsible_user_id = $_POST['responsible_user_id'];
$expend_type_id = $_POST['expend_type_id'];
$amount = $_POST['amount'];
$job_expend_id = $_POST['job_expend_id'];
$i = 1;


$sql_expend = "UPDATE tbl_job_expend
                SET  
                    expend_type_id = '$expend_type_id'
                    , expend_amount = '$amount'
                    WHERE job_expend_id = '$job_expend_id'
                ";

$rs_expend = mysqli_query($connect_db, $sql_expend) or die($connect_db->error);


if ($rs_expend) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}
// $arr['result'] = 1;
echo json_encode($arr);

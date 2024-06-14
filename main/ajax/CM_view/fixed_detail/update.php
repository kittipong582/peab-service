<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$symptom_type_id = $_POST['symptom_type_id'];
$reason_type_id = $_POST['reason_type_id'];
$fixed_id = $_POST['fixed_id'];

$remark = $_POST['remark'];



$sql_fixed = "UPDATE tbl_fixed
                SET 
symptom_type_id = '$symptom_type_id'
                    ,reason_type_id = '$reason_type_id'
                    ,remark = '$remark'
WHERE fixed_id = '$fixed_id'
                ";

$rs_fixed = mysqli_query($connect_db, $sql_fixed) or die($connect_db->error);


if ($rs_fixed) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}
// $arr['result'] = 1;
echo json_encode($arr);

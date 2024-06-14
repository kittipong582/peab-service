<?php
include("../../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$form_id = $_POST['form_id'];
$form_name = $_POST['form_name'];
$form_type = $_POST['form_type'];
$have_remark = '0';
if (isset($_POST['have_remark'])) {
    $have_remark = 1;
}
$choice1 = $_POST['choice1'];
$choice2 = $_POST['choice2'];

$sql_insert = "UPDATE tbl_oh_form SET 

form_name = '$form_name'
,form_type = '$form_type'
,have_remark = '$have_remark'
,choice1= '$choice1'
,choice2 = '$choice2'
WHERE form_id = '$form_id'";
// echo $sql_insert;
if (mysqli_query($connect_db, $sql_insert)) {
    $arr['sql'] = $sql_insert;
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}


$arr['sql'] = $sql_insert;
echo json_encode($arr);

<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$list_order = $_POST['list_order'];
$job_type = $_POST['job_type'];
$form_name = $_POST['form_name'];
$form_type = $_POST['form_type'];
$have_remark = '0';
if (isset($_POST['have_remark'])) {
    $have_remark = $_POST['have_remark'];
}
$choice1 = $_POST['choice1'];
$choice2 = $_POST['choice2'];
$product_type = $_POST['product_type'];

$sql_insert = "INSERT INTO tbl_technical_form SET 
job_type = '$job_type'
,form_name = '$form_name'
,form_type = '$form_type'
,have_remark = '$have_remark'
,list_order = '$list_order'
,choice1= '$choice1'
,choice2 = '$choice2'
,product_type = '$product_type'";
// echo $sql_insert;
if (mysqli_query($connect_db, $sql_insert)) {
    $arr['sql'] = $sql_insert;
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}



echo json_encode($arr);

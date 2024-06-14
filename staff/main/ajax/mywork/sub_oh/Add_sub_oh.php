<?php
session_start();
include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];

$get_oh_datetime = (empty($_POST['get_oh_datetime']) ? 'NULL' : date("Y-m-d", strtotime($_POST['get_oh_datetime'])));
$get_oh_user = $_POST['get_oh_user'];

$send_oh_datetime = (empty($_POST['send_oh_datetime']) ? 'NULL' : date("Y-m-d", strtotime($_POST['send_oh_datetime'])));
$send_oh_user = $_POST['sent_oh_user'];

$get_qcoh_datetime = (empty($_POST['get_qcoh_datetime']) ? 'NULL' : date("Y-m-d", strtotime($_POST['get_qcoh_datetime'])));
$get_qcoh_user = $_POST['get_qcoh_user'];

$send_qcoh_datetime = (empty($_POST['send_qcoh_datetime']) ? 'NULL' : date("Y-m-d", strtotime($_POST['send_qcoh_datetime'])));
$send_qcoh_user = $_POST['send_qcoh_user'];

$pay_oh_datetime = (empty($_POST['pay_oh_datetime']) ? 'NULL' : date("Y-m-d", strtotime($_POST['pay_oh_datetime'])));
$pay_oh_user = $_POST['pay_oh_user'];

$return_datetime = (empty($_POST['return_datetime']) ? 'NULL' : date("Y-m-d", strtotime($_POST['return_datetime'])));
$return_oh_user = $_POST['return_oh_user'];


if ($get_oh_datetime != 'NULL') {

    $sql = "UPDATE tbl_job 
SET get_oh_datetime = '$get_oh_datetime'
WHERE job_id = '$job_id'";
$rs_update = mysqli_query($connect_db, $sql) or die($connect_db->error);
}else{
    $sql = "UPDATE tbl_job 
    SET get_oh_datetime = null
    WHERE job_id = '$job_id'";
    $rs_update = mysqli_query($connect_db, $sql) or die($connect_db->error);
}

if ($send_oh_datetime != 'NULL') {

    $sql = "UPDATE tbl_job 
SET send_oh_datetime = '$send_oh_datetime'
WHERE job_id = '$job_id'";
$rs_update = mysqli_query($connect_db, $sql) or die($connect_db->error);
}else{
    $sql = "UPDATE tbl_job 
    SET send_oh_datetime = null
    WHERE job_id = '$job_id'";
    $rs_update = mysqli_query($connect_db, $sql) or die($connect_db->error);
}

if ($get_qcoh_datetime != 'NULL') {

    $sql = "UPDATE tbl_job 
SET get_qcoh_datetime = '$get_qcoh_datetime'
WHERE job_id = '$job_id'";
$rs_update = mysqli_query($connect_db, $sql) or die($connect_db->error);
}else{
    $sql = "UPDATE tbl_job 
    SET get_qcoh_datetime = null
    WHERE job_id = '$job_id'";
    $rs_update = mysqli_query($connect_db, $sql) or die($connect_db->error);
}

if ($send_qcoh_datetime != 'NULL') {

    $sql = "UPDATE tbl_job 
SET send_qcoh_datetime = '$send_qcoh_datetime'
WHERE job_id = '$job_id'";
$rs_update = mysqli_query($connect_db, $sql) or die($connect_db->error);
}else{
    $sql = "UPDATE tbl_job 
    SET send_qcoh_datetime = null
    WHERE job_id = '$job_id'";
    $rs_update = mysqli_query($connect_db, $sql) or die($connect_db->error);
}


if ($pay_oh_datetime != 'NULL') {

    $sql = "UPDATE tbl_job 
SET pay_oh_datetime = '$pay_oh_datetime'
WHERE job_id = '$job_id'";
$rs_update = mysqli_query($connect_db, $sql) or die($connect_db->error);
}else{
    $sql = "UPDATE tbl_job 
    SET pay_oh_datetime = null
    WHERE job_id = '$job_id'";
    $rs_update = mysqli_query($connect_db, $sql) or die($connect_db->error);
}


if ($return_datetime != 'NULL') {

    $sql = "UPDATE tbl_job 
SET return_datetime = '$return_datetime'
WHERE job_id = '$job_id'";
$rs_update = mysqli_query($connect_db, $sql) or die($connect_db->error);
}else{
    $sql = "UPDATE tbl_job 
    SET return_datetime = null
    WHERE job_id = '$job_id'";
    $rs_update = mysqli_query($connect_db, $sql) or die($connect_db->error);
}

// echo $get_qcoh_user;

$sql = "UPDATE tbl_job 
SET get_oh_user = '$get_oh_user'
,send_oh_user = '$send_oh_user'
,get_qcoh_user = '$get_qcoh_user'
,send_qcoh_user = '$send_qcoh_user'
,pay_oh_user = '$pay_oh_user'
,return_oh_user = '$return_oh_user'
WHERE job_id = '$job_id'";


$rs_update = mysqli_query($connect_db, $sql) or die($connect_db->error);

if ($rs_update) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

// echo "test";
echo json_encode($arr);

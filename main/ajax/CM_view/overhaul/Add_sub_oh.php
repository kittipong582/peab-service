<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];

$oh_type2 = date("Y-m-d", strtotime($_POST['oh_type2']));
$user_oh_type2 = $_POST['user_oh_type2'];

$oh_type3 = date("Y-m-d", strtotime($_POST['oh_type3']));
$user_oh_type3 = $_POST['user_oh_type3'];

$oh_type4 = date("Y-m-d", strtotime($_POST['oh_type4']));
$user_oh_type4 = $_POST['user_oh_type4'];

$oh_type5 = date("Y-m-d", strtotime($_POST['oh_type5']));
$user_oh_type5 = $_POST['user_oh_type5'];

$oh_type6 = date("Y-m-d", strtotime($_POST['oh_type6']));
$user_oh_type6 = $_POST['user_oh_type6'];

$oh_type7 = date("Y-m-d", strtotime($_POST['oh_type7']));
$user_oh_type7 = $_POST['user_oh_type7'];

$oh_type8 = date("Y-m-d", strtotime($_POST['oh_type8']));
$user_oh_type8 = $_POST['user_oh_type8'];


if ($_POST['oh_type2'] != '') {

    $sql = "UPDATE tbl_job_oh 
SET appointment_datetime = " . ($_POST['oh_type2'] != "" ? "'" . $oh_type2 . "'" : "NULL") . ",
user_id = '$user_oh_type2'
WHERE job_id = '$job_id' AND oh_type = 2 ";
    $rs_update = mysqli_query($connect_db, $sql) or die($connect_db->error);
} else {
    $sql = "UPDATE tbl_job_oh
    SET appointment_datetime = null,
    user_id = null
    WHERE job_id = '$job_id' AND oh_type = 2";
    $rs_update = mysqli_query($connect_db, $sql) or die($connect_db->error);
}

if ($_POST['oh_type3'] != '') {

    $sql = "UPDATE tbl_job_oh 
SET appointment_datetime = " . ($_POST['oh_type3'] != "" ? "'" . $oh_type3 . "'" : "NULL") . ",
user_id = '$user_oh_type3'
WHERE job_id = '$job_id' AND oh_type = 3";
    $rs_update = mysqli_query($connect_db, $sql) or die($connect_db->error);
} else {
    $sql = "UPDATE tbl_job_oh 
    SET appointment_datetime = null,
    user_id = null
    WHERE job_id = '$job_id' AND oh_type = 3";
    $rs_update = mysqli_query($connect_db, $sql) or die($connect_db->error);
}

if ($_POST['oh_type4'] != '') {

    $sql = "UPDATE tbl_job_oh 
SET appointment_datetime = " . ($_POST['oh_type4'] != "" ? "'" . $oh_type4 . "'" : "NULL") . ",
user_id = '$user_oh_type4'
WHERE job_id = '$job_id' AND oh_type = 4";
    $rs_update = mysqli_query($connect_db, $sql) or die($connect_db->error);
} else {
    $sql = "UPDATE tbl_job_oh 
    SET appointment_datetime = null,
    user_id = null
    WHERE job_id = '$job_id' AND oh_type = 4";
    $rs_update = mysqli_query($connect_db, $sql) or die($connect_db->error);
}

if ($_POST['oh_type5'] != '') {

    $sql = "UPDATE tbl_job_oh 
SET appointment_datetime = " . ($_POST['oh_type5'] != "" ? "'" . $oh_type5 . "'" : "NULL") . ",
user_id = '$user_oh_type5'
WHERE job_id = '$job_id' AND oh_type = 5";
    $rs_update = mysqli_query($connect_db, $sql) or die($connect_db->error);
} else {
    $sql = "UPDATE tbl_job_oh 
    SET appointment_datetime = null,
    user_id = null
    WHERE job_id = '$job_id' AND oh_type = 5";
    $rs_update = mysqli_query($connect_db, $sql) or die($connect_db->error);
}


if ($_POST['oh_type6'] != '') {

    $sql = "UPDATE tbl_job_oh 
SET appointment_datetime = " . ($_POST['oh_type6'] != "" ? "'" . $oh_type6 . "'" : "NULL") . ",
user_id = '$user_oh_type6'
WHERE job_id = '$job_id' AND oh_type = 6";
    $rs_update = mysqli_query($connect_db, $sql) or die($connect_db->error);
} else {
    $sql = "UPDATE tbl_job_oh 
    SET appointment_datetime = null,
    user_id = null
    WHERE job_id = '$job_id' AND oh_type = 6";
    $rs_update = mysqli_query($connect_db, $sql) or die($connect_db->error);
}


if ($_POST['oh_type7'] != '') {

    $sql = "UPDATE tbl_job_oh 
SET appointment_datetime = " . ($_POST['oh_type7'] != "" ? "'" . $oh_type7 . "'" : "NULL") . ",
user_id = '$user_oh_type7'
WHERE job_id = '$job_id' AND oh_type = 7";
    $rs_update = mysqli_query($connect_db, $sql) or die($connect_db->error);
} else {
    $sql = "UPDATE tbl_job_oh 
    SET appointment_datetime = null,
    user_id = null
    WHERE job_id = '$job_id' AND oh_type = 7";
    $rs_update = mysqli_query($connect_db, $sql) or die($connect_db->error);
}


if ($_POST['oh_type8'] != '') {

    $sql = "UPDATE tbl_job_oh 
SET appointment_datetime = " . ($_POST['oh_type8'] != "" ? "'" . $oh_type8 . "'" : "NULL") . ",
user_id = '$user_oh_type8'
WHERE job_id = '$job_id' AND oh_type = 8";
    $rs_update = mysqli_query($connect_db, $sql) or die($connect_db->error);
} else {
    $sql = "UPDATE tbl_job_oh 
    SET appointment_datetime = null,
    user_id = null
    WHERE job_id = '$job_id' AND oh_type = 8";
    $rs_update = mysqli_query($connect_db, $sql) or die($connect_db->error);
}

if ($rs_update) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

// echo "test";
echo json_encode($arr);

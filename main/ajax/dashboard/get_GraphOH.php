
<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$array_data = array();
$year = $_POST['year'];
$last_year = date('Y', strtotime($year . " - 1 year"));

$sql_job = "SELECT COUNT(*) AS total_job FROM tbl_job WHERE YEAR(appointment_date) = '$year' AND job_type = '3'";
$rs_job = mysqli_query($connect_db, $sql_job) or die($connect_db->error);
$row_job = mysqli_fetch_array($rs_job);

// $sql_job_start = "SELECT COUNT(*) AS total_start FROM tbl_job WHERE YEAR(appointment_date) = '$year' AND job_type = '1'
//     AND open_datetime IS NOT NULL";
// $rs_job_start = mysqli_query($connect_db, $sql_job_start) or die($connect_db->error);
// $row_job_start = mysqli_fetch_array($rs_job_start);

$sql_job_finish = "SELECT COUNT(*) AS total_finish FROM tbl_job WHERE YEAR(appointment_date) = '$year' AND job_type = '3'
    AND finish_service_time IS NOT NULL  AND finish_service_time IS NOT NULL ";
$rs_job_finish = mysqli_query($connect_db, $sql_job_finish) or die($connect_db->error);
$row_job_finish = mysqli_fetch_array($rs_job_finish);
$open_job =  $row_job['total_job']- $row_job_finish['total_finish'];
$temp1 = array(
    "job_type" => 'OPEN',
    "total_job" => $open_job

);
array_push($array_data, $temp1);

// $temp2 = array(
//     "job_type" => 'OPEN',
//     "total_job" => $row_job_start['total_start']

// );

// array_push($array_data, $temp2);

$temp3 = array(
    "job_type" => 'CLOSE',
    "total_job" => $row_job_finish['total_finish']

);
array_push($array_data, $temp3);



echo json_encode($array_data);

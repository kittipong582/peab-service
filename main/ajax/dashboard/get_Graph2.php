
<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$array_data = array();
$year = $_POST['year'];
$last_year = date('Y', strtotime($year . " - 1 year"));

$job_type = array(
    '',
    'CM',
    'PM',
    'IN',
    'OH',
    'OTH'
);

for ($type = 1; $type <= 5; $type++) {

    $sql_job = "SELECT COUNT(*) AS total_job FROM tbl_job WHERE YEAR(appointment_date) = '$year' AND job_type = '$type'";
    $rs_job = mysqli_query($connect_db, $sql_job) or die($connect_db->error);
    $row_job = mysqli_fetch_array($rs_job);

    $temp3 = array(
        "job_type" => $job_type[$type],
        "total_job" => $row_job['total_job']
    );
    array_push($array_data, $temp3);
}


echo json_encode($array_data);

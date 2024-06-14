
<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$array_data = array();
$array_data_last = array();
$year = $_POST['year'];
$last_year = $year-1;

$months = array(
    '',
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July ',
    'August',
    'September',
    'October',
    'November',
    'December',
);

for ($m = 1; $m <= 12; $m++) {

    $sql_job = "SELECT COUNT(*) AS total_job FROM tbl_job WHERE YEAR(appointment_date) = '$year' AND MONTH(appointment_date) = '$m'";
    $rs_job = mysqli_query($connect_db, $sql_job) or die($connect_db->error);
    $row_job = mysqli_fetch_array($rs_job);

    $temp3 = array(
        "month" => $months[$m],
        "total_job" => $row_job['total_job']
    );
    array_push($array_data, $temp3);
}


// var_dump($array_data);

echo json_encode(array($array_data, $array_data_last));

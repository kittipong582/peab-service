<?php
session_start();
include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$create_user_id = $_SESSION['user_id'];
$job_id = $_POST['job_id'];
$income_type_id = $_POST['income_type_id'];
$amount = $_POST['amount'];

$quantity = $_POST['quantity'];
$job_income_id = getRandomID(5, 'tbl_job_income', 'job_income_id');
$i = 1;


$sql_income = "INSERT INTO tbl_job_income
                SET  job_income_id = '$job_income_id'
                    , create_user_id = '$create_user_id'
                    ,job_id = '$job_id'
                    ,income_type_id = '$income_type_id'
                    , income_amount = '$amount'
                    ,quantity = '$quantity'
                ";

$rs_income = mysqli_query($connect_db, $sql_income) or die($connect_db->error);

$sql_spare = "SELECT SUM(unit_price) AS total FROM tbl_job_spare_used WHERE job_id = '$job_id'";
$result_spare  = mysqli_query($connect_db, $sql_spare);
$row_spare = mysqli_fetch_array($result_spare);

$sql_income = "SELECT * FROM tbl_job_income WHERE job_id = '$job_id'";
$result_income  = mysqli_query($connect_db, $sql_income);
while ($row_income = mysqli_fetch_array($result_income)) {

    $income_total += $row_income['quantity'] * $row_income['income_amount'];
}

$service_total = $income_total + $row_spare['total'];


if ($rs_income) {
    $arr['result'] = 1;
    $arr['total_service'] = number_format($service_total) . ' บาท';
} else {
    $arr['result'] = 0;
}
$arr['result'] = 1;
echo json_encode($arr);

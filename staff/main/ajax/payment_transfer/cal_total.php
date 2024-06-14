<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

    $i = 1;
foreach ($_POST['select_status'] as $key => $value) {
    $temp_array_u[$i]['select_status'] = $value;
    $i++;
}


for ($a = 1; $a < $i; $a++) {

    $payment_id = $temp_array_u[$a]['select_status'];

    $sql = "SELECT cash_amount FROM tbl_job_payment_file WHERE payment_id = '$payment_id'";
    $qry = mysqli_query($connect_db, $sql) or die($connect_db->error);
    $rows = mysqli_fetch_assoc($qry);
    $total_amount +=  $rows['cash_amount'];
}

$arr['total_amount'] = $total_amount;
echo json_encode($arr);


<?php

session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$customer_id = $_POST['customer_id'];

$sql_del = "DELETE  FROM tbl_customer_payment WHERE customer_id = '$customer_id'";
$result_del = mysqli_query($connect_db, $sql_del) or die($connect_db->error);

$i = 1;
foreach ($_POST['job_type'] as $key => $value) {
    $temp_array_u[$i]['job_type'] = $value;
    $i++;
}


$i = 1;
foreach ($_POST['spare_cost'] as $key => $value) {
    $temp_array_u[$i]['spare_cost'] = $value;
    $i++;
}

$i = 1;
foreach ($_POST['service_cost'] as $key => $value) {
    $temp_array_u[$i]['service_cost'] = $value;
    $i++;
}


for ($a = 1; $a < $i; $a++) {
    $job_type = $temp_array_u[$a]['job_type'];
    $spare_cost = $temp_array_u[$a]['spare_cost'];
    $service_cost = $temp_array_u[$a]['service_cost'];


    $sql_cus_pay = "INSERT INTO tbl_customer_payment
                SET spare_cost = '$spare_cost'
                ,service_cost = '$service_cost'
                ,customer_id = '$customer_id'
                ,job_type = '$job_type'";
    $rs =  mysqli_query($connect_db, $sql_cus_pay);
}
if ($rs) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}
echo json_encode($arr);

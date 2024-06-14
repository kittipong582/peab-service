<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$overhaul_id = $_POST['overhaul_id'];
$sql = "SELECT * FROM tbl_overhaul WHERE overhaul_id = '$overhaul_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

if ($row['product_type'] == 1) {
    $product_type = 'เครื่องชง';
} else if ($row['product_type'] == 2) {
    $product_type = 'เครื่องบด';
} else if ($row['product_type'] == 3) {
    $product_type = 'เครื่องปั่น';
}

$brand_id = $row['brand_id'];
$sql_brand = "SELECT * FROM tbl_product_brand WHERE brand_id = '$brand_id'";
$result_brand  = mysqli_query($connect_db, $sql_brand);
$row_brand = mysqli_fetch_array($result_brand);

$model_id = $row['model_id'];
$sql_model = "SELECT * FROM tbl_product_model WHERE model_id = '$model_id'";
$result_model  = mysqli_query($connect_db, $sql_model);
$row_model = mysqli_fetch_array($result_model);


if ($row['warranty_start_date'] != null) {
    $warranty_start_date = date("d-m-Y", strtotime($row['warranty_start_date']));
} else {
    $warranty_start_date = "-";
}

if ($row['warranty_expire_date'] == null) {
    $warranty = "-";
} else {

    $now = strtotime("today");
    $expire_date = strtotime($row['warranty_expire_date']);
    $datediff = $expire_date - $now;

    $days_remain = round($datediff / (60 * 60 * 24));
    if ($days_remain < 0) {
        $total_remain = "หมดอายุ " . abs($days_remain) . " วัน";
    } else {
        $total_remain = "เหลือ " . $days_remain . " วัน";
    }
    $warranty = date("d-m-Y", strtotime($row['warranty_expire_date'])) . " ( " . $total_remain . " )";
}



$arr['product_type'] = $product_type;
$arr['serial_no'] = $row['serial_no'];
$arr['brand_name'] = $row_brand['brand_name'];
$arr['model_name'] = $row_model['model_name'];

$arr['warranty_start_date'] = $warranty_start_date;
$arr['warranty_expire_date'] = $warranty;


echo json_encode($arr);

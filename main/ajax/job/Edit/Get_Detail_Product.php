<?php 
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$product_id = $_POST['product_id'];


$sql_product = "SELECT * FROM tbl_product b 
LEFT JOIN tbl_product_brand c ON b.brand_id = c.brand_id
LEFT JOIN tbl_product_model d ON b.model_id = d.model_id
LEFT JOIN tbl_product_type a ON a.type_id = b.product_type
WHERE b.product_id = '$product_id'";
$result_product  = mysqli_query($connect_db, $sql_product);
$row_product = mysqli_fetch_array($result_product);


if ($row_product['warranty_type'] == 1) {
    $warranty_text = 'ซื้อจากบริษัท';
} else  if ($row_product['warranty_type'] == 2) {
    $warranty_text = 'ไม่ได้ซื้อจากบริษัท';
} else if ($row_product['warranty_type'] == 3) {
    $warranty_text = 'สัญญาบริการ';
}

if ($row_product['install_date'] != null) {
    $install = date("d-m-Y", strtotime($row_product['install_date']));
} else {
    $install = "-";
}

if ($row_product['warranty_start_date'] != null) {
    $warranty_start_date = date("d-m-Y", strtotime($row_product['warranty_start_date']));
} else {
    $warranty_start_date = "-";
}

if ($row_product['warranty_expire_date'] == null) {
    $warranty = "-";
} else {

    $now = strtotime("today");
    $expire_date = strtotime($row_product['warranty_expire_date']);
    $datediff = $expire_date - $now;

    $days_remain = round($datediff / (60 * 60 * 24));
    if ($days_remain < 0) {
        $total_remain = "หมดอายุ " . abs($days_remain) . " วัน";
    } else {
        $total_remain = "เหลือ " . $days_remain . " วัน";
    }
    $warranty = date("d-m-Y", strtotime($row_product['warranty_expire_date'])) . " ( " . $total_remain . " )";
}

$arr['product_id'] = $row_product['product_id'];
$arr['serial_no'] = $row_product['serial_no'];
$arr['product_type'] = $row_product['type_code']." - ".$row_product['type_name'];
$arr['brand'] = $row_product['brand_name'];
$arr['model'] = $row_product['model_name'];
$arr['warranty_type'] = $warranty_text;
$arr['install_date'] = $install;
$arr['warranty_start_date'] = $warranty_start_date;
$arr['warranty_expire_date'] = $warranty;

echo json_encode($arr);
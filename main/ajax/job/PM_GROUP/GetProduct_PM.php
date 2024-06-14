<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$product_id = $_POST['product_id'];
$customer_id = $_POST['customer_id'];
$sql = "SELECT * FROM tbl_product a
LEFT JOIN tbl_product_type b ON b.type_id = a.product_type
WHERE a.product_id = '$product_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

$product_type = $row['type_code'] . " - " . $row['type_name'];

$brand_id = $row['brand_id'];
$sql_brand = "SELECT * FROM tbl_product_brand WHERE brand_id = '$brand_id'";
$result_brand  = mysqli_query($connect_db, $sql_brand);
$row_brand = mysqli_fetch_array($result_brand);

$model_id = $row['model_id'];
$sql_model = "SELECT * FROM tbl_product_model WHERE model_id = '$model_id'";
$result_model  = mysqli_query($connect_db, $sql_model);
$row_model = mysqli_fetch_array($result_model);

if ($row['warranty_type'] == 1) {
    $warranty_text = 'ซื้อจากบริษัท';
} else  if ($row['warranty_type'] == 2) {
    $warranty_text = 'ไม่ได้ซื้อจากบริษัท';
} else if ($row['warranty_type'] == 3) {
    $warranty_text = 'สัญญาบริการ';
}


if ($row['install_date'] != null) {
    $install = date("d-m-Y", strtotime($row['install_date']));
} else {
    $install = "-";
}

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



$sql_branch = "SELECT *FROM tbl_customer_branch a
                LEFT JOIN tbl_customer b ON a.customer_id = b.customer_id 
                WHERE a.customer_branch_id = '$customer_id'";
$result_branch = mysqli_query($connect_db, $sql_branch);
$row_branch = mysqli_fetch_array($result_branch);

$branch_care_id = $row_branch['branch_care_id'];
$customer_branch_id = $row_branch['customer_branch_id'];

$sql_branch_1 = "SELECT * FROM tbl_branch WHERE branch_id = '$branch_care_id'";
$result_branch_1 = mysqli_query($connect_db, $sql_branch_1);
$row_branch_1 = mysqli_fetch_array($result_branch_1);

$sql_contact = "SELECT * FROM tbl_customer_contact WHERE customer_branch_id = '$customer_id' and main_contact_status = 1";
$result_contact = mysqli_query($connect_db, $sql_contact);
$row_contact = mysqli_fetch_array($result_contact);




$arr['customer_name'] = $row_branch['customer_name'];
$arr['branch_name'] = $row_branch['branch_name'];
$arr['contact_name'] = $row_contact['contact_name'];
$arr['contact_position'] = $row_contact['contact_position'];
$arr['contact_phone'] = $row_contact['contact_phone'];
$arr['customer_branch_id'] = $customer_branch_id;

///////////////////////////////2.////////////////
$arr['product_id'] = $product_id;
$arr['product_type'] = $product_type;
$arr['serial_no'] = $row['serial_no'];
$arr['brand_name'] = $row_brand['brand_name'];
$arr['model_name'] = $row_model['model_name'];
$arr['warranty_type'] = $warranty_text;
$arr['install_date'] = $install;
$arr['warranty_start_date'] = $warranty_start_date;
$arr['warranty_expire_date'] = $warranty;


/////////////////////////////4.////////////////////

$user_id = $_SESSION['user_id'];
$user_level = $_SESSION['user_level'];
if ($user_level == 1) {

    $sql_level = "SELECT *,a.branch_id AS user_branch FROM tbl_user a 
    LEFT JOIN tbl_branch b ON b.branch_id = a.branch_id
    WHERE a.user_id = '$user_id'";
    $result_level  = mysqli_query($connect_db, $sql_level);
    $row_level = mysqli_fetch_array($result_level);

    $arr['branch_care_id'] = $row_level['user_branch'];
    $arr['branch_care'] = $row_level['branch_name'];
} else {
    $arr['branch_care_id'] = $row_branch['branch_care_id'];
    $arr['branch_care'] = $row_branch_1['branch_name'];
}


///////////////////////1./////////////////////////


echo json_encode($arr);

<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$customer_branch_id = $_POST['customer_branch_id'];
$customer_id = $_POST['customer_id'];
$branch_name = $_POST['branch_name'];
$branch_code = $_POST['branch_code'];
$billing_type = $_POST['billing_type'];
$address = $_POST['address'];

$district_id = $_POST['district_id'];
$district_zipcode = $_POST['district_zipcode'];
$branch_care_id = $_POST['branch_care_id'];
$google_map_link = $_POST['google_map_link'];
$ax_code = $_POST['ax_code'];

$tax_branch_code = $_POST['tax_branch_code'];
$billing_name = $_POST['branch_invoice_name'];
$billing_tax_no = $_POST['branch_tax_no'];
$billing_address = $_POST['branch_invoice_address'];

$sql_check = "SELECT COUNT(branch_name) AS branch_num FROM tbl_customer_branch WHERE branch_name = '$branch_name' AND customer_branch_id != '$customer_branch_id'";
$result_check  = mysqli_query($connect_db, $sql_check);
$row_check = mysqli_fetch_array($result_check);
// echo $sql_check;
if ($row_check['branch_num'] == 0) {

    $sql_insert_brance = "UPDATE tbl_customer_branch
    SET customer_id = '$customer_id'
    ,branch_name = '$branch_name'
    ,branch_code = '$branch_code'
    ,tax_branch_code = '$tax_branch_code'
    ,branch_care_id = '$branch_care_id'
    ,billing_type = '$billing_type'
    ,billing_name = '$billing_name'
    ,billing_tax_no = '$billing_tax_no'
    ,billing_address = '$billing_address'
    ,district_id = '$district_id'
    ,address = '$address'
    ,google_map_link = '$google_map_link'
    ,ax_code = '$ax_code'
    WHERE customer_branch_id = '$customer_branch_id'";



    if (mysqli_query($connect_db, $sql_insert_brance)) {
        $arr['result'] = 1;
        $arr['sql2'] = $sql_insert_brance;
        $arr['customer_id'] = $customer_branch_id;
    } else {
        $arr['result'] = 0;
    }
} else {

    $arr['result'] = 2;
}

$arr['user_id'] = $create_user_id;

echo json_encode($arr);

<?php
session_start();
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$create_user_id = $_SESSION['user_id'];
$customer_id = $_POST['customer_id'];
$branch_name = mysqli_real_escape_string($connect_db, $_POST['branch_name']);
$branch_code = mysqli_real_escape_string($connect_db, $_POST['branch_code']);
$billing_type = mysqli_real_escape_string($connect_db, $_POST['billing_type']);
$address = mysqli_real_escape_string($connect_db, $_POST['address']);

$province_id = mysqli_real_escape_string($connect_db, $_POST['province_id']);
$amphoe_id = mysqli_real_escape_string($connect_db, $_POST['amphoe_id']);
$district_id = mysqli_real_escape_string($connect_db, $_POST['district_id']);
$district_zipcode = mysqli_real_escape_string($connect_db, $_POST['district_zipcode']);
$branch_care_id = mysqli_real_escape_string($connect_db, $_POST['branch_care_id']);
$google_map_link = mysqli_real_escape_string($connect_db, $_POST['google_map_link']);
$ax_code = mysqli_real_escape_string($connect_db, $_POST['ax_code']);

$tax_branch_code = mysqli_real_escape_string($connect_db, $_POST['tax_branch_code']);
$billing_name = mysqli_real_escape_string($connect_db, $_POST['branch_invoice_name']);
$billing_tax_no = mysqli_real_escape_string($connect_db, $_POST['branch_tax_no']);
$billing_address = mysqli_real_escape_string($connect_db, $_POST['branch_invoice_address']);


$customer_branch_id = getRandomID(10, 'tbl_customer_branch', 'customer_branch_id');
$sql_check = "SELECT COUNT(branch_name) AS branch_num FROM tbl_customer_branch WHERE branch_name = '$branch_name'";
$result_check  = mysqli_query($connect_db, $sql_check);
$row_check = mysqli_fetch_array($result_check);
// echo $sql_check;
if ($row_check['branch_num'] == 0) {
    $sql_insert_brance = "INSERT INTO tbl_customer_branch (customer_branch_id, customer_id, active_status, branch_name, branch_code, branch_note, branch_care_id, billing_type, billing_name, billing_branch_name, billing_tax_no, billing_address, district_id, address, google_map_link,tax_branch_code,ax_code) 
    VALUES ('$customer_branch_id', '$customer_id', '1', '$branch_name', '$branch_code', NULL, '$branch_care_id', '$billing_type', '$billing_name', NULL, '$billing_tax_no', '$billing_address', '$district_id', '$address', '$google_map_link','$tax_branch_code','$ax_code')";


    // echo $sql_insert_brance;
    if (mysqli_query($connect_db, $sql_insert_brance)) {

        $sql_insert_contact = "INSERT INTO tbl_customer_contact (contact_id, customer_branch_id, create_datetime, create_user_id, main_contact_status, contact_name, contact_phone, contact_email, contact_line_id, contact_position, active_status) VALUES ";

        $and_insert = "";

        foreach ($_POST['contact_name'] as $key => $value) {

            $contact_name = mysqli_real_escape_string($connect_db, $value);
            $contact_phone = mysqli_real_escape_string($connect_db, $_POST['contact_phone'][$key]);
            $contact_email = mysqli_real_escape_string($connect_db, $_POST['contact_email'][$key]);
            $contact_line_id = mysqli_real_escape_string($connect_db, $_POST['contact_line_id'][$key]);
            $contact_position = mysqli_real_escape_string($connect_db, $_POST['contact_position'][$key]);

            if ($contact_name != "") {
                $sql_insert_contact .= $and_insert . " (NULL, '$customer_branch_id', current_timestamp(), '$create_user_id', '1', '$contact_name', '$contact_phone', '$contact_email', '$contact_line_id', '$contact_position', '1') ";
                $and_insert = " , ";
            }
        }
    }


    $arr['sql2'] = $sql_insert_brance;
    $arr['sql3'] = $sql_insert_contact;

    if (mysqli_query($connect_db, $sql_insert_contact)) {
        $arr['result'] = 1;
        $arr['customer_id'] = $customer_id;
    } else {
        $arr['result'] = 0;
    }
} else {

    $arr['result'] = 2;
}

$arr['user_id'] = $create_user_id;

echo json_encode($arr);

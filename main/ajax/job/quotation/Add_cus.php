<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


// var_dump($_POST);

$job_id = $_POST['job_id'];
$create_user_id = $_SESSION['user_id'];
$customer_id = $_POST['add_customer_id'];
$customer_code = $_POST['add_customer_code'];
$customer_name = $_POST['add_customer_name'];
$customer_type = $_POST['add_customer_type'];
$invoice_name = $_POST['invoice_name'];
$tax_no = $_POST['tax_no'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$invoice_address = $_POST['invoice_address'];
$invoice_address2 = $_POST['invoice_address2'];


$sql = "INSERT INTO tbl_customer
SET customer_id = '$customer_id'
,create_user_id = '$create_user_id'
,customer_code = '$customer_code'
,customer_name = '$customer_name'
,customer_type ='$customer_type'
,invoice_name = '$invoice_name'
,tax_no = '$tax_no'
,email	= '$email'
,phone = '$phone'
,invoice_address = '$invoice_address'
,invoice_address2 = '$invoice_address2'
";
// echo $sql;
if ($result_insert  = mysqli_query($connect_db, $sql)) {



    $customer_branch_id = getRandomID(10, 'tbl_customer_branch', 'customer_branch_id');

    $branch_name = mysqli_real_escape_string($connect_db, $_POST['add_branch_name']);
    $branch_code = mysqli_real_escape_string($connect_db, $_POST['add_branch_code']);
    $billing_type = mysqli_real_escape_string($connect_db, $_POST['billing_type']);
    $address = mysqli_real_escape_string($connect_db, $_POST['address']);
    $address2 = mysqli_real_escape_string($connect_db, $_POST['address2']);
    $district_id = mysqli_real_escape_string($connect_db, $_POST['district_id']);

    $branch_care_id = mysqli_real_escape_string($connect_db, $_POST['branch_care_id']);
    $google_map_link = mysqli_real_escape_string($connect_db, $_POST['google_map_link']);
    $ax_code = mysqli_real_escape_string($connect_db, $_POST['ax_code']);

    $tax_branch_code = mysqli_real_escape_string($connect_db, $_POST['tax_branch_code']);
    $billing_name = mysqli_real_escape_string($connect_db, $_POST['branch_invoice_name']);
    $billing_tax_no = mysqli_real_escape_string($connect_db, $_POST['branch_tax_no']);
    $billing_address = mysqli_real_escape_string($connect_db, $_POST['branch_invoice_address']);
    $billing_address2 = mysqli_real_escape_string($connect_db, $_POST['branch_invoice_address2']);


    $sql_customer = "INSERT INTO tbl_customer_branch
    SET customer_branch_id = '$customer_branch_id'
    ,customer_id = '$customer_id'
    ,branch_name = '$branch_name'
    ,branch_code = '$branch_code'
    ,billing_type = '$billing_type'
    ,address = '$address'
    ,address2 ='$address2'
    ,district_id	= '$district_id'
    ,branch_care_id = '$branch_care_id'
    ,google_map_link = '$google_map_link'
    ,ax_code = '$ax_code'
    ,tax_branch_code = '$tax_branch_code'
    ,billing_name = '$billing_name'
    ,billing_tax_no = '$billing_tax_no'
    ,billing_address = '$billing_address'
    ,billing_address2 = '$billing_address2'
    ";
    if ($result_customer  = mysqli_query($connect_db, $sql_customer)) {


        $contact_name = $_POST['contact_name'];
        $contact_position = $_POST['contact_position'];
        $contact_phone = $_POST['contact_phone'];
        $contact_email = $_POST['contact_email'];
        $contact_line_id = $_POST['contact_line_id'];

        $sql_contact = "INSERT INTO tbl_customer_contact
    SET contact_name = '$contact_name'
    ,customer_branch_id = '$customer_branch_id'
    ,contact_position = '$contact_position'
    ,create_user_id = '$create_user_id'
    ,contact_phone = '$contact_phone'
    ,contact_email = '$contact_email'
    ,contact_line_id ='$contact_line_id'
    ";
        $result_contact  = mysqli_query($connect_db, $sql_contact);
    }




    $sql_job = "UPDATE tbl_job 
    SET customer_branch_id = '$customer_branch_id'
    ,contact_name = '$contact_name'
    ,contact_position = '$contact_position'
    ,contact_phone = '$contact_phone'
    ,care_branch_id = '$branch_care_id'
    WHERE job_id = '$job_id'";
      $result_job  = mysqli_query($connect_db, $sql_job);
    
}



if ($result_job) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

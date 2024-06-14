<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$create_user_id = $_SESSION['user_id'];
$job_id = $_POST['job_id'];

$total_amount = str_replace(',', '', $_POST['all_total']);
$account_id = $_POST['account_id'];
$cash_amount = $_POST['cash_amount'];
$transfer_amount = $_POST['transfer_amount'];
$customer_cost = $_POST['customer_cost'];
$payment_note = $_POST['payment_note'];
$job_id = $_POST['job_id'];
$group_pm_id = $_POST['group_pm_id'];
$ref_type = $_POST['ref_type'];


$m = date('m', strtotime("this month"));
$year = substr(date("Y") + 543, 2);

$sql_count = "SELECT COUNT(bill_no) AS num FROM tbl_job_payment_file";
$result_count  = mysqli_query($connect_db, $sql_count);
$row_count = mysqli_fetch_array($result_count);

if ($row_count != 0) {
    $l = 4;
    $sql_no = "SELECT bill_no FROM tbl_job_payment_file ORDER BY create_datetime DESC LIMIT 1";
    $result_no  = mysqli_query($connect_db, $sql_no);
    $row_no = mysqli_fetch_array($result_no);

    $post_job_no = substr($row_no['bill_no'], -5) + 1;
    $last_job_no = sprintf("%0" . $l . "d", $post_job_no);
} else {
    $l = 5;
    $post_job_no = 1;
    $last_job_no = sprintf("%0" . $l . "d", $post_job_no);
}
// echo $last_job_no;
$bill_no = $year . $m . $last_job_no;


$sql = "INSERT INTO tbl_job_payment_file 
SET total_amount = '$total_amount'
,account_id = '$account_id'
,cash_amount = '$cash_amount'
,transfer_amount = '$transfer_amount'
,customer_cost = '$customer_cost'
,remark = '$payment_note'
,create_user_id = '$create_user_id'
,ref_type = '$ref_type'
,job_id = '$job_id'
,bill_no = '$bill_no'";


$rs_insert = mysqli_query($connect_db, $sql) or die($connect_db->error);
$payment_id = mysqli_insert_id($connect_db);
// echo $sql;


if ($_POST['business_group_id'] != '') {

    $business_group_id = $_POST['business_group_id'];

    $sql_bill = "SELECT tax_no,invoice_name,invoice_address,phone,email FROM tbl_business_group WHERE group_id = '$business_group_id'";
    $result_bill  = mysqli_query($connect_db, $sql_bill);
    $row_bill = mysqli_fetch_array($result_bill);

    $tax_no = $row_bill['tax_no'];
    $invoice_name = $row_bill['invoice_name'];
    $invoice_address = $row_bill['invoice_address'];
    $phone = $row_bill['phone'];
    $email = $row_bill['email'];

    $sql_update = "UPDATE tbl_job_payment_file 
    SET tax_no = '$tax_no',
    invoice_name = '$invoice_name',
    invoice_address = '$invoice_address',
    phone = '$phone',
    email = '$email'
    WHERE payment_id = '$payment_id'";
    mysqli_query($connect_db, $sql_update) or die($connect_db->error);

    // echo $sql_update;
} else {
    $customer_id = $_POST['customer_id'];

    $sql_bill = "SELECT invoice_name,tax_no,invoice_address,phone,email FROM tbl_customer WHERE customer_id = '$customer_id'";
    $result_bill  = mysqli_query($connect_db, $sql_bill);
    $row_bill = mysqli_fetch_array($result_bill);


    $tax_no = $row_bill['tax_no'];
    $invoice_name = $row_bill['invoice_name'];
    $invoice_address = $row_bill['invoice_address'];
    $phone = $row_bill['phone'];
    $email = $row_bill['email'];

    $sql_update = "UPDATE tbl_job_payment_file 
    SET tax_no = '$tax_no',
    invoice_name = '$invoice_name',
    invoice_address = '$invoice_address',
    phone = '$phone',
    email = '$email'
    WHERE payment_id = '$payment_id'";
mysqli_query($connect_db, $sql_update) or die($connect_db->error);
    // echo $sql_update;
}

$files_name  = $_FILES['image1']['name'];
$files_tmp_name  = $_FILES['image1']['tmp_name'];


$i = 0;
foreach ($files_name as $key) {


    $file_1  = explode(".", $key);

    $count1 = count($file_1) - 1;

    $file_surname_1 = $file_1[$count1];
    $files_tmp = $_FILES['image1']['tmp_name'][$i];
    $filename_images_1 = md5(date('mds') . rand(111, 999) . date("hsid") . rand(111, 999)) . "." . $file_surname_1;

    if ($file_surname_1 == 'jpg' || $file_surname_1 == 'jpeg' || $file_surname_1 == 'gif' || $file_surname_1 == 'png' || $file_surname_1 == 'JPG' || $file_surname_1 == 'JPEG' || $file_surname_1 == 'GIF' || $file_surname_1 == 'PNG') {


        if (move_uploaded_file($files_tmp, "../../../upload/payment_img/" . $filename_images_1)) {
            $sql1 = "INSERT INTO tbl_job_payment_img SET img_id = '$filename_images_1'
                    ,payment_id = '$payment_id'
                    ;";

            $rs1 = mysqli_query($connect_db, $sql1) or die($connect_db->error);
        }
    }
    $i++;
}





if ($rs_insert) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}



echo json_encode($arr);

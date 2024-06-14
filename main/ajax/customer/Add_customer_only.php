<?php
session_start();
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$customer_id = mysqli_real_escape_string($connect_db, $_POST['customer_id']);
$customer_name = mysqli_real_escape_string($connect_db, $_POST['customer_name']);
$customer_code = mysqli_real_escape_string($connect_db, $_POST['customer_code']);
$customer_type = mysqli_real_escape_string($connect_db, $_POST['customer_type']);
$invoice_name = mysqli_real_escape_string($connect_db, $_POST['invoice_name']);
$tax_no = mysqli_real_escape_string($connect_db, $_POST['tax_no']);
$email = mysqli_real_escape_string($connect_db, $_POST['email']);
$phone = mysqli_real_escape_string($connect_db, $_POST['phone']);
$invoice_address = mysqli_real_escape_string($connect_db, $_POST['invoice_address']);
$bill_type = mysqli_real_escape_string($connect_db, $_POST['bill_type']);
$customer_group = mysqli_real_escape_string($connect_db, $_POST['customer_group']);


$create_user_id = $_SESSION['user_id'];

$sql_check = "SELECT COUNT(*) as num_chk FROM tbl_customer WHERE customer_name = '$customer_name'";
$result_check = mysqli_query($connect_db, $sql_check);
$row_check = mysqli_fetch_array($result_check);

if ($row_check['num_chk'] == 0) {
    $branch_name = mysqli_real_escape_string($connect_db, $_POST['branch_name']);


    // echo "sdgsdgsd";

    $sql_insert_customer = "INSERT INTO tbl_customer 
        SET customer_id = '$customer_id',
          customer_name = '$customer_name',
           customer_code = '$customer_code',
        customer_type = '$customer_type',
         tax_no = '$tax_no',
          invoice_name = '$invoice_name',
           invoice_address = '$invoice_address',
             email = '$email',
              phone = '$phone',
              bill_type = '$bill_type',
               customer_group = '$customer_group' ";


    $arr['sql_1'] = $sql_insert_customer;

    if (mysqli_query($connect_db, $sql_insert_customer)) {


        if ($bill_type == 2) {
            $business_group = mysqli_real_escape_string($connect_db, $_POST['business_group']);
            $sql_business = "UPDATE tbl_customer 
            SET business_group_id = '$business_group'
            WHERE customer_id = '$customer_id'";
            mysqli_query($connect_db, $sql_business);
        }


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


            $sql_cus_pay = "INSERT into tbl_customer_payment
                SET customer_id = '$customer_id',
                job_type = '$job_type',
                spare_cost = '$spare_cost',
                service_cost = '$service_cost' ";
            mysqli_query($connect_db, $sql_cus_pay);
        }


        $arr['sql2'] = $sql_insert_brance;
        $arr['sql3'] = $sql_insert_contact;

        $arr['result'] = 1;
    } else {
        $arr['result'] = 0;
    }
} else {

    $arr['result'] = 2;
}
$arr['user_id'] = $create_user_id;

echo json_encode($arr);
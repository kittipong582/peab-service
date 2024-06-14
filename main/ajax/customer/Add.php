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

    $sql_check1 = "SELECT COUNT(*) as num_chk1 FROM tbl_customer_branch WHERE branch_name = '$branch_name'";
    $result_check1 = mysqli_query($connect_db, $sql_check1);
    $row_check1 = mysqli_fetch_array($result_check1);


    if ($row_check1['num_chk1'] == 0) {

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

        $branch_name = mysqli_real_escape_string($connect_db, $_POST['branch_name']);
        $branch_code = mysqli_real_escape_string($connect_db, $_POST['branch_code']);
        $billing_type = mysqli_real_escape_string($connect_db, $_POST['billing_type']);
        $address = mysqli_real_escape_string($connect_db, $_POST['address']);
        $address2 = mysqli_real_escape_string($connect_db, $_POST['address2']);
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
        // $billing_address2 = mysqli_real_escape_string($connect_db, $_POST['branch_invoice_address2']);

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




            $customer_branch_id = getRandomID(10, 'tbl_customer_branch', 'customer_branch_id');

            $sql_insert_brance = "INSERT INTO tbl_customer_branch (customer_branch_id, customer_id, active_status, branch_name, branch_code, branch_note, branch_care_id, billing_type, billing_name, billing_branch_name, billing_tax_no, billing_address, district_id, address, google_map_link,tax_branch_code,ax_code) 
            VALUES ('$customer_branch_id', '$customer_id', '1', '$branch_name', '$branch_code', NULL, '$branch_care_id', '$billing_type', '$billing_name', NULL, '$billing_tax_no', '$billing_address', '$district_id', '$address', '$google_map_link','$tax_branch_code','$ax_code')";

            mysqli_query($connect_db, $sql_insert_brance);

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

            mysqli_query($connect_db, $sql_insert_contact);


            $arr['sql2'] = $sql_insert_brance;
            $arr['sql3'] = $sql_insert_contact;

            $arr['result'] = 1;
        } else {
            $arr['result'] = 0;
        }
    } else {

        $arr['result'] = 3;
    }
} else {

    $arr['result'] = 2;
}
$arr['user_id'] = $create_user_id;

echo json_encode($arr);
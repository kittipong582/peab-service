<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

    $customer_id = $_POST['customer_id'];
    $customer_branch_id = $_POST['customer_branch_id'];
    
    $sql_branch = "SELECT *FROM tbl_customer_branch a
                    LEFT JOIN tbl_customer b ON a.customer_id = b.customer_id 
                    WHERE customer_branch_id = '$customer_branch_id'";
    $result_branch = mysqli_query($connect_db, $sql_branch);
    $row_branch = mysqli_fetch_array($result_branch);
    
    $branch_care_id = $row_branch['branch_care_id'];
    
    $sql_branch_1 = "SELECT * FROM tbl_branch WHERE branch_id = '$branch_care_id'";
    $result_branch_1 = mysqli_query($connect_db, $sql_branch_1);
    $row_branch_1 = mysqli_fetch_array($result_branch_1);
    
    $sql_contact = "SELECT * FROM tbl_customer_contact WHERE customer_branch_id = '$customer_branch_id' and main_contact_status = 1";
    $result_contact = mysqli_query($connect_db, $sql_contact);
    $row_contact = mysqli_fetch_array($result_contact);
    
    
    $arr['customer_name'] = $row_branch['customer_name'];
    $arr['branch_name'] = $row_branch['branch_name'];
    $arr['contact_name'] = $row_contact['contact_name'];
    $arr['contact_position'] = $row_contact['contact_position'];
    $arr['contact_phone'] = $row_contact['contact_phone'];
    $arr['customer_branch_id'] = $customer_branch_id;
    
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
    
    echo json_encode($arr);
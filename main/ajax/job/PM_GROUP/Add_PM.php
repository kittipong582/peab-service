<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$user_id = $_POST['user_id'];

$starttime = microtime(true);
//////////////////////////////////////////////////////////



$i = 1;
foreach ($_POST['choose_product_id'] as $key => $value) {
    $temp_array_u[$i]['choose_product_id'] = $value;
    $i++;
}


/////////////////////////////////////////////////

$j = 1;
foreach ($_POST['list_pm_job'] as $key => $value) {
    $temp_array_u[$j]['list_pm_job'] = $value;
    $j++;
}

$j = 1;
foreach ($_POST['appointment_date'] as $key => $value) {
    $temp_array_u[$j]['appointment_date'] = $value;
    $j++;
}

$j = 1;
foreach ($_POST['branch_care_id'] as $key => $value) {
    $temp_array_u[$j]['branch_care_id'] = $value;
    $j++;
}

$j = 1;
foreach ($_POST['responsible_user_id'] as $key => $value) {
    $temp_array_u[$j]['responsible_user_id'] = $value;
    $j++;
}



$j = 1;
foreach ($_POST['PMhours'] as $key => $value) {
    $temp_array_u[$j]['PMhours'] = $value;
    $j++;
}

$j = 1;
foreach ($_POST['PMminutes'] as $key => $value) {
    $temp_array_u[$j]['PMminutes'] = $value;
    $j++;
}

$j = 1;
foreach ($_POST['PMhoure'] as $key => $value) {
    $temp_array_u[$j]['PMhoure'] = $value;
    $j++;
}

$j = 1;
foreach ($_POST['PMminutee'] as $key => $value) {
    $temp_array_u[$j]['PMminutee'] = $value;
    $j++;
}


for ($xx = 1; $xx < $j; $xx++) {

    $sql_count = "SELECT COUNT(job_id) AS num FROM tbl_job";
    $result_count  = mysqli_query($connect_db, $sql_count);
    $row_count = mysqli_fetch_array($result_count);

    if ($row_count['num'] != 0) {
        $sql_form_no = "SELECT (case WHEN (SELECT count(*) as count_this_month FROM tbl_job ) > 0 THEN LPAD((MAX(substring(job_no, -6))+1),6,0) ELSE '000001' end ) as NextCode 
    FROM tbl_job ";
        $rs_form_no = mysqli_query($connect_db, $sql_form_no);
        $row_form_no = mysqli_fetch_array($rs_form_no);
        (int)$last_job_no =  $row_form_no['NextCode'];
    } else {
        $l = 6;
        $post_job_no = 1;
        (int)$last_job_no = sprintf("%0" . $l . "d", $post_job_no);
    }

    $create_user_id = $_SESSION['user_id'];

    // $group_pm_id = $data = mysqli_real_escape_string($connect_db, $_POST['group_pm_id']);
    $group_pm_id = getRandomID(10, 'tbl_group_pm', 'group_pm_id');


    $temp_pm_date = explode('-', $_POST['pm_date']);
    $pm_date = date('Y-m-d', strtotime($temp_pm_date['0'] . "-" . $temp_pm_date['1'] . "-" . $temp_pm_date['2']));

    $sql_group_pm = "INSERT INTO tbl_group_pm
        SET  group_date = '$pm_date'
            ,create_user_id = '$create_user_id'
            ,group_pm_id = '$group_pm_id'
        ";
    $arr['sql_group_pm'] = $sql_group_pm;
    $rs_group_pm = mysqli_query($connect_db, $sql_group_pm);

    for ($a = 1; $a < $i; $a++) {

        $remark = strip_tags($_POST['note']);
        $job_id = getRandomID(10, 'tbl_job', 'job_id');
        $create_user_id = $_SESSION['user_id'];
        $job_type = 2;
        $customer_branch_id = $_POST['customer_branch_id'];
        $contact_name = $_POST['contact_name'];
        $contact_position = $_POST['contact_position'];
        $contact_phone = $_POST['contact_phone'];
        $sub_job_type_id = $_POST['sub_job_type_id'];
        // $product_id = $_POST['choose_product_id'];
        $product_id = $temp_array_u[$a]['choose_product_id'];
        $initial_symptoms = strip_tags($_POST['damaged_report']);
        $ref_job = $_POST['ref_job'];

        $branch_care_id = $temp_array_u[$xx]['branch_care_id'];
        $responsible_user_id = $temp_array_u[$xx]['responsible_user_id'];

        /////////////job_no////////////////
        $pre_job_no = "PM";
        $mid_job_no = substr(date("Y") + 543, 2);
        $job_no = $pre_job_no . $mid_job_no . $last_job_no;

        $con_appoint = "";
        if ($temp_array_u[$xx]['appointment_date'] != "") {
            $appointment_date = date("Y-m-d", strtotime($temp_array_u[$xx]['appointment_date']));
            $con_appoint .= ",appointment_date = '$appointment_date'";
        }
        
        $con_list_pm = "";
        if ($temp_array_u[$xx]['list_pm_job'] != "") {
            $list_pm_job = $temp_array_u[$xx]['list_pm_job'];
            $con_list_pm .= ",list_pm_job = '$list_pm_job'";
        }

        $sql = "INSERT INTO tbl_job
        SET job_id = '$job_id'
        ,job_no = '$job_no'
        ,create_user_id = '$create_user_id'
        ,job_type = '$job_type'
        ,customer_branch_id = '$customer_branch_id'
        ,contact_name ='$contact_name'
        ,contact_position = '$contact_position'
        ,contact_phone = '$contact_phone'
        ,product_id	 ='$product_id'
        ,remark = '$remark'
        $con_appoint
        $con_list_pm
        ,sub_job_type_id = '$sub_job_type_id'";
        $result_insert  = mysqli_query($connect_db, $sql);

        (int)$last_job_no += 1;

        $sql_contact = "SELECT contact_name FROM tbl_customer_contact WHERE contact_name LIKE '%$contact_name%'";
        $result_contact  = mysqli_query($connect_db, $sql_contact);
        $num_contact = mysqli_num_rows($result_contact);

        if ($num_contact == 0) {
            $insert_contact = "INSERT INTO tbl_customer_contact
            SET  customer_branch_id = '$customer_branch_id'
                ,create_user_id = '$create_user_id'
                ,main_contact_status = '0'
                ,contact_name = '$contact_name'
                ,contact_phone = '$contact_phone'
                ,contact_position = '$contact_position'
            ;";

            $rs_contact  = mysqli_query($connect_db, $insert_contact);
        }

        $PMhours = $temp_array_u[$xx]['PMhours'];
        $PMminutes = $temp_array_u[$xx]['PMminutes'];
        $PMhoure = $temp_array_u[$xx]['PMhoure'];
        $PMminutee = $temp_array_u[$xx]['PMminutee'];

        $sql_update = "UPDATE tbl_job 
            SET appointment_date = '$appointment_date'
            WHERE job_id = '$job_id'";
        $result_update  = mysqli_query($connect_db, $sql_update);

        $h = $PMhours;
        $m = $PMminutes;
        $time = $h . $m;
        if ($time != "") {
            $appointment_time_start = date("H:i", strtotime($time));
            $sql_update = "UPDATE tbl_job 
                SET appointment_time_start = '$appointment_time_start'
                WHERE job_id = '$job_id'";
            $result_update  = mysqli_query($connect_db, $sql_update);
        }

        $eh = $PMhoure;
        $em = $PMminutee;
        $time = $eh . $em;

        if ($time != "") {
            $appointment_time_end = date("H:i", strtotime($time));
            $sql_update = "UPDATE tbl_job 
                SET appointment_time_end = '$appointment_time_end' 
                WHERE job_id = '$job_id'";
            $result_update  = mysqli_query($connect_db, $sql_update);
        }

        if ($branch_care_id != "") {
            $sql_update = "UPDATE tbl_job 
                SET care_branch_id	= '$branch_care_id'
                WHERE job_id = '$job_id'";
            $result_update  = mysqli_query($connect_db, $sql_update);
        }

        if ($responsible_user_id != "") {
            $sql_update = "UPDATE tbl_job 
                SET responsible_user_id = '$responsible_user_id'
                WHERE job_id = '$job_id'";
            $result_update  = mysqli_query($connect_db, $sql_update);

            $sql_update_group = "UPDATE tbl_group_pm 
                SET responsible_user_id = '$responsible_user_id'
                WHERE group_pm_id = '$group_pm_id'";
            $result_update_group  = mysqli_query($connect_db, $sql_update_group);
        }

        if ($responsible_user_id != "") {
            $sql_update = "UPDATE tbl_job 
                SET responsible_user_id = '$responsible_user_id'
                WHERE job_id = '$job_id'";
            $result_update  = mysqli_query($connect_db, $sql_update);
        }

        if ($ref_job != "") {
            $sql_ref = "INSERT INTO tbl_job_ref
            SET ref_job_id = '$ref_job'
                ,job_id = '$job_id'";
            $result_ref  = mysqli_query($connect_db, $sql_ref);
            $stamp_date = date("Y-m-d H:i:s", strtotime('NOW'));
            $sql_ref_status = "UPDATE tbl_job 
            SET IN_PM_check = '1'
            ,IN_PM_check_user_id = '$create_user_id'
            ,IN_PM_check_datetime = '$stamp_date'
            WHERE job_id = '$ref_job'";
            $result_ref_status  = mysqli_query($connect_db, $sql_ref_status);
        }

        $count = 1;
        foreach ($_POST['job_service_tab_' . $a] as $key => $value) {
            $temp_array_u[$count]['job_service_tab_' . $a] = $value;
            $count++;
        }

        $count = 1;
        foreach ($_POST['quantity_tab_' . $a] as $key => $value) {
            $temp_array_u[$count]['quantity'] = $value;
            $count++;
        }

        $count = 1;
        foreach ($_POST['unit_price_tab_' . $a] as $key => $value) {
            $temp_array_u[$count]['unit_price'] = $value;
            $count++;
        }

        $count = 1;
        foreach ($_POST['unit_cost_tab_' . $a] as $key => $value) {
            $temp_array_u[$count]['unit_cost'] = $value;
            $count++;
        }

        $list_order = 1;
        for ($b = 1; $b < $count; $b++) {
            $quantity = $temp_array_u[$b]['quantity'];
            $unit_price = $temp_array_u[$b]['unit_price'];
            $unit_cost = $temp_array_u[$b]['unit_cost'];
            $job_service = $temp_array_u[$b]['job_service'];
            $sql_service = "INSERT INTO tbl_job_open_oth_service
                        SET  job_id = '$job_id'
                            , service_id = '$job_service'
                            , list_order = '$list_order'
                            ,quantity = '$quantity'
                            ,unit_cost = '$unit_cost'
                            ,unit_price = '$unit_price'
                        ";
            $rs_service = mysqli_query($connect_db, $sql_service);
            $list_order++;
        }

        $x = 1;
        foreach ($_POST['staff'] as $key => $value) {
            $temp_array_u[$x]['staff'] = $value;
            $x++;
        }

        for ($b = 1; $b < $x; $b++) {
            $staff = $temp_array_u[$b]['staff'];
            if ($staff != "") {
                $sql_staff = "INSERT INTO tbl_job_staff
                    SET job_id = '$job_id'
                        ,staff_id = '$staff'
                    ";
                $rs_staff = mysqli_query($connect_db, $sql_staff);
            }
        }

        $sql_detail = "INSERT INTO tbl_group_pm_detail
        SET  job_id = '$job_id'
            ,group_pm_id = '$group_pm_id'
        ";
        $rs_detail = mysqli_query($connect_db, $sql_detail);


        $sql_line = "SELECT * FROM tbl_user WHERE user_id = '$responsible_user_id';";
        $rs_line  = mysqli_query($connect_db, $sql_line);
        $row_line = mysqli_fetch_array($rs_line);


        if ($row_line['line_active'] == "1") {

            $sql_job = "SELECT a.*,b.branch_name FROM tbl_job a 
            JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id 
            WHERE a.job_id = '$job_id';";
            $rs_job  = mysqli_query($connect_db, $sql_job);
            $row_job = mysqli_fetch_array($rs_job);

            $aate = date('d/m/Y', strtotime('+543 Years', strtotime($row_job['appointment_date'])));
            $appointment_date = $row_job['appointment_time_start'] . " ถึง " . $row_job['appointment_time_end'];

            $job_type = "";
            if ($row_job['job_type'] == 1) {
                $job_type = "CM";
            } else if ($row_job['job_type'] == 2) {
                $job_type = "PM";
            } else if ($row_job['job_type'] == 3) {
                $job_type = "Installation";
            } else if ($row_job['job_type'] == 4) {
            } else if ($row_job['job_type'] == 5) {

                $job_type = "Other";
            } else if ($row_job['job_type'] == 6) {

                $job_type = "Quotation";
            }

            $line_token = $row_line['line_token'];
            // $token = "koNpmxIz0Hl0DgA2oDB4oIDtRYR2NnOSbsb8slrO3AU";
            $msgLineNotify =
                "\r\n" . "แจ้งเตือนงาน " . "\r\n"
                . "เลขที่" . " : " . " " . $job_no . "\r\n"
                . "ชื่อร้าน" . " : " . $row_job['branch_name'] . "\r\n"
                . "วันที่" . " : " . $aate . "\r\n"
                . "เวลา" . " : " . $appointment_date . "\r\n"
                . "ประเภทงาน" . " : " . $job_type . "\r\n"
                . "ผู้ติดต่อ" . " : " . $row_job['contact_name'] . " [" . $row_job['contact_phone'] . "]" . "\r\n";

            $StrokeAlert = "$line_token";

            $chOne = curl_init();
            curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
            curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($chOne, CURLOPT_POST, 1);
            curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $msgLineNotify);
            $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $line_token . '',);
            curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($chOne);

            //Result error 
            if (curl_error($chOne)) {
                echo 'error:' . curl_error($chOne);
            } else {

                $result_ = json_decode($result, true);
            }
            curl_close($chOne);
            ////////////////////////////////////////////////////////////////////////////
            // $arr['result'] = 1;
        }

        if ($a > 10) {
            exit;
        }
    }
    if ($xx > 10) {
        exit;
    }
}

//////////////////////////////////////////////////////////

// $i = 1;
// foreach ($_POST['list_pm_job'] as $key => $value) {
//     $temp_array_u[$i]['list_pm_job'] = $value;
//     $i++;
// }

// $i = 1;
// foreach ($_POST['appointment_date'] as $key => $value) {
//     $temp_array_u[$i]['appointment_date'] = $value;
//     $i++;
// }

// $i = 1;
// foreach ($_POST['branch_care_id'] as $key => $value) {
//     $temp_array_u[$i]['branch_care_id'] = $value;
//     $i++;
// }

// $i = 1;
// foreach ($_POST['responsible_user_id'] as $key => $value) {
//     $temp_array_u[$i]['responsible_user_id'] = $value;
//     $i++;
// }

// $i = 1;
// foreach ($_POST['PMhours'] as $key => $value) {
//     $temp_array_u[$i]['PMhours'] = $value;
//     $i++;
// }

// $i = 1;
// foreach ($_POST['PMminutes'] as $key => $value) {
//     $temp_array_u[$i]['PMminutes'] = $value;
//     $i++;
// }

// $i = 1;
// foreach ($_POST['PMhoure'] as $key => $value) {
//     $temp_array_u[$i]['PMhoure'] = $value;
//     $i++;
// }

// $i = 1;
// foreach ($_POST['PMminutee'] as $key => $value) {
//     $temp_array_u[$i]['PMminutee'] = $value;
//     $i++;
// }

// $i = 1;
// foreach ($_POST['choose_product_id'] as $key => $value) {
//     $temp_array_u[$i]['choose_product_id'] = $value;
//     $i++;
// }


// $sql_count = "SELECT COUNT(job_id) AS num FROM tbl_job";
// $result_count  = mysqli_query($connect_db, $sql_count);
// $row_count = mysqli_fetch_array($result_count);

// if ($row_count['num'] != 0) {
//     $sql_form_no = "SELECT (case WHEN (SELECT count(*) as count_this_month FROM tbl_job ) > 0 THEN LPAD((MAX(substring(job_no, -6))+1),6,0) ELSE '000001' end ) as NextCode 
//     FROM tbl_job ";
//     $rs_form_no = mysqli_query($connect_db, $sql_form_no);
//     $row_form_no = mysqli_fetch_array($rs_form_no);
//     (int)$last_job_no =  $row_form_no['NextCode'];
// } else {
//     $l = 6;
//     $post_job_no = 1;
//     (int)$last_job_no = sprintf("%0" . $l . "d", $post_job_no);
// }

// $create_user_id = $_SESSION['user_id'];

// $group_pm_id = $data = mysqli_real_escape_string($connect_db, $_POST['group_pm_id']);

// $temp_pm_date = explode('-', $_POST['pm_date']);
// $pm_date = date('Y-m-d', strtotime($temp_pm_date['0'] . "-" . $temp_pm_date['1'] . "-" . $temp_pm_date['2']));

// $sql_group_pm = "INSERT INTO tbl_group_pm
// SET  group_date = '$pm_date'
//     ,create_user_id = '$create_user_id'
//     ,group_pm_id = '$group_pm_id'
// ";

// $rs_group_pm = mysqli_query($connect_db, $sql_group_pm);

// for ($a = 1; $a < $i; $a++) {

//     $remark = strip_tags($_POST['note']);
//     $job_id = getRandomID(10, 'tbl_job', 'job_id');
//     $create_user_id = $_SESSION['user_id'];
//     $job_type = 2;
//     $customer_branch_id = $_POST['customer_branch_id'];
//     $contact_name = $_POST['contact_name'];
//     $contact_position = $_POST['contact_position'];
//     $contact_phone = $_POST['contact_phone'];
//     $sub_job_type_id = $_POST['sub_job_type_id'];
//     // $product_id = $_POST['choose_product_id'];
//     $product_id = $temp_array_u[$a]['choose_product_id'];
//     $initial_symptoms = strip_tags($_POST['damaged_report']);
//     $ref_job = $_POST['ref_job'];

//     /////////////job_no////////////////
//     $pre_job_no = "PM";
//     $mid_job_no = substr(date("Y") + 543, 2);
//     $job_no = $pre_job_no . $mid_job_no . $last_job_no;

//     $con_appoint = "";
//     if ($temp_array_u[1]['appointment_date'] != "") {
//         $appointment_date = date("Y-m-d", strtotime($temp_array_u[1]['appointment_date']));
//         $con_appoint .= ",appointment_date = '$appointment_date'";
//     }

//     if ($temp_array_u[1]['list_pm_job'] != "") {
//         $list_pm_job = $temp_array_u[1]['list_pm_job'];
//         $con_appoint .= ",list_pm_job = '$list_pm_job'";
//     }

//     $sql = "INSERT INTO tbl_job
//     SET job_id = '$job_id'
//     ,job_no = '$job_no'
//     ,create_user_id = '$create_user_id'
//     ,job_type = '$job_type'
//     ,customer_branch_id = '$customer_branch_id'
//     ,contact_name ='$contact_name'
//     ,contact_position = '$contact_position'
//     ,contact_phone = '$contact_phone'
//     ,product_id	 ='$product_id'
//     ,remark = '$remark'
//     $con_appoint
//     ,sub_job_type_id = '$sub_job_type_id'";
//     $result_insert  = mysqli_query($connect_db, $sql);

//     (int)$last_job_no += 1;

//     $sql_contact = "SELECT contact_name FROM tbl_customer_contact WHERE contact_name LIKE '%$contact_name%'";
//     $result_contact  = mysqli_query($connect_db, $sql_contact);
//     $num_contact = mysqli_num_rows($result_contact);

//     if ($num_contact == 0) {
//         $insert_contact = "INSERT INTO tbl_customer_contact
//         SET  customer_branch_id = '$customer_branch_id'
//             ,create_user_id = '$create_user_id'
//             ,main_contact_status = '0'
//             ,contact_name = '$contact_name'
//             ,contact_phone = '$contact_phone'
//             ,contact_position = '$contact_position'
//         ;";

//         $rs_contact  = mysqli_query($connect_db, $insert_contact);
//     }

//     $branch_care_id = $temp_array_u[1]['branch_care_id'];
//     $responsible_user_id = $temp_array_u[1]['responsible_user_id'];

//     $PMhours = $temp_array_u[$a]['PMhours'];
//     $PMminutes = $temp_array_u[$a]['PMminutes'];
//     $PMhoure = $temp_array_u[$a]['PMhoure'];
//     $PMminutee = $temp_array_u[$a]['PMminutee'];

//     $sql_update = "UPDATE tbl_job 
//         SET appointment_date = '$appointment_date'
//         WHERE job_id = '$job_id'";
//     $result_update  = mysqli_query($connect_db, $sql_update);

//     $h = $PMhours;
//     $m = $PMminutes;
//     $time = $h . $m;
//     if ($time != "") {
//         $appointment_time_start = date("H:i", strtotime($time));
//         $sql_update = "UPDATE tbl_job 
//             SET appointment_time_start = '$appointment_time_start'
//             WHERE job_id = '$job_id'";
//         $result_update  = mysqli_query($connect_db, $sql_update);
//     }

//     $eh = $PMhoure;
//     $em = $PMminutee;
//     $time = $eh . $em;
//     if ($time != "") {
//         $appointment_time_end = date("H:i", strtotime($time));
//         $sql_update = "UPDATE tbl_job 
//             SET appointment_time_end = '$appointment_time_end' 
//             WHERE job_id = '$job_id'";
//         $result_update  = mysqli_query($connect_db, $sql_update);
//     }

//     if ($branch_care_id != "") {
//         $sql_update = "UPDATE tbl_job 
//             SET care_branch_id	= '$branch_care_id'
//             WHERE job_id = '$job_id'";
//         $result_update  = mysqli_query($connect_db, $sql_update);
//     }

//     if ($responsible_user_id != "") {
//         $sql_update = "UPDATE tbl_job 
//             SET responsible_user_id = '$responsible_user_id'
//             WHERE job_id = '$job_id'";
//         $result_update  = mysqli_query($connect_db, $sql_update);

//         $sql_update_group = "UPDATE tbl_group_pm 
//             SET responsible_user_id = '$responsible_user_id'
//             WHERE group_pm_id = '$group_pm_id'";
//         $result_update_group  = mysqli_query($connect_db, $sql_update_group);
//     }

//     if ($responsible_user_id != "") {
//         $sql_update = "UPDATE tbl_job 
//             SET responsible_user_id = '$responsible_user_id'
//             WHERE job_id = '$job_id'";
//         $result_update  = mysqli_query($connect_db, $sql_update);
//     }

//     if ($ref_job != "") {
//         $sql_ref = "INSERT INTO tbl_job_ref
//         SET ref_job_id = '$ref_job'
//             ,job_id = '$job_id'";
//         $result_ref  = mysqli_query($connect_db, $sql_ref);

//         $stamp_date = date("Y-m-d H:i:s", strtotime('NOW'));

//         $sql_ref_status = "UPDATE tbl_job 
//         SET IN_PM_check = '1'
//         ,IN_PM_check_user_id = '$create_user_id'
//         ,IN_PM_check_datetime = '$stamp_date'
//         WHERE job_id = '$ref_job'";
//         $result_ref_status  = mysqli_query($connect_db, $sql_ref_status);
//     }

//     $count = 1;
//     foreach ($_POST['job_service_tab_' . $a] as $key => $value) {
//         $temp_array_u[$count]['job_service_tab_' . $a] = $value;
//         $count++;
//     }

//     $count = 1;
//     foreach ($_POST['quantity_tab_' . $a] as $key => $value) {
//         $temp_array_u[$count]['quantity'] = $value;
//         $count++;
//     }

//     $count = 1;
//     foreach ($_POST['unit_price_tab_' . $a] as $key => $value) {
//         $temp_array_u[$count]['unit_price'] = $value;
//         $count++;
//     }

//     $count = 1;
//     foreach ($_POST['unit_cost_tab_' . $a] as $key => $value) {
//         $temp_array_u[$count]['unit_cost'] = $value;
//         $count++;
//     }

//     $list_order = 1;
//     for ($b = 1; $b < $count; $b++) {

//         $quantity = $temp_array_u[$b]['quantity'];
//         $unit_price = $temp_array_u[$b]['unit_price'];
//         $unit_cost = $temp_array_u[$b]['unit_cost'];
//         $job_service = $temp_array_u[$b]['job_service'];

//         $sql_service = "INSERT INTO tbl_job_open_oth_service
//                     SET  job_id = '$job_id'
//                         , service_id = '$job_service'
//                         , list_order = '$list_order'
//                         ,quantity = '$quantity'
//                         ,unit_cost = '$unit_cost'
//                         ,unit_price = '$unit_price'
//                     ";

//         $rs_service = mysqli_query($connect_db, $sql_service);
//         $list_order++;
//     }


//     $x = 1;
//     foreach ($_POST['staff'] as $key => $value) {
//         $temp_array_u[$x]['staff'] = $value;
//         $x++;
//     }

//     for ($b = 1; $b < $x; $b++) {
//         $staff = $temp_array_u[$b]['staff'];
//         if ($staff != "") {
//             $sql_staff = "INSERT INTO tbl_job_staff
//                 SET job_id = '$job_id'
//                     ,staff_id = '$staff'
//                 ";
//             $rs_staff = mysqli_query($connect_db, $sql_staff);
//         }
//     }

//     $sql_detail = "INSERT INTO tbl_group_pm_detail
//     SET  job_id = '$job_id'
//         ,group_pm_id = '$group_pm_id'
//     ";
//     $rs_detail = mysqli_query($connect_db, $sql_detail);

//     //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//     $sql_line = "SELECT * FROM tbl_user WHERE user_id = '$responsible_user_id';";
//     $rs_line  = mysqli_query($connect_db, $sql_line);
//     $row_line = mysqli_fetch_array($rs_line);

//     // echo $row_line['line_active'] . "<br/>";
//     // echo $row_line['line_token'] . "<br/>";

//     //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//     if ($row_line['line_active'] == "1") {

//         $sql_job = "SELECT a.*,b.branch_name FROM tbl_job a 
//     JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id 
//     WHERE a.job_id = '$job_id';";
//         // echo $sql_job. "<br/>";
//         $rs_job  = mysqli_query($connect_db, $sql_job);
//         $row_job = mysqli_fetch_array($rs_job);

//         $aate = date('d/m/Y', strtotime('+543 Years', strtotime($row_job['appointment_date'])));
//         $appointment_date = $row_job['appointment_time_start'] . " ถึง " . $row_job['appointment_time_end'];

//         $job_type = "";
//         if ($row_job['job_type'] == 1) {
//             $job_type = "CM";
//         } else if ($row_job['job_type'] == 2) {
//             $job_type = "PM";
//         } else if ($row_job['job_type'] == 3) {
//             $job_type = "Installation";
//         } else if ($row_job['job_type'] == 4) {
//         } else if ($row_job['job_type'] == 5) {

//             $job_type = "Other";
//         } else if ($row_job['job_type'] == 6) {

//             $job_type = "Quotation";
//         }

//         $line_token = $row_line['line_token'];
//         // $token = "koNpmxIz0Hl0DgA2oDB4oIDtRYR2NnOSbsb8slrO3AU";
//         $msgLineNotify =
//             "\r\n" . "แจ้งเตือนงาน " . "\r\n"
//             . "เลขที่" . " : " . " " . $job_no . "\r\n"
//             . "ชื่อร้าน" . " : " . $row_job['branch_name'] . "\r\n"
//             . "วันที่" . " : " . $aate . "\r\n"
//             . "เวลา" . " : " . $appointment_date . "\r\n"
//             . "ประเภทงาน" . " : " . $job_type . "\r\n"
//             . "ผู้ติดต่อ" . " : " . $row_job['contact_name'] . " [" . $row_job['contact_phone'] . "]" . "\r\n";

//         $StrokeAlert = "$line_token";

//         $chOne = curl_init();
//         curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
//         curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
//         curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
//         curl_setopt($chOne, CURLOPT_POST, 1);
//         curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $msgLineNotify);
//         $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $line_token . '',);
//         curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
//         curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
//         $result = curl_exec($chOne);

//         //Result error 
//         if (curl_error($chOne)) {
//             echo 'error:' . curl_error($chOne);
//         } else {

//             $result_ = json_decode($result, true);
//         }
//         curl_close($chOne);
//         ////////////////////////////////////////////////////////////////////////////
//         // $arr['result'] = 1;
//     }
// }

if ($result_insert) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}


echo json_encode($arr);

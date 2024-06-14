<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$close_user_id = $_SESSION['user_id'];
$close_datetime = date("Y-m-d H:i", strtotime("NOW"));
$job_id = $_POST['job_id'];
$distance_date = $_POST['distance_date'];
$create_user_id = $_SESSION['user_id'];
$sql_chk = "SELECT * FROM tbl_group_pm_detail a
LEFT JOIN tbl_group_pm b ON b.group_pm_id = a.group_pm_id
WHERE b.group_pm_id IN(SELECT group_pm_id FROM tbl_group_pm_detail WHERE job_id = '$job_id')";
$rs_chk = mysqli_query($connect_db, $sql_chk);
$num_chk = mysqli_num_rows($rs_chk);


if ($num_chk == 0) {

    $i = 1;
    foreach ($_POST['appointment_date'] as $key => $value) {
        $temp_array_u[$i]['appointment_date'] = $value;
        $i++;
    }

    $i = 1;
    foreach ($_POST['branch_care_id'] as $key => $value) {
        $temp_array_u[$i]['branch_care_id'] = $value;
        $i++;
    }

    $i = 1;
    foreach ($_POST['responsible_user_id'] as $key => $value) {
        $temp_array_u[$i]['responsible_user_id'] = $value;
        $i++;
    }

    $i = 1;
    foreach ($_POST['PMhours'] as $key => $value) {
        $temp_array_u[$i]['PMhours'] = $value;
        $i++;
    }

    $i = 1;
    foreach ($_POST['PMminutes'] as $key => $value) {
        $temp_array_u[$i]['PMminutes'] = $value;
        $i++;
    }

    $i = 1;
    foreach ($_POST['PMhoure'] as $key => $value) {
        $temp_array_u[$i]['PMhoure'] = $value;
        $i++;
    }

    $i = 1;
    foreach ($_POST['PMminutee'] as $key => $value) {
        $temp_array_u[$i]['PMminutee'] = $value;
        $i++;
    }

    $sql_close = "UPDATE tbl_job 
    SET close_user_id = '$close_user_id'
        ,close_datetime	= '$close_datetime'
        WHERE job_id = '$job_id'";

    mysqli_query($connect_db, $sql_close);


    $sql_job = "SELECT * FROM tbl_job WHERE job_id = '$job_id'";
    $rs_job = mysqli_query($connect_db, $sql_job);
    $row_job = mysqli_fetch_assoc($rs_job);

    for ($a = 1; $a < $i; $a++) {


        $remark = strip_tags($row_job['note']);
        $job_id = getRandomID(10, 'tbl_job', 'job_id');

        $job_type = $row_job['job_type'];
        $customer_branch_id = $row_job['customer_branch_id'];
        $contact_name = $row_job['contact_name'];
        $contact_position = $row_job['contact_position'];
        $contact_phone = $row_job['contact_phone'];
        $sub_job_type_id = $row_job['sub_job_type_id'];
        $product_id = $row_job['product_id'];
        $initial_symptoms = strip_tags($row_job['damaged_report']);
        $ref_job = $row_job['ref_job'];

        /////////////job_no////////////////
        $pre_job_no = "PM";
        $mid_job_no = substr(date("Y") + 543, 2);

        $sql_count = "SELECT COUNT(job_id) AS num FROM tbl_job";
        $result_count = mysqli_query($connect_db, $sql_count);
        $row_count = mysqli_fetch_array($result_count);


        if ($row_count['num'] != 0) {

            $sql_form_no = "SELECT (case WHEN (SELECT count(*) as count_this_month FROM tbl_job ) > 0 THEN LPAD((MAX(substring(job_no, -6))+1),6,0) ELSE '000001' end ) as NextCode 
        FROM tbl_job ";
            $rs_form_no = mysqli_query($connect_db, $sql_form_no);
            $row_form_no = mysqli_fetch_array($rs_form_no);

            $last_job_no = $row_form_no['NextCode'];
        } else {
            $l = 6;
            $post_job_no = 1;
            $last_job_no = sprintf("%0" . $l . "d", $post_job_no);
        }

        $job_no = $pre_job_no . $mid_job_no . $last_job_no;


        if ($temp_array_u[$a]['appointment_date'] != "") {

            $appointment_date = date("Y-m-d", strtotime($temp_array_u[$a]['appointment_date']));

            $con_appoint = ",appointment_date = '$appointment_date'";
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
    ,next_pm_period = '$distance_date'
    $con_appoint
    ,sub_job_type_id = '$sub_job_type_id'";

        $result_insert = mysqli_query($connect_db, $sql);

        $branch_care_id = $temp_array_u[$a]['branch_care_id'];
        $responsible_user_id = $temp_array_u[$a]['responsible_user_id'];
        $PMhours = $temp_array_u[$a]['PMhours'];
        $PMminutes = $temp_array_u[$a]['PMminutes'];
        $PMhoure = $temp_array_u[$a]['PMhoure'];
        $PMminutee = $temp_array_u[$a]['PMminutee'];

        $h = $PMhours;
        $m = $PMminutes;
        $time = $h . $m;
        if ($time != "") {
            $appointment_time_start = date("H:i", strtotime($time));

            $conupdate .= ",appointment_time_start = '$appointment_time_start'";
        }

        $eh = $PMhoure;
        $em = $PMminutee;
        $time = $eh . $em;

        if ($time != "") {
            $appointment_time_end = date("H:i", strtotime($time));

            $conupdate .= ",appointment_time_end = '$appointment_time_end'";

        }

        if ($branch_care_id != "") {
            $conupdate .= ",care_branch_id	= '$branch_care_id'";
        }


        if ($responsible_user_id != "") {
            $conupdate .= ",responsible_user_id = '$responsible_user_id'";

        }


        $sql_update = "UPDATE tbl_job 
        SET     appointment_date = '$appointment_date'
        $conupdate
        WHERE job_id = '$job_id1'";
        $result_update = mysqli_query($connect_db, $sql_update);



        if ($ref_job != "") {
            $sql_ref = "INSERT INTO tbl_job_ref
        SET    ref_job_id = '$ref_job',
                 job_id = '$job_id1'";
            $result_ref = mysqli_query($connect_db, $sql_ref);

            $stamp_date = date("Y-m-d H:i:s", strtotime('NOW'));

            $sql_ref_status = "UPDATE tbl_job 
        SET IN_PM_check = '1'
        ,IN_PM_check_user_id = '$create_user_id'
        ,IN_PM_check_datetime = '$stamp_date'
        WHERE job_id = '$ref_job'";
            $result_ref_status = mysqli_query($connect_db, $sql_ref_status);
        }



        $sql_job_open_oth = "SELECT * FROM tbl_job_open_oth_service WHERE job_id = '$job_id'";
        $rs_job_open_oth = mysqli_query($connect_db, $sql_job_open_oth);

        $list_order = 1;
        while ($row_job_open_oth = mysqli_fetch_assoc($rs_job_open_oth)) {

            $quantity = $row_job_open_oth['quantity'];
            $unit_price = $row_job_open_oth['unit_price'];
            $unit_cost = $row_job_open_oth['unit_cost'];
            $job_service = $row_job_open_oth['service_id'];


            $sql_service = "INSERT INTO tbl_job_open_oth_service
                    SET  job_id = '$job_id1job_id1'
                        , service_id = '$job_service'
                        , list_order = '$list_order'
                        ,quantity = '$quantity'
                        ,unit_cost = '$unit_cost'
                        ,unit_price = '$unit_price'
                    ";

            $rs_service = mysqli_query($connect_db, $sql_service);
            $list_order++;
        }


        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $sql_line = "SELECT * FROM tbl_user WHERE user_id = '$responsible_user_id';";
        // echo $sql_line . "<br/>";
        $rs_line = mysqli_query($connect_db, $sql_line);
        $row_line = mysqli_fetch_array($rs_line);

        // echo $row_line['line_active'] . "<br/>";
        // echo $row_line['line_token'] . "<br/>";


        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // if ($row_line['line_active'] == "1") {

        //     $sql_job = "SELECT a.*,b.branch_name FROM tbl_job a 
        // JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id 
        // WHERE a.job_id = '$job_id';";
        //     // echo $sql_job. "<br/>";
        //     $rs_job = mysqli_query($connect_db, $sql_job);
        //     $row_job = mysqli_fetch_array($rs_job);

        //     $date = date('d/m/Y', strtotime('+543 Years', strtotime($row_job['appointment_date'])));
        //     $appointment_date = $row_job['appointment_time_start'] . " ถึง " . $row_job['appointment_time_end'];

        //     $job_type = "";
        //     if ($row_job['job_type'] == 1) {
        //         $job_type = "CM";
        //     } else if ($row_job['job_type'] == 2) {
        //         $job_type = "PM";
        //     } else if ($row_job['job_type'] == 3) {
        //         $job_type = "Installation";
        //     } else if ($row_job['job_type'] == 4) {

        //     } else if ($row_job['job_type'] == 5) {

        //         $job_type = "Other";

        //     } else if ($row_job['job_type'] == 6) {

        //         $job_type = "Quotation";

        //     }

        //     $line_token = $row_line['line_token'];
        //     // $token = "koNpmxIz0Hl0DgA2oDB4oIDtRYR2NnOSbsb8slrO3AU";
        //     $msgLineNotify =
        //         "\r\n" . "แจ้งเตือนงาน " . "\r\n"
        //         . "เลขที่" . " : " . " " . $job_no . "\r\n"
        //         . "ชื่อร้าน" . " : " . $row_job['branch_name'] . "\r\n"
        //         . "วันที่" . " : " . $date . "\r\n"
        //         . "เวลา" . " : " . $appointment_date . "\r\n"
        //         . "ประเภทงาน" . " : " . $job_type . "\r\n"
        //         . "ผู้ติดต่อ" . " : " . $row_job['contact_name'] . " [" . $row_job['contact_phone'] . "]" . "\r\n";


        //     $StrokeAlert = "$line_token";


        //     $chOne = curl_init();
        //     curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
        //     curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
        //     curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
        //     curl_setopt($chOne, CURLOPT_POST, 1);
        //     curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $msgLineNotify);
        //     $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $line_token . '', );
        //     curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
        //     curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
        //     $result = curl_exec($chOne);

        //     //Result error 
        //     if (curl_error($chOne)) {
        //         echo 'error:' . curl_error($chOne);
        //     } else {

        //         $result_ = json_decode($result, true);
        //     }
        //     curl_close($chOne);
        //     ////////////////////////////////////////////////////////////////////////////

        //     // $arr['result'] = 1;

        // }
    }


    if ($result_insert) {
        $arr['result'] = 1;
    } else {
        $arr['result'] = 0;
    }

} else {



    $job_select = array();
    while ($row_chk = mysqli_fetch_assoc($rs_chk)) {

        $job_id = $row_chk['job_id'];


        $sql_close = "UPDATE tbl_job 
    SET close_user_id = '$close_user_id'
        ,close_datetime	= '$close_datetime'
        WHERE job_id = '$job_id'";

        if (mysqli_query($connect_db, $sql_close)) {


            $sql_close = "UPDATE tbl_group_pm 
    SET close_user_id = '$close_user_id'
        ,close_datetime	= '$close_datetime'
        WHERE group_pm_id = '{$row_chk['group_pm_id']}'";
            mysqli_query($connect_db, $sql_close);
        }

        array_push($job_select, $job_id);
    }

    $i = 1;
    foreach ($_POST['appointment_date'] as $key => $value) {
        $temp_array_u[$i]['appointment_date'] = $value;
        $i++;
    }

    $i = 1;
    foreach ($_POST['branch_care_id'] as $key => $value) {
        $temp_array_u[$i]['branch_care_id'] = $value;
        $i++;
    }

    $i = 1;
    foreach ($_POST['responsible_user_id'] as $key => $value) {
        $temp_array_u[$i]['responsible_user_id'] = $value;
        $i++;
    }

    $i = 1;
    foreach ($_POST['PMhours'] as $key => $value) {
        $temp_array_u[$i]['PMhours'] = $value;
        $i++;
    }

    $i = 1;
    foreach ($_POST['PMminutes'] as $key => $value) {
        $temp_array_u[$i]['PMminutes'] = $value;
        $i++;
    }

    $i = 1;
    foreach ($_POST['PMhoure'] as $key => $value) {
        $temp_array_u[$i]['PMhoure'] = $value;
        $i++;
    }

    $i = 1;
    foreach ($_POST['PMminutee'] as $key => $value) {
        $temp_array_u[$i]['PMminutee'] = $value;
        $i++;
    }





    for ($a = 1; $a < $i; $a++) {

        if ($temp_array_u[$a]['appointment_date'] != "") {

            $appointment_date = date("Y-m-d", strtotime($temp_array_u[$a]['appointment_date']));

            $con_appoint = ",appointment_date = '$appointment_date'";
        }

        $responsible_user_id = $temp_array_u[$a]['responsible_user_id'];
        $branch_care_id = $temp_array_u[$a]['branch_care_id'];

        $PMhours = $temp_array_u[$a]['PMhours'];
        $PMminutes = $temp_array_u[$a]['PMminutes'];
        $PMhoure = $temp_array_u[$a]['PMhoure'];
        $PMminutee = $temp_array_u[$a]['PMminutee'];

        $h = $PMhours;
        $m = $PMminutes;
        $time = $h . $m;
        if ($time != "") {
            $appointment_time_start = date("H:i", strtotime($time));

            $conupdate .= ",appointment_time_start = '$appointment_time_start'";
        }

        $eh = $PMhoure;
        $em = $PMminutee;
        $time = $eh . $em;

        if ($time != "") {
            $appointment_time_end = date("H:i", strtotime($time));

            $conupdate .= ",appointment_time_end = '$appointment_time_end'";

        }

        if ($branch_care_id != "") {
            $conupdate .= ",care_branch_id	= '$branch_care_id'";
        }


        if ($responsible_user_id != "") {
            $conupdate .= ",responsible_user_id = '$responsible_user_id'";

        }




        $group_pm_id = getRandomID(10, 'tbl_group_pm', 'group_pm_id');


        $sql_head = "INSERT INTO tbl_group_pm
                SET  group_date = '$appointment_date'
                    ,create_user_id = '$create_user_id'
                    ,responsible_user_id = '$responsible_user_id'
                    ,group_pm_id = '$group_pm_id'
              ";

        if (mysqli_query($connect_db, $sql_head)) {


            foreach ($job_select as $job_id) {


                $sql_job = "SELECT * FROM tbl_job WHERE job_id = '$job_id'";
                $rs_job = mysqli_query($connect_db, $sql_job);
                $row_job = mysqli_fetch_assoc($rs_job);

                $remark = strip_tags($row_job['note']);
                $job_id1 = getRandomID(10, 'tbl_job', 'job_id');

                $job_type = $row_job['job_type'];
                $customer_branch_id = $row_job['customer_branch_id'];
                $contact_name = $row_job['contact_name'];
                $contact_position = $row_job['contact_position'];
                $contact_phone = $row_job['contact_phone'];
                $sub_job_type_id = $row_job['sub_job_type_id'];
                $product_id = $row_job['product_id'];
                $initial_symptoms = strip_tags($row_job['damaged_report']);
                $ref_job = $row_job['ref_job'];

                /////////////job_no////////////////
                $pre_job_no = "PM";
                $mid_job_no = substr(date("Y") + 543, 2);

                $sql_count = "SELECT COUNT(job_id) AS num FROM tbl_job";
                $result_count = mysqli_query($connect_db, $sql_count);
                $row_count = mysqli_fetch_array($result_count);


                if ($row_count['num'] != 0) {

                    $sql_form_no = "SELECT (case WHEN (SELECT count(*) as count_this_month FROM tbl_job ) > 0 THEN LPAD((MAX(substring(job_no, -6))+1),6,0) ELSE '000001' end ) as NextCode 
        FROM tbl_job ";
                    $rs_form_no = mysqli_query($connect_db, $sql_form_no);
                    $row_form_no = mysqli_fetch_array($rs_form_no);

                    $last_job_no = $row_form_no['NextCode'];
                } else {
                    $l = 6;
                    $post_job_no = 1;
                    $last_job_no = sprintf("%0" . $l . "d", $post_job_no);
                }

                $job_no = $pre_job_no . $mid_job_no . $last_job_no;




                $sql = "INSERT INTO tbl_job
    SET job_id = '$job_id1'
    ,job_no = '$job_no'
    ,create_user_id = '$create_user_id'
    ,job_type = '$job_type'
    ,customer_branch_id = '$customer_branch_id'
    ,contact_name ='$contact_name'
    ,contact_position = '$contact_position'
    ,contact_phone = '$contact_phone'
    ,product_id	 ='$product_id'
    ,remark = '$remark'
    ,next_pm_period = '$distance_date'
    $con_appoint
    ,sub_job_type_id = '$sub_job_type_id'";
                ;
                $result_insert = mysqli_query($connect_db, $sql);

                if ($result_insert) {
                    $sql_detail = "INSERT INTO tbl_group_pm_detail
                    SET  job_id = '$job_id1'
                        ,group_pm_id = '$group_pm_id'";

                    $rs_detail = mysqli_query($connect_db, $sql_detail);

                    $sql_update = "UPDATE tbl_job 
                    SET   appointment_date = '$appointment_date'
                            $conupdate
                            WHERE job_id = '$job_id1'";
                    $result_update = mysqli_query($connect_db, $sql_update);

                }
            }

            $temp_array_job = array(
                'job_id' => $job_id1,
                'date' => $appointment_date
            );

            array_push($job_select, $temp_array_job);

            // if (!in_array($appointment_date, $appointment_select, true)) {
            //     $appointment_date_select = array_push($appointment_select, $appointment_date);
            // }








            if ($ref_job != "") {
                $sql_ref = "INSERT INTO tbl_job_ref
        SET    ref_job_id = '$ref_job',
                 job_id = '$job_id1'";
                $result_ref = mysqli_query($connect_db, $sql_ref);

                $stamp_date = date("Y-m-d H:i:s", strtotime('NOW'));

                $sql_ref_status = "UPDATE tbl_job 
        SET IN_PM_check = '1'
        ,IN_PM_check_user_id = '$create_user_id'
        ,IN_PM_check_datetime = '$stamp_date'
        WHERE job_id = '$ref_job'";
                $result_ref_status = mysqli_query($connect_db, $sql_ref_status);
            }



            $sql_job_open_oth = "SELECT * FROM tbl_job_open_oth_service WHERE job_id = '$job_id'";
            $rs_job_open_oth = mysqli_query($connect_db, $sql_job_open_oth);

            $list_order = 1;
            while ($row_job_open_oth = mysqli_fetch_assoc($rs_job_open_oth)) {

                $quantity = $row_job_open_oth['quantity'];
                $unit_price = $row_job_open_oth['unit_price'];
                $unit_cost = $row_job_open_oth['unit_cost'];
                $job_service = $row_job_open_oth['service_id'];


                $sql_service = "INSERT INTO tbl_job_open_oth_service
                    SET  job_id = '$job_id1'
                        , service_id = '$job_service'
                        , list_order = '$list_order'
                        ,quantity = '$quantity'
                        ,unit_cost = '$unit_cost'
                        ,unit_price = '$unit_price'
                    ";

                $rs_service = mysqli_query($connect_db, $sql_service);
                $list_order++;
            }


            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $sql_line = "SELECT * FROM tbl_user WHERE user_id = '$responsible_user_id';";
            // echo $sql_line . "<br/>";
            $rs_line = mysqli_query($connect_db, $sql_line);
            $row_line = mysqli_fetch_array($rs_line);

            // echo $row_line['line_active'] . "<br/>";
            // echo $row_line['line_token'] . "<br/>";


            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            // if ($row_line['line_active'] == "1") {

            //     $sql_job = "SELECT a.*,b.branch_name FROM tbl_job a 
            // JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id 
            // WHERE a.job_id = '$job_id1';";
            //     // echo $sql_job. "<br/>";
            //     $rs_job = mysqli_query($connect_db, $sql_job);
            //     $row_job = mysqli_fetch_array($rs_job);

            //     $date = date('d/m/Y', strtotime('+543 Years', strtotime($row_job['appointment_date'])));
            //     $appointment_date = $row_job['appointment_time_start'] . " ถึง " . $row_job['appointment_time_end'];

            //     $job_type = "";
            //     if ($row_job['job_type'] == 1) {
            //         $job_type = "CM";
            //     } else if ($row_job['job_type'] == 2) {
            //         $job_type = "PM";
            //     } else if ($row_job['job_type'] == 3) {
            //         $job_type = "Installation";
            //     } else if ($row_job['job_type'] == 4) {

            //     } else if ($row_job['job_type'] == 5) {

            //         $job_type = "Other";

            //     } else if ($row_job['job_type'] == 6) {

            //         $job_type = "Quotation";

            //     }

            //     $line_token = $row_line['line_token'];
            //     // $token = "koNpmxIz0Hl0DgA2oDB4oIDtRYR2NnOSbsb8slrO3AU";
            //     $msgLineNotify =
            //         "\r\n" . "แจ้งเตือนงาน " . "\r\n"
            //         . "เลขที่" . " : " . " " . $job_no . "\r\n"
            //         . "ชื่อร้าน" . " : " . $row_job['branch_name'] . "\r\n"
            //         . "วันที่" . " : " . $date . "\r\n"
            //         . "เวลา" . " : " . $appointment_date . "\r\n"
            //         . "ประเภทงาน" . " : " . $job_type . "\r\n"
            //         . "ผู้ติดต่อ" . " : " . $row_job['contact_name'] . " [" . $row_job['contact_phone'] . "]" . "\r\n";


            //     $StrokeAlert = "$line_token";


            //     $chOne = curl_init();
            //     curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
            //     curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
            //     curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
            //     curl_setopt($chOne, CURLOPT_POST, 1);
            //     curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $msgLineNotify);
            //     $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $line_token . '', );
            //     curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
            //     curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
            //     $result = curl_exec($chOne);

            //     //Result error 
            //     if (curl_error($chOne)) {
            //         echo 'error:' . curl_error($chOne);
            //     } else {

            //         $result_ = json_decode($result, true);
            //     }
            //     curl_close($chOne);
            //     ////////////////////////////////////////////////////////////////////////////

            //     // $arr['result'] = 1;

            // }

            $arr['result'] = 1;


        }

    }



}





echo json_encode($arr);
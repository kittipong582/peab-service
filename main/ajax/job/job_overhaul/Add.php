<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = getRandomID(10, 'tbl_job', 'job_id');
$create_user_id = $_SESSION['user_id'];
$customer_branch_id = $_POST['customer_branch_id'];
$contact_name = $_POST['contact_name'];
$contact_position = $_POST['contact_position'];
$contact_phone = $_POST['contact_phone'];
$overhaul_id = $_POST['overhaul_id'];
$product_id = $_POST['product_id'];
if ($_POST['appointment_date'] != "") {

    $appointment_date = date("Y-m-d", strtotime($_POST['appointment_date']));

    $con_appoint = ",appointment_date = '$appointment_date'";
}

////////////////////เวลาเริ่ม///////
$h = $_POST['hours'];
$m = $_POST['minutes'];
$time = $h . $m;
$appointment_time_start = date("H:i", strtotime($time));

////////////////////เวลาเริ่ม///////
$he = $_POST['houre'];
$me = $_POST['minutee'];
$time = $he . $me;
$appointment_time_end = date("H:i", strtotime($time));


$branch_care_id = $_POST['branch_care_id'];
$responsible_user_id = $_POST['responsible_user_id'];
$remark = strip_tags($_POST['note']);

/////////////job_no////////////////
$pre_job_no = "OH";
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
SET job_id = '$job_id'
,job_no = '$job_no'
,job_type = '4'
,create_user_id = '$create_user_id'
,customer_branch_id = '$customer_branch_id'
,contact_name ='$contact_name'
,contact_position = '$contact_position'
,contact_phone = '$contact_phone'
,product_id = '$product_id'
,care_branch_id	= '$branch_care_id'
,responsible_user_id = '$responsible_user_id'
$con_appoint
,remark = '$remark'
";

$result_insert = mysqli_query($connect_db, $sql);

if ($result_insert) {

    for ($x = 1; $x <= 8; $x++) {

        $condi = "";
        if ($x == 1) {
            $condi = ",user_id = '$responsible_user_id'";
        }

        $sql_oh = "INSERT INTO tbl_job_oh
        SET job_id = '$job_id'
        ,oh_type = '$x'
        $condi
        ";
        $rs_oh = mysqli_query($connect_db, $sql_oh);
    }
}


$sql_contact = "SELECT contact_name FROM tbl_customer_contact WHERE contact_name LIKE '%$contact_name%'";
$result_contact = mysqli_query($connect_db, $sql_contact);
$num_contact = mysqli_num_rows($result_contact);

if ($num_contact == 0) {


    $insert_contact = "INSERT INTO tbl_customer_contact
    SET  
        customer_branch_id = '$customer_branch_id'
        ,create_user_id = '$create_user_id'
        ,main_contact_status = '0'
        ,contact_name = '$contact_name'
        ,contact_phone = '$contact_phone'
        ,contact_position = '$contact_position'
     ;";

    $rs_contact = mysqli_query($connect_db, $insert_contact);
}


if ($_POST['appointment_date'] != "") {
    $appointment_date = date("Y-m-d", strtotime($_POST['appointment_date']));

    $sql_update = "UPDATE tbl_job
    SET appointment_date = '$appointment_date'
    WHERE job_id = '$job_id'";
    $result_update = mysqli_query($connect_db, $sql_update);
}

if ($appointment_time_start != $appointment_time_end) {

    $sql_update = "UPDATE tbl_job
    SET ,appointment_time_start = '$appointment_time_start'
        ,appointment_time_end = '$appointment_time_end'
    WHERE job_id = '$job_id'";
    $result_update = mysqli_query($connect_db, $sql_update);
}

if ($overhaul_id != "") {


    $sql_update = "UPDATE tbl_job 
SET overhaul_id = '$overhaul_id'
WHERE job_id = '$job_id'";

    $result_update = mysqli_query($connect_db, $sql_update);


    ////////////////////////LOG///////////////////////
    $sql_log = "INSERT INTO tbl_overhaul_log
SET job_id = '$job_id'
,overhaul_id = '$overhaul_id'
,create_user_id = '$create_user_id'";
    $result_log = mysqli_query($connect_db, $sql_log);



    $sql_up_oh = "UPDATE tbl_overhaul 
    SET current_customer_branch_id = '$customer_branch_id'
    WHERE overhaul_id = '$overhaul_id'";

    $result_up_oh = mysqli_query($connect_db, $sql_up_oh);

    // echo $sql_update;
}


if ($_POST['return_oh_user'] != "") {

    $return_oh_user = $_POST['return_oh_user'];
    $return_datetime = date("Y-m-d", strtotime($_POST['return_datetime']));

    $sql_return_oh = "UPDATE tbl_job
    SET  return_oh_user = '$return_oh_user'
    WHERE job_id = '$job_id'";
    $result_return_oh = mysqli_query($connect_db, $sql_return_oh);

    if ($_POST['return_datetime'] != "") {
        $return_datetime = date("Y-m-d", strtotime($_POST['return_datetime']));

        $sql_returndate = "UPDATE tbl_job
        SET return_datetime = '$return_datetime'
        WHERE job_id = '$job_id'";
        $result_returndate = mysqli_query($connect_db, $sql_returndate);
    }
}





if ($_POST['get_oh_datetime'] != "") {
    $get_oh_datetime = date("Y-m-d", strtotime($_POST['get_oh_datetime']));

    $sql_update = "UPDATE tbl_job
    SET get_oh_datetime = '$get_oh_datetime'
    WHERE job_id = '$job_id'";
    $result_update = mysqli_query($connect_db, $sql_update);

    // echo $sql_update;
}

if ($_POST['get_oh_user'] != "") {
    $get_oh_user = $_POST['get_oh_user'];

    $sql_update = "UPDATE tbl_job
    SET get_oh_user = '$get_oh_user'
    WHERE job_id = '$job_id'";
    $result_update = mysqli_query($connect_db, $sql_update);
}

if ($_POST['send_oh_datetime'] != "") {
    $send_oh_datetime = date("Y-m-d", strtotime($_POST['send_oh_datetime']));

    $sql_update = "UPDATE tbl_job
    SET send_oh_datetime = '$send_oh_datetime'
    WHERE job_id = '$job_id'";
    $result_update = mysqli_query($connect_db, $sql_update);
}

if ($_POST['send_oh_user'] != "") {
    $get_oh_user = $_POST['send_oh_user'];

    $sql_update = "UPDATE tbl_job
    SET send_oh_user = '$send_oh_user'
    WHERE job_id = '$job_id'";
    $result_update = mysqli_query($connect_db, $sql_update);
}

if ($_POST['qc_oh_datetime'] != "") {
    $qc_oh_datetime = date("Y-m-d", strtotime($_POST['qc_oh_datetime']));

    $sql_update = "UPDATE tbl_job
    SET qc_oh_datetime = '$qc_oh_datetime'
    WHERE job_id = '$job_id'";
    $result_update = mysqli_query($connect_db, $sql_update);
}

if ($_POST['qc_oh_user'] != "") {
    $qc_oh_user = $_POST['qc_oh_user'];

    $sql_update = "UPDATE tbl_job
    SET qc_oh_user = '$qc_oh_user'
    WHERE job_id = '$job_id'";
    $result_update = mysqli_query($connect_db, $sql_update);
}





$i = 1;
foreach ($_POST['quantity'] as $key => $value) {
    $temp_array_u[$i]['quantity'] = $value;
    $i++;
}

$i = 1;
foreach ($_POST['job_service'] as $key => $value) {
    $temp_array_u[$i]['job_service'] = $value;
    $i++;
}

$i = 1;
foreach ($_POST['unit_price'] as $key => $value) {
    $temp_array_u[$i]['unit_price'] = $value;
    $i++;
}
$i = 1;
foreach ($_POST['unit_cost'] as $key => $value) {
    $temp_array_u[$i]['unit_cost'] = $value;
    $i++;
}

$list_order = 1;
for ($a = 1; $a < $i; $a++) {

    $quantity = $temp_array_u[$a]['quantity'];
    $unit_price = $temp_array_u[$a]['unit_price'];
    $unit_cost = $temp_array_u[$a]['unit_cost'];
    $job_service = $temp_array_u[$a]['job_service'];


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


$job_ref = $_POST['job_ref'];
if ($job_ref != "") {

    $sql_ref = "INSERT INTO tbl_job_ref 
SET job_id = '$job_id'
,ref_job_id = '$job_ref'";
    $rs_ref = mysqli_query($connect_db, $sql_ref) or die($connect_db->error);
}


$i = 1;
foreach ($_POST['staff'] as $key => $value) {
    $temp_array_u[$i]['staff'] = $value;
    $i++;
}


for ($b = 1; $b < $i; $b++) {

    $staff = $temp_array_u[$b]['staff'];
    // echo $b."</br>";

    if ($staff != "") {

        $sql_staff = "INSERT INTO tbl_job_staff
                SET  job_id = '$job_id'
                    , staff_id = '$staff'
                ";

        $rs_staff = mysqli_query($connect_db, $sql_staff);
    }
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$sql_line = "SELECT * FROM tbl_user WHERE user_id = '$responsible_user_id';";
// echo $sql_line . "<br>";
$rs_line = mysqli_query($connect_db, $sql_line) or die($connect_db->error);
$row_line = mysqli_fetch_array($rs_line);

// echo $row_line['line_active'] . "<br>";
// echo $row_line['line_token'] . "<br>";


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








if ($result_insert) {

    if ($row_line['line_active'] == "1") {


        $sql_job = "SELECT a.*,b.branch_name FROM tbl_job a 
        JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id 
        WHERE a.job_id = '$job_id';";
        // echo $sql_job. "<br>";
        $rs_job = mysqli_query($connect_db, $sql_job) or die($connect_db->error);
        $row_job = mysqli_fetch_array($rs_job);

        $date = date('d/m/Y', strtotime('+543 Years', strtotime($row_job['appointment_date'])));
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
            . "วันที่" . " : " . $date . "\r\n"
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


    // ดึงข้อมูลคิวก่อนลบ
    $sql_select_queue = "SELECT queue_no FROM tbl_customer_queue WHERE customer_branch_id = '$customer_branch_id'";
    $result_select_queue = mysqli_query($connect_db, $sql_select_queue) or die($connect_db->error);
    $row_queue = mysqli_fetch_assoc($result_select_queue);
    $queue_no = $row_queue['queue_no'];

    // ลบคิว
    $sql_delete = "DELETE FROM tbl_customer_queue WHERE customer_branch_id = '$customer_branch_id' AND queue_no ='$queue_no'";
    $res_delete = mysqli_query($connect_db, $sql_delete) or die($connect_db->error);


    if ($res_delete) {
        // อัปเดตหมายเลขคิวของคิวที่เหลือ
        $sql_update_queue = "UPDATE tbl_customer_queue SET queue_no = queue_no - 1 WHERE queue_no > '$queue_no'";
        $result_update_queue = mysqli_query($connect_db, $sql_update_queue) or die($connect_db->error);

        if ($result_update_queue) {
            $arr['result'] = 1; // ลบคิวสำเร็จ
        } else {
            $arr['result'] = 0; // ลบคิวสำเร็จ แต่มีปัญหาในการอัปเดตหมายเลขคิว
        }
    } else {
        $arr['result'] = 0; // ลบคิวไม่สำเร็จ
    }

    // $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

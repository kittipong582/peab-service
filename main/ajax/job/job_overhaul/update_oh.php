<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];
if ($_POST['appointment_date'] != "") {

    $appointment_date = date("Y-m-d", strtotime($_POST['appointment_date']));

    $con_appoint = ",appointment_date = '$appointment_date'";
}
$initial_symptoms = $_POST['damaged_report'];
$remark = strip_tags($_POST['note']);
////////////////////เวลาเริ่ม///////
$h = $_POST['hours'];
$m = $_POST['minutes'];
$time = $h . $m;
$appointment_time_start = date("H:i", strtotime($time));
$appointment_time_start = date("H:i", strtotime($time));
$product_id = $_POST['product_id'];
////////////////////เวลาเริ่ม///////
$he = $_POST['houre'];
$me = $_POST['minutee'];
$time = $he . $me;
$appointment_time_end = date("H:i", strtotime($time));
$responsible_user_id = $_POST['responsible_user_id'];
$customer_branch_id = $_POST['customer_branch_id'];
$branch_care_id = $_POST['branch_care_id'];
$overhaul_id = $_POST['overhaul_id'];
$contact_name = $_POST['contact_name'];
$contact_position = $_POST['contact_position'];
$contact_phone = $_POST['contact_phone'];


$sql = "UPDATE tbl_job
SET 

appointment_time_start = '$appointment_time_start'
,appointment_time_end = '$appointment_time_end'
,responsible_user_id = '$responsible_user_id'
,remark = '$remark'
,product_id = '$product_id'
,care_branch_id	= '$branch_care_id'
$con_appoint
,customer_branch_id = '$customer_branch_id'
,contact_name = '$contact_name'
,contact_position = '$contact_position'
,contact_phone = '$contact_phone'
WHERE job_id = '$job_id'";

$result_insert  = mysqli_query($connect_db, $sql);


$sql_del = "DELETE FROM tbl_job_open_oth_service WHERE job_id = '$job_id'";
$result_del  = mysqli_query($connect_db, $sql_del);


if ($_POST['return_oh_user'] != "") {
    $return_oh_user = $_POST['return_oh_user'];
    
    $sql_return_oh = "UPDATE tbl_job
    SET  return_oh_user = '$return_oh_user'
    WHERE job_id = '$job_id'";
    $result_return_oh  = mysqli_query($connect_db, $sql_return_oh);

    if ($_POST['return_datetime'] != "") {
        $return_datetime = date("Y-m-d", strtotime($_POST['return_datetime']));

        $sql_returndate = "UPDATE tbl_job
        SET return_datetime = '$return_datetime'
        WHERE job_id = '$job_id'";
        $result_returndate  = mysqli_query($connect_db, $sql_returndate);
        
    }
}

if ($overhaul_id != "") {

    $sql_update = "UPDATE tbl_job 
SET overhaul_id = '$overhaul_id'
WHERE job_id = '$job_id'";

    $result_update  = mysqli_query($connect_db, $sql_update);


    $sql_del = "DELETE FROM tbl_overhaul_log WHERE job_id = '$job_id' AND return_datetime is null";
    $result_del  = mysqli_query($connect_db, $sql_del);

    $sql_up_oh = "UPDATE tbl_overhaul SET
current_customer_branch_id = NULL
WHERE current_customer_branch_id = '$customer_branch_id'";
    $result_up_oh  = mysqli_query($connect_db, $sql_up_oh);
    // echo $sql_up_oh;

    ////////////////////////LOG///////////////////////
    $sql_log = "INSERT INTO tbl_overhaul_log
SET job_id = '$job_id'
,overhaul_id = '$overhaul_id'
,create_user_id = '$create_user_id'";
    $result_log  = mysqli_query($connect_db, $sql_log);


    $sql_up_oh = "UPDATE tbl_overhaul 
    SET current_customer_branch_id = '$customer_branch_id'
    WHERE overhaul_id = '$overhaul_id'";

    $result_up_oh  = mysqli_query($connect_db, $sql_up_oh);

    // echo $sql_update;
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


$sql4 = "DELETE FROM tbl_job_staff WHERE job_id = '$job_id'";
$rs4 = mysqli_query($connect_db, $sql4) or die($connect_db->error);

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


$sql_ref = "SELECT *,b.job_id as ref_job_id FROM tbl_job_ref a 
LEFT JOIN tbl_job b ON a.ref_job_id = b.job_id
WHERE a.job_id = '$job_id'";
$result_ref  = mysqli_query($connect_db, $sql_ref);
$row_ref = mysqli_fetch_array($result_ref);

$ref_job_id = $row_ref['ref_job_id'];

$sql_up_ref = "UPDATE tbl_job
SET 
appointment_date = '$appointment_date'
WHERE job_id = '$ref_job_id' AND close_approve_id IS NULL";

$result_up_ref  = mysqli_query($connect_db, $sql_up_ref);


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$sql_line = "SELECT * FROM tbl_user WHERE user_id = '$responsible_user_id';";
// echo $sql_line . "<br>";
$rs_line  = mysqli_query($connect_db, $sql_line) or die($connection->error);
$row_line = mysqli_fetch_array($rs_line);

// echo $row_line['line_active'] . "<br>";
// echo $row_line['line_token'] . "<br>";


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


if ($row_line['line_active'] == "1") {


    $sql_job = "SELECT a.*,b.branch_name FROM tbl_job a 
    JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id 
    WHERE a.job_id = '$job_id';";
    // echo $sql_job. "<br>";
    $rs_job  = mysqli_query($connect_db, $sql_job) or die($connection->error);
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





if ($result_insert) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

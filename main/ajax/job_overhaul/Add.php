<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = getRandomID(10, 'tbl_job', 'job_id');
$create_user_id = $_SESSION['user_id'];
$customer_branch_id = $_POST['customer_branch_id'];
$contact_name = $_POST['contact_name'];
$contact_position = $_POST['contact_position'];
$contact_phone = $_POST['contact_phone'];
$overhaul_id = $_POST['overhaul_id'];
$appointment_date = date("Y-m-d", strtotime($_POST['appointment_date']));


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
$remark = $_POST['note'];

/////////////job_no////////////////
$pre_job_no = "OH";
$mid_job_no = substr(date("Y") + 543, 2);

$sql_count = "SELECT COUNT(job_id) AS num FROM tbl_job";
$result_count  = mysqli_query($connect_db, $sql_count);
$row_count = mysqli_fetch_array($result_count);

if ($row_count != 0) {
    $l = 5;
    $sql_no = "SELECT job_no FROM tbl_job ORDER BY create_datetime DESC LIMIT 1";
    $result_no  = mysqli_query($connect_db, $sql_no);
    $row_no = mysqli_fetch_array($result_no);

    $post_job_no = substr($row_no['job_no'], -5) + 1;
    $last_job_no = sprintf("%0" . $l . "d", $post_job_no);
} else {
    $l = 5;
    $post_job_no = 1;
    $last_job_no = sprintf("%0" . $l . "d", $post_job_no);
}

$job_no = $pre_job_no . $mid_job_no . $last_job_no;


$sql = "INSERT INTO tbl_job
SET job_id = '$job_id'
,job_no = '$job_no'
,create_user_id = '$create_user_id'
,customer_branch_id = '$customer_branch_id'
,contact_name ='$contact_name'
,contact_position = '$contact_position'
,contact_phone = '$contact_phone'
,overhaul_id	 ='$overhaul_id'
,care_branch_id	= '$branch_care_id'
,responsible_user_id = '$responsible_user_id'
,remark = '$remark'";

$result_insert  = mysqli_query($connect_db, $sql);

if ($_POST['appointment_date'] != "") {
    $appointment_date = date("Y-m-d", strtotime($_POST['appointment_date']));

    $sql_update = "UPDATE tbl_job
    SET appointment_date = '$appointment_date'
    WHERE job_id = '$job_id'";
    $result_update  = mysqli_query($connect_db, $sql_update);
}

if ($_POST['appointment_date'] != "") {
    $appointment_date = date("Y-m-d", strtotime($_POST['appointment_date']));

    $sql_update = "UPDATE tbl_job
    SET appointment_date = '$appointment_date'
    WHERE job_id = '$job_id'";
    $result_update  = mysqli_query($connect_db, $sql_update);
}

if ($appointment_time_start != $appointment_time_end) {

    $sql_update = "UPDATE tbl_job
    SET ,appointment_time_start = '$appointment_time_start'
        ,appointment_time_end = '$appointment_time_end'
    WHERE job_id = '$job_id'";
    $result_update  = mysqli_query($connect_db, $sql_update);
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

$list_order = 1;
for ($a = 1; $a < $i; $a++) {

    $quantity = $temp_array_u[$a]['quantity'];
    $unit_price = $temp_array_u[$a]['unit_price'];
    $job_service = $temp_array_u[$a]['job_service'];


    $sql_service = "INSERT INTO tbl_job_open_oth_service
                SET  job_id = '$job_id'
                    , service_id = '$job_service'
                    , list_order = '$list_order'
                    ,quantity = '$quantity'
                    ,unit_price = '$unit_price'
                ";

    $rs_service = mysqli_query($connect_db, $sql_service) or die($connection->error);
    $list_order++;
}



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
    } else {
        $job_type = "Installation";
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

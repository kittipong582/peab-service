<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$job_id = $_POST['job_id'];
$type = $_POST['type'];



if ($type == 1) {

    $sql_main = "SELECT a.job_no,b.line_token,line_active FROM tbl_job a
LEFT JOIN tbl_user b ON a.responsible_user_id = b.user_id 
WHERE a.job_id = '$job_id'";
    $result_main  = mysqli_query($connect_db, $sql_main);
    $row_main = mysqli_fetch_array($result_main);

    if ($row_main['line_active'] == "1") {


        $sql_job = "SELECT a.*,b.branch_name FROM tbl_job a 
    JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id 
    WHERE a.job_id = '$job_id';";
        // echo $sql_job. "<br>";
        $rs_job  = mysqli_query($connect_db, $sql_job);
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
            $job_type = "Overhaul";
        } else if ($row_job['job_type'] == 5) {
            $job_type = "Other";
        } else if ($row_job['job_type'] == 6) {
            $job_type = "Quotation";
        }


        $line_token = $row_main['line_token'];
        // $token = "koNpmxIz0Hl0DgA2oDB4oIDtRYR2NnOSbsb8slrO3AU";
        $msgLineNotify =
            "\r\n" . "แจ้งเตือนลบงาน " . "\r\n"
            . "เลขที่" . " : " . " " . $row_job['job_no'] . "\r\n"
            . "ชื่อร้าน" . " : " . $row_job['branch_name'] . "\r\n"
            . "วันที่" . " : " . $date . "\r\n"
            . "เวลา" . " : " . $appointment_date . "\r\n"
            . "ประเภทงาน" . " : " . $job_type . "\r\n"
            . "ผู้ติดต่อ" . " : " . $row_job['contact_name'] . " [" . $row_job['contact_phone'] . "]" . "\r\n"
            . "หมายเหตุ" . " : " . "เนื่องจากบันทึกเปิดงานผิดพลาด" . "\r\n";


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
    }


    $sql_del = "DELETE FROM tbl_job WHERE job_id = '$job_id'";
    $result_del  = mysqli_query($connect_db, $sql_del);

    if ($result_del) {
        $arr['result'] = 1;
    } else {
        $arr['result'] = 2;
    }
} else if ($type == 2) {



    $sql_pm = "SELECT job_id FROM tbl_group_pm_detail WHERE group_pm_id = '$job_id'";
    $rs_pm  = mysqli_query($connect_db, $sql_pm) or die($connect_db->error);
    while ($row_pm = mysqli_fetch_array($rs_pm)) {

        $sql_del = "DELETE FROM tbl_job WHERE job_id = '{$row_pm['job_id']}'";
        $result_del  = mysqli_query($connect_db, $sql_del);
    }

    $sql_del_detail = "DELETE FROM tbl_group_pm_detail WHERE group_pm_id = '$job_id'";
    $result_del_detail  = mysqli_query($connect_db, $sql_del_detail);

    if ($result_del_detail) {
        $sql_del_pm = "DELETE FROM tbl_group_pm WHERE group_pm_id = '$job_id'";
        $result_del_pm  = mysqli_query($connect_db, $sql_del_pm);

        if ($result_del_pm) {
            $arr['result'] = 1;
        } else {
            $arr['result'] = 2;
        }
    } else {
        $arr['result'] = 2;
    }
}
echo json_encode($arr);

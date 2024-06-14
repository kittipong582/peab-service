<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];


$quotation_id = $_POST['quotation_id'];
$discounts = $_POST['discounts'];
$total = $_POST['last_total'];
$product_id = $_POST['product_id'];
$job_id = $_POST['job_id'];
$customer_branch_id = $_POST['customer_branch_id'];
$job_customer_type = $_POST['job_customer_type'];
$contact_name = $_POST['job_customer_type'];
$contact_position = $_POST['contact_position'];
$contact_phone = $_POST['contact_phone'];

$sql_del = "DELETE FROM tbl_quotation_detail WHERE quotation_id = '$quotation_id'";
$result_del  = mysqli_query($connect_db, $sql_del);

$sql_quotation = "UPDATE tbl_quotation_head 
SET 
discounts = '$discounts'
,total = '$total'
WHERE quotation_id = '$quotation_id'";
$result_quotation  = mysqli_query($connect_db, $sql_quotation);


if ($job_customer_type == 2) {
    $sql_update = "UPDATE tbl_job     
SET 
customer_branch_id = null,
product_id = null,
contact_name = null,
contact_position = null,
contact_phone = null,
job_customer_type = '$job_customer_type'

WHERE job_id = '$job_id'";
    $result_update  = mysqli_query($connect_db, $sql_update);
} else {

    $sql_update = "UPDATE tbl_job     
    SET 
    customer_branch_id = '$customer_branch_id',
    contact_name = '$contact_name',
    contact_position = '$contact_position',
    contact_phone = '$contact_phone',
    job_customer_type = '$job_customer_type'
    WHERE job_id = '$job_id'";
    $result_update  = mysqli_query($connect_db, $sql_update);
}


if ($product_id != "") {
    $sql_update = "UPDATE tbl_job     
SET 
product_id = '$product_id'
WHERE job_id = '$job_id'";
    $result_update  = mysqli_query($connect_db, $sql_update);
}



$i = 1;
foreach ($_POST['qs_id'] as $key => $value) {
    $temp_array_u[$i]['qs_id'] = $value;
    $i++;
}

$i = 1;
foreach ($_POST['quantity'] as $key => $value) {
    $temp_array_u[$i]['quantity'] = $value;
    $i++;
}

$i = 1;
foreach ($_POST['unit'] as $key => $value) {
    $temp_array_u[$i]['unit'] = $value;
    $i++;
}


for ($a = 1; $a < $i; $a++) {

    $qs_id = $temp_array_u[$a]['qs_id'];
    $quantity = $temp_array_u[$a]['quantity'];
    $price = $temp_array_u[$a]['unit'];

    $sql_qs = "INSERT INTO tbl_quotation_detail 
    SET quotation_id = '$quotation_id'
    ,list_order = '$a'
    ,qs_id = '$qs_id'
    ,price = '$price'
    ,quantity = '$quantity'";
    $result_qs  = mysqli_query($connect_db, $sql_qs);

    // echo $sql_qs;
    // echo "<br/>";
}



if ($_FILES['uploadfile'] != "") {

    $tmpFilePath_1 = $_FILES['uploadfile']['tmp_name'];

    $file_1  = explode(".", $_FILES['uploadfile']['name']);

    $count1 = count($file_1) - 1;

    $file_surname_1 = $file_1[$count1];

    $filename_images_1 = md5(date('mds') . rand(111, 999) . date("hsid") . rand(111, 999)) . "." . $file_surname_1;

    if ($file_surname_1 == 'jpg' || $file_surname_1 == 'jpeg' || $file_surname_1 == 'gif' || $file_surname_1 == 'png' || $file_surname_1 == 'JPG' || $file_surname_1 == 'JPEG' || $file_surname_1 == 'GIF' || $file_surname_1 == 'PNG' || $file_surname_1 == 'PDF' || $file_surname_1 == 'pdf') {

        if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], "../../../upload/quotation_file/" . $filename_images_1)) {

            $sql_insert = "UPDATE tbl_job 
            SET quotation_file = '$filename_images_1'
            WHERE job_id = '$job_id'";
            $rs1 = mysqli_query($connect_db, $sql_insert) or die($connect_db->error);

            if ($rs1) {
                $arr['result'] = 1;
            } else {
                $arr['result'] = 0;
            }
        }
    }
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





if ($result_qs) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

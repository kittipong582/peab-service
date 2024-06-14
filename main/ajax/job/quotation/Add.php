<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = getRandomID(10, 'tbl_job', 'job_id');
$create_user_id = $_SESSION['user_id'];
$job_type = $_POST['job_type'];
$customer_branch_id = $_POST['customer_branch_id'];
$contact_name = $_POST['contact_name'];
$contact_position = $_POST['contact_position'];
$contact_phone = $_POST['contact_phone'];
$job_customer_type = $_POST['job_customer_type'];
$customer_name = $_POST['customer_name'];
$branch_care_id = $_POST['branch_care_id'];
$remark = strip_tags($_POST['note']);
$product_id = $_POST['product_id'];

/////////////job_no////////////////
$pre_job_no = "QT";
$mid_job_no = substr(date("Y") + 543, 2);

$sql_count = "SELECT COUNT(job_id) AS num FROM tbl_job";
$result_count  = mysqli_query($connect_db, $sql_count);
$row_count = mysqli_fetch_array($result_count);

if ($row_count['num'] != 0) {

    $sql_form_no = "SELECT (case WHEN (SELECT count(*) as count_this_month FROM tbl_job ) > 0 THEN LPAD((MAX(substring(job_no, -6))+1),6,0) ELSE '000001' end ) as NextCode 
    FROM tbl_job ";
    $rs_form_no = mysqli_query($connect_db, $sql_form_no);
    $row_form_no = mysqli_fetch_array($rs_form_no);

    $last_job_no =  $row_form_no['NextCode'];
} else {
    $l = 6;
    $post_job_no = 1;
    $last_job_no = sprintf("%0" . $l . "d", $post_job_no);
}

$job_no = $pre_job_no . $mid_job_no . $last_job_no;



$sql = "INSERT INTO tbl_job
SET job_id = '$job_id'
,job_no = '$job_no'
,create_user_id = '$create_user_id'
,job_type = '$job_type'
,customer_branch_id = '$customer_branch_id'
,contact_name ='$contact_name'
,contact_position = '$contact_position'
,contact_phone = '$contact_phone'
,care_branch_id	= '$branch_care_id'
,remark = '$remark'
,job_customer_type = '$job_customer_type'
";

$result_insert  = mysqli_query($connect_db, $sql);


$sql_contact = "SELECT contact_name FROM tbl_customer_contact WHERE contact_name LIKE '%$contact_name%'";
$result_contact  = mysqli_query($connect_db, $sql_contact);
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

    $rs_contact  = mysqli_query($connect_db, $insert_contact);
}

if($product_id != ""){
    $sql_update = "UPDATE tbl_job 
    SET product_id = '$product_id'
    WHERE job_id = '$job_id'";
    $result_update  = mysqli_query($connect_db, $sql_update);

}

if ($customer_branch_id == "") {
    $sql_update = "UPDATE tbl_job 
    SET customer_branch_id = NULL
    WHERE job_id = '$job_id'";
    $result_update  = mysqli_query($connect_db, $sql_update);
}

if ($job_customer_type == 2) {
    $sql_update = "UPDATE tbl_job 
    SET temp_name = '$customer_name'
    WHERE job_id = '$job_id'";
    $result_update  = mysqli_query($connect_db, $sql_update);
}

if ($contact_name == "") {
    $sql_update = "UPDATE tbl_job 
    SET contact_name = NULL
    WHERE job_id = '$job_id'";
    $result_update  = mysqli_query($connect_db, $sql_update);
}

if ($contact_position == "") {
    $sql_update = "UPDATE tbl_job 
    SET contact_position = NULL
    WHERE job_id = '$job_id'";
    $result_update  = mysqli_query($connect_db, $sql_update);
}

if ($contact_phone == "") {
    $sql_update = "UPDATE tbl_job 
    SET contact_phone = NULL
    WHERE job_id = '$job_id'";
    $result_update  = mysqli_query($connect_db, $sql_update);
}

if ($care_branch_id == "") {
    $sql_update = "UPDATE tbl_job 
    SET care_branch_id = NULL
    WHERE job_id = '$job_id'";
    $result_update  = mysqli_query($connect_db, $sql_update);
}


$quotation_id = getRandomID(10, 'tbl_quotation_head', 'quotation_id');
$discounts = $_POST['discounts'];
$total = $_POST['last_total'];

if ($total != "" && $total > 0) {



    $sql_quotation = "INSERT INTO tbl_quotation_head 
SET quotation_id = '$quotation_id'
,job_id = '$job_id'
,discounts = '$discounts'
,total = '$total'";
    $result_quotation  = mysqli_query($connect_db, $sql_quotation);


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
    }
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



$job_ref = $_POST['job_ref'];
if ($job_ref != "") {

    $sql_ref = "INSERT INTO tbl_job_ref 
SET job_id = '$job_id'
,ref_job_id = '$job_ref'";
    $rs_ref = mysqli_query($connect_db, $sql_ref) or die($connect_db->error);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$sql_line = "SELECT * FROM tbl_user WHERE user_id = '$responsible_user_id';";
// echo $sql_line . "<br>";
$rs_line  = mysqli_query($connect_db, $sql_line) or die($connect_db->error);
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
        $rs_job  = mysqli_query($connect_db, $sql_job) or die($connect_db->error);
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

    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$create_user_id = $_SESSION['user_id'];
$form_id = $_POST['form_id'];
$job_id = $_POST['job_id'];
$oh_job_type = 1;


$oh_type = $_POST['oh_type'];
//////////////////////////////////choice
$choice_no1 = $_POST['choice_no1'];
$choice_no2 = $_POST['choice_no2'];
$choice_no3 = $_POST['choice_no3'];
$choice_no4 = $_POST['choice_no4'];
$choice_no5 = $_POST['choice_no5'];
$choice_no6 = $_POST['choice_no6'];
$choice_no7 = $_POST['choice_no7'];
$choice_no8 = $_POST['choice_no8'];
$choice_no9 = $_POST['choice_no9'];
$choice_no10 = $_POST['choice_no10'];
$choice_no11 = $_POST['choice_no11'];
$choice_no12 = $_POST['choice_no12'];
$choice_no13 = $_POST['choice_no13'];
$choice_no14 = $_POST['choice_no14'];
$choice_no15 = $_POST['choice_no15'];
$choice_no16 = $_POST['choice_no16'];
$choice_no17 = $_POST['choice_no17'];
$choice_no18 = $_POST['choice_no18'];
$choice_no19 = $_POST['choice_no19'];
$choice_no20 = $_POST['choice_no20'];
$choice_no21 = $_POST['choice_no21'];
$choice_no22 = $_POST['choice_no22'];
$choice_no23 = $_POST['choice_no23'];
$choice_no24 = $_POST['choice_no24'];
$choice_no25 = $_POST['choice_no25'];
$choice_no26 = $_POST['choice_no26'];
$choice_no27 = $_POST['choice_no27'];
$choice_no28 = $_POST['choice_no28'];
$choice_no29 = $_POST['choice_no29'];
$choice_no30 = $_POST['choice_no30'];
$choice_no31 = $_POST['choice_no31'];
$choice_no32 = $_POST['choice_no32'];
$choice_no33 = $_POST['choice_no33'];
$choice_no34 = $_POST['choice_no34'];
$choice_no35 = $_POST['choice_no35'];
$choice_no36 = $_POST['choice_no36'];
$choice_no37 = $_POST['choice_no37'];



//////////////////detail//////////////

$no1_detail = $_POST['no1_detail'];
$no2_detail = $_POST['no2_detail'];
$no3_detail = $_POST['no3_detail'];
$no4_detail = $_POST['no4_detail'];
$no5_detail = $_POST['no5_detail'];
$no6_detail = $_POST['no6_detail'];
$no7_detail = $_POST['no7_detail'];
$no8_detail = $_POST['no8_detail'];
$no9_detail = $_POST['no9_detail'];
$no10_detail = $_POST['no10_detail'];
$no11_detail = $_POST['no11_detail'];
$no12_detail = $_POST['no12_detail'];
$no13_detail = $_POST['no13_detail'];
$no14_detail = $_POST['no14_detail'];
$no15_detail = $_POST['no15_detail'];
$no16_detail = $_POST['no16_detail'];
$no17_detail = $_POST['no17_detail'];
$no18_detail = $_POST['no18_detail'];
$no19_detail = $_POST['no19_detail'];
$no20_detail = $_POST['no20_detail'];
$no21_detail = $_POST['no21_detail'];
$no22_detail = $_POST['no22_detail'];
$no23_detail = $_POST['no23_detail'];
$no24_detail = $_POST['no24_detail'];
$no25_detail = $_POST['no25_detail'];
$no26_detail = $_POST['no26_detail'];
$no27_detail = $_POST['no27_detail'];
$no28_detail = $_POST['no28_detail'];
$no29_detail = $_POST['no29_detail'];
$no30_detail = $_POST['no30_detail'];
$no31_detail = $_POST['no31_detail'];
$no32_detail = $_POST['no32_detail'];
$no33_detail = $_POST['no33_detail'];
$no34_detail = $_POST['no34_detail'];
$no35_detail = $_POST['no35_detail'];
$no36_detail = $_POST['no36_detail'];
$no37_detail = $_POST['no37_detail'];


$note = $_POST['note'];
$create_datetime = date("y-m-d H:i:s", strtotime('NOW'));


$sql_record = "INSERT INTO tbl_oh_form
    SET  job_id = '$job_id'
        ,form_id = '$form_id'
        ,oh_job_type = '$oh_job_type'
        ,create_user_id = '$create_user_id'
        ,create_datetime = '$create_datetime'
        .oh_type = '$oh_type'
        ,choice_no1 = '$choice_no1'
        ,choice_no2 = '$choice_no2'
        ,choice_no3 = '$choice_no3'
        ,choice_no4 = '$choice_no4'
        ,choice_no5 = '$choice_no5'
        ,choice_no6 = '$choice_no6'
        ,choice_no7 = '$choice_no7'
        ,choice_no8 = '$choice_no8'
        ,choice_no9 = '$choice_no9'
        ,choice_no10 = '$choice_no10'
        ,choice_no11 = '$choice_no11'
        ,choice_no12 = '$choice_no12'
        ,choice_no13 = '$choice_no13'
        ,choice_no14 = '$choice_no14'
        ,choice_no15 = '$choice_no15'
        ,choice_no16 = '$choice_no16'
        ,choice_no17 = '$choice_no17'
        ,choice_no18 = '$choice_no18'
        ,choice_no19 = '$choice_no19'
        ,choice_no20 = '$choice_no20'
        ,choice_no21 = '$choice_no21'
        ,choice_no22 = '$choice_no22'
        ,choice_no23 = '$choice_no23'
        ,choice_no24 = '$choice_no24'
        ,choice_no25 = '$choice_no25'
        ,choice_no26 = '$choice_no26'
        ,choice_no27 = '$choice_no27'
        ,choice_no28 = '$choice_no28'
        ,choice_no29 = '$choice_no29'
        ,choice_no30 = '$choice_no30'
        ,choice_no31 = '$choice_no31'
        ,choice_no32 = '$choice_no32'
        ,choice_no33 = '$choice_no33'
        ,choice_no34 = '$choice_no34'
        ,choice_no35 = '$choice_no35'
        ,choice_no36 = '$choice_no36'
        ,choice_no37 = '$choice_no37'

        ,no1_detail = '$no1_detail'
        ,no2_detail = '$no2_detail'
        ,no3_detail = '$no3_detail'
        ,no4_detail = '$no4_detail'
        ,no5_detail = '$no5_detail'
        ,no6_detail = '$no6_detail'
        ,no7_detail = '$no7_detail'
        ,no8_detail = '$no8_detail'
        ,no9_detail = '$no9_detail'
        ,no10_detail = '$no10_detail'
        ,no11_detail = '$no11_detail'
        ,no12_detail = '$no12_detail'
        ,no13_detail = '$no13_detail'
        ,no14_detail = '$no14_detail'
        ,no15_detail = '$no15_detail'
        ,no16_detail = '$no16_detail'
        ,no17_detail = '$no17_detail'
        ,no18_detail = '$no18_detail'
        ,no19_detail = '$no19_detail'
        ,no20_detail = '$no20_detail'
        ,no21_detail = '$no21_detail'
        ,no22_detail = '$no22_detail'
        ,no23_detail = '$no23_detail'
        ,no24_detail = '$no24_detail'
        ,no25_detail = '$no25_detail'
        ,no26_detail = '$no26_detail'
        ,no27_detail = '$no27_detail'
        ,no28_detail = '$no28_detail'
        ,no29_detail = '$no29_detail'
        ,no30_detail = '$no30_detail'
        ,no31_detail = '$no31_detail'
        ,no32_detail = '$no32_detail'
        ,no33_detail = '$no33_detail'
        ,no34_detail = '$no34_detail'
        ,no35_detail = '$no35_detail'
        ,no36_detail = '$no36_detail'
        ,no37_detail = '$no37_detail'
        ,note = '$note'
    ";

$rs_record = mysqli_query($connect_db, $sql_record) or die($connect_db->error);


if ($rs_record) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

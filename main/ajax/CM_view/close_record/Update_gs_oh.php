<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$create_user_id = $_SESSION['user_id'];
$form_id = $_POST['form_id'];
$job_id = $_POST['job_id'];
$oh_job_type = 2;

$sub_oh_type = $_POST['sub_oh_type'];
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




//////////////////spare detail//////////////

$no1_spare = $_POST['no1_spare'];
$no2_spare = $_POST['no2_spare'];
$no3_spare = $_POST['no3_spare'];
$no4_spare = $_POST['no4_spare'];
$no5_spare = $_POST['no5_spare'];
$no6_spare = $_POST['no6_spare'];
$no7_spare = $_POST['no7_spare'];
$no8_spare = $_POST['no8_spare'];
$no9_spare = $_POST['no9_spare'];
$no10_spare = $_POST['no10_spare'];
$no11_spare = $_POST['no11_spare'];
$no12_spare = $_POST['no12_spare'];
$no13_spare = $_POST['no13_spare'];
$no14_spare = $_POST['no14_spare'];
$no15_spare = $_POST['no15_spare'];
$no16_spare = $_POST['no16_spare'];
$no17_spare = $_POST['no17_spare'];
$no18_spare = $_POST['no18_spare'];
$no19_spare = $_POST['no19_spare'];
$no20_spare = $_POST['no20_spare'];
$no21_spare = $_POST['no21_spare'];
$no22_spare = $_POST['no22_spare'];
$no23_spare = $_POST['no23_spare'];
$no24_spare = $_POST['no24_spare'];
$no25_spare = $_POST['no25_spare'];
$no26_spare = $_POST['no26_spare'];
$no27_spare = $_POST['no27_spare'];
$no28_spare = $_POST['no28_spare'];
$no29_spare = $_POST['no29_spare'];
$no30_spare = $_POST['no30_spare'];
$no31_spare = $_POST['no31_spare'];
$no32_spare = $_POST['no32_spare'];
$no33_spare = $_POST['no33_spare'];
$no34_spare = $_POST['no34_spare'];
$no35_spare = $_POST['no35_spare'];
$no36_spare = $_POST['no36_spare'];
$no37_spare = $_POST['no37_spare'];

//////////////////spare detail//////////////
$no1_spare_detail = $_POST['no1_spare_detail'];
$no2_spare_detail = $_POST['no2_spare_detail'];
$no3_spare_detail = $_POST['no3_spare_detail'];
$no4_spare_detail = $_POST['no4_spare_detail'];
$no5_spare_detail = $_POST['no5_spare_detail'];
$no6_spare_detail = $_POST['no6_spare_detail'];
$no7_spare_detail = $_POST['no7_spare_detail'];
$no8_spare_detail = $_POST['no8_spare_detail'];
$no9_spare_detail = $_POST['no9_spare_detail'];
$no10_spare_detail = $_POST['no10_spare_detail'];
$no11_spare_detail = $_POST['no11_spare_detail'];
$no12_spare_detail = $_POST['no12_spare_detail'];
$no13_spare_detail = $_POST['no13_spare_detail'];
$no14_spare_detail = $_POST['no14_spare_detail'];
$no15_spare_detail = $_POST['no15_spare_detail'];
$no16_spare_detail = $_POST['no16_spare_detail'];
$no17_spare_detail = $_POST['no17_spare_detail'];
$no18_spare_detail = $_POST['no18_spare_detail'];
$no19_spare_detail = $_POST['no19_spare_detail'];
$no20_spare_detail = $_POST['no20_spare_detail'];
$no21_spare_detail = $_POST['no21_spare_detail'];
$no22_spare_detail = $_POST['no22_spare_detail'];
$no23_spare_detail = $_POST['no23_spare_detail'];
$no24_spare_detail = $_POST['no24_spare_detail'];
$no25_spare_detail = $_POST['no25_spare_detail'];
$no26_spare_detail = $_POST['no26_spare_detail'];
$no27_spare_detail = $_POST['no27_spare_detail'];
$no28_spare_detail = $_POST['no28_spare_detail'];
$no29_spare_detail = $_POST['no29_spare_detail'];
$no30_spare_detail = $_POST['no30_spare_detail'];
$no31_spare_detail = $_POST['no31_spare_detail'];
$no32_spare_detail = $_POST['no32_spare_detail'];
$no33_spare_detail = $_POST['no33_spare_detail'];
$no34_spare_detail = $_POST['no34_spare_detail'];
$no35_spare_detail = $_POST['no35_spare_detail'];
$no36_spare_detail = $_POST['no36_spare_detail'];
$no37_spare_detail = $_POST['no37_spare_detail'];


$note = $_POST['remark'];
$create_datetime = date("y-m-d H:i:s", strtotime('NOW'));


$sql_record = "UPDATE tbl_oh_form
    SET  
        oh_type = '$oh_type'
        ,sub_oh_type = '$sub_oh_type'
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
        ,no1_spare = '$no1_spare'
        ,no2_spare = '$no2_spare'
        ,no3_spare = '$no3_spare'
        ,no4_spare = '$no4_spare'
        ,no5_spare = '$no5_spare'
        ,no6_spare = '$no6_spare'
        ,no7_spare = '$no7_spare'
        ,no8_spare = '$no8_spare'
        ,no9_spare = '$no9_spare'
        ,no10_spare = '$no10_spare'
        ,no11_spare = '$no11_spare'
        ,no12_spare = '$no12_spare'
        ,no13_spare = '$no13_spare'
        ,no14_spare = '$no14_spare'
        ,no15_spare = '$no15_spare'
        ,no16_spare = '$no16_spare'
        ,no17_spare = '$no17_spare'
        ,no18_spare = '$no18_spare'
        ,no19_spare = '$no19_spare'
        ,no20_spare = '$no20_spare'
        ,no21_spare = '$no21_spare'
        ,no22_spare = '$no22_spare'
        ,no23_spare = '$no23_spare'
        ,no24_spare = '$no24_spare'
        ,no25_spare = '$no25_spare'
        ,no26_spare = '$no26_spare'
        ,no27_spare = '$no27_spare'
        ,no28_spare = '$no28_spare'
        ,no29_spare = '$no29_spare'
        ,no30_spare = '$no30_spare'
        ,no31_spare = '$no31_spare'
        ,no32_spare = '$no32_spare'
        ,no33_spare = '$no33_spare'
        ,no34_spare = '$no34_spare'
        ,no35_spare = '$no35_spare'
        ,no36_spare = '$no36_spare'
        ,no37_spare = '$no37_spare'
        ,no1_spare_detail = '$no1_spare_detail'
        ,no2_spare_detail = '$no2_spare_detail'
        ,no3_spare_detail = '$no3_spare_detail'
        ,no4_spare_detail = '$no4_spare_detail'
        ,no5_spare_detail = '$no5_spare_detail'
        ,no6_spare_detail = '$no6_spare_detail'
        ,no7_spare_detail = '$no7_spare_detail'
        ,no8_spare_detail = '$no8_spare_detail'
        ,no9_spare_detail = '$no9_spare_detail'
        ,no10_spare_detail = '$no10_spare_detail'
        ,no11_spare_detail = '$no11_spare_detail'
        ,no12_spare_detail = '$no12_spare_detail'
        ,no13_spare_detail = '$no13_spare_detail'
        ,no14_spare_detail = '$no14_spare_detail'
        ,no15_spare_detail = '$no15_spare_detail'
        ,no16_spare_detail = '$no16_spare_detail'
        ,no17_spare_detail = '$no17_spare_detail'
        ,no18_spare_detail = '$no18_spare_detail'
        ,no19_spare_detail = '$no19_spare_detail'
        ,no20_spare_detail = '$no20_spare_detail'
        ,no21_spare_detail = '$no21_spare_detail'
        ,no22_spare_detail = '$no22_spare_detail'
        ,no23_spare_detail = '$no23_spare_detail'
        ,no24_spare_detail = '$no24_spare_detail'
        ,no25_spare_detail = '$no25_spare_detail'
        ,no26_spare_detail = '$no26_spare_detail'
        ,no27_spare_detail = '$no27_spare_detail'
        ,no28_spare_detail = '$no28_spare_detail'
        ,no29_spare_detail = '$no29_spare_detail'
        ,no30_spare_detail = '$no30_spare_detail'
        ,no31_spare_detail = '$no31_spare_detail'
        ,no32_spare_detail = '$no32_spare_detail'
        ,no33_spare_detail = '$no33_spare_detail'
        ,no34_spare_detail = '$no34_spare_detail'
        ,no35_spare_detail = '$no35_spare_detail'
        ,no36_spare_detail = '$no36_spare_detail'
        ,no37_spare_detail = '$no37_spare_detail'

        ,note = '$note'
        WHERE form_id = '$form_id'
    ";

$rs_record = mysqli_query($connect_db, $sql_record) or die($connect_db->error);


if ($rs_record) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);
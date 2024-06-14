<?php
session_start();
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$province_id = $_POST['province_id'];
$amphoe_name_th = mysqli_real_escape_string($connect_db, $_POST['amphoe_name_th']);
$amphoe_name_en = mysqli_real_escape_string($connect_db, $_POST['amphoe_name_en']);
$amphoe_zipcode = mysqli_real_escape_string($connect_db, $_POST['amphoe_zipcode']);



$sql_check = "SELECT COUNT(amphoe_id) as Num FROM tbl_amphoe WHERE ref_province = '$province_id' AND amphoe_name_th = '$amphoe_name_th'";
$rs_check = mysqli_query($connect_db, $sql_check) or die($connect_db->error);
$row_check = mysqli_fetch_array($rs_check);

if ($row_check['Num'] == 0) {

    $sql_runnumber = "SELECT MAX(amphoe_code) last_code FROM tbl_amphoe WHERE ref_province = '$province_id'";
    $rs_runnumber = mysqli_query($connect_db, $sql_runnumber) or die($connect_db->error);
    $row_runnumber = mysqli_fetch_array($rs_runnumber);
    $amphoe_code = $row_runnumber['last_code'] + 1;

    $sql_id = "SELECT MAX(amphoe_id) last_id FROM tbl_amphoe ";
    $rs_id = mysqli_query($connect_db, $sql_id) or die($connect_db->error);
    $row_id = mysqli_fetch_array($rs_id);
    $amphoe_id = $row_id['last_id'] + 1;

    $sql3 = "INSERT INTO tbl_amphoe
    SET    amphoe_name_th = '$amphoe_name_th'
        , amphoe_name_en = '$amphoe_name_en'
        , amphoe_code = '$amphoe_code'
        , ref_province = '$province_id'
        ,amphoe_id = '$amphoe_id'
        ";

    $rs3 = mysqli_query($connect_db, $sql3) or die($connect_db->error);



    if ($rs3) {
        $arr['result'] = 1;
    } else {
        $arr['result'] = 0;
        $arr['error_type'] = "";
    }
} else {
    $arr['result'] = 2;
    $arr['error_type'] = "มีข้อมูลซ้ำในระบบ";
}




echo json_encode($arr);

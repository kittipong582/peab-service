<?php
session_start();
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$amphoe_id = $_POST['amphoe_id'];
$district_name_th = mysqli_real_escape_string($connect_db, $_POST['district_name_th']);
$district_name_en = mysqli_real_escape_string($connect_db, $_POST['district_name_en']);
$district_zipcode = mysqli_real_escape_string($connect_db, $_POST['district_zipcode']);
$place_type = mysqli_real_escape_string($connect_db, $_POST['place_type']);



$sql_check = "SELECT COUNT(district_id) as Num FROM tbl_district WHERE ref_amphoe = '$amphoe_id' AND district_name_th = '$district_name_th' AND district_zipcode = '$district_zipcode'";
$rs_check = mysqli_query($connect_db, $sql_check) or die($connect_db->error);
$row_check = mysqli_fetch_array($rs_check);

if ($row_check['Num'] == 0) {

    $sql_runnumber = "SELECT MAX(district_id) last_id FROM tbl_district ";
    $rs_runnumber = mysqli_query($connect_db, $sql_runnumber) or die($connect_db->error);
    $row_runnumber = mysqli_fetch_array($rs_runnumber);
    $district_id = $row_runnumber['last_id'] + 1;

    $sql3 = "INSERT INTO tbl_district
    SET    district_name_th = '$district_name_th'
        , district_name_en = '$district_name_en'
        , district_zipcode = '$district_zipcode'
        , ref_amphoe = '$amphoe_id'
        , place_type = '$place_type'
        ,district_id = '$district_id'
        ";
    // echo $sql3;
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

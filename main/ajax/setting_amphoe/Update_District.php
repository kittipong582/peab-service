<?php
session_start();
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$district_id = $_POST['district_id'];
$district_name_th = mysqli_real_escape_string($connect_db, $_POST['district_name_th']);
$district_name_en = mysqli_real_escape_string($connect_db, $_POST['district_name_en']);
$district_zipcode = mysqli_real_escape_string($connect_db, $_POST['district_zipcode']);
$place_type = mysqli_real_escape_string($connect_db, $_POST['place_type']);
$ref_amphoe = mysqli_real_escape_string($connect_db, $_POST['ref_amphoe']);


$sql_check = "SELECT COUNT(district_id) as Num FROM tbl_district WHERE district_id != '$district_id' AND ref_amphoe = '$ref_amphoe'  AND district_name_th = '$district_name_th'";
$rs_check = mysqli_query($connect_db, $sql_check) or die($connect_db->error);
$row_check = mysqli_fetch_array($rs_check);

if ($row_check['Num'] == 0) {



    $sql3 = "UPDATE tbl_district
    SET    district_name_th = '$district_name_th'
        , district_name_en = '$district_name_en'
        , district_zipcode = '$district_zipcode'
        , place_type = '$place_type'
        WHERE district_id = '$district_id'
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

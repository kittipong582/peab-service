<?php
session_start();
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$ref_province = $_POST['ref_province'];
$amphoe_id = mysqli_real_escape_string($connect_db, $_POST['amphoe_id']);
$amphoe_name_th = mysqli_real_escape_string($connect_db, $_POST['amphoe_name_th']);
$amphoe_name_en = mysqli_real_escape_string($connect_db, $_POST['amphoe_name_en']);



$sql_check = "SELECT COUNT(amphoe_id) as Num FROM tbl_amphoe WHERE amphoe_id != '$amphoe_id' AND ref_province = '$ref_province'  AND amphoe_name_th = '$amphoe_name_th'";
$rs_check = mysqli_query($connect_db, $sql_check) or die($connect_db->error);
$row_check = mysqli_fetch_array($rs_check);

if ($row_check['Num'] == 0) {



    $sql3 = "UPDATE tbl_amphoe
    SET    amphoe_name_th = '$amphoe_name_th'
        , amphoe_name_en = '$amphoe_name_en'
        WHERE amphoe_id = '$amphoe_id'
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

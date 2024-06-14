<?php
session_start();
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$product_id = $_POST['product_id'];
$brand_id = mysqli_real_escape_string($connect_db, $_POST['brand_id']);
$model_id = mysqli_real_escape_string($connect_db, $_POST['model_id']);
$product_type = mysqli_real_escape_string($connect_db, $_POST['product_type']);
$serial_no = mysqli_real_escape_string($connect_db, $_POST['serial_no']);
$current_branch_id = mysqli_real_escape_string($connect_db, $_POST['current_branch_id']);

$install_date = date("Y-m-d", strtotime($_POST['install_date']));
$buy_date = date("Y-m-d", strtotime($_POST['buy_date']));
$warranty_start_date = date("Y-m-d", strtotime($_POST['warranty_start_date']));
$warranty_end_date = date("Y-m-d", strtotime($_POST['warranty_end_date']));
$warranty_type = $_POST['warranty_type'];
$note = mysqli_real_escape_string($connect_db, $_POST['note']);


$create_user_id = $_SESSION['user_id'];
$sql_check = "SELECT COUNT(product_id) as Num FROM tbl_product WHERE product_id != '$product_id' AND serial_no = '$serial_no' AND brand_id = '$brand_id'";
$rs_check = mysqli_query($connect_db, $sql_check) or die($connect_db->error);
$row_check = mysqli_fetch_array($rs_check);

if ($row_check['Num'] == 0) {
    $sql3 = "UPDATE tbl_product
SET    
    model_id = '$model_id'
    ,brand_id = '$brand_id'
    , product_type = '$product_type'
    , serial_no = '$serial_no'
    , install_date = '$install_date'
    , buy_date = '$buy_date'
    ,warranty_type = '$warranty_type'
    , warranty_start_date = '$warranty_start_date'
    , warranty_expire_date = '$warranty_end_date'
    , note = '$note'
    WHERE product_id = '$product_id'";
    // echo $sql3;
    $rs3 = mysqli_query($connect_db, $sql3) or die($connect_db->error);

    $sql_check_date = "SELECT * FROM tbl_product WHERE product_id = '$product_id'";
    $rs_check_date = mysqli_query($connect_db, $sql_check_date) or die($connect_db->error);
    $row_check_date = mysqli_fetch_array($rs_check_date);

    if ($row_check_date['install_date'] == '1970-01-01') {

        $sql_date = "UPDATE tbl_product 
        SET install_date = NULL        
        WHERE product_id = '$product_id'";
        $rs_date = mysqli_query($connect_db, $sql_date) or die($connect_db->error);
    }
    if ($row_check_date['buy_date'] == '1970-01-01') {

        $sql_date = "UPDATE tbl_product 
        SET buy_date = NULL        
        WHERE product_id = '$product_id'";
        $rs_date = mysqli_query($connect_db, $sql_date) or die($connect_db->error);
    }
    if ($row_check_date['warranty_start_date'] == '1970-01-01') {

        $sql_date = "UPDATE tbl_product 
        SET warranty_start_date = NULL        
        WHERE product_id = '$product_id'";
        $rs_date = mysqli_query($connect_db, $sql_date) or die($connect_db->error);
    }
    if ($row_check_date['warranty_expire_date'] == '1970-01-01') {

        $sql_date = "UPDATE tbl_product 
        SET warranty_expire_date = NULL        
        WHERE product_id = '$product_id'";
        $rs_date = mysqli_query($connect_db, $sql_date) or die($connect_db->error);
    }



    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}


$arr['customer_branch_id'] = $current_branch_id;

echo json_encode($arr);

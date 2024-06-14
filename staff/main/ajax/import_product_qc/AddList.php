<?php
session_start();
include("../../../../config/main_function.php");

$connection = connectDB("LM=VjfQ{6rsm&/h`");


$ref_number = mysqli_real_escape_string($connection, $_POST['ref_number']);
$model_code = mysqli_real_escape_string($connection, $_POST['model_code']);
$lot_no = mysqli_real_escape_string($connection, $_POST['lot_no']);
$quantity = mysqli_real_escape_string($connection, $_POST['quantity']);
$lot_id = mysqli_real_escape_string($connection, $_POST['lot_id']);

if ($connection) {


    $sql_model = "SELECT * FROM tbl_product_waiting WHERE model_code = '$model_code'";
    $rs_model = mysqli_query($connection, $sql_model);
    $cmt_model = mysqli_num_rows($rs_model);
    $row_model = mysqli_fetch_array($rs_model);
    $new_remain_quantity = $row_model['remain_quantity'] + $quantity;
    $new_import_quantity = $row_model['remain_quantity'] + $quantity;
   


    if ($cmt_model >= 1) {
        $sql_insert = "UPDATE tbl_product_waiting SET 
            remain_quantity =  '$new_remain_quantity',
            import_quantity =  '$new_import_quantity',
            quantity = '$new_import_quantity'
             WHERE model_code = '$model_code'";
    } else {
        $sql_insert = "INSERT INTO tbl_product_waiting SET 
            lot_id = '$lot_id',
            lot_no = '$lot_no',
            create_user_id = '$create_user_id', 
            model_code = '$model_code',
            ref_number = '$ref_number',
            quantity = '$quantity',
            import_quantity = '$quantity',
            remain_quantity = '$quantity'";
    }

    $res_insert = mysqli_query($connection, $sql_insert) or die($connection->error);

    if ($res_insert) {
        $arr['result'] = 1;
    } else {
        $arr['result'] = 0;
    }
} else {
    $arr['result'] = 9;
}

mysqli_close($connection);
echo json_encode($arr);
?>
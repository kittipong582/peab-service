<?php
session_start();
include("../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$import_id = mysqli_real_escape_string($connection, $_POST['import_id']);
$remark = mysqli_real_escape_string($connection, $_POST['remark']);
$datetime = date("Y-m-d H:i");

$sql = "UPDATE tbl_import_stock
    SET  receive_result = '1'
        ,receive_remark = '$remark',
        receive_datetime = '$datetime'
    WHERE import_id = '$import_id' ;";

$rs = mysqli_query($connection, $sql) or die($connection->error);



//////////////////////////////////////////////////////////////////////////////
$sql_l = "SELECT * FROM tbl_import_stock a 
                    JOIN  tbl_import_stock_detail b ON a.import_id = b.import_id
                    WHERE a.import_id = '$import_id' ;";
$rs_l  = mysqli_query($connection, $sql_l) or die($connection->error);
while ($row_l = mysqli_fetch_assoc($rs_l)) {


    $sql_us = "SELECT * FROM tbl_branch_stock WHERE branch_id = '{$row_l['receive_branch_id']}' AND spare_part_id = '{$row_l['spare_part_id']}' ;";
    $rs_us  = mysqli_query($connection, $sql_us) or die($connection->error);
    $row_us = mysqli_fetch_assoc($rs_us);


    if ($row_l['spare_part_id'] == $row_us['spare_part_id']) {

        $remain = $row_us['remain_stock'] + $row_l['quantity'];

        $sql_user_stock = "UPDATE tbl_branch_stock
        SET  remain_stock = '$remain'
        WHERE branch_id = '{$row_us['branch_id']}' AND spare_part_id = '{$row_us['spare_part_id']}' ;";

        $rs_user_stock = mysqli_query($connection, $sql_user_stock) or die($connection->error);
    } else {

        $sql_user_stock = "INSERT INTO tbl_branch_stock
            SET  branch_id = '{$row_l['receive_branch_id']}'
                ,spare_part_id = '{$row_l['spare_part_id']}'
                ,remain_stock  = '{$row_l['quantity']}'
            ;";
        $rs_user_stock = mysqli_query($connection, $sql_user_stock) or die($connection->error);
    }
}

if ($rs && $rs_user_stock) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

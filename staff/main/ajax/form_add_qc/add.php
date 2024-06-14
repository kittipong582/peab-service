<?php
session_start();
include ("../../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

$arr = array();

$job_qc_id = mysqli_real_escape_string($connection, $_POST['job_qc_id']);
$product_qc_id = getRandomID2(10, 'tbl_product_qc', 'product_qc_id');

$appointment_date = $_POST['appointment_date'];
$appointment_date = explode('-', $_POST['appointment_date']);
$appointment_date = date('Y-m-d', strtotime($appointment_date['0'] . "-" . $appointment_date['1'] . "-" . $appointment_date['2']));
$model_code = mysqli_real_escape_string($connection, $_POST['model_code']);
$create_user_id = mysqli_real_escape_string($connection, $_POST['user_id']);
$lot_id = mysqli_real_escape_string($connection, $_POST['lot_id']);
$product_type = mysqli_real_escape_string($connection, $_POST['product_type']);
$series_no = mysqli_real_escape_string($connection, $_POST['series_no']);
$machine_status = mysqli_real_escape_string($connection, $_POST['machine_status']);

$sql_waiting = "SELECT * FROM tbl_product_waiting WHERE lot_id = '$lot_id'";
$res_waiting = mysqli_query($connection, $sql_waiting);
$row_waiting = mysqli_fetch_assoc($res_waiting);


if ($row_waiting['remain_quantity'] > 0) {

    $sql_update_wait = "UPDATE tbl_product_waiting SET 
    remain_quantity = remain_quantity - 1
    WHERE lot_id = '$lot_id'";
    $res_update_wait = mysqli_query($connection, $sql_update_wait);

    $i = 1;
    foreach ($_POST['model_code'] as $key => $value) {
        $temp_array[$i]['model_code'] = $value;
        $i++;
    }

    $j = 1;
    foreach ($_POST['responsible_user_id'] as $key => $value) {
        $temp_array[$j]['responsible_user_id'] = $value;
        $j++;
    }



    $sql = "SELECT * FROM tbl_job_qc";
    $res = mysqli_query($connection, $sql);
    $row = mysqli_num_rows($res);

    if ($row >= 1) {
        $list_order = $row + 1;
    } else {
        $list_order = 1;
    }


    $sql_list_product = "SELECT * FROM tbl_job_qc";
    $res_list_product = mysqli_query($connection, $sql_list_product);
    $row_list_product = mysqli_num_rows($res_list_product);

    if ($row_list_product >= 1) {
        $list_order_product = $row_list_product + 1;
    } else {
        $list_order_product = 1;
    }

    $sql_insert = "INSERT INTO tbl_job_qc SET 
    job_qc_id = '$job_qc_id',
    list_order = '$list_order',
    lot_id = '$lot_id',
    product_type_id = '$product_type',
    create_user_id = '$create_user_id',   
    appointment_date = '$appointment_date'";
    $res_insert = mysqli_query($connection, $sql_insert);

    if ($res_insert) {

            $sql_insert_product = "INSERT INTO tbl_product_qc SET 
            product_qc_id = '$product_qc_id',
            model_code = '$model_code',
            series_no = '$series_no',
            machine_status = '$machine_status',
            list_order = '$list_order_product',
            create_user_id = '$create_user_id', 
            job_qc_id = '$job_qc_id'";
        $res_insert_product = mysqli_query($connection, $sql_insert_product);


        for ($a = 1; $a < $j; $a++) {
            $staff_qc_id = getRandomID2(10, 'tbl_staff_qc', 'staff_qc_id');
            $responsible_user_id = $temp_array[$a]['responsible_user_id'];

            $sql_insert_staff = "INSERT INTO tbl_staff_qc SET 
            staff_qc_id = '$staff_qc_id',
            staff_id = '$responsible_user_id',
            create_user_id = '$create_user_id', 
            job_qc_id = '$job_qc_id'";
            $res_insert_staff = mysqli_query($connection, $sql_insert_staff);
        }
        if ($res_update_wait) {
            $arr['result'] = 1;
        }
    } else {
        $arr['result'] = 0;
    }
} else {
    $arr['result'] = 10;
}

mysqli_close($connection);
echo json_encode($arr);

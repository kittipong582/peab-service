<?php
session_start();
include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$create_user_id = $_SESSION['user_id'];
$responsible_user_id = $_POST['responsible_user_id'];
$job_id = $_POST['job_id'];


$sql_branch = "SELECT * FROM tbl_user WHERE user_id = '$responsible_user_id'";
$result_branch  = mysqli_query($connect_db, $sql_branch);
$row_branch = mysqli_fetch_array($result_branch);

$sql_customer = "SELECT customer_id FROM tbl_job WHERE job_id = '$job_id'";
$result_customer  = mysqli_query($connect_db, $sql_customer);
$row_customer = mysqli_fetch_array($result_customer);

$branch_id = $row_branch['branch_id'];


$sql_chk = "SELECT customer_group FROM tbl_customer WHERE customer_id = '{$row_customer['customer_id']}'";
$result_chk  = mysqli_query($connect_db, $sql_chk);
$row_chk = mysqli_fetch_array($result_chk);


$i = 1;
foreach ($_POST['quantity'] as $key => $value) {
    $temp_array_u[$i]['quantity'] = $value;
    $i++;
}

$i = 1;
foreach ($_POST['insurance_status'] as $key => $value) {
    $temp_array_u[$i]['insurance_status'] = $value;
    $i++;
}

$i = 1;
foreach ($_POST['spare_part'] as $key => $value) {
    $temp_array_u[$i]['spare_part'] = $value;
    $i++;
}

$i = 1;
foreach ($_POST['cost'] as $key => $value) {
    $temp_array_u[$i]['cost'] = $value;
    $i++;
}

$i = 1;
foreach ($_POST['spare_used_id'] as $key => $value) {
    $temp_array_u[$i]['spare_used_id'] = $value;
    $i++;
}
for ($a = 1; $a < $i; $a++) {

    $spare_used_id = $temp_array_u[$a]['spare_used_id'];
    $spare_part = $temp_array_u[$a]['spare_part'];
    $insurance_type = $temp_array_u[$a]['insurance_status'];
    $quantity = $temp_array_u[$a]['quantity'];
    $cost = $temp_array_u[$a]['cost'];

    if ($insurance_type == 0) {
        $insurance_status = 0;
    } else {
        $insurance_status = 1;
    }

    if ($insurance_status == 0) {
        $unit_price = $quantity * $cost;
    } else {
        $unit_price = 0;
    }

    $sql_count = "SELECT * FROM tbl_branch_stock WHERE branch_id = '$branch_id' AND spare_part_id = '$spare_part'";
    $result_stock  = mysqli_query($connect_db, $sql_count);
    $row_count = mysqli_fetch_array($result_stock);

    if ($row_count['remain_stock'] > 0 &&  $row_count['remain_stock'] >= $quantity) {


        $sql_used = "SELECT * FROM tbl_job_spare_used WHERE job_id = '$job_id' AND spare_part_id = '$spare_part'";
        $result_used  = mysqli_query($connect_db, $sql_used);
        $row_num = mysqli_num_rows($result_used);
        $row_used = mysqli_fetch_array($result_used);
        if ($row_num == 1) {

            // echo "1";
            $new_quantity = $row_used['quantity'] + $quantity;
            $new_unit_price = $row_used['unit_price'] + $unit_price;

            $sql_service = "UPDATE tbl_job_spare_used
            SET  quantity = '$new_quantity'
                ,unit_price = '$new_unit_price'
                WHERE spare_part_id = '$spare_part' AND job_id = '$job_id'
            ";
            $rs_service = mysqli_query($connect_db, $sql_service) or die($connect_db->error);
        } else {
            // echo "2";
            $sql_service = "INSERT INTO tbl_job_spare_used
                SET  spare_used_id = '$spare_used_id'
                    , spare_part_id = '$spare_part'
                    ,create_user_id = '$create_user_id'
                    ,job_id = '$job_id'
                    , insurance_status = '$insurance_status'
                    ,quantity = '$quantity'
                    ,unit_price = '$unit_price',
                    insurance_type = '$insurance_type'
                ";

            $rs_service = mysqli_query($connect_db, $sql_service) or die($connect_db->error);
        }

        $sql_stock = "SELECT * FROM tbl_branch_stock WHERE branch_id = '$branch_id' AND spare_part_id = '$spare_part'";
        $result_stock  = mysqli_query($connect_db, $sql_stock);
        $row_stock = mysqli_fetch_array($result_stock);

        $remain = $row_stock['remain_stock'] - $quantity;

        $sql_update = "UPDATE tbl_branch_stock
                SET  remain_stock = '$remain'
                WHERE branch_id = '$branch_id' AND spare_part_id = '$spare_part'

                ";

        $rs_update = mysqli_query($connect_db, $sql_update) or die($connect_db->error);
    } else {
        $arr['result'] = 0;
    }
}

$sql_spare = "SELECT SUM(unit_price) AS totall FROM tbl_job_spare_used WHERE job_id = '$job_id'";
$result_spare  = mysqli_query($connect_db, $sql_spare);
$row_spare = mysqli_fetch_array($result_spare);

$sql_income = "SELECT * FROM tbl_job_income WHERE job_id = '$job_id'";
$result_income  = mysqli_query($connect_db, $sql_income);
while ($row_income = mysqli_fetch_array($result_income)) {

    $income_total += $row_income['quantity'] * $row_income['income_amount'];
}

$service_total = $income_total + $row_spare['totall'];


$sql_spare_q = "SELECT SUM(quantity) AS all_quantity FROM tbl_job_spare_used WHERE job_id = '$job_id'";
$result_spare_q  = mysqli_query($connect_db, $sql_spare_q);
$row_spare_q = mysqli_fetch_array($result_spare_q);


if ($rs_service && $rs_update) {
    $arr['result'] = 1;
    $arr['total_spare'] = number_format($row_spare['totall']);
    $arr['td_total'] = number_format($service_total);
    $arr['spare_quantity'] = number_format($row_spare_q['all_quantity']);
} else {
    $arr['result'] = 0;
}
// $arr['result'] = 1;
echo json_encode($arr);

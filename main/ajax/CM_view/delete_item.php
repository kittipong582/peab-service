<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$spare_used_id = $_POST['spare_used_id'];

$sql_spare_part = "SELECT *,b.job_id AS id_job FROM tbl_job_spare_used a
LEFT JOIN tbl_job b ON a.job_id = b.job_id 
LEFT JOIN tbl_user c ON b.responsible_user_id = c.user_id 
WHERE a.spare_used_id = '$spare_used_id'";
$result_spare_part  = mysqli_query($connect_db, $sql_spare_part);
$row_spare_part = mysqli_fetch_array($result_spare_part);

$branch_id = $row_spare_part['branch_id'];
$spare_id = $row_spare_part['spare_part_id'];
$id_job = $row_spare_part['id_job'];

$sql_stock = "SELECT * FROM tbl_branch_stock WHERE branch_id = '$branch_id' AND spare_part_id = '$spare_id'";
$result_stock  = mysqli_query($connect_db, $sql_stock);
$row_stock = mysqli_fetch_array($result_stock);

$return_stock = $row_stock['remain_stock'] + $row_spare_part['quantity'];

$sql_update = "UPDATE tbl_branch_stock 
SET remain_stock = '$return_stock'
WHERE branch_id = '$branch_id' AND spare_part_id = '$spare_id'";
$result_update  = mysqli_query($connect_db, $sql_update);






////////////////////////////////////////////////////คำนวน///////////////////////////
$sql_group = "SELECT * FROM tbl_group_pm_detail WHERE job_id = '{$row_spare_part['job_id']}'";
$result_group  = mysqli_query($connect_db, $sql_group);
$row_group = mysqli_fetch_array($result_group);
$num_group = mysqli_num_rows($result_group);


$sql_del = "DELETE  FROM tbl_job_spare_used WHERE spare_used_id = '$spare_used_id'";
$result_del = mysqli_query($connect_db, $sql_del) or die($connect_db->error);


if ($num_group > 0) {

    $sql_detail = "SELECT * FROM tbl_group_pm_detail WHERE group_pm_id = '{$row_group['group_pm_id']}'";
    $result_detail  = mysqli_query($connect_db, $sql_detail);

    while ($row_detail = mysqli_fetch_array($result_detail)) {
        $sql_spare = "SELECT SUM(unit_price) AS totall FROM tbl_job_spare_used WHERE job_id = '{$row_detail['job_id']}'";
        $result_spare  = mysqli_query($connect_db, $sql_spare);
        $row_spare = mysqli_fetch_array($result_spare);


        $total_spare += $row_spare['totall'];

        $sql_income = "SELECT * FROM tbl_job_income WHERE job_id = '{$row_detail['job_id']}'";
        $result_income  = mysqli_query($connect_db, $sql_income);
        while ($row_income = mysqli_fetch_array($result_income)) {

            $income_total += $row_income['quantity'] * $row_income['income_amount'];
        }

        $service_total += $income_total;


        $sql_spare_q = "SELECT SUM(quantity) AS all_quantity FROM tbl_job_spare_used WHERE job_id = '{$row_detail['job_id']}'";
        $result_spare_q  = mysqli_query($connect_db, $sql_spare_q);
        $row_spare_q = mysqli_fetch_array($result_spare_q);

        $spare_quantity += $row_spare_q['all_quantity'];
    }
} else {

    $job_id = $row_spare_part['job_id'];

    $sql_spare = "SELECT SUM(unit_price) AS totall FROM tbl_job_spare_used WHERE job_id = '$job_id'";
    $result_spare  = mysqli_query($connect_db, $sql_spare);
    $row_spare = mysqli_fetch_array($result_spare);

    $total_spare = $row_spare['totall'];

    $sql_income = "SELECT * FROM tbl_job_income WHERE job_id = '$job_id'";
    $result_income  = mysqli_query($connect_db, $sql_income);
    while ($row_income = mysqli_fetch_array($result_income)) {

        $income_total += $row_income['quantity'] * $row_income['income_amount'];
    }

    $service_total = $income_total;



    $sql_spare_q = "SELECT SUM(quantity) AS all_quantity FROM tbl_job_spare_used WHERE job_id = '$job_id'";
    $result_spare_q  = mysqli_query($connect_db, $sql_spare_q);
    $row_spare_q = mysqli_fetch_array($result_spare_q);

    $spare_quantity = $row_spare_q['all_quantity'];
}

if ($result_del && $result_update) {
    $arr['result'] = 1;
    $arr['total_spare'] = number_format($total_spare);
    $arr['total_service'] = number_format($service_total);
    $arr['spare_quantity'] = number_format($spare_quantity);
} else {
    $arr['result'] = 0;
}

// // echo $sql_spare_q;
// if () {
//     $arr['result'] = 1;
//     $arr['total_spare'] = number_format($row_spare['total']);
//     $arr['td_total'] = number_format($service_total);
//     $arr['spare_quantity'] = number_format($row_spare_q['all_quantity']);
// } else {
//     $arr['result'] = 0;
// }

echo json_encode($arr);

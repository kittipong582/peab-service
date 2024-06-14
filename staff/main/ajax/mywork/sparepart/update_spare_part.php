<?php
session_start();
include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$create_user_id = $_SESSION['user_id'];
$branch_id = $_POST['branch_id'];
$job_id = $_POST['job_id'];
$spare_used_id = $_POST['spare_used_id'];
$insurance_type = $_POST['insurance_status'];
$spare_part = $_POST['spare_part'];
$quantity = $_POST['quantity'];
$cost = $_POST['cost'];

// // var_dump($_POST);
// if ($insurance_status == 0) {
//     $unit_price = $quantity * $cost;
// } else {
//     $unit_price = 0;
// }

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



$sql_old = "SELECT * FROM tbl_job_spare_used WHERE spare_used_id = '$spare_used_id'";
$result_old  = mysqli_query($connect_db, $sql_old);
$row_old = mysqli_fetch_array($result_old);

$sql_count = "SELECT * FROM tbl_branch_stock WHERE branch_id = '$branch_id' AND spare_part_id = '$spare_part'";
$result_stock  = mysqli_query($connect_db, $sql_count);
$row_count = mysqli_fetch_array($result_stock);

$stock = $row_count['remain_stock'] + $row_old['quantity'];


$sql_up_stock = "UPDATE tbl_branch_stock 
SET remain_stock = '$stock'
WHERE branch_id = '$branch_id' AND spare_part_id = '$spare_part'";
$rs_up_stock = mysqli_query($connect_db, $sql_up_stock);

if ($rs_up_stock) {

    $sql_count = "SELECT * FROM tbl_branch_stock WHERE branch_id = '$branch_id' AND spare_part_id = '$spare_part'";
    $result_stock  = mysqli_query($connect_db, $sql_count);
    $row_count = mysqli_fetch_array($result_stock);

    if ($row_count['remain_stock'] > 0 &&  $row_count['remain_stock'] >= $quantity) {



        $sql_service = "UPDATE tbl_job_spare_used
                SET  
                    spare_part_id = '$spare_part'
                    ,create_user_id = '$create_user_id'
                    ,job_id = '$job_id'
                    , insurance_status = '$insurance_status'
                    ,quantity = '$quantity'
                    ,unit_price = '$unit_price'
                    ,insurance_type = '$insurance_type'
                    WHERE spare_used_id = '$spare_used_id'
                ";

        $rs_service = mysqli_query($connect_db, $sql_service) or die($connect_db->error);




        $sql_stock = "SELECT * FROM tbl_branch_stock WHERE branch_id = '$branch_id' AND spare_part_id = '$spare_part'";
        $result_stock  = mysqli_query($connect_db, $sql_stock);
        $row_stock = mysqli_fetch_array($result_stock);

        $remain = $row_stock['remain_stock'] - $quantity;

        $sql_update = "UPDATE tbl_branch_stock
                SET  remain_stock = '$remain'
                WHERE branch_id = '$branch_id' AND spare_part_id = '$spare_part'

                ";

        $rs_update = mysqli_query($connect_db, $sql_update) or die($connect_db->error);

        // echo $sql_update;
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

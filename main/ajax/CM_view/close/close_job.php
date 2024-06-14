<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$close_user_id = $_SESSION['user_id'];
$close_datetime = date("Y-m-d H:i", strtotime("NOW"));
$job_id = $_POST['job_id'];
$close_note = $_POST['close_note'];

$sql_job = "SELECT a.job_type,b.customer_branch_id FROM tbl_job a 
LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id
WHERE a.job_id = '$job_id'";
$result_job  = mysqli_query($connect_db, $sql_job);
$row_job = mysqli_fetch_array($result_job);
$new_branch = $row_job['customer_branch_id'];


if ($row_job['job_type'] == 3) {

    $sql_product = "SELECT a.*,b.current_branch_id FROM tbl_in_product a
     LEFT JOIN tbl_product b ON a.product_id = b.product_id
     WHERE a.job_id = '$job_id'";
    $result_product  = mysqli_query($connect_db, $sql_product);
    $i = 0;
    while ($row_product = mysqli_fetch_array($result_product)) {

        $product_id = $row_product['product_id'];
        $old_branch = $row_product['current_branch_id'];
        if ($new_branch != $old_branch) {

            $update_product = "UPDATE tbl_product 
            SET current_branch_id = '$new_branch'
            WHERE product_id = '$product_id'";
            $rs_product = mysqli_query($connect_db, $update_product);


            $transfer_id = getRandomID(10, 'tbl_product_transfer', 'transfer_id');

            $sql3 = "INSERT INTO tbl_product_transfer
            SET  transfer_id = '$transfer_id'   
            ,from_branch_id = '$old_branch'
            ,create_datetime = '$close_datetime'
            ,to_branch_id = '$new_branch'
            ,create_user_id = '$close_user_id'
            ,product_id = '$product_id'
            ";
            $rs3 = mysqli_query($connect_db, $sql3) or die($connect_db->error);
        }
    }
}


$sql_update = "UPDATE tbl_job
        SET  close_user_id = '$close_user_id'
        ,close_datetime	= '$close_datetime'
        ,close_note = '$close_note'
        WHERE job_id = '$job_id'";

$rs_update = mysqli_query($connect_db, $sql_update) or die($connect_db->error);



if ($row_job['job_type'] == 2) {
    $chk_row = 0;
    $sql_pm_detail = "SELECT job_id,group_pm_id FROM tbl_group_pm_detail WHERE group_pm_id in(SELECT group_pm_id FROM tbl_group_pm_detail WHERE job_id = '$job_id')";
    $result_pm_detail  = mysqli_query($connect_db, $sql_pm_detail);
    $num_pm_detail = mysqli_num_rows($result_pm_detail);

    if ($num_pm_detail > 0) {

        while ($row_pm_detail = mysqli_fetch_array($result_pm_detail)) {

            $sql_update = "UPDATE tbl_job
        SET  close_user_id = '$close_user_id'
        ,close_datetime	= '$close_datetime'
        ,close_note = '$close_note'
        WHERE job_id = '{$row_pm_detail['job_id']}'";

            $rs_update = mysqli_query($connect_db, $sql_update) or die($connect_db->error);

            $chk_row++;
            $group_pm_id = $row_pm_detail['group_pm_id'];
        }
    }


    if ($num_pm_detail == $chk_row) {


        $sql_group_update = "UPDATE tbl_group_pm SET
    close_user_id = '$close_user_id'
    ,close_datetime = '$close_datetime'
    WHERE group_pm_id = '$group_pm_id'";

        $rs_group_update = mysqli_query($connect_db, $sql_group_update) or die($connect_db->error);
    }
}


if ($rs_update) {

    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

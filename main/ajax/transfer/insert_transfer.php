<?php
session_start(); 
include("../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$transfer_id = mysqli_real_escape_string($connection, $_POST['transfer_id']);
$from_branch = mysqli_real_escape_string($connection, $_POST['from_branch']);
$to_branch = mysqli_real_escape_string($connection, $_POST['to_branch']);
$ax_ref_no = mysqli_real_escape_string($connection, $_POST['ax_ref_no']);
$remark = mysqli_real_escape_string($connection, $_POST['remark']);

$ax_withdraw_date = $_POST['withdraw_date'];
$ax_withdraw_date = str_replace('/', '-', $withdraw_date);
$ax_withdraw_date = date('Y-m-d', strtotime($withdraw_date));

$create_user_id = $_SESSION['user_id'];

// 6504xxxxx
$year = date('y')+43;
$month = date('m');
$job_ex = $year.$month;

$sql_conut = "SELECT count(*) as count1 FROM tbl_transfer WHERE transfer_no LIKE '%$job_ex%'";
$rs_conut  = mysqli_query($connection, $sql_conut) or die($connection->error);
$row_conut = mysqli_fetch_assoc($rs_conut);
//  echo $sql_conut;
 
 $count_no = $row_conut['count1'] + 1;
 $transfer_no = "TF".$year.$month.str_pad($count_no, 4,"0",STR_PAD_LEFT);
// echo  $count_no;


$sql = "INSERT INTO tbl_transfer
SET   transfer_id = '$transfer_id'
    ,transfer_no = '$transfer_no'
    ,create_user_id  = '$create_user_id'
    ,from_branch_id  = '$from_branch'
    ,to_branch_id  = '$to_branch'
    ,ax_ref_no  = '$ax_ref_no'
    ,ax_withdraw_date  = '$ax_withdraw_date'
    ,note = '$remark'
    ;";
$rs = mysqli_query($connection, $sql) or die($connection->error);


$i = 1;
foreach ($_POST['ax'] as $key => $value) {
    $temp_array_u[$i]['ax'] = $value;
    $i++;
}

$i = 1;
foreach ($_POST['quantity'] as $key => $value) {
    $temp_array_u[$i]['quantity'] = $value;
    $i++;
}

for ($a = 1; $a < $i; $a++) {

    $ax = $temp_array_u[$a]['ax'];
    $quantity = $temp_array_u[$a]['quantity'];


    $sql_detail = "INSERT INTO tbl_transfer_detail
                SET  transfer_id = '$transfer_id'
                    ,spare_part_id = '$ax'
                    , quantity = '$quantity'
                    , list_order = '$a'
                ";

    $rs_detail = mysqli_query($connection, $sql_detail) or die($connection->error);
    

    $sql_us = "SELECT remain_stock FROM tbl_branch_stock WHERE branch_id = '$from_branch' AND spare_part_id = '$ax' ;";
    $rs_us  = mysqli_query($connection, $sql_us) or die($connection->error);
    $row_us = mysqli_fetch_assoc($rs_us);

    $from_remain = $row_us['remain_stock'] - $quantity ;

    $sql_user_stock = "UPDATE tbl_branch_stock
                SET remain_stock  = '$from_remain'
                WHERE spare_part_id = '$ax' AND branch_id = '$from_branch'
                ;";
    $rs_user_stock = mysqli_query($connection, $sql_user_stock) or die($connection->error);

}

if ($rs && $rs_detail && $rs_user_stock) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}


echo json_encode($arr);
<?php
include('../../config/main_function.php');
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$sql = "SELECT 
b.customer_branch_id
FROM tbl_customer_branch b 
WHERE b.active_status = '1' AND (b.branch_code LIKE 'CC%' 
    OR b.branch_code LIKE 'SC%' 
    OR b.branch_code LIKE 'SD%' 
    OR b.branch_code LIKE 'RM%' 
    OR b.branch_code LIKE 'JM%' 
    OR b.branch_code LIKE 'DD%' 
    OR b.branch_code LIKE 'CD%'
    OR b.branch_code = 'C1100737' 
    OR b.branch_code = 'C1100738');";
$res = mysqli_query($connection, $sql);
echo $num = mysqli_num_rows($res);

while ($row = mysqli_fetch_assoc($res)) {
    $ptt_branch_id = getRandomID(10,'tbl_ptt_customer_branch','ptt_branch_id');

    echo $sql_ins = "INSERT INTO `tbl_ptt_customer_branch` SET 
    `ptt_branch_id` = '$ptt_branch_id'
    , `customer_branch_id` = '{$row['customer_branch_id']}' ";
    $res_ins = mysqli_query($connection, $sql_ins);

}
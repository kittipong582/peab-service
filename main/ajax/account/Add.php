<?php
session_start();
include("../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$account_id = getRandomID(10, 'tbl_account', 'account_id');
$bank_id = $_POST['bank_id'];
$account_no = mysqli_real_escape_string($connection, $_POST['account_no']);
$account_name = mysqli_real_escape_string($connection, $_POST['account_name']);
$bank_branch_name = mysqli_real_escape_string($connection, $_POST['bank_branch_name']);
$account_type = mysqli_real_escape_string($connection, $_POST['account_type']);


$sql_insert = "INSERT INTO tbl_account SET 
            account_id = '$account_id',
            bank_id = '$bank_id', 
            account_no = '$account_no', 
            account_name = '$account_name', 
            bank_branch_name = '$bank_branch_name',
            account_type = '$account_type'

           ";
$insert = mysqli_query($connection, $sql_insert);

if ($insert) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

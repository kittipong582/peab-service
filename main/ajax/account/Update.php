<?php 

include("../../../config/main_function.php");

$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

    $account_id = mysqli_real_escape_string($connection, $_POST['account_id']);
    $bank_id = mysqli_real_escape_string($connection, $_POST['bank_id']);
    $account_no = mysqli_real_escape_string($connection, $_POST['account_no']);
    $account_name = mysqli_real_escape_string($connection, $_POST['account_name']);
    $bank_branch_name = mysqli_real_escape_string($connection, $_POST['bank_branch_name']);
    $account_type = mysqli_real_escape_string($connection, $_POST['account_type']);


$sql_update = "UPDATE tbl_account SET 
bank_id = '$bank_id',
account_no = '$account_no',
account_name = '$account_name',
bank_branch_name = '$bank_branch_name',
account_type = '$account_type'
WHERE account_id = '$account_id'";

$rs_update = mysqli_query($connection,$sql_update);

if ($rs_update) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

?>
<?php
    session_start();
    include("../../../config/main_function.php");
    date_default_timezone_set("Asia/Bangkok");

    $secure = "LM=VjfQ{6rsm&/h`";
    $connection = connectDB($secure);

    $account_id = getRandomID(10, 'tbl_account', 'account_id');
    $bank_name = mysqli_real_escape_string($connection, $_POST['bank_name']);
    $account_no = mysqli_real_escape_string($connection, $_POST['account_no']);
    $account_name = mysqli_real_escape_string($connection, $_POST['account_name']);
    $bank_branch_name = mysqli_real_escape_string($connection, $_POST['bank_branch_name']);


    if ($connection) {

        $sql_update = "UPDATE tbl_account SET 
        bank_name = '$bank_name',
        account_no = '$account_no', 
        account_name = '$account_name' 
        bank_branch_name = '$bank_branch_name' 
            WHERE account_id = '$account_id'";
        $update = mysqli_query($connection,$sql_update);
        if($update){
            $result = 1;
        }else{
            $result = 0;
        }
    } else {
        $result = 0;
    }
    $arr['result'] = $result;
    echo json_encode($arr);

    mysqli_close($connection);
?>
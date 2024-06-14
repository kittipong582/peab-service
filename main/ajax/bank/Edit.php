<?php
    session_start();
    include("../../../config/main_function.php");
    date_default_timezone_set("Asia/Bangkok");

    $secure = "LM=VjfQ{6rsm&/h`";
    $connection = connectDB($secure);

    $bank_id = mysqli_real_escape_string($connection, $_POST['bank_id']);
    $bank_name = mysqli_real_escape_string($connection, $_POST['bank_name']);
   
    // $datetime = date('Y-m-d H:i:s');

    if ($connection) {

        $sql_update = "UPDATE tbl_bank SET 
         bank_id = '$bank_id',
         bank_name = '$bank_name', 
         WHERE bank_id = '$bank_id'";

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
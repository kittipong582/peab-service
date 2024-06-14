<?php
    session_start();
    include("../../../config/main_function.php");
    date_default_timezone_set("Asia/Bangkok");

    $secure = "LM=VjfQ{6rsm&/h`";
    $connection = connectDB($secure);

    $expend_type_name = mysqli_real_escape_string($connection, $_POST['expend_type_name']);
    $description = mysqli_real_escape_string($connection, $_POST['description']);
    $expend_code = mysqli_real_escape_string($connection, $_POST['expend_code']);


    $datetime = date('Y-m-d H:i:s');

    if ($connection) {

        $sql_insert = "INSERT INTO tbl_expend_type SET 
            expend_type_name = '$expend_type_name', 
            description = '$description', 
            expend_code = '$expend_code',   
            active_status = '1' ";
        $insert = mysqli_query($connection, $sql_insert);
        if($insert){
            $result = 1;
        }else{
            $result = 0;
        }
    } else {
        $result = 0;
    }

    mysqli_close($connection);
    $arr['result'] = $result;
    echo json_encode($arr);
?>
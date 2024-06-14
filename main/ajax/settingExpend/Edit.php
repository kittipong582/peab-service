<?php
    session_start();
    include("../../../config/main_function.php");
    date_default_timezone_set("Asia/Bangkok");

    $secure = "LM=VjfQ{6rsm&/h`";
    $connection = connectDB($secure);

    $expend_type_id = mysqli_real_escape_string($connection, $_POST['expend_type_id']);
    $expend_type_name = mysqli_real_escape_string($connection, $_POST['expend_type_name']);
    $description = mysqli_real_escape_string($connection, $_POST['description']);

    $datetime = date('Y-m-d H:i:s');

    if ($connection) {

        $sql_update = "UPDATE tbl_expend_type SET 
        expend_type_id = '$expend_type_id',
            expend_type_name = '$expend_type_name', 
            description = '$description' 
            WHERE expend_type_id = '$expend_type_id'";
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
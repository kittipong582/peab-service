<?php
    session_start();
    include("../../../config/main_function.php");
    date_default_timezone_set("Asia/Bangkok");

    $secure = "LM=VjfQ{6rsm&/h`";
    $connection = connectDB($secure);

    $user_id = $_SESSION['user_id'];

    $line_active = mysqli_real_escape_string($connection, $_POST['line_active']);
    $line_token = mysqli_real_escape_string($connection, $_POST['line_token']);

    if($line_active == "1"){
        $temp_line = "line_active = '1', line_token = '$line_token' ";
    }else{
        $temp_line = "line_active = '0', line_token = '' ";
    }

    if ($connection) {

        $sql_edit = "UPDATE tbl_user SET 
            $temp_line
            WHERE user_id = '$user_id'";
        $edit = mysqli_query($connection,$sql_edit);
        if($edit){
            $result = 1;
        }else{
            $result = 0;
        }

    } else {
        $result = 0;
    }

    $arr['result'] = $result;
    echo json_encode($arr);
?>
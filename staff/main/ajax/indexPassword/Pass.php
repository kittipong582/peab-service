<?php
    session_start();
    include("../../../config/main_function.php");
    date_default_timezone_set("Asia/Bangkok");

    $secure = "LM=VjfQ{6rsm&/h`";
    $connection = connectDB($secure);

    $user_id = $_SESSION['user_id'];

    $old_pass = mysqli_real_escape_string($connection, $_POST['old_pass']);
    $new_pass = mysqli_real_escape_string($connection, $_POST['new_pass']);
    $confirm_pass = mysqli_real_escape_string($connection, $_POST['confirm_pass']);

    if ($connection) {

        $sql = "SELECT u.*
            FROM tbl_user u
            WHERE u.user_id = '$user_id'";
        $rs = mysqli_query($connection, $sql);
        $row = mysqli_fetch_array($rs);

        $old_pass = md5($old_pass);
        $old_pass = stringInsert($old_pass,$row['secure_text'],$row['secure_pointer']);

        if($old_pass == $row['password']){
            $secure_text = randomCode(5);
            $secure_pointer = rand(1,15);
            $confirm_pass = md5($confirm_pass);
            $confirm_pass = stringInsert($confirm_pass,$secure_text,$secure_pointer);

            $sql_edit = "UPDATE tbl_user SET 
                password = '$confirm_pass', 
                secure_text = '$secure_text', 
                secure_pointer = '$secure_pointer' 
                WHERE user_id = '$user_id'";
            $edit = mysqli_query($connection,$sql_edit);
            if($edit){
                $result = 1;
            } else {
                $result = 0;
            }
        } else {
            $result = 0;
        }
    } else {
        $result = 0;
    }

    $arr['result'] = $result;
    echo json_encode($arr);
?>
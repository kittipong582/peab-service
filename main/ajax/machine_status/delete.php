<?php
    session_start();
    include("../../../config/main_function.php");
    $connection = connectDB("LM=VjfQ{6rsm&/h`");

    $status_id =  mysqli_real_escape_string($connection, $_POST['status_id']);

    if($connection){

    $sql_delete = "DELETE FROM tbl_machine_status WHERE status_id  = '$status_id'";

    $res_delete = mysqli_query($connection, $sql_delete)  or die($connection->error);

        if($res_delete){
            $arr['result'] = 1;
        }else{
            $arr['result'] = 0;
        }
    }else{
    $arr['result'] = 9;
    }

mysqli_close($connection);
echo json_encode($arr);
?>
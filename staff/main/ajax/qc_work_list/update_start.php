 <?php
    session_start();
    include ("../../../../config/main_function.php");
    $connection = connectDB("LM=VjfQ{6rsm&/h`"); 

    $job_qc_id =  mysqli_real_escape_string($connection, $_POST['job_qc_id']);
    $start_qc = date("Y-m-d H:i:s");;

    if($connection){

    $sql_update = "UPDATE tbl_job_qc SET  
        start_qc = '$start_qc' 
        WHERE job_qc_id = '$job_qc_id'";

    $res_update = mysqli_query($connection, $sql_update)  or die($connection->error);

        if($res_update){
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
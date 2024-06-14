 <?php
    session_start();
    @include("../../../../config/main_function.php");
    $connect_db = connectDB("LM=VjfQ{6rsm&/h`");

    $job_id =  mysqli_real_escape_string($connect_db, $_POST['job_id']);
    $total_score =  mysqli_real_escape_string($connect_db, $_POST['sum_score']);
    $close_audit =  mysqli_real_escape_string($connect_db, $_POST['close_audit']);

    if ($connect_db) {

        $sql_update = "UPDATE tbl_job_audit SET  
        total_score = '$total_score',
        close_audit = '$close_audit'
        WHERE job_id = '$job_id'";

        $res_update = mysqli_query($connect_db, $sql_update)  or die($connect_db->error);

        if ($res_update) {
            $arr['result'] = 1;
        } else {
            $arr['result'] = 0;
        }
    } else {
        $arr['result'] = 9;
    }

    mysqli_close($connect_db);
    echo json_encode($arr);
    ?>
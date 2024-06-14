<?php
    session_start();
    @include("../../../../config/main_function.php");
    $connect_db = connectDB("LM=VjfQ{6rsm&/h`");

    $job_id =  mysqli_real_escape_string($connect_db, $_POST['job_id']);
    $total_score =  mysqli_real_escape_string($connect_db, $_POST['sum_score']);
    $close_qc =  mysqli_real_escape_string($connect_db, $_POST['close_qc']);
    $remark = mysqli_real_escape_string($connect_db, $_POST['remark']);

    if ($connect_db) {

        $sql_update = "UPDATE tbl_job_qc SET  
        total_score = '$total_score',
        remark = '$remark',
        close_qc = '$close_qc'
        WHERE job_qc_id = '$job_id'";

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
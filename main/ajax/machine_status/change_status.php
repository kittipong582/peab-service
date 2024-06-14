<?php
    session_start();
    include("../../../config/main_function.php");
    $connection = connectDB("LM=VjfQ{6rsm&/h`");

    $status_id  = mysqli_real_escape_string($connection, $_POST['status_id']);

    $sql = "SELECT * FROM tbl_machine_status WHERE status_id  = '$status_id'";
    $rs = mysqli_query($connection, $sql) or die($connection->error);
    $row = mysqli_fetch_array($rs);

    // echo $sql;

    if ($row['active_status'] == "1") {
        $new_status = "0";
    } else {
        $new_status = "1";
    }

    $arr['status'] = $new_status;

    $sql2 = "UPDATE tbl_machine_status SET 
            active_status = '$new_status'
            WHERE  status_id  = '$status_id'";

    $rs2 = mysqli_query($connection, $sql2) or die($connection->error);

    if ($rs2) {
        $arr['result'] = 1;
    } else {
        $arr['result'] = 0;
    }
    echo json_encode($arr);
    ?>
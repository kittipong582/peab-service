<?php
    session_start();
    include("../../../config/main_function.php");
    $connection = connectDB("LM=VjfQ{6rsm&/h`");

    $audit_id = mysqli_real_escape_string($connection, $_POST['audit_id']);

    $sql = "SELECT * FROM tbl_audit_form WHERE audit_id = '$audit_id'";
    $rs = mysqli_query($connection, $sql) or die($connection->error);
    $row = mysqli_fetch_array($rs);

    // echo $sql;

    if ($row['active_status'] == "1") {
        $new_status = "0";
    } else {
        $new_status = "1";
    }

    $arr['status'] = $new_status;

    $sql2 = "UPDATE tbl_audit_form SET 
            active_status = '$new_status'
            WHERE  audit_id = '$audit_id'";

    $rs2 = mysqli_query($connection, $sql2) or die($connection->error);

    if ($rs2) {
        $arr['result'] = 1;
    } else {
        $arr['result'] = 0;
    }
    echo json_encode($arr);
    ?>
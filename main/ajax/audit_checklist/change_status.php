 <?php
    session_start();
    include("../../../config/main_function.php");
    $connection = connectDB("LM=VjfQ{6rsm&/h`");

    $topic_id = mysqli_real_escape_string($connection, $_POST['topic_id']);

    $sql = "SELECT active_status FROM tbl_audit_topic WHERE topic_id = '$topic_id'";
    $rs = mysqli_query($connection, $sql) or die($connection->error);
    $row = mysqli_fetch_array($rs);

    // echo $sql;

    if ($row['active_status'] == "1") {
        $new_status = "0";
    } else {
        $new_status = "1";
    }

    $arr['status'] = $new_status;

    $sql2 = "UPDATE tbl_audit_topic SET 
            active_status = '$new_status'
            WHERE  topic_id = '$topic_id'";

    $rs2 = mysqli_query($connection, $sql2) or die($connection->error);

    if ($rs2) {
        $arr['result'] = 1;
    } else {
        $arr['result'] = 0;
    }
    echo json_encode($arr);
    ?>
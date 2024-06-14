 <?php
    session_start();
    include("../../../config/main_function.php");
    $connection = connectDB("LM=VjfQ{6rsm&/h`");

    $topic_qc_id  = getRandomID2(10, 'tbl_qc_topic', 'topic_qc_id');
    // $audit_id = $_POST['audit_id'];
    $topic_detail = mysqli_real_escape_string($connection, $_POST['topic_detail']);
    $qc_id = mysqli_real_escape_string($connection, $_POST['qc_id']);

    if ($connection) {

        $sql_insert = "INSERT INTO tbl_qc_topic SET    
        topic_qc_id = '$topic_qc_id',
        qc_id = '$qc_id',
        topic_detail = '$topic_detail'";
        $res_insert = mysqli_query($connection, $sql_insert)  or die($connection->error);

        if ($res_insert) {
            $arr['result'] = 1;
        } else {
            $arr['result'] = 0;
        }
    } else {
        $arr['result'] = 9;
    }

    mysqli_close($connection);
    echo json_encode($arr);
    ?>
 <?php
    session_start();
    include("../../../config/main_function.php");
    $connection = connectDB("LM=VjfQ{6rsm&/h`");

    $topic_detail =  mysqli_real_escape_string($connection, $_POST['topic_detail']);
    $topic_qc_id =  mysqli_real_escape_string($connection, $_POST['topic_qc_id']);

    if ($connection) {

        $sql_update = "UPDATE tbl_qc_topic  SET  
        topic_detail = '$topic_detail' 
        WHERE topic_qc_id = '$topic_qc_id'";

        $res_update = mysqli_query($connection, $sql_update)  or die($connection->error);

        if ($res_update) {
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
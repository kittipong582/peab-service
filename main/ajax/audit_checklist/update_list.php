 <?php
    session_start();
    include("../../../config/main_function.php");
    $connection = connectDB("LM=VjfQ{6rsm&/h`");

    $update_topic_datail =  mysqli_real_escape_string($connection, $_POST['update_topic_datail']);
    $topic_id =  mysqli_real_escape_string($connection, $_POST['topic_id']);

    if ($connection) {

        $sql_update = "UPDATE tbl_audit_topic  SET  
        topic_datail = '$update_topic_datail' 
        WHERE topic_id = '$topic_id'";

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
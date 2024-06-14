 <?php
    session_start();
    include("../../../config/main_function.php");
    $connection = connectDB("LM=VjfQ{6rsm&/h`");

    $topic_id  = getRandomID2(10, 'tbl_audit_topic', 'topic_id');
    $audit_id = $_POST['audit_id'];
    $topic_datail = mysqli_real_escape_string($connection, $_POST['topic_datail']);

    if ($connection) {

        $sql_insert = "INSERT INTO tbl_audit_topic SET    
        topic_id = '$topic_id',
        audit_id = '$audit_id',
        topic_datail = '$topic_datail'";
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
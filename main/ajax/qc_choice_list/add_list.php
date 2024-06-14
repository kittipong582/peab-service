 <?php
    session_start();
    include("../../../config/main_function.php");
    $connection = connectDB("LM=VjfQ{6rsm&/h`");

    $subtopic_id  = mysqli_real_escape_string($connection, $_POST['subtopic_id']);
    $topic_id = mysqli_real_escape_string($connection, $_POST['topic_id']);
    $subtopic_detail = mysqli_real_escape_string($connection, $_POST['subtopic_detail']);
    $choice_type = mysqli_real_escape_string($connection, $_POST['choice_type']);

    if ($connection) {

        $sql_insert = "INSERT INTO tbl_qc_subtopic SET  
        subtopic_id = '$subtopic_id',
        topic_id = '$topic_id',
        subtopic_detail = '$subtopic_detail'";

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
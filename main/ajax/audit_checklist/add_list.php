 <?php
    session_start();
    include("../../../config/main_function.php");
    $connection = connectDB("LM=VjfQ{6rsm&/h`");

    $topic_id  = getRandomID2(10, 'tbl_audit_topic', 'topic_id');
    $audit_id = $_POST['audit_id'];
    $topic_datail = mysqli_real_escape_string($connection, $_POST['topic_datail']);

    if ($connection) {

        $sql = "SELECT MAX(list_order) AS Max_listorder FROM tbl_audit_topic WHERE audit_id = '$audit_id'";
        $res = mysqli_query($connection, $sql);
        $row = mysqli_fetch_assoc($res);
    
        if ($row >= 1) {
            $list_order = $row['Max_listorder'] + 1;
        } else {
            $list_order = 1;
        }

        $sql_insert = "INSERT INTO tbl_audit_topic SET    
        topic_id = '$topic_id',
        audit_id = '$audit_id',
        topic_datail = '$topic_datail',
        list_order = '$list_order'";
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
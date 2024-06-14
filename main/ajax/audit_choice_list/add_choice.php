<?php
session_start();
include("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

$arr = array();


if ($connection) {
    $checklist_id = getRandomID2(10, 'tbl_audit_checklist', 'checklist_id');
    $checklist_name = mysqli_real_escape_string($connection, $_POST['checklist_name']);
    $description = mysqli_real_escape_string($connection, $_POST['description']);
    $data = mysqli_real_escape_string($connection, $_POST['data']);
    $topic_id  = $_POST['topic_id'];

    $i = 1;
    foreach ($_POST['score_name'] as $key => $value) {
        $temp_array[$i]['score_name'] = $value;
        $i++;
    }

    $i = 1;
    foreach ($_POST['score'] as $key => $value) {
        $temp_array[$i]['score'] = $value;
        $i++;
    }



    $sql = "SELECT MAX(list_order) AS Max_listorder FROM tbl_audit_checklist WHERE topic_id = '$topic_id'";
    $res = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($res);

    if ($row >= 1) {
        $list_order = $row['Max_listorder'] + 1;
    } else {
        $list_order = 1;
    }


    $sql_insert = "INSERT INTO tbl_audit_checklist SET 
    checklist_id = '$checklist_id',
    checklist_name = '$checklist_name',
    list_order = '$list_order',
    topic_id = '$topic_id',
    description = '$description'";
    $res_insert = mysqli_query($connection, $sql_insert);

    if ($res_insert) {

        for ($a = 1; $a < $i; $a++) {
            $score_name = $temp_array[$a]['score_name'];
            $score = $temp_array[$a]['score'];
            $score_id = getRandomID2(10, 'tbl_audit_score', 'score_id');

            $sql = "SELECT * FROM tbl_audit_score WHERE checklist_id = '$checklist_id'";
            $res = mysqli_query($connection, $sql);
            $row = mysqli_num_rows($res);

            if ($row > 0) {
                $list_order = $row + 1;
            } else {
                $list_order = 1;
            }

            $sql_insert_score = "INSERT INTO tbl_audit_score SET 
            score_id = '$score_id',
            checklist_id = '$checklist_id',
            score_name = '$score_name',
            score = '$score',
            list_order = '$list_order'";
            $res_insert_score = mysqli_query($connection, $sql_insert_score);
            // mysqli_query($connection, $sql_insert_score);

        }


        $arr['result'] = 1;


        if (!$res_insert_score) {
            $arr['result'] = 0;
        }
    } else {
        // $arr['result'] = 0;
    }
} else {
    $arr['result'] = 9;
}

mysqli_close($connection);
echo json_encode($arr);
?>
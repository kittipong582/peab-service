<?php
session_start();
include("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

$arr = array();


if ($connection) {
    // $checklist_id = getRandomID2(10, 'tbl_audit_checklist', 'checklist_id');
    $checklist_id = $_POST['checklist_id'];
    $checklist_name = mysqli_real_escape_string($connection, $_POST['checklist_name']);
    $description = mysqli_real_escape_string($connection, $_POST['description']);
    $topic_id = $_POST['topic_id'];

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
   $sql_insert = "UPDATE tbl_qc_checklist SET 

    checklist_name = '$checklist_name',
    checklist_id = '$checklist_id',
    description = '$description'
    WHERE topic_id = '$topic_id'";
    $res_insert = mysqli_query($connection, $sql_insert);

    if ($res_insert) {

        $sql_delete = "DELETE FROM tbl_qc_score WHERE checklist_id = '$checklist_id'";
        $res_delete = mysqli_query($connection, $sql_delete) or die($connection->error);

        $arr['result'] = 1;


        for ($a = 1; $a < $i; $a++) {
            $score_name = $temp_array[$a]['score_name'];
            $score = $temp_array[$a]['score'];
            $score_id = getRandomID2(10, 'tbl_qc_score', 'score_id');



            $sql = "SELECT * FROM tbl_qc_score WHERE checklist_id = '$checklist_id'";
            $res = mysqli_query($connection, $sql);
            $row = mysqli_num_rows($res);

            if ($row > 0) {
                $list_order = $row + 1;
            } else {
                $list_order = 1;
            }


            $sql_insert_score = "INSERT INTO tbl_qc_score SET 
            score_id = '$score_id',
            checklist_id = '$checklist_id',
            score_name = '$score_name',
            score = '$score',
            list_order = '$list_order'";
            $res_insert_score = mysqli_query($connection, $sql_insert_score);
            // mysqli_query($connection, $sql_insert_score);

        }




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
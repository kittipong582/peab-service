<?php
session_start();
include ("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");



$checklist_id = mysqli_real_escape_string($connection, $_POST['checklist_id']);
$checklist_name = mysqli_real_escape_string($connection, $_POST['checklist_name']);
$checklist_type = mysqli_real_escape_string($connection, $_POST['checklist_type']);
$topic_qc_id = mysqli_real_escape_string($connection, $_POST['topic_qc_id']);
$description = mysqli_real_escape_string($connection, $_POST['description']);
$description_way = mysqli_real_escape_string($connection, $_POST['description_way']);
$description_acceptance = mysqli_real_escape_string($connection, $_POST['description_acceptance']);
$description_time = mysqli_real_escape_string($connection, $_POST['description_time']);


// $sql = "SELECT * FROM tbl_qc_checklist";
// $res = mysqli_query($connection, $sql);
// $row = mysqli_num_rows($res);

// if ($row >= 1) {
//     $list_order = $row + 1;
// } else {
//     $list_order = 1;
// }

$sql = "SELECT MAX(list_order) AS Max_listorder FROM tbl_qc_checklist WHERE topic_qc_id = '$topic_qc_id'";
$res = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($res);

if ($row >= 1) {
    $list_order = $row['Max_listorder'] + 1;
} else {
    $list_order = 1;
}



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


if ($connection) {

        $sql_insert = "INSERT INTO tbl_qc_checklist SET  
        checklist_id = '$checklist_id',
        topic_qc_id = '$topic_qc_id',
        list_order = '$list_order',
        description = '$description',
        description_way = '$description_way',
        description_acceptance = '$description_acceptance',
        description_time = '$description_time',
        checklist_name = '$checklist_name',
        checklist_type = '$checklist_type'";

    $res_insert = mysqli_query($connection, $sql_insert) or die ($connection->error);

    if ($res_insert) {


        for ($a = 1; $a < $i; $a++) {
            $score_name = $temp_array[$a]['score_name'];
            $score = $temp_array[$a]['score'];
            $score_id = getRandomID2(10, 'tbl_audit_score', 'score_id');

            $sql_score = "SELECT * FROM tbl_qc_score WHERE checklist_id = '$checklist_id'";
            $res_score = mysqli_query($connection, $sql_score);
            $row_score = mysqli_num_rows($res_score);

            if ($row_score > 0) {
                $list_order = $row_score + 1;
            } else {
                $list_order = 1;
            }


            $sql_insert_score = "INSERT INTO tbl_qc_score SET 
            score_id = '$score_id',
            checklist_id = '$checklist_id',
            score_name = '$score_name',
            score = '$score',
            list_order = '$list_order'";

            $res_insert_score = mysqli_query($connection, $sql_insert_score) or die ($connection->error);
        }
    }

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
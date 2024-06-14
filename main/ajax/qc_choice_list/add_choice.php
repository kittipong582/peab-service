<?php
session_start();
include ("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

$checklist_id = getRandomID2(10, 'tbl_qc_checklist', 'checklist_id');
$checklist_name = mysqli_real_escape_string($connection, $_POST['checklist_name']);
$description = mysqli_real_escape_string($connection, $_POST['description']);
$checklist_type = mysqli_real_escape_string($connection, $_POST['checklist_type']);
$topic_id = mysqli_real_escape_string($connection, $_POST['topic_id']);

if ($connection) {

    $sql = "SELECT * FROM tbl_qc_checklist";
    $res = mysqli_query($connection, $sql);
    $row = mysqli_num_rows($res);

    if ($row >= 1) {
        $list_order = $row + 1;
    } else {
        $list_order = 1;
    }

    $sql_insert = "INSERT INTO tbl_qc_checklist SET 
        checklist_id = '$checklist_id',
        checklist_type = '$checklist_type',
        checklist_name = '$checklist_name',
        list_order = '$list_order',
        topic_id = '$topic_id',
        description = '$description'";

    $res_insert = mysqli_query($connection, $sql_insert) or die ($connection->error);

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
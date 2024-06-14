<?php
session_start();
include ("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");


$sql = "SELECT frm.qc_id , top.topic_qc_id , chk.checklist_id , chk.checklist_name , chk.list_order FROM tbl_qc_form frm JOIN tbl_qc_topic top ON frm.qc_id = top.qc_id JOIN tbl_qc_checklist chk ON top.topic_qc_id = chk.topic_qc_id WHERE frm.qc_id ='5470660858' ORDER BY frm.create_datetime ASC , top.create_datetime ASC , chk.create_datetime ASC;";
$res = mysqli_query($connection, $sql);

$list = 1;
while ($row = mysqli_fetch_assoc($res)) {

    $sql_list = "SELECT MAX(list_order) AS Max_listorder FROM tbl_qc_checklist WHERE topic_qc_id = '{$row['topic_qc_id']}' AND checklist_id = '{$row['checklist_id']}'";
    $res_list = mysqli_query($connection, $sql_list);
    $row_list = mysqli_fetch_assoc($res_list);

    if ($row_list >= 1) {
        $list_order = $row_list['Max_listorder'] + 1;
    } else {
        $list_order = 1;
    }
    echo $list_order;
    echo "<pre>";
    var_dump($sql_list);
    echo "</pre>";

    echo$sql_update = "UPDATE tbl_qc_checklist SET  
        list_order = '$list'
       WHERE topic_qc_id = '{$row['topic_qc_id']}' AND checklist_id = '{$row['checklist_id']}'";
    $res_update = mysqli_query($connection, $sql_update) or die($connection->error);

    $list++;
}

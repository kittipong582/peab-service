<?php
session_start();
include("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

$checklist_id = mysqli_real_escape_string($connection, $_POST['checklist_id']);
$topic_id = mysqli_real_escape_string($connection, $_POST['topic_id']);

if ($connection) {

    $sql_delete = "DELETE FROM tbl_audit_checklist WHERE checklist_id  = '$checklist_id'";

    $res_delete = mysqli_query($connection, $sql_delete) or die($connection->error);

    if ($res_delete) {

        $sql_au_id = "SELECT * FROM tbl_audit_topic WHERE topic_id = '$topic_id'";
        $res_au_id = mysqli_query($connection, $sql_au_id) or die($connection->error);
        $row_au_id = mysqli_fetch_assoc($res_au_id);
        $audit_id = $row_au_id['audit_id'];

        $sql = "SELECT chl.checklist_id FROM `tbl_audit_form` frm 
                LEFT JOIN tbl_audit_topic topc ON frm.audit_id = topc.audit_id
                LEFT JOIN tbl_audit_checklist chl ON topc.topic_id = chl.topic_id
                WHERE frm.audit_id ='$audit_id'
                ORDER BY topc.list_order ASC , chl.create_datetime ASC;";
        $res = mysqli_query($connection, $sql);

        $list = 1;
        while ($row = mysqli_fetch_assoc($res)) {
            $sql_up = "UPDATE tbl_audit_checklist SET list_order = '$list' WHERE checklist_id = '{$row['checklist_id']}'";
            $res_up = mysqli_query($connection, $sql_up);
            $list++;
        }

        // $sql = "SELECT * FROM tbl_audit_checklist WHERE topic_id = '$topic_id' order by list_order ASC";
        // $res = mysqli_query($connection, $sql);
        // $new_list_order = 1;

        // while ($row = mysqli_fetch_assoc($res)) {
        //     $sql_update = "UPDATE tbl_audit_checklist SET  
        //     list_order = '$new_list_order',
        //     WHERE checklist_id = '{$row['checklist_id']}'";
        //     mysqli_query($connection, $sql_update);
        //     $new_list_order++;
        // }

        $arr['result'] = 1;
    } else {
        $arr['result'] = 0;
    }
} else {
    $arr['result'] = 9;
}

mysqli_close($connection);
echo json_encode($arr);

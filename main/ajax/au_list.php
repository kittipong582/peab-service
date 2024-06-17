<?php

include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$sql = "SELECT chl.checklist_id FROM `tbl_audit_form` frm 
LEFT JOIN tbl_audit_topic topc ON frm.audit_id = topc.audit_id
LEFT JOIN tbl_audit_checklist chl ON topc.topic_id = chl.topic_id
WHERE frm.audit_id ='8911966805'
ORDER BY topc.list_order ASC , chl.create_datetime ASC;";
// $res = mysqli_query($connect_db, $sql);

$list = 1;
while ($row = mysqli_fetch_assoc($res)) {
    echo $row['checklist_id'];

    echo $sql_up = "UPDATE tbl_audit_checklist SET list_order = '$list' WHERE checklist_id = '{$row['checklist_id']}'";
    echo "<br/>";
    // $res_up = mysqli_query($connect_db, $sql_up);
    $list++;
}

<?php
session_start();
include("../../../config/main_function.php");
date_default_timezone_set("Asia/Bangkok");

$connection = connectDB("LM=VjfQ{6rsm&/h`");



if ($connection) {
    

    $i = 0;
    foreach ($_POST['checklist_id'] as $key => $value) {
        $i++;
        $sql = "UPDATE tbl_audit_checklist SET list_order = '$i' WHERE checklist_id = '$value'";
        $sort = mysqli_query($connection, $sql);
    }

    $result = 1;
} else {
    $result = 0;
}


mysqli_close($connection);
$arr['result'] = $result;
echo json_encode($arr);
?>
<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$checklist_id = mysqli_real_escape_string($connect_db, $_POST['checklist_id']);
$choice_name = mysqli_real_escape_string($connect_db, $_POST['choice_name']);

$sql = "SELECT * FROM tbl_product_type_qc_checklist_choice WHERE checklist_id = '$checklist_id'";
$res = mysqli_query($connect_db, $sql);
$row = mysqli_num_rows($res);

if ($row > 0) {
    $list_order = $row + 1;
} else {
    $list_order = 1;
}

$sql_insert = "INSERT INTO tbl_product_type_qc_checklist_choice SET 
    checklist_id = '$checklist_id',
    list_order = '$list_order',
    choice_name = '$choice_name'";

// echo"$sql_insert";
if (mysqli_query($connect_db, $sql_insert)) {
    $arr['sql'] = $sql_insert;
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}
echo json_encode($arr);
?>
<?php 
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$oth_type_id = mysqli_real_escape_string($connect_db, $_POST['oth_type_id']);

$sql = "SELECT * FROM tbl_oth_job_type WHERE oth_type_id = '$oth_type_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

if ($row['active_status'] == 1) {
    $status = 0;
} else {
    $status = 1;
}

$arr['status'] = $status;

$sql_update_user = "UPDATE tbl_oth_job_type SET 
				active_status = '$status'
				WHERE oth_type_id = '$oth_type_id'";

if (mysqli_query($connect_db, $sql_update_user)) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);
?>
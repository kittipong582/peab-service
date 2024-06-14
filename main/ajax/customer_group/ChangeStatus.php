<?php 
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$customer_group_id = mysqli_real_escape_string($connect_db, $_POST['customer_group_id']);

$sql = "SELECT * FROM tbl_customer_group WHERE customer_group_id = '$customer_group_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

if ($row['active_status'] == 1) {
    $status = 0;
} else {
    $status = 1;
}

$arr['status'] = $status;

$sql_update_user = "UPDATE tbl_customer_group SET 
				active_status = '$status'
				WHERE customer_group_id = '$customer_group_id'";

if (mysqli_query($connect_db, $sql_update_user)) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);
?>
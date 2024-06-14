<?php 
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$business_group_id = $_POST['business_group_id'];

$sql = "SELECT * FROM tbl_business_group WHERE group_id = '$business_group_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

if ($row['active_status'] == 1) {
    $status = 0;
} else {
    $status = 1;
}

$arr['status'] = $status;

$sql_update_user = "UPDATE tbl_business_group SET 
				active_status = '$status'
				WHERE group_id = '$business_group_id'";

                // echo $sql;

if (mysqli_query($connect_db, $sql_update_user)) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);
?>
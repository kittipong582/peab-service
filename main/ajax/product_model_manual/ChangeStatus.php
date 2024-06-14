<?php 
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$key_value = mysqli_real_escape_string($connect_db, $_POST['key_value']);


$tab = $_POST['tab'];

if ($tab == '1') {
    $table = 'tbl_product_model_manual';
    $key_name = 'manual_id';
}elseif ($tab == '2') {
    $table = 'tbl_product_model_sparepart';
    $key_name = 'product_part_id';
}


$sql = "SELECT * FROM $table WHERE $key_name = '$key_value'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

if ($row['active_status'] == 1) {
    $status = 0;
} else {
    $status = 1;
}

$arr['status'] = $status;

$sql_update_user = "UPDATE $table SET 
				active_status = '$status'
				WHERE $key_name = '$key_value'";

if (mysqli_query($connect_db, $sql_update_user)) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);
?>
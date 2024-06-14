<?php 

include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$bank_id = mysqli_real_escape_string($connect_db, $_POST['bank_id']);
$bank_name = mysqli_real_escape_string($connect_db, $_POST['bank_name']);


$sql_update = "UPDATE tbl_bank SET 
bank_name = '$bank_name' 
WHERE bank_id = '$bank_id'";
$arr['sql'] = $sql_update;
if (mysqli_query($connect_db, $sql_update)) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);






?>
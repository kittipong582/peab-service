<?php 
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$spare_part_id = mysqli_real_escape_string($connect_db, $_POST['spare_part_id']);
$spare_part_code = mysqli_real_escape_string($connect_db, $_POST['spare_part_code']);

$sql = "SELECT count(*) as check_code FROM tbl_spare_part WHERE spare_part_code = '$spare_part_code' AND spare_part_id != '$spare_part_id'";
$rs = mysqli_query($connect_db, $sql) or die($connect_db->error);
$row = mysqli_fetch_array($rs);

$check_code = $row['check_code'];

$status = ($check_code == 0) ? 1 : 0 ;

echo json_encode($status);
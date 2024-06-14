<?php
include("../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$spare_part_id = $_POST['spare_part_id'];

//  $tr = $_POST['rowCount'];

$sql_unit = "SELECT spare_part_unit,spare_part_code FROM tbl_spare_part WHERE spare_part_id = '$spare_part_id';";
$rs_unit = mysqli_query($connection, $sql_unit);
$row_unit = mysqli_fetch_assoc($rs_unit);

$arr['unit'] = $row_unit['spare_part_unit'];
$arr['code'] = $row_unit['spare_part_code'];

mysqli_close($connection);
echo json_encode($arr);


?>

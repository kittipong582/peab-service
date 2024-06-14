<?php
include("../../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$spare_part_id = $_POST['spare_part_id'];
$branch_id = $_POST['branch_id'];

//  $tr = $_POST['rowCount'];

$sql_remain = "SELECT remain_stock FROM tbl_branch_stock WHERE spare_part_id = '$spare_part_id' AND branch_id = '$branch_id' ;";
$rs_remain = mysqli_query($connection, $sql_remain);
$row_remain = mysqli_fetch_assoc($rs_remain);

$arr['remain'] = $row_remain['remain_stock'];

mysqli_close($connection);
echo json_encode($arr);


?>

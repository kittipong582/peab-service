<?php

include('../../../config/main_function.php');
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$amphoe_id = $_POST['amphoe_id'];

$sql = "SELECT * FROM tbl_branch_care WHERE amphoe_id = '$amphoe_id'";
$rs = mysqli_query($connection, $sql) or die($connection->error);
$row = mysqli_fetch_array($rs);

$branch_id = $row['branch_id'];

echo json_encode($branch_id);
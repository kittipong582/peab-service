<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$branch_id = $_POST['branch_id'];
$sql = "SELECT * FROM tbl_branch WHERE branch_id = '$branch_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

$arr['branch_id'] = $row['branch_id'];
$arr['branch_name'] = $row['branch_name'];

echo json_encode($arr);

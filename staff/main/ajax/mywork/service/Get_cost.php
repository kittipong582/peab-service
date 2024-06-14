<?php
include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$income_id = $_POST['income_id'];
$sql = "SELECT * FROM tbl_income_type WHERE income_type_id = '$income_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);


$arr['cost'] = $row['unit_cost'];
echo json_encode($arr);
?>



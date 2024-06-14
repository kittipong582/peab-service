<?php

include("../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$district_id = $_POST['district_id'];

$sql_zip = "SELECT district_zipcode FROM tbl_district WHERE district_id = '$district_id'";
$rs_zip  = mysqli_query($connection, $sql_zip);
$row_zip = mysqli_fetch_array($rs_zip);

$arr['zipcode'] = $row_zip['district_zipcode'];
echo json_encode($arr);
?>

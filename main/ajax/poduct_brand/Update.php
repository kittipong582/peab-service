<?php 

include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$brand_id = mysqli_real_escape_string($connect_db, $_POST['brand_id']);
$brand_name = mysqli_real_escape_string($connect_db, $_POST['brand_name']);

$sql_update = "UPDATE tbl_product_brand SET brand_name = '$brand_name' WHERE brand_id = '$brand_id'";
$arr['sql'] = $sql_update;
if (mysqli_query($connect_db, $sql_update)) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

?>
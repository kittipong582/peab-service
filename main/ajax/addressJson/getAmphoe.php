<?php

include('../../../config/main_function.php');
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$province_id = $_POST['province_id'];

$list = array();

$sql = "SELECT * FROM tbl_amphoe WHERE ref_province = '$province_id' ORDER BY amphoe_name_th ASC";
$rs = mysqli_query($connection, $sql) or die($connection->error);
while ($row = mysqli_fetch_array($rs)) {
    
    $temp_array = array(
        "amphoe_id" => $row['amphoe_id'],
        "amphoe_name_th" => $row['amphoe_name_th'],
    );

    array_push($list,$temp_array);

}

echo json_encode($list);
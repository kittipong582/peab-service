<?php

include('../../../config/main_function.php');
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$amphoe_id = $_POST['amphoe_id'];

$list = array();

$sql = "SELECT * FROM tbl_district WHERE ref_amphoe = '$amphoe_id' ORDER BY district_name_th ASC";
$rs = mysqli_query($connection, $sql) or die($connection->error);
while ($row = mysqli_fetch_array($rs)) {
    
    $temp_array = array(
        "district_id" => $row['district_id'],
        "district_name_th" => $row['district_name_th'],
        "district_zipcode" => $row['district_zipcode'],
    );

    array_push($list,$temp_array);

}

echo json_encode($list);
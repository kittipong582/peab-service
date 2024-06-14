<?php

include('../../../config/main_function.php');

$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$province_id = $_POST['province'];
$branch_id = $_POST['branch_id'];



$sql_amphoe = "SELECT * FROM tbl_amphoe WHERE ref_province = '$province_id'";
$rs_amphoe = mysqli_query($connection, $sql_amphoe) or die($connection->error);
while ($row_amphoe = mysqli_fetch_assoc($rs_amphoe)) {

    $amphoe_id = $row_amphoe['amphoe_id'];

    $sql_del = "DELETE FROM tbl_branch_care WHERE amphoe_id = '$amphoe_id'";
    $rs_del = mysqli_query($connection, $sql_del) or die($connection->error);

    $sql_save = "INSERT INTO tbl_branch_care 
    SET branch_id = '$branch_id',
    amphoe_id = '$amphoe_id';
    ";
    $rs3 = mysqli_query($connection, $sql_save) or die($connection->error);
}

if ($rs3 && $rs_del) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

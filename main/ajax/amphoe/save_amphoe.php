<?php

include('../../../config/main_function.php');

$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$amphoe_id = $_POST['amphoe_id'];
$branch_id = $_POST['branch_id'];

$sql_check = "SELECT COUNT(branch_id) AS num FROM tbl_branch_care WHERE amphoe_id = '$amphoe_id'";
$rs_check = mysqli_query($connection, $sql_check) or die($connection->error);
$row_check = mysqli_fetch_assoc($rs_check);

$sql_am = "SELECT * FROM tbl_amphoe WHERE amphoe_id = '$amphoe_id'";
$rs_am = mysqli_query($connection, $sql_am) or die($connection->error);
$row_am = mysqli_fetch_assoc($rs_am);

$province = $row_am['ref_province'];


if ($row_check['num'] == 1) {

    $sql_save = "UPDATE tbl_branch_care 
    SET branch_id = '$branch_id'
    WHERE amphoe_id = '$amphoe_id';
    ";
    $rs3 = mysqli_query($connection, $sql_save) or die($connection->error);
} else {

    $sql_save = "INSERT INTO tbl_branch_care 
    SET branch_id = '$branch_id',
    amphoe_id = '$amphoe_id';
    ";
    $rs3 = mysqli_query($connection, $sql_save) or die($connection->error);
}


if ($rs3) {
    $arr['result'] = 1;
    $arr['province'] = $province;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

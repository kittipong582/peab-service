<?php
session_start();
include('../../../config/main_function.php');
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$branch_name = mysqli_real_escape_string($connection, $_POST['branch_name']);
$address1 = mysqli_real_escape_string($connection, $_POST['address1']);
$address2 = mysqli_real_escape_string($connection, $_POST['address2']);
$district_id = mysqli_real_escape_string($connection, $_POST['district']);
$branch_id = mysqli_real_escape_string($connection, $_POST['branch_id']);
$zone_id = mysqli_real_escape_string($connection, $_POST['zone_id']);
$team_number = mysqli_real_escape_string($connection, $_POST['team_number']);

$sql3 = "UPDATE tbl_branch
SET    
    branch_name = '$branch_name'
    , address = '$address1'
    , address2 = '$address2'
    , district_id = '$district_id'
    , zone_id = '$zone_id'
    ,team_number = '$team_number'
    WHERE branch_id = '$branch_id'";

$rs3 = mysqli_query($connection, $sql3) or die($connection->error);

if ($rs3) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}


echo json_encode($arr);

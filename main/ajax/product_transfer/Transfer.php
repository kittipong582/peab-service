<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$create_user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];
$branch_id = mysqli_real_escape_string($connect_db, $_POST['to_branch_id']);
$transfer_id = mysqli_real_escape_string($connect_db, $_POST['transfer_id']);
$note = mysqli_real_escape_string($connect_db, $_POST['note']);
$date_now = date("Y-m-d H:i:s", strtotime("now"));
$install_date = date("Y-m-d", strtotime($_POST['install_date']));
$sql = "SELECT * FROM tbl_product WHERE product_id = '$product_id'";
$rs  = mysqli_query($connect_db, $sql) or die($connect_db->error);
$row = mysqli_fetch_assoc($rs);

$from_branch_id = $row['current_branch_id'];



$sql3 = "INSERT INTO tbl_product_transfer
SET  transfer_id = '$transfer_id'   
,from_branch_id = '$from_branch_id'
,create_datetime = '$date_now'
,to_branch_id = '$branch_id'
,create_user_id = '$create_user_id'
,note = '$note'
,product_id = '$product_id'
";
$rs3 = mysqli_query($connect_db, $sql3) or die($connect_db->error);



$sql_update = "UPDATE tbl_product 
SET current_branch_id = '$branch_id'
,install_date = '$install_date'
WHERE product_id = '$product_id'";
$rs_update = mysqli_query($connect_db, $sql_update) or die($connect_db->error);

if ($rs3 && $rs_update) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}
echo json_encode($arr);

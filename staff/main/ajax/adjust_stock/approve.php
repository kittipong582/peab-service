

<?php
session_start();
include("../../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);
$adjust_id = mysqli_real_escape_string($connection, $_POST['adjust_id']);
$result = $_POST['result'];
$user_id = $_SESSION['user_id'];

$sql_update = "UPDATE tbl_adjust_head 
set approve_result = '$result'
,approve_user_id = '$user_id'
WHERE adjust_id = '$adjust_id'";
$rs_update = mysqli_query($connection, $sql_update) or die($connection->error);



if ($result == 1) {


    $sql_type = "SELECT adjust_type,receive_user_id FROM tbl_adjust_head WHERE adjust_id = '$adjust_id'";
    $rs_type  = mysqli_query($connection, $sql_type) or die($connection->error);
    $row_type = mysqli_fetch_assoc($rs_type);
    $user = $row_type['receive_user_id'];

    if ($row_type['adjust_type'] == 1) {

        $sql_detail = "SELECT * FROM tbl_adjust_detail WHERE adjust_id = '$adjust_id'";
        $rs_detail  = mysqli_query($connection, $sql_detail) or die($connection->error);
        while ($row_detail = mysqli_fetch_assoc($rs_detail)) {

            $ax = $row_detail['spare_part_id'];
            $quantity = $row_detail['quantity'];

            $sql_chk = "SELECT remain_stock FROM tbl_user_stock WHERE spare_part_id = '$ax' AND user_id = '$user' ;";
            $rs_chk  = mysqli_query($connection, $sql_chk) or die($connection->error);
            $row_chk = mysqli_fetch_assoc($rs_chk);

            $remain_stock = $row_chk['remain_stock'] - $quantity;

            $sql_user_stock = "UPDATE tbl_user_stock
                SET remain_stock  = '$remain_stock'
                WHERE spare_part_id = '$ax' AND user_id = '$user'
                ;";
            $rs_user_stock = mysqli_query($connection, $sql_user_stock) or die($connection->error);
        }
    }

    if ($row_type['adjust_type'] == 2) {

        $sql_detail = "SELECT * FROM tbl_adjust_detail WHERE adjust_id = '$adjust_id'";
        $rs_detail  = mysqli_query($connection, $sql_detail) or die($connection->error);
        while ($row_detail = mysqli_fetch_assoc($rs_detail)) {

            $ax = $row_detail['spare_part_id'];
            $quantity = $row_detail['quantity'];

            $sql_chk = "SELECT remain_stock FROM tbl_user_stock WHERE spare_part_id = '$ax' AND user_id = '$user' ;";
            $rs_chk  = mysqli_query($connection, $sql_chk) or die($connection->error);
            $row_chk = mysqli_fetch_assoc($rs_chk);

            $remain_stock = $row_chk['remain_stock'] + $quantity;

            $sql_user_stock = "UPDATE tbl_user_stock
                SET remain_stock  = '$remain_stock'
                WHERE spare_part_id = '$ax' AND user_id = '$user'
                ;";
            $rs_user_stock = mysqli_query($connection, $sql_user_stock) or die($connection->error);
        }
    }
    if ($rs_update && $rs_user_stock) {
        $arr['result'] = 1;
    } else {
        $arr['result'] = 2;
    }
} else {
    $arr['result'] = 1;
}

echo json_encode($arr);

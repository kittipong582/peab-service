<?php
session_start();
include("../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$transfer_id = mysqli_real_escape_string($connection, $_POST['transfer_id']);
$remark = mysqli_real_escape_string($connection, $_POST['remark']);
$result = mysqli_real_escape_string($connection, $_POST['result']);

$sql = "UPDATE tbl_transfer
    SET  approve_result = '$result'
    WHERE transfer_id = '$transfer_id' ;";

$rs = mysqli_query($connection, $sql) or die($connection->error);

if ($result == 0) {
    $sql_l = "SELECT * FROM tbl_transfer a 
JOIN  tbl_transfer_detail b ON a.transfer_id = b.transfer_id
WHERE a.transfer_id = '$transfer_id' ;";
    $rs_l  = mysqli_query($connection, $sql_l) or die($connection->error);
    while ($row_l = mysqli_fetch_assoc($rs_l)) {

        $sql_usf = "SELECT * FROM tbl_branch_stock WHERE branch_id = '{$row_l['from_branch_id']}' AND spare_part_id = '{$row_l['spare_part_id']}' ;";
        $rs_usf  = mysqli_query($connection, $sql_usf) or die($connection->error);
        $row_usf = mysqli_fetch_assoc($rs_usf);


        $from_remain = $row_usf['remain_stock'] + $row_l['quantity'];

        $sql_user_stock = "UPDATE tbl_branch_stock
    SET  remain_stock = '$from_remain'
    WHERE branch_id = '{$row_usf['branch_id']}' AND spare_part_id = '{$row_usf['spare_part_id']}' ;";

        $rs_user_stock = mysqli_query($connection, $sql_user_stock) or die($connection->error);
    }
} else {
    //////////////////////////////////////////////////////////////////////////////
    $sql_l = "SELECT * FROM tbl_transfer a 
JOIN  tbl_transfer_detail b ON a.transfer_id = b.transfer_id
WHERE a.transfer_id = '$transfer_id' ;";
    $rs_l  = mysqli_query($connection, $sql_l) or die($connection->error);
    while ($row_l = mysqli_fetch_assoc($rs_l)) {

        $sql_ust = "SELECT * FROM tbl_branch_stock WHERE branch_id = '{$row_l['to_branch_id']}' AND spare_part_id = '{$row_l['spare_part_id']}' ;";
        $rs_ust  = mysqli_query($connection, $sql_ust) or die($connection->error);
        $row_ust = mysqli_fetch_assoc($rs_ust);


        if ($row_l['spare_part_id'] == $row_ust['spare_part_id']) {

            $to_remain = $row_ust['remain_stock'] + $row_l['quantity'];

            $sql_user_stock = "UPDATE tbl_branch_stock
SET  remain_stock = '$to_remain'
WHERE branch_id = '{$row_ust['branch_id']}' AND spare_part_id = '{$row_ust['spare_part_id']}' ;";

            $rs_user_stock = mysqli_query($connection, $sql_user_stock) or die($connection->error);
        } else {

            $sql_user_stock = "INSERT INTO tbl_branch_stock
SET  branch_id = '{$row_l['to_branch_id']}'
,spare_part_id = '{$row_l['spare_part_id']}'
,remain_stock  = '{$row_l['quantity']}'
;";
            $rs_user_stock = mysqli_query($connection, $sql_user_stock) or die($connection->error);
        }
    }
}
// echo $sql;

if ($rs) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);

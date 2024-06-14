<?php

include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$sql_branch = "SELECT * FROM tbl_customer_branch WHERE active_status = '1' ";
$res_branch = mysqli_query($connect_db, $sql_branch);
$count = mysqli_num_rows($res_branch);

$register_datetime  = date('Y-m-d H:s:i');
$i = 0;
while ($row_branch = mysqli_fetch_assoc($res_branch)) {

    $qr_id = getRandomID(20, 'tbl_qr_code', 'qr_id');
    $qr_no = getRandomID2(8, 'tbl_qr_code', 'qr_no');

    $sql_insert = "INSERT INTO tbl_qr_code SET  
            qr_id = '$qr_id',
            qr_no = '$qr_no'
            ";
    $res_insert = mysqli_query($connect_db, $sql_insert)  or die($connect_db->error);

    if ($res_insert) {
       $sql_update = "UPDATE tbl_qr_code SET
        register_datetime  = '$register_datetime' ,
        branch_id = '{$row_branch['customer_branch_id']}' 
        WHERE qr_id = '$qr_id'";
        $res_update = mysqli_query($connect_db, $sql_update)  or die($connect_db->error);
    }

    echo "<pre>";
    echo  $sql_insert;
    echo  $sql_update;
    echo  $count;
    echo "</pre>";
    $i++;
    if ($i > 15000) {
        exit;
    }
}

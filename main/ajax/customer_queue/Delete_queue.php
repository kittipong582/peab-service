<?php
@include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$customer_id = mysqli_real_escape_string($connect_db, $_POST['customer_id']);
$customer_branch_id = mysqli_real_escape_string($connect_db, $_POST['customer_branch_id']);

if ($connect_db) {
    // ดึงข้อมูลคิวก่อนลบ
    $sql_select_queue = "SELECT queue_no FROM tbl_customer_queue WHERE customer_branch_id = '$customer_branch_id'";
    $result_select_queue = mysqli_query($connect_db, $sql_select_queue) or die($connect_db->error);
    $row_queue = mysqli_fetch_assoc($result_select_queue);
    $queue_no = $row_queue['queue_no'];

    // ลบคิว
    $sql_delete = "DELETE FROM tbl_customer_queue WHERE customer_branch_id = '$customer_branch_id' AND queue_no ='$queue_no'";
    $res_delete = mysqli_query($connect_db, $sql_delete) or die($connect_db->error);


    if ($res_delete) {
        // อัปเดตหมายเลขคิวของคิวที่เหลือ
        $sql_update_queue = "UPDATE tbl_customer_queue SET queue_no = queue_no - 1 WHERE queue_no > '$queue_no'";
        $result_update_queue = mysqli_query($connect_db, $sql_update_queue) or die($connect_db->error);

        if ($result_update_queue) {
            $arr['result'] = 1; // ลบคิวสำเร็จ
        } else {
            $arr['result'] = 0; // ลบคิวสำเร็จ แต่มีปัญหาในการอัปเดตหมายเลขคิว
        }
    } else {
        $arr['result'] = 0; // ลบคิวไม่สำเร็จ
    }
} else {
    $arr['result'] = 9; // ไม่สามารถเชื่อมต่อฐานข้อมูลได้
}

mysqli_close($connect_db);
echo json_encode($arr);
?>

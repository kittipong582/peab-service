<?php
include("../../../config/main_function.php");
session_start();
$product_id = $_POST['product_id'];
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$user_id = $_SESSION['user_id'];
$user_level = $_SESSION['user_level'];
$admin_status = $_SESSION['admin_status'];

$sql_user = "SELECT * FROM tbl_user 
WHERE user_id = '$user_id'";
$result_user  = mysqli_query($connect_db, $sql_user);
$row_user = mysqli_fetch_array($result_user);



?>

<table class="table table-striped table-bordered table-hover tbl_transfer" id="tbl_transfer">
    <thead>
        <tr>
            <th style="width:2%;">#</th>
            <th class="text-center" style="width:15%;">สาขา (ต้นทาง)</th>
            <th class="text-center" style="width:15%;">สาขา (ปลายทาง)</th>
            <th class="text-center">ผู้ทำรายการ</th>
            <th class="text-center" style="width:15%;">หมายเหตุ</th>
            <th class="text-center">สถานะ</th>

        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
       $sql = "SELECT a.*,d.branch_name AS team_name,c.branch_name As cus_branch_name,b.fullname AS create_name FROM tbl_product_transfer a
        LEFT JOIN tbl_user b ON a.create_user_id = b.user_id
        LEFT JOIN tbl_customer_branch c ON a.to_branch_id = c.customer_branch_id
        LEFT JOIN tbl_customer_branch d ON a.from_branch_id = d.customer_branch_id

         WHERE a.product_id = '$product_id' ORDER BY a.create_datetime";

        $result  = mysqli_query($connect_db, $sql);

        // echo $sql;
        while ($row = mysqli_fetch_array($result)) {


            $sql_branch = "SELECT * FROM tbl_customer_branch WHERE branch_care_id = '{$row_user['branch_id']}' AND  customer_branch_id = '{$row['to_branch_id']}'";
            $result_branch  = mysqli_query($connect_db, $sql_branch);
            $row_cnt = mysqli_num_rows($result_branch);

            if ($row['receive_result'] == 1) {
                $status = "รับโอนแลว";
            } else if ($row['receive_result'] == 2) {
                $status = "ยกลิกการโอนแล้ว";
            } else {
                $status = "รอดำเนินการ";
            }

        ?>
            <tr>
                <td><?php echo ++$i; ?></td>
                <td class="text-center"><?php echo $row['team_name']; ?></td>
                <td class="text-center"><?php echo $row['cus_branch_name']; ?></td>

                <td class="text-center"><?php echo $row['create_name']; ?><br><?php echo date("d-m-Y", strtotime($row['create_datetime'])); ?></td>
                <td class="text-center"><?php echo $row['note']; ?></td>
                <td class="text-center"><?php echo $status ?></td>

            </tr>
        <?php } ?>
    </tbody>
</table>
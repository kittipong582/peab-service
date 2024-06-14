<?php
include("../../../config/main_function.php");
session_start();
$user_branch_id = $_SESSION['branch_id'];
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$overhaul_id = $_POST['overhaul_id'];

?>

<table class="table table-striped table-bordered table-hover tbl_transfer" id="tbl_transfer">
    <thead>
        <tr>
            <th style="width:10%;">#</th>
            <th class="text-center">AX No</th>
            <th class="text-left">Transfer No</th>
            <th class="text-center">ทีมงาน (ปลายทาง)</th>

            <th class="text-center">ผู้ทำรายการ</th>
            <th class="text-center" style="width:20%;">หมายเหตุ</th>
            <th class="text-center">สถานะ</th>
            <!-- <th style="width:10%;"></th> -->
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        $sql = "SELECT *,d.branch_name AS team_name,c.branch_name As cus_branch_name FROM tbl_overhaul_transfer a
        LEFT JOIN tbl_user b ON a.create_user_id = b.user_id
        LEFT JOIN tbl_branch c ON a.to_branch_id = c.branch_id
        LEFT JOIN tbl_branch d ON a.from_branch_id = d.branch_id
         WHERE a.overhaul_id = '$overhaul_id' ORDER BY a.create_datetime";
        $result  = mysqli_query($connect_db, $sql);
        
        while ($row = mysqli_fetch_array($result)) {


            if ($row['receive_result'] == 1) {
                $status = "รับโอนแล้ว";
            } else if ($row['receive_result'] == 2) {
                $status = "ยกเลิกการโอนแล้ว";
            } else {
                $status = "รอดำเนินการ";
            }

        ?>
            <tr>
                <td><?php echo ++$i; ?></td>
                <td class="text-center"><?php echo $row['ax_ref_no']; ?></td>
                <td class="text-left"><?php echo $row['oh_transfer_no']; ?></td>
                <td class="text-center"><?php echo $row['cus_branch_name']; ?></td>

                <td class="text-center"><?php echo $row['fullname']; ?></td>
                <td class="text-center"><?php echo $row['note']; ?></td>
                <td class="text-center"><?php echo $status ?></td>
                <!-- <td>
                    <?php if ($row['to_branch_id'] == $user_branch_id || $_SESSION['admin_status'] == 9 && $row['receive_result'] == 0) { ?>
                        <div style="padding-bottom: 1ex;">
                            <button class="btn btn-xs btn-success btn-block" onclick="ModalReceive('<?php echo $row['oh_transfer_id'] ?>');">ยืนยันการรับโอน</button>
                        </div>
                    <?php } ?>
                </td> -->
            </tr>
        <?php } ?>
    </tbody>
</table>
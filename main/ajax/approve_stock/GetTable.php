<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
session_start();

$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$chk_date = $_POST['chk'];

$user_id = $_SESSION['user_id'];
$user_level = $_SESSION['user_level'];
$admin_status = $_SESSION['admin_status'];

$start_date = explode('/', $_POST['start_date']);
$start_date = date('Y-m-d', strtotime($start_date['0'] . "-" . $start_date['1'] . "-" . $start_date['2']));

$end_date = explode('/', $_POST['end_date']);
$end_date = date('Y-m-d', strtotime($end_date['0'] . "-" . $end_date['1'] . "-" . $end_date['2']));


$condition = "";
if ($chk_date != "2") {
    $condition .= " AND a.create_datetime BETWEEN '$start_date 00:00:00' AND  '$end_date 23:59:59'  ";
}

if ($admin_status == 9) {

    $sql = "SELECT a.*,b.fullname FROM tbl_transfer a 
JOIN tbl_user b ON a.create_user_id = b.user_id
WHERE a.to_user_id = '$user_id' $condition
ORDER BY a.transfer_no DESC";
} else if ($user_level == 2) {
}
$result  = mysqli_query($connect_db, $sql);
echo $sql;

?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:4%;" class="text-center">#</th>
            <th class="text-center" style="width:12%;">หมายเลขโอนย้าย</th>
            <!-- <th class="text-center" style="width:11%;">อ้างอิง AX </th> -->
            <!-- <th class="text-left" style="width:26%;">สิ่งที่โอนย้าย</th> -->
            <!-- <th class="text-center" style="width:13%;">วันที่เบิกจาก AX</th> -->
            <th class="text-center" style="width:10%;">การยืนยัน</th>
            <th class="text-center" style="width:11%;">ผู้สร้างรายการ</th>
            <th class="text-center" style="width:11%;">วันที่ทำรายการ</th>
            <th class="text-center" style="width:10%;">ผู้โอน</th>


            <th style="width:7%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;

        while ($row = mysqli_fetch_array($result)) {

            $i++;

            $sql_r = "SELECT fullname FROM tbl_user WHERE user_id = '{$row['from_user_id']}' ;";
            $rs_r  = mysqli_query($connect_db, $sql_r) or die($connection->error);
            $row_r = mysqli_fetch_assoc($rs_r);

            $sql_d = "SELECT * FROM tbl_transfer_detail a JOIN tbl_spare_part b ON a.spare_part_id = b.spare_part_id 
        WHERE a.transfer_id = '{$row['transfer_id']}' ;";
            $rs_d  = mysqli_query($connect_db, $sql_d) or die($connection->error);

            $note = "-";
            if ($row['note'] != "") {
                $note = $row['note'];
            }

            $chk = "-";
            if ($row['receive_result'] == "") {
                $chk = "<span class = 'badge rounded-pill bg-warning text-black'>รอดำเนินการ</span>";
            } else if ($row['receive_result'] == "1") {
                $chk = "<span class = 'badge rounded-pill bg-success text-black'>รับ</span>" . "<br>" . date('d-M-Y', strtotime($row['receive_datetime']));
            } else if ($row['receive_result'] == "0") {
                $chk = "<span class = 'badge rounded-pill bg-danger text-black'>ไม่รับ</span>" . "<br>" . date('d-M-Y', strtotime($row['receive_datetime']));
            }



        ?>
            <tr>
                <td class="text-center"><?php echo $i; ?></td>
                <td class="text-center"><?php echo $row['transfer_no']; ?></td>
                <!-- <td class="text-center"><?php echo $row['ax_ref_no']; ?> <br> [
                <?php echo date('d-M-Y', strtotime($row['ax_withdraw_date'])); ?> ]</td> -->
                <!-- <td class="text-left">
                <?php while ($row_d = mysqli_fetch_assoc($rs_d)) { ?>
                - <?php echo $row_d['spare_part_name'] . " x " . $row_d['quantity'] . "<br>"; ?>
                <?php } ?>
            </td> -->
                <!-- <td class="text-center"><?php echo date('d-m-Y', strtotime($row['ax_withdraw_date'])); ?></td> -->
                <td class="text-center"><?php echo $chk; ?></td>
                <td class="text-center"><?php echo $row['fullname']; ?></td>
                <td class="text-center"><?php echo date('d-m-Y', strtotime($row['create_datetime'])); ?></td>
                <td class="text-center"><?php echo $row_r['fullname']; ?></td>

                <td>
                    <button class="btn btn-success btn-block btn-xs" onclick="modal_detail('<?php echo $row['transfer_id']; ?>');"><i class="fa fa-search"></i>
                        ดูรายละเอียด</button>
                    <!-- <button class="btn btn-success btn-block btn-xs"
                    onclick="modal_approve('<?php echo $row['transfer_id']; ?>');"><i class="fa fa-check"></i>
                    อนุมัติ</button>
                <button class="btn btn-danger btn-block btn-xs"
                    onclick="modal_cancel('<?php echo $row['transfer_id']; ?>');"><i class="fa fa-times"></i>
                    ปฏิเสธ</button> -->
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
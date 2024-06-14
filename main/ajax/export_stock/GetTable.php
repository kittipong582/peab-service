<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$branch = $_POST['branch'];
$user = $_POST['user'];

$start_date = explode('/', $_POST['start_date']);
$start_date = date('Y-m-d', strtotime($start_date['0'] . "-" . $start_date['1'] . "-" . $start_date['2']));

$end_date = explode('/', $_POST['end_date']);
$end_date = date('Y-m-d', strtotime($end_date['0'] . "-" . $end_date['1'] . "-" . $end_date['2']));


$sql = "SELECT a.*,b.fullname,c.branch_name,d.*,e.spare_part_name FROM tbl_import_stock a 
LEFT JOIN tbl_user b ON a.create_user_id = b.user_id 
LEFT JOIN tbl_branch c ON b.branch_id = c.branch_id 
LEFT JOIN tbl_import_stock_detail d ON a.import_id = d.import_id 
LEFT JOIN tbl_spare_part e ON d.spare_part_id = e.spare_part_id 
ORDER BY a.create_datetime DESC";
$result  = mysqli_query($connect_db, $sql);
// echo $sql;

?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <!-- <th style="width:5%;" class="text-center">#</th> -->
            <th class="text-center" style="width:15%;">หมายเลขนำเข้า</th>
            <th class="text-center" style="width:15%;">หมายเลข AX อ้างอิง</th>
            <th class="text-center" style="width:21%;">สิ่งที่เบิก</th>
            <th class="text-center" style="width:15%;">วันที่เบิกจาก AX</th>
            <th class="text-center">หมายเหตุ</th>
            <th class="text-center">ผู้รับ</th>
            <!-- <th class="text-center" style="width:18%;">เอกสารประกอบการบันทึก</th> -->
            <th style="width:10%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;

        while ($row = mysqli_fetch_array($result)) {

            $i++;

        $sql_r = "SELECT fullname FROM tbl_user WHERE user_id = '{$row['receive_user_id']}' ;";
        $rs_r  = mysqli_query($connect_db, $sql_r) or die($connection->error);
        $row_r = mysqli_fetch_assoc($rs_r);


        ?>
        <tr>
            <!-- <td class="text-center"><?php echo $i; ?></td> -->
            <td class="text-center"><?php echo $row['import_no']; ?></td>
            <td class="text-center"><?php echo $row['ax_ref_no']; ?></td>
            <td class="text-center"><?php echo $row['spare_part_name'] . " x " . $row['quantity']; ?></td>
            <td class="text-center"><?php echo date('d-m-Y H:i',strtotime($row['ax_withdraw_date'])); ?></td>
            <td class="text-center"><?php echo $row['note']; ?></td>
            <td class="text-center"><?php echo $row_r['fullname']; ?></td>
            <td>
                <button class="btn btn-success btn-block btn-xs" onclick="modal_detail('');"><i
                        class="fa fa-search"></i>
                    ดูลายละเอียด</button>

                    <!-- <a href="edit_ax_import.php?id=<?php echo $row['import_id']; ?>" class="btn btn-warning btn-block btn-xs">แก้ไข</a> -->

            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
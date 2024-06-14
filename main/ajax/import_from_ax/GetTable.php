<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$branch = $_POST['branch'];
$user = $_POST['user'];
$user_id = $_SESSION['user_id'];
$user_level = $_SESSION['user_level'];
$admin_status = $_SESSION['admin_status'];


$start_date = explode('/', $_POST['start_date']);
$start_date = date('Y-m-d', strtotime($start_date['0'] . "-" . $start_date['1'] . "-" . $start_date['2']));

$end_date = explode('/', $_POST['end_date']);
$end_date = date('Y-m-d', strtotime($end_date['0'] . "-" . $end_date['1'] . "-" . $end_date['2']));


$condition = "";
if ($branch != "x") {
    $condition .= "AND c.branch_id = '$branch' ";
}

//  = "";
// if ($user != "x") {
//      .= "AND b.user_id = '$user' ";
// }

if ($admin_status == 9 || $user_level == 4) {
    $sql = "SELECT a.*,c.branch_name,c.branch_name FROM tbl_import_stock a 
JOIN tbl_branch c ON a.receive_branch_id = c.branch_id
WHERE a.create_datetime BETWEEN '$start_date 00:00:00' AND  '$end_date 23:59:59' $condition 
ORDER BY a.create_datetime DESC";
} else {
    if ($user_level == 1) {

        $sql = "SELECT a.*,c.branch_name,c.branch_name FROM tbl_import_stock a 
        JOIN tbl_branch c ON a.receive_branch_id = c.branch_id
        WHERE a.create_datetime BETWEEN '$start_date 00:00:00' AND  '$end_date 23:59:59' AND b.user_id = '$user_id'

        ORDER BY a.create_datetime DESC";
    }
    if ($user_level == 2) {


        $sql_branch = "SELECT branch_id FROM tbl_user WHERE user_id = '$user_id'";
        $result_branch  = mysqli_query($connect_db, $sql_branch);
        $row_branch = mysqli_fetch_array($result_branch);

        $branch_id = $row_branch['branch_id'];

        $sql = "SELECT a.*,c.branch_name,c.branch_name,a.receive_branch_id FROM tbl_import_stock a 
        
        JOIN tbl_branch c ON a.receive_branch_id = c.branch_id
        WHERE a.create_datetime BETWEEN '$start_date 00:00:00' AND  '$end_date 23:59:59' AND a.receive_branch_id = '$branch_id'

        UNION  

        SELECT a.*,c.branch_name,c.branch_name,a.receive_branch_id FROM tbl_import_stock a 
        
        JOIN tbl_branch c ON a.receive_branch_id = c.branch_id
        WHERE a.create_datetime BETWEEN '$start_date 00:00:00' AND  '$end_date 23:59:59' AND b.user_id = '$user_id'


        ORDER BY create_datetime DESC";
    } else if ($user_level == 3) {

        $sql_branch = "SELECT zone_id FROM tbl_user WHERE user_id = '$user_id'";
        $result_branch  = mysqli_query($connect_db, $sql_branch);
        $row_branch = mysqli_fetch_array($result_branch);

        $zone_id = $row_branch['zone_id'];


        $sql = "SELECT a.*,c.branch_name,c.branch_name,a.receive_branch_id,c.zone_id FROM tbl_import_stock a 
        
        JOIN tbl_branch c ON a.receive_branch_id = c.branch_id
        WHERE a.create_datetime BETWEEN '$start_date 00:00:00' AND  '$end_date 23:59:59' AND c.zone_id = '$zone_id'


        ORDER BY a.create_datetime DESC";
    }
}

$result  = mysqli_query($connect_db, $sql);
// echo $sql;

?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:5%;" class="text-center">#</th>
            <th class="text-center" style="width:12%;">หมายเลขนำเข้า</th>
            <th class="text-center" style="width:15%;">อ้างอิง AX </th>
            <th class="text-left" style="width:28%;">สิ่งที่นำเข้า</th>
            <!-- <th class="text-center" style="width:13%;">วันที่เบิกจาก AX</th> -->
            <th class="text-center" style="width:10%;">การยืนยัน</th>
            <th class="text-center" style="width:14%;">ผู้รับ</th>
            <th class="text-center" style="width:10%;"></th>
            <!-- <th class="text-center" style="width:18%;">เอกสารประกอบการบันทึก</th> -->
            <!-- <th style="width:10%;"></th> -->
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;

        while ($row = mysqli_fetch_array($result)) {

            $i++;


            $sql_d = "SELECT * FROM tbl_import_stock_detail a JOIN tbl_spare_part b ON a.spare_part_id = b.spare_part_id 
        WHERE a.import_id = '{$row['import_id']}' ;";
            $rs_d  = mysqli_query($connect_db, $sql_d) or die($connection->error);


            $note = "-";
            if ($row['note'] != "") {
                $note = $row['note'];
            }

            if ($row['receive_datetime'] != "") {
                $date = date('d-M-Y', strtotime($row['receive_datetime']));
            }else{
                $date = '-';
            }

            $chk = "-";
            if ($row['receive_result'] == "") {
                $chk = "<span class = 'badge rounded-pill bg-warning text-black'> รอดำเนินการ </span>";
            } else if ($row['receive_result'] == "1") {
                $chk = "<span class = 'badge rounded-pill bg-success text-black'> รับ </span>" . "<br>" . $date;
            } else if ($row['receive_result'] == "0") {
                $chk = "<span class = 'badge rounded-pill bg-danger text-black'> ไม่รับ </span>" . "<br>" . $date;
            }

        ?>
            <tr>
                <td class="text-center"><?php echo $i; ?></td>
                <td class="text-center"><?php echo $row['import_no']; ?></td>
                <td class="text-center"><?php echo $row['ax_ref_no']; ?> <br> [ <?php echo date('d-M-Y', strtotime($row['ax_withdraw_date'])); ?> ]</td>
                <td class="text-left">
                    <?php while ($row_d = mysqli_fetch_assoc($rs_d)) { ?>
                        - <?php echo " [ " . $row_d['spare_part_code'] . " ] " . $row_d['spare_part_name'] . " x " . $row_d['quantity'] . "<br>"; ?>
                    <?php } ?>
                </td>
                <!-- <td class="text-center"><?php echo date('d-m-Y', strtotime($row['ax_withdraw_date'])); ?></td> -->
                <td class="text-center"><?php echo $chk; ?></td>
                <td class="text-center"><?php echo $row['branch_name']; ?></td>
                <td>

                    <button class="btn btn-success btn-block btn-xs" onclick="modal_detail('<?php echo $row['import_id']; ?>');"><i class="fa fa-search"></i>
                        ดูรายละเอียด</button>
                    <?php if ($user_id == $row['create_user_id'] && $row['receive_result'] == null) { ?>
                        <button class="btn btn-danger btn-block btn-xs" onclick="delete_import('<?php echo $row['import_id'] ?>');">
                            ลบ</button>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
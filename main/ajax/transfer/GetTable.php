<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$branch = $_POST['branch'];
$user = $_POST['user'];


$sql_admin = "SELECT user_id FROM tbl_user WHERE admin_status = 9 ;";
$result_admin  = mysqli_query($connect_db, $sql_admin);
$row_admin = mysqli_fetch_array($result_admin);

$admin = $row_admin['user_id'];

$user_id = $_SESSION['user_id'];

// $user_condition = "";
// if($user_id != $admin){
//     $user_condition .="AND a.from_branch_id = '$branch' ";
// }


$start_date = explode('/', $_POST['start_date']);
$start_date = date('Y-m-d', strtotime($start_date['0'] . "-" . $start_date['1'] . "-" . $start_date['2']));

$end_date = explode('/', $_POST['end_date']);
$end_date = date('Y-m-d', strtotime($end_date['0'] . "-" . $end_date['1'] . "-" . $end_date['2']));


$condition = "";
if($branch != "x"){
    $condition .="AND c.branch_id = '$branch' ";
}




$sql = "SELECT a.*,c.branch_name,d.branch_name AS from_name FROM tbl_transfer a 
JOIN tbl_branch c ON a.to_branch_id = c.branch_id
JOIN tbl_branch d ON a.from_branch_id = d.branch_id
WHERE a.create_datetime BETWEEN '$start_date 00:00:00' AND  '$end_date 23:59:59' $condition 
ORDER BY a.create_datetime DESC ;";
$result  = mysqli_query($connect_db, $sql);
// echo $sql;

?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:5%;" class="text-center">#</th>
            <!-- <th class="text-center" style="width:12%;">หมายเลขโอนย้าย</th> -->
            <th class="text-center" style="width:15%;">อ้างอิง AX </th>
            <th class="text-center" style="width:13%;">วันที่ทำรายการ</th>
            
            <th class="text-left" style="width:28%;">รายการอะไหล่</th>
            <th class="text-center" style="width:13%;">ผู้ทำรายการ</th>
            
            <!-- <th class="text-center" style="width:10%;">การยืนยัน</th> -->
            <th class="text-center" style="width:14%;">ทีมผู้โอน</th>
            <th class="text-center" style="width:14%;">ทีมผู้รับ</th>
            <!-- <th class="text-center" style="width:18%;">เอกสารประกอบการบันทึก</th> -->
            <!-- <th style="width:10%;"></th> -->
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;

        while ($row = mysqli_fetch_array($result)) {

            $i++;

        $sql_r = "SELECT fullname FROM tbl_user WHERE user_id = '{$row['create_user_id']}' ;";
        $rs_r  = mysqli_query($connect_db, $sql_r) or die($connection->error);
        $row_r = mysqli_fetch_assoc($rs_r);

        $sql_d = "SELECT * FROM tbl_transfer_detail a JOIN tbl_spare_part b ON a.spare_part_id = b.spare_part_id 
        WHERE a.transfer_id = '{$row['transfer_id']}' ;";
        $rs_d  = mysqli_query($connect_db, $sql_d) or die($connection->error);
        
        
        $note = "-";
        if($row['note'] != ""){
            $note = $row['note'];
        }

        $chk = "-";
        if($row['approve_result'] =="") {
            $chk = "<span class = 'badge rounded-pill bg-warning text-black'>รอดำเนินการ</span>";
        }else if($row['approve_result'] =="1") {
            $chk = "<span class = 'badge rounded-pill bg-success text-black'>รับ</span>" . "<br>" . date('d-M-Y',strtotime($row['receive_datetime'])) ;
        }else if($row['approve_result'] =="0") {
            $chk = "<span class = 'badge rounded-pill bg-danger text-black'>ไม่รับ</span>" . "<br>" . date('d-M-Y',strtotime($row['receive_datetime']));
        }

        ?>
        <tr>
            <td class="text-center"><?php echo $i; ?></td>
            <td class="text-center"><?php echo $row['ax_ref_no']; ?></td>
            <td class="text-center"><?php echo date('d-M-Y',strtotime($row['create_datetime'])); ?></td>
            <!-- <td class="text-center"><?php echo $row['ax_ref_no']; ?> <br> [ <?php echo date('d-M-Y',strtotime($row['ax_withdraw_date'])); ?> ]</td> -->
            <td class="text-left">
                <?php while ($row_d = mysqli_fetch_assoc($rs_d)){ ?>
                - <?php echo $row_d['spare_part_code']." - ".$row_d['spare_part_name'] . " x " . $row_d['quantity'] . "<br>"; ?>
                <?php } ?>
            </td>
            <td class="text-center"><?php echo $row_r['fullname']; ?></td>
            
            <!-- <td class="text-center"><?php echo $chk; ?></td> -->
            <td class="text-center"><?php echo $row['from_name']; ?></td>
            <td class="text-center"><?php echo $row['branch_name']; ?></td>
            <!-- <td>
                <button class="btn btn-success btn-block btn-xs" onclick="modal_detail('');"><i
                        class="fa fa-search"></i>
                    ดูลายละเอียด</button>
            </td> -->
        </tr>
        <?php } ?>
    </tbody>
</table>
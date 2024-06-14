<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
session_start();

$start_date = explode('/', $_POST['start_date']);
$start_date = date('Y-m-d', strtotime($start_date['0'] . "-" . $start_date['1'] . "-" . $start_date['2']));

$end_date = explode('/', $_POST['end_date']);
$end_date = date('Y-m-d', strtotime($end_date['0'] . "-" . $end_date['1'] . "-" . $end_date['2']));

$chk_date = $_POST['chk'];
$branch_id = $_SESSION['branch_id'];
$user_level = $_SESSION['user_level'];
$admin_status = $_SESSION['admin_status'];

$condition = "";
// $condition1 = "AND approve_result is NULL";
if ($chk_date == "1") {
    $condition .= " AND a.create_datetime BETWEEN '$start_date 00:00:00' AND  '$end_date 23:59:59'";
    // $condition1 .= " AND a.create_datetime BETWEEN '$start_date 00:00:00' AND  '$end_date 23:59:59'";
}





$sql = "SELECT a.*,b.fullname AS create_user,c.branch_name AS from_user FROM tbl_adjust_head a  
    LEFT JOIN tbl_user b ON a.create_user_id = b.user_id
    LEFT JOIN tbl_branch c ON a.receive_branch_id = c.branch_id
    WHERE a.receive_branch_id = '$branch_id' $condition 
  ORDER BY create_datetime  DESC";

// echo $sql;
$result  = mysqli_query($connect_db, $sql);
$num_row = mysqli_num_rows($result);
// $row = mysqli_fetch_array($result);



?>

<?php
if ($num_row > 0) {

    while ($row = mysqli_fetch_array($result)) {

        if ($row['adjust_type'] == 2) {
            $ad_type = 'ลด';
        } else {
            $ad_type = 'เพิ่ม';
        }

        $sql_d = "SELECT * FROM tbl_adjust_detail a JOIN tbl_spare_part b ON a.spare_part_id = b.spare_part_id 
                WHERE a.adjust_id = '{$row['adjust_id']}' ;";
        // echo $sql_d;
        $rs_d  = mysqli_query($connect_db, $sql_d) or die($connect_db->error);

        switch ($row['approve_result']) {
            case "1":
                $chk = "<span class = 'badge rounded-pill bg-success text-black'> รับ </span>";
                break;
            case "0":
                $chk = "<span class = 'badge rounded-pill bg-danger text-black'> ไม่รับ </span>";
                break;
            default:
                $chk = "<span class = 'badge rounded-pill bg-warning text-black'> รอดำเนินการ </span>";
        }

?>
        <br>

        <div class="ibox mb-3 d-block">
            <div class="ibox-title">
                <b><?php echo $row['adjust_no'] ?></b>
                <div class="ibox-tools">
                    <?php echo $chk ?>
                </div>
            </div>
            <div class="ibox-content">

                <div class="row">

                    <div class="col-6 mb-1">
                        <label><b>AX_Ref_no</b></label> : <?php echo $row['ax_ref_no'] ?>
                    </div>

                    <div class="col-6 mb-1">
                        <label><b>วันที่ทำรายการ</b></label> :
                        <?php echo date('d-m-Y', strtotime($row['create_datetime'])); ?>
                    </div>

                </div>

                <div class="row">

                    <div class="col-6 mb-1">
                        <label><b>ผู้ทำรายการ</b></label> : <?php echo $row['create_user']; ?>
                    </div>

                    <div class="col-6 mb-1">
                        <label><b>ทีม</b></label> : <?php echo $row['from_user']; ?>
                    </div>

                    <div class="col-6 mb-1">
                        <label><b>ประเภทการปรับ</b></label> :
                        <?php echo $ad_type; ?>
                    </div>

                    <div class="col-6 mb-1">
                        <label><b>หมายเหตุ</b></label> :
                        <?php echo $row['note']; ?>
                    </div>

                </div>

                <div class="row">

                    <div class="col-12">
                        <label><b>รายการอะไหล่</b></label> : <br>
                        <div class="row">

                            <?php
                            $i = 0;
                            while ($row_d = mysqli_fetch_array($rs_d)) {
                                $i++;
                            ?>
                                <div class="col-8">
                                    <b><?php echo $i; ?>. </b>[ <?php echo $row_d['spare_part_code']; ?> ]
                                    <?php echo $row_d['spare_part_name']; ?> x
                                    <?php echo $row_d['quantity']; ?><br>
                                </div>
                                <div class="col-4">
                                    <?php echo $row_d['remark']; ?><br>
                                </div>


                            <?php } ?>

                        </div>


                    </div>


                </div>

                <br>
<!-- 
                <div class="row">
                    <div class="col-12">
                        <?php if ($row['approve_result'] == NULL && $user_level == 2 || $row['approve_result'] == NULL && $user_level == 3) { ?>
                            <button class="btn btn-success btn-block btn-xs" onclick="modal_approve('<?php echo $row['adjust_id']; ?>','1');"><i class="fa fa-check"></i>
                                อนุมัติ</button>
                            <button class="btn btn-danger btn-block btn-xs" onclick="modal_approve('<?php echo $row['adjust_id']; ?>','0');"><i class="fa fa-times"></i>
                                ปฏิเสธ</button>
                        <?php } ?>
                    </div>
                </div> -->

            </div>
        </div>

    <?php
    }
    ?>

<?php
} else {
?>
    <br>
    <center>
        <h1> ไม่พบข้อมูล </h1>
    </center>

<?php
}
?>

<div class="modal hide fade in" id="modal" role="dialog" data-keyboard="false" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div id="show_modal"></div>
        </div>
    </div>
</div>

<script>

</script>
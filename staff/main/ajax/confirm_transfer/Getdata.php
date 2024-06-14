<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
session_start();

$start_date = explode('/', $_POST['start_date']);
$start_date = date('Y-m-d', strtotime($start_date['0'] . "-" . $start_date['1'] . "-" . $start_date['2']));

$end_date = explode('/', $_POST['end_date']);
$end_date = date('Y-m-d', strtotime($end_date['0'] . "-" . $end_date['1'] . "-" . $end_date['2']));

$chk_date = $_POST['chk'];
$user_id = $_SESSION['user_id'];
$branch_id = $_SESSION['branch_id'];
$user_level = $_SESSION['user_level'];


$condition = "";
if ($chk_date == "1") {
    $condition .= " AND a.create_datetime BETWEEN '$start_date 00:00:00' AND  '$end_date 23:59:59'";
} else {
    $condition .= " AND a.create_datetime BETWEEN '$start_date 00:00:00' AND  '$end_date 23:59:59' AND a.approve_result IS NULL";
}

// $sql = "SELECT a.*,b.fullname AS create_user,c.fullname AS from_user FROM tbl_transfer a  
// LEFT JOIN tbl_user b ON a.create_user_id = b.user_id
// LEFT JOIN tbl_user c ON a.from_user_id = c.user_id
// WHERE a.to_user_id = '$user_id' $condition ORDER BY receive_result IS NULL DESC ;";
// // echo $sql;
// $result  = mysqli_query($connect_db, $sql);

// // $row = mysqli_fetch_array($result);



$sql = "SELECT a.*,b.branch_name AS create_user,c.branch_name AS from_user FROM tbl_transfer a  
LEFT JOIN tbl_branch b ON a.from_branch_id = b.branch_id
LEFT JOIN tbl_branch c ON a.to_branch_id = c.branch_id
WHERE a.to_branch_id = '$branch_id' $condition  ORDER BY transfer_no DESC";
$result  = mysqli_query($connect_db, $sql);

$num_row = mysqli_num_rows($result);

?>

<?php
if ($num_row > 0) {
    while ($row = mysqli_fetch_array($result)) {

        $sql_r = "SELECT fullname FROM tbl_user WHERE user_id = '{$row['create_user_id']}' ;";
        $rs_r  = mysqli_query($connect_db, $sql_r) or die($connection->error);
        $row_r = mysqli_fetch_assoc($rs_r);

        $sql_d = "SELECT * FROM tbl_transfer_detail a JOIN tbl_spare_part b ON a.spare_part_id = b.spare_part_id 
                WHERE a.transfer_id = '{$row['transfer_id']}' ;";
        // echo $sql_d;
        $rs_d  = mysqli_query($connect_db, $sql_d) or die($connection->error);

        switch ($row['approve_result']) {
            case "1":
                $chk = "<span class = 'badge rounded-pill bg-success text-black'> รับ </span>";
                break;
            case "0":
                $chk = "<span class = 'badge rounded-pill bg-danger text-black'> ปฏิเสธ </span>";
                break;
            default:
                $chk = "<span class = 'badge rounded-pill bg-warning text-black'> รอดำเนินการ </span>";
        }

?>
        <br>

        <div class="ibox mb-3 d-block">
            <div class="ibox-title">
                <b><?php echo $row['transfer_no'] ?></b>
                <div class="ibox-tools">
                    <?php echo $chk ?>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row">

                    <div class="col-6 mb-3">
                        <label><b>AX_Ref_no</b></label> :<br> <?php echo $row['ax_ref_no'] ?>
                    </div>

                    <div class="col-6 mb-3">
                        <label><b>การทำรายการ</b></label> :<br>
                        <?php echo $row_r['fullname']; ?> <br><?php echo date('d-m-Y', strtotime($row['create_datetime'])); ?>
                    </div>

                </div>

                <div class="row">

                    <div class="col-6 mb-3">
                        <label><b>ผู้โอนย้าย</b></label> :<br> <?php echo $row['create_user']; ?>
                    </div>

                    <div class="col-6 mb-3">
                        <label><b>ผู้รับ</b></label> :<br> <?php echo $row['from_user']; ?>
                    </div>



                </div>

                <div class="row mb-2">

                    <div class="col-12">
                        <label><b>รายการอะไหล่</b></label> : <br>

                        <?php
                        $i = 0;
                        while ($row_d = mysqli_fetch_array($rs_d)) {
                            $i++;
                        ?>

                            <b><?php echo $i; ?>. </b>[ <?php echo $row_d['spare_part_code']; ?> ]
                            <?php echo $row_d['spare_part_name']; ?> x
                            <?php echo $row_d['quantity']; ?><br>


                        <?php } ?>

                    </div>


                </div>
                <br>
                <div class="row">
                    <div class="col-12">
                        <label><b>หมายเหตุ</b></label> : <br>


                        <label><?php echo $row['note'] ?></label>

                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-12">
                        <?php if ($row['approve_result'] == 1 ) { ?>
                            <button class="btn btn-success btn-block btn-xs" onclick="modal_detail('<?php echo $row['transfer_id']; ?>');"><i class="fa fa-search"></i>
                                ดูรายละเอียด</button>
                        <?php }
                        if ($row['approve_result'] == null && $user_level == 2) {
                        ?>
                            <button class="btn btn-success btn-block btn-xs" onclick="modal_approve('<?php echo $row['transfer_id']; ?>','1');"><i class="fa fa-check"></i>
                                อนุมัติ</button>
                            <button class="btn btn-danger btn-block btn-xs" onclick="modal_approve('<?php echo $row['transfer_id']; ?>','0');"><i class="fa fa-times"></i>
                                ปฏิเสธ</button>
                        <?php } ?>
                    </div>
                </div>

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
    function modal_detail(transfer_id) {

        $.ajax({
            type: "post",
            url: "ajax/confirm_transfer/modal_detail.php",
            data: {
                transfer_id: transfer_id
            },
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
                $('.summernote').summernote({
                    toolbar: false,
                    height: 100,
                });
                $(".select2").select2({});
                $(".datepicker").datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                });
            }
        });

    }

    function modal_approve(transfer_id, result) {
        swal({
            title: "",
            text: "กรุณายืนยันการทำรายการ",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#00FF00",
            confirmButtonText: "ยืนยัน",
            cancelButtonColor: "#DD6B55",
            cancelButtonText: "ยกเลิก",
            closeOnConfirm: false
        }, function() {

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "ajax/confirm_transfer/approve.php",
                data: {
                    transfer_id: transfer_id,
                    result: result
                },
                success: function(response) {

                    if (response.result == 1) {
                        swal({
                            title: "",
                            text: "ดำเนินการสำเร็จ",
                            type: "success",
                            showConfirmButton: false,
                            timer: 500
                        }, function() {
                            swal.close();
                            window.location.reload();
                        });
                    } else {
                        swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                    }

                }
            });

        });
    }
</script>
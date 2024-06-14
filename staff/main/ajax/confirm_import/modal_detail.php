<?php
session_start();
include('header2.php');
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$import_id = $_POST['import_id'];
$user_level = $_SESSION['user_level'];
$sql = "SELECT a.*,b.fullname    FROM tbl_import_stock a 
LEFT JOIN tbl_user b ON a.create_user_id = b.user_id
WHERE a.import_id = '$import_id';";
$result  = mysqli_query($connect_db, $sql);
// echo $sql;
$row = mysqli_fetch_array($result);


$chk2 = "-";
if ($row['receive_result'] == "") {
    $ch2 = "<span class = 'badge rounded-pill bg-warning text-black'>รอดำเนินการ</span>";
} else if ($row['receive_result'] == "1") {
    $chk2 = "<span class = 'badge rounded-pill bg-success text-black'>รับ</span>" . " [ " . date('d-M-Y', strtotime($row['receive_datetime'])) . " ]";
} else if ($row['receive_result'] == "0") {
    $chk2 = "<span class = 'badge rounded-pill bg-danger text-black'>ไม่รับ</span>" . " [ " . date('d-M-Y', strtotime($row['receive_datetime'])) . " ]";
}

switch ($row['receive_result']) {
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

<div class="modal-header">
    <h4 class="modal-title" id="exampleModalLabel">ยืนยันการรับของ <?php echo $chk ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>

<form id="frm_confirm" method="POST" enctype="multipart/form-data" novalidate>
    <div class="modal-body" style="padding-bottom: 0;">

        <input type="hidden" name="import_id" id="import_id" value="<?php echo $import_id ?>">


        <div class="row" style="margin-bottom:10px;">

            <!-- <div class="col-md-12 col-xs-12"> -->

            <?php

            if ($row['receive_result'] != NULL || $row['receive_result'] != "") {


                $sql_d = "SELECT * FROM tbl_import_stock_detail a JOIN tbl_spare_part b ON a.spare_part_id = b.spare_part_id 
                WHERE a.import_id = '{$row['import_id']}' ORDER BY list_order";
                // echo $sql_d;
                $rs_d  = mysqli_query($connect_db, $sql_d) or die($connection->error);

                $remark = "-";
                if ($row['receive_remark'] != "") {
                    $remark = $row['receive_remark'];
                }

            ?>
                <div class="row">

                    <div class="col-6">
                        <div class="form-group ">
                            <label><b>หมายเลขนำเข้า</b></label><br>
                            <label><?php echo $row['import_no'] ?></label>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group ">
                            <label><b>AX_Ref_no</b></label><br>
                            <label><?php echo $row['ax_ref_no'] ?></label>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group ">
                            <label><b>วันที่เบิกจาก AX</b></label><br>
                            <label><?php echo date('d-m-Y', strtotime($row['ax_withdraw_date'])); ?></label>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group ">
                            <label><b>ผู้ทำรายการ</b></label><br>
                            <label><?php echo $row['fullname'] ?></label>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group ">
                            <label><b>วันที่ทำรายการ</b></label><br>
                            <label><?php echo date('d-m-Y', strtotime($row['create_datetime'])); ?></label>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group ">
                            <label><b>วันที่อนุมัติ</b></label><br>
                            <label><?php echo date('d-m-Y', strtotime($row['receive_datetime'])); ?></label>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group ">
                            <label><b>หมายเหตุ</b></label><br>
                            <label><?php echo $row['note']; ?></label>
                        </div>
                    </div>

                    <!-- <div class="col-md-4">
                        <div class="form-group ">
                            <label><b>สถานะ</b></label><br>
                            <label><?php echo $chk2; ?></label>
                        </div>
                    </div> -->

                    <div class="col-6">
                        <div class="form-group ">
                            <label><b>หมายเหตุการอนุมัติ</b></label><br>
                            <label><?php echo $remark ?></label>
                        </div>
                    </div>

                    <div class="col-12">


                        <table class="table table-striped table-bordered table-hover dataTables-example spare_part_tbl">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:8%;">รหัสอะไหล่ </th>
                                    <th class="text-left" style="width:35%;">สิ่งที่เบิก</th>
                                    <th class="text-center" style="width:15%;">จำนวน</th>
                                    <!-- <th class="text-center" style="width:5%;">หมายเหตุ</th> -->
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $i = 0;

                                while ($row_d = mysqli_fetch_array($rs_d)) {

                                    $i++;


                                ?>


                                    <tr>

                                        <td class="text-center"><?php echo $row_d['spare_part_code']; ?></td>
                                        <td class="text-left"><?php echo $row_d['spare_part_name']; ?></td>
                                        <td class="text-center"><?php echo $row_d['quantity']; ?></td>


                                    </tr>

                                <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </div>



            <?php
            } else {

                $sql_d = "SELECT * FROM tbl_import_stock_detail a JOIN tbl_spare_part b ON a.spare_part_id = b.spare_part_id 
                WHERE a.import_id = '{$row['import_id']}' ORDER BY list_order";
                // echo $sql_d;
                $rs_d  = mysqli_query($connect_db, $sql_d) or die($connection->error);
            ?>

                <div class="row">

                    <div class="col-6">
                        <div class="form-group ">
                            <label><b>หมายเลขนำเข้า</b></label><br>
                            <label><?php echo $row['import_no'] ?></label>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group ">
                            <label><b>AX_Ref_no</b></label><br>
                            <label><?php echo $row['ax_ref_no'] ?></label>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group ">
                            <label><b>วันที่เบิกจาก AX</b></label><br>
                            <label><?php echo date('d-m-Y', strtotime($row['ax_withdraw_date'])); ?></label>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group ">
                            <label><b>ผู้ทำรายการ</b></label><br>
                            <label><?php echo $row['fullname'] ?></label>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group ">
                            <label><b>วันที่ทำรายการ</b></label><br>
                            <label><?php echo date('d-m-Y', strtotime($row['create_datetime'])); ?></label>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group ">
                            <label><b>หมายเหตุ</b></label><br>
                            <label><?php echo $row['note']; ?></label>
                        </div>
                    </div>


                    <div class="col-12">

                        <table class="table table-striped table-bordered table-hover dataTables-example spare_part_tbl">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:8%;">รหัสอะไหล่ </th>
                                    <th class="text-left" style="width:35%;">สิ่งที่เบิก</th>
                                    <th class="text-center" style="width:15%;">จำนวน</th>
                                    <!-- <th class="text-center" style="width:5%;">หมายเหตุ</th> -->
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $i = 0;

                                while ($row_d = mysqli_fetch_array($rs_d)) {

                                    $i++;


                                ?>


                                    <tr>

                                        <td class="text-center"><?php echo $row_d['spare_part_code']; ?></td>
                                        <td class="text-left"><?php echo $row_d['spare_part_name']; ?></td>
                                        <td class="text-center"><?php echo $row_d['quantity']; ?></td>


                                    </tr>

                                <?php } ?>
                            </tbody>
                        </table>

                    </div>


                    <?php if ($user_level == 2) { ?>
                        <div class="col-12">
                            <div class="form-group ">
                                <label>หมายเหตุ</label>
                                <textarea class="form-control summernote" rows="4" name="remark" id="remark"></textarea>
                            </div>
                        </div>


                        <div class="col-6 text-center">
                            <div class="form-group">
                                <button type="button" class="btn btn-success btn-xs btn-block" onclick="submit_approve();"><i class="fa fa-check"></i>
                                    อนุมัติ</button>
                                <!-- <button class="btn btn-danger btn-xs"
                                onclick="modal_cancel('<?php echo $row['import_id']; ?>');"><i class="fa fa-times"></i>
                                ปฏิเสธ</button> -->
                            </div>
                        </div>

                        <div class="col-6 text-center">
                            <div class="form-group">
                                <!-- <button class="btn btn-success btn-xs"
                                onclick="modal_approve('<?php echo $row['import_id']; ?>');"><i class="fa fa-check"></i>
                                อนุมัติ</button> -->
                                <button type="button" class="btn btn-danger btn-xs btn-block" onclick="submit_cancel();"><i class="fa fa-times"></i>
                                    ปฏิเสธ</button>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <!-- <div class="row"> -->

                <!-- </div> -->

            <?php
            }
            ?>


            <!-- </div> -->


        </div>

        <div class="row">
            <!-- <div class="col-12" style="text-align:right;">
                <button class="btn btn-success btn-md" type="button"
                    onclick="submit_approve();">ยืนยันการอนุมัติ</button>
            </div> -->
            <div class="col-12" style="text-align:right;">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"> ปิด</button>
            </div>
        </div><br>

    </div>
</form>



<script>
    $(document).ready(function() {


        $(".datepicker").datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            format: 'dd/mm/yyyy',
            autoclose: true
        });

        $(".select2").select2({});


    });

    $('.spare_part_tbl').DataTable({
        pageLength: 25,
        responsive: true,
    });

    $('.summernote').summernote({
        toolbar: false,
    });

    function submit_approve() {

        var import_id = $('#import_id').val();
        var remark = $('#remark').val();

        var formData = new FormData($("#frm_confirm")[0]);

        swal({
            title: 'กรุณายืนยันเพื่อทำรายการ',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'ยกเลิก',
            confirmButtonText: 'ยืนยัน',
            closeOnConfirm: false
        }, function() {
            $.ajax({
                type: 'POST',
                url: 'ajax/confirm_import/update_import.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    if (data.result == 0) {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'ไม่สามารถเพิ่มข้อมูลได้',
                            type: 'warning'
                        });
                        return false;
                    }
                    if (data.result == 1) {

                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1000
                        });
                        $('#Modal').modal('hide');
                        $('.modal-backdrop').remove();
                        Getdata();
                        // location.reload();
                    }
                }
            })
        });
    }


    function submit_cancel() {

        var import_id = $('#import_id').val();
        var remark = $('#remark').val();

        var formData = new FormData($("#frm_confirm")[0]);

        swal({
            title: 'กรุณายืนยันเพื่อทำรายการ',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'ยกเลิก',
            confirmButtonText: 'ยืนยัน',
            closeOnConfirm: false
        }, function() {
            $.ajax({
                type: 'POST',
                url: 'ajax/confirm_import/cancel_import.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    if (data.result == 0) {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'ไม่สามารถเพิ่มข้อมูลได้',
                            type: 'warning'
                        });
                        return false;
                    }
                    if (data.result == 1) {

                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1000
                        });
                        $('#Modal').modal('hide');
                        $('.modal-backdrop').remove();
                        Getdata();

                        // location.reload();
                    }
                }
            })
        });
    }
</script>
<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$job_id = $_POST['job_id'];
$type = $_POST['type'];
$sql = "SELECT a.*,b.product_type FROM tbl_job a
LEFT JOIN tbl_product b ON a.product_id = b.product_id
WHERE a.job_id = '$job_id'";
$rs  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($rs);

$sql_form1 = "SELECT * FROM tbl_oh_form WHERE product_type = '{$row['product_type']}' AND oh_type = '$type' AND list_order Between '1' and '16'";
$rs_form1  = mysqli_query($connect_db, $sql_form1);

$sql_form2 = "SELECT * FROM tbl_oh_form WHERE product_type = '{$row['product_type']}' AND oh_type = '$type' AND list_order Between '17' and '32'";
$rs_form2  = mysqli_query($connect_db, $sql_form2);

$i = 1;

if ($type == 1) {
    $oh_type_name = "เปิดล้างเครื่อง";
} else if ($type == 2) {
    $oh_type_name = "ล้างเครื่องเสร็จ";
} else if ($type == 3) {
    $oh_type_name = "เปิด QC";
} else if ($type == 4) {
    $oh_type_name = "ปิด QC";
} else if ($type == 5) {
    $oh_type_name = "ส่งคืนเครื่อง";
} else if ($type == 6) {
    $oh_type_name = "รับเครื่อง";
}
?>
<style>
    .select2-dropdown {
        z-index: 9999999;
    }
</style>
<form action="" method="post" id="form_qc" enctype="multipart/form-data">

    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>งาน OH</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body" style="padding-bottom: 0;">
        <input type="hidden" id="oh_form_id" name="oh_form_id" value="<?php echo getRandomID(10, 'tbl_job_oh_form_head', 'oh_form_id'); ?>"></input>
        <input type="hidden" id="job_id" name="job_id" value="<?php echo $job_id ?>"></input>
        <input type="hidden" id="product_type" name="product_type" value="<?php echo $row['product_type'] ?>"></input>
        <input type="hidden" id="oh_type" name="oh_type" value="<?php echo $type ?>"></input>
        <div class="row mb-3">

            <div class="col-4 mb-2">
                <label>ประเภท OH</label>

                <input type="text" readonly class="form-control" value="<?php echo $oh_type_name ?>">
            </div>

        </div>


        <div class="row mb-2">
            <div class="col-6">
                <div class="row">
                    <?php while ($row_form1 = mysqli_fetch_array($rs_form1)) { ?>
                        <input type="hidden" id="form_id" name="form_id[]" value="<?php echo $row_form1['form_id'] ?>">
                        <input type="hidden" id="form_type" name="form_type[]" value="<?php echo $row_form1['form_type'] ?>">

                        <?php if ($row_form1['form_type'] == 1) { ?>
                            <div class="col-12 mb-3">
                                <b><?php echo $row_form1['list_order'] . "." . $row_form1['form_name'] ?></b><br>
                                <input type="radio" class="iradio_square-green" id="select_choice" name="select_choice<?php echo $row_form1['list_order'] ?>" value="1"><label style="font-size: 13px; padding-right: 7px;padding-left: 7px;"> <?php echo $row_form1['choice1'] ?></label>
                                <input type="radio" class="iradio_square-green" id="select_choice" name="select_choice<?php echo $row_form1['list_order'] ?>" value="2"><label style="font-size: 13px; padding-right: 7px;padding-left: 7px;"> <?php echo $row_form1['choice2'] ?> </label>
                                <?php if ($row_form1['have_remark'] == 1) { ?>
                                    <input type="text" class="form-control" style="padding-right: 10px;padding-left: 10px;" id="note" name="note<?php echo $i; ?>">
                                <?php } ?>
                            </div>
                        <?php } else if ($row_form1['form_type'] == 2) { ?>
                            <div class="col-12 mb-3">
                                <b><?php echo $row_form1['list_order'] . "." . $row_form1['form_name'] ?></b><br>
                                <label style="font-size: 13px; padding-right: 7px;padding-left: 7px;"> <?php echo $row_form1['choice1'] ?></label> <input type="text" class="form-control mb-2" style="width: 50%;" id="choice1_value" name="choice1_value<?php echo $row_form1['list_order'] ?>">
                                <label style="font-size: 13px; padding-right: 7px;padding-left: 7px;"> <?php echo $row_form1['choice2'] ?> </label> <input type="text" class="form-control mb-2" style="width: 50%;" id="choice2_value" name="choice2_value<?php echo $row_form1['list_order'] ?>">
                                <?php if ($row_form1['have_remark'] == 1) { ?>
                                    <input type="text" class="form-control" style="padding-right: 10px;padding-left: 10px;" id="note" name="note<?php echo $i; ?>">
                                <?php } ?>
                            </div>
                        <?php  } else if ($row_form1['form_type'] == 3) { ?>
                            <div class="col-12 mb-3">
                                <b><?php echo $row_form1['list_order'] . "." . $row_form1['form_name'] ?></b><br>
                                <label style="font-size: 13px; padding-right: 7px;padding-left: 7px;"> <?php echo "หมายเหตุ" ?></label> <input type="text" style="width: 70%;" class="form-control" id="note" name="note<?php echo $row_form1['list_order'] ?>">

                            </div>
                        <?php  }  ?>


                    <?php $i++;
                    } ?>
                </div>
            </div>

            <div class="col-6">
                <div class="row">
                    <?php $b = 17;
                    while ($row_form2 = mysqli_fetch_array($rs_form2)) { ?>
                        <input type="hidden" id="form_id" name="form_id[]" value="<?php echo $row_form2['form_id'] ?>">
                        <input type="hidden" id="form_type" name="form_type[]" value="<?php echo $row_form2['form_type'] ?>">

                        <?php if ($row_form2['form_type'] == 1) { ?>
                            <div class="col-12 mb-3">
                                <b><?php echo $row_form2['list_order'] . "." . $row_form2['form_name'] ?></b><br>
                                <input type="radio" class="iradio_square-green" id="select_choice" name="select_choice<?php echo $row_form2['list_order'] ?>" value="1"><label style="font-size: 13px; padding-right: 7px;padding-left: 7px;"> <?php echo $row_form2['choice1'] ?></label>
                                <input type="radio" class="iradio_square-green" id="select_choice" name="select_choice<?php echo $row_form2['list_order'] ?>" value="2"><label style="font-size: 13px; padding-right: 7px;padding-left: 7px;"> <?php echo $row_form2['choice2'] ?> </label>
                                <?php if ($row_form2['have_remark'] == 1) { ?>
                                    <input type="text" class="form-control" style="padding-right: 10px;padding-left: 10px;" id="note" name="note<?php echo $i; ?>">
                                <?php } ?>
                            </div>
                        <?php } else if ($row_form2['form_type'] == 2) { ?>
                            <div class="col-12 mb-3">
                                <b><?php echo $row_form2['list_order'] . "." . $row_form2['form_name'] ?></b><br>
                                <label style="font-size: 13px; padding-right: 7px;padding-left: 7px;"> <?php echo $row_form2['choice1'] ?></label> <input type="text" class="form-control mb-2" style="width: 50%;" id="choice1_value" name="choice1_value<?php echo $row_form2['list_order'] ?>">
                                <label style="font-size: 13px; padding-right: 7px;padding-left: 7px;"> <?php echo $row_form2['choice2'] ?> </label> <input type="text" class="form-control mb-2" style="width: 50%;" id="choice2_value" name="choice2_value<?php echo $row_form2['list_order'] ?>">
                                <?php if ($row_form2['have_remark'] == 1) { ?>
                                    <input type="text" class="form-control" style="padding-right: 10px;padding-left: 10px;" id="note" name="note<?php echo $i; ?>">
                                <?php } ?>
                            </div>
                        <?php  } else if ($row_form2['form_type'] == 3) { ?>
                            <div class="col-12 mb-3">
                                <b><?php echo $row_form2['list_order'] . "." . $row_form2['form_name'] ?></b><br>
                                <label style="font-size: 13px; padding-right: 7px;padding-left: 7px;"> <?php echo "หมายเหตุ" ?></label> <input type="text" class="form-control" id="note" name="note<?php echo $row_form2['list_order'] ?>">

                            </div>
                        <?php  }  ?>
                    <?php $b++;
                    } ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mb-2">
                <label>หมายเหตุเพิ่มเติม</label>
            </div>
            <div class="col-12 mb-1">
                <textarea class="summernote" id="remark" name="remark"></textarea>
            </div>
        </div>

    </div>

    <hr>


    <br>
    </div>


</form>
<div class="modal-footer">
    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"> ปิด</button>
    <button class="btn btn-success btn-sm" type="button" id="submit" onclick="Submit_qc_overhaul()">บันทึก</button>
</div>


<?php include('import_script.php'); ?>
<script>
    $(".select2").select2({});

    $('.date').datepicker({
        // startView: 0,
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true,
        format: "dd/mm/yyyy",

    })


    function Submit_qc_overhaul() {


        var formData = new FormData($("#form_qc")[0]);

        if (job_id == "") {
            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                type: 'error'
            });
            return false;
        }

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
                url: 'ajax/CM_view/sub_oh/add_qc_overhaul.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    if (data.result == 1) {
                        $('#modal1').modal('hide');
                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                            showConfirmButton: false
                        });
                        setTimeout(function() {
                            swal.close();
                        }, 500);
                        window.location.reload();
                    }
                    if (data.result == 0) {
                        swal({
                            title: "เกิดข้อผิดพลาด",
                            text: "บันทึกผิดพลาด",
                            type: "error",
                        });
                        return false;
                    }

                    if (data.result == 2) {
                        swal({
                            title: "มีการบันทึกรายการแล้ว",
                            text: "กรุณาตรวจสอบข้อมูล",
                            type: "error",
                        });
                        return false;
                    }
                }

            })
        });
    }
</script>
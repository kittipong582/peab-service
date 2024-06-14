<?php
session_start();
include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$oh_form_id = $_POST['oh_form_id'];
$type = $_POST['type'];
$sql = "SELECT a.* FROM tbl_job_oh_form_head a
LEFT JOIN tbl_job c ON a.job_id = c.job_id
LEFT JOIN tbl_product b ON c.product_id = b.product_id
WHERE a.oh_form_id = '$oh_form_id'";
$rs  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($rs);

// echo $sql;

$sql_form = "SELECT * FROM tbl_oh_form";
$rs_form  = mysqli_query($connect_db, $sql_form);

$i = 1;

if ($type == 1) {
    $ohtype = "รับเครื่องกลับเพื่อOH";
} else if ($type == 2) {
    $ohtype = "ส่งเครื่องหลังจากล้าง";
} else if ($type == 3) {
    $ohtype = "เปิด QC";
} else if ($type == 4) {
    $ohtype = "ปิด QC";
}else if($type == 5){
    $ohtype = "ส่งเครื่องคืนร้าน";
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
        <input type="hidden" id="oh_form_id" name="oh_form_id" value="<?php echo $row['oh_form_id']; ?>"></input>
        <input type="hidden" id="job_id" name="job_id" value="<?php echo $job_id ?>"></input>

        <div class="row">

            <div class="col-12 mb-2">
                <label>ประเภท OH</label>
            </div>
            <div class="col-12 mb-3">
                <input type="text" readonly class="form-control" value="<?php echo $ohtype ?>">
            </div>

            <div class="col-12 mb-2">
                <label>ประเภทเครื่อง</label>
            </div>
            <div class="col-12 mb-3">
                <select class="select2 form-control" id="product_type" name="product_type" style="width:100%;">
                    <option value="">กรุณาเลือกประเภทเครื่อง</option>
                    <option value="1" <?php if ($row['product_type'] == 1) {
                                            echo "selected";
                                        } ?>>เครื่อง OH</option>
                    <option value="2" <?php if ($row['product_type'] == 2) {
                                            echo "selected";
                                        } ?>>เครื่องสำรอง</option>
                </select>
            </div>


            <div class="col-12 mb-2">
                <label>ตัวเลือกเครื่องสำรอง</label>
            </div>
            <div class="col-12 mb-3">
                <select class="select2 form-control" id="product_status" name="product_status" style="width:100%;">
                    <option value="">กรุณาเลือก</option>
                    <option value="1" <?php if ($row['product_status'] == 1) {
                                            echo "selected";
                                        } ?>>รับเครื่องสำรอง</option>
                    <option value="2" <?php if ($row['product_status'] == 2) {
                                            echo "selected";
                                        } ?>>วางเครื่องสำรอง</option>
                    <option value="3" <?php if ($row['product_status'] == 3) {
                                            echo "selected";
                                        } ?>>ไม่รับเครื่องสำรอง</option>
                </select>
            </div>
        </div>
        <hr>
        <div class="row mb-2">
            <?php while ($row_form = mysqli_fetch_array($rs_form)) {

                $sql_val1 = "SELECT * FROM tbl_job_oh_form_detail WHERE form_id = '{$row_form['form_id']}' AND oh_form_id = '$oh_form_id'";
                $result_val1  = mysqli_query($connect_db, $sql_val1);
                $row_val1 = mysqli_fetch_array($result_val1);

            ?>
                <input type="hidden" id="form_id" name="form_id[]" value="<?php echo $row_form['form_id'] ?>">
                <div class="col-12 mb-3">
                    <?php echo $row_form['list_order'] . "." . $row_form['form_name'] ?>
                </div>
                <div class="col-12 mb-3">
                    <input type="radio" class="iradio_square-green" id="select_choice" name="select_choice<?php echo $i ?>" value="1" <?php if ($row_val1['select_choice'] == 1) {
                                                                                                                                            echo "CHECKED";
                                                                                                                                        } ?>><label style="font-size: 13px; padding-right: 10px;padding-left: 10px;"> <?php echo $row_form['choice1'] ?> </label><br>
                    <input type="radio" class="iradio_square-green" id="select_choice" name="select_choice<?php echo $i ?>" value="2" <?php if ($row_val1['select_choice'] == 2) {
                                                                                                                                            echo "CHECKED";
                                                                                                                                        } ?>><label style="font-size: 13px;padding-right: 10px;padding-left: 10px; "> <?php echo $row_form['choice2'] ?> </label>
                    <input type="text" class="boxline" style="padding-right: 10px;padding-left: 10px;" id="note" name="note<?php echo $i; ?>" value="<?php echo $row_val1['note'] ?>">
                </div>
            <?php $i++;
            } ?>
        </div>

        <div class="row">
            <div class="col-12 mb-2">
                <label>หมายเหตุเพิ่มเติม</label>
            </div>
            <div class="col-12 mb-1">
                <textarea class="summernote" id="remark" name="remark"><?php echo $row['remark'] ?></textarea>
            </div>
        </div>

    </div>

    <hr>


    <br>
    </div>


</form>
<div class="modal-footer">
    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"> ปิด</button>
    <button class="btn btn-success btn-sm" type="button" id="submit" onclick="Submit_Edit()">บันทึก</button>
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


    function Submit_Edit() {


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
                url: 'ajax/mywork/record_qc/update_qc_overhaul.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    if (data.result == 1) {
                        $('#modal').modal('hide');
                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                        }, function() {
                            Getdata();
                        });
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
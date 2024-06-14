<?php

include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$job_id = $_POST['job_id'];
$product_id = $_POST['product_id'];

$sql_chk = "SELECT job_type FROM tbl_job WHERE job_id = '$job_id'";
$rs_chk = mysqli_query($connect_db, $sql_chk) or die($connect_db->error);
$row_chk = mysqli_fetch_assoc($rs_chk);

if ($row_chk['job_type'] == 3) {
    $sql = "SELECT a.*,b.product_type FROM tbl_job a
    LEFT JOIN tbl_in_product c ON a.job_id = c.job_id
LEFT JOIN tbl_product b ON c.product_id = b.product_id
WHERE a.job_id = '$job_id' AND c.product_id = '$product_id'";
} else {
    $sql = "SELECT a.*,b.product_type FROM tbl_job a
LEFT JOIN tbl_product b ON a.product_id = b.product_id
WHERE a.job_id = '$job_id'";
}
$rs = mysqli_query($connect_db, $sql) or die($connect_db->error);
$row = mysqli_fetch_assoc($rs);

// $url = '../../../admin/upload/' . $row['receive_file'];

///////column 
$sql_form = "SELECT * FROM tbl_technical_form WHERE job_type ='{$row['job_type']}' AND product_type = '{$row['product_type']}' ORDER BY list_order";
$result_form  = mysqli_query($connect_db, $sql_form);

// echo $sql;
?>

<div class="modal-header">
    <h4 class="modal-title" id="exampleModalLabel">บันทึกการปฏิบัติงาน</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<form id="frm_record_finish_job" method="POST" enctype="multipart/form-data">
    <div class="modal-body" style="padding-bottom: 0;">


        <input type="hidden" id="job_id" name="job_id" value="<?php echo $job_id ?>"></input>
        <input type="hidden" id="product_id" name="product_id" value="<?php echo $product_id ?>"></input>
        <div class="row">
            <?php
            $i = 1;

            while ($row_form = mysqli_fetch_array($result_form)) { ?>

                <input type="hidden" id="form_id" name="form_id[]" value="<?php echo $row_form['form_id']; ?>">

                <?php if ($row_form['form_type'] == '1' && $row_form['have_remark'] == '0') {

                ?>

                    <div class="col-12 mb-3">
                        <?php echo $row_form['list_order'] . "." . $row_form['form_name'] ?>
                    </div>
                    <div class="col-12 mb-3">

                        <input type="radio" class="iradio_square-green" id="select_choice" name="select_choice<?php echo $i; ?>" value="1"><label style="font-size: 13px; padding-right: 7px;padding-left: 7px;"> <?php echo $row_form['choice1'] ?></label>
                        <input type="radio" class="iradio_square-green" id="select_choice" name="select_choice<?php echo $i; ?>" value="2"><label style="font-size: 13px; padding-right: 7px;padding-left: 7px;"> <?php echo $row_form['choice2'] ?> </label>

                    </div>

                <?php } else if ($row_form['form_type'] == '1' && $row_form['have_remark'] == '1') {

                ?>

                    <div class="col-12 mb-3">
                        <?php echo $row_form['list_order'] . "." . $row_form['form_name'] ?>
                    </div>
                    <div class="col-12 mb-3">

                        <input type="radio" class="iradio_square-green" id="select_choice" name="select_choice<?php echo $i; ?>" value="1"><label style="font-size: 13px; padding-right: 10px;padding-left: 10px;"> <?php echo $row_form['choice1'] ?> </label><br>
                        <input type="radio" class="iradio_square-green" id="select_choice" name="select_choice<?php echo $i; ?>" value="2"><label style="font-size: 13px;padding-right: 10px;padding-left: 10px; "> <?php echo $row_form['choice2'] ?> </label>

                        <input type="text" class="boxline" style="padding-right: 10px;padding-left: 10px;" id="note" name="note<?php echo $i; ?>">
                    </div>

                <?php  } else if ($row_form['form_type'] == '2') {

                ?>
                    <div class="col-12 mb-3">
                        <?php echo $row_form['list_order'] . "." . $row_form['form_name'] ?>
                    </div>
                    <div class="col-12 mb-3">
                        <label style="font-size: 13px;"> <?php echo $row_form['choice1'] ?> </label><input type="text" class="boxline" style="padding-right: 10px;padding-left: 10px;" id="choice1_value" name="choice1_value<?php echo $i ?>">
                        <label style="font-size: 13px; "> <?php echo $row_form['choice2'] ?> </label><input type="text" class="boxline" style="padding-right: 10px;padding-left: 10px;" id="choice2_value" name="choice2_value<?php echo $i ?>">
                    </div>

            <?php  }
                $i++;
            }
            ?>
        </div>

        <hr>
        <div class="row">
            <div class="col-12 mb-1">
                <label>หมายเหตุ</label>
            </div>

            <div class="col-12 mb-1">
                <textarea class="summernote" id="remark" name="remark"></textarea>
            </div>


        </div>
        <hr>
        <div class="row">
            <div class="col-12 mb-1">
                <label>ประเมินความพึงพอใจ</label>
            </div>
            <?php
            $i = 0;

            $sql_el = "SELECT * FROM tbl_job_evaluate WHERE job_type = '{$row_chk['job_type']}' ORDER BY list_order ASC";
            $rs_el = mysqli_query($connect_db, $sql_el);
            while ($row_el = mysqli_fetch_assoc($rs_el)) {

                $i++;
            ?>
                <!-- 1. -->
                <div class="col-12 mb-2">
                    <?php echo $i . ". " . $row_el['detail'] ?>
                </div>
                <div class="col-12 mb-3">
                    <input type="radio" class="iradio_square-green" id="choice_el_<?php echo  $i ?>" name="choice_el_<?php echo $row_el['evaluate_id'] ?>" value="5"><label style="font-size: 13px; padding-right: 10px;"> &nbsp;มากที่สุด</label><br>
                    <input type="radio" class="iradio_square-green" id="choice_el_<?php echo $i ?>" name="choice_el_<?php echo $row_el['evaluate_id'] ?>" value="4"><label style="font-size: 13px; padding-right: 10px;"> &nbsp;มาก</label><br>
                    <input type="radio" class="iradio_square-green" id="choice_el_<?php echo $i ?>" name="choice_el_<?php echo $row_el['evaluate_id'] ?>" value="3"><label style="font-size: 13px; padding-right: 10px;"> &nbsp;ปานกลาง </label><br>
                    <input type="radio" class="iradio_square-green" id="choice_el_<?php echo $i ?>" name="choice_el_<?php echo $row_el['evaluate_id'] ?>" value="2"><label style="font-size: 13px; padding-right: 10px;"> &nbsp;น้อย </label><br>
                    <input type="radio" class="iradio_square-green" id="choice_el_<?php echo $i ?>" name="choice_el_<?php echo $row_el['evaluate_id'] ?>" value="1"><label style="font-size: 13px; padding-right: 10px;"> &nbsp;น้อยที่สุด </label><br>

                </div>
            <?php } ?>


        </div>

    </div>
</form>


<div class="modal-footer">
    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"> ปิด</button>
    <button type="button" class="btn btn-primary btn-sm" onclick="Submit_close_record();"></i>บันทึก</button>

</div>


<script>
    $(document).ready(function() {

        $(".select2").select2({});


        $('.iradio_square-green').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    });



    function Submit_close_record() {


        var job_id = $('#job_id').val();


        var formData = new FormData($("#frm_record_finish_job")[0]);

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
                url: 'ajax/mywork/record_finish_job/Add.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    if (data.result == 1) {
                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                            showConfirmButton: false
                        });
                        setTimeout(function() {
                            swal.close();
                        }, 500);
                        $("#modal").modal('hide');

                        Getdata();
                    } else {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'ชื่อผู้ใช้ซ้ำ กรุณากรอกใหม่ !!',
                            type: 'warning'
                        });
                        return false;
                    }

                }
            })
        });

    }
</script>
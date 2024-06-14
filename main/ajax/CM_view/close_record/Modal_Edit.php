<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];

$sql = "SELECT b.job_type,b.job_id,c.product_type,c.product_id FROM tbl_job b 
LEFT JOIN tbl_product c ON b.product_id = c.product_id
WHERE b.job_id = '$job_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

// echo $sql;

///////column 
$sql_form = "SELECT * FROM tbl_technical_form WHERE job_type ='{$row['job_type']}' AND product_type = '{$row['product_type']}' AND list_order BETWEEN '1' and '16'  ORDER BY list_order";
$result_form  = mysqli_query($connect_db, $sql_form);
// echo $sql_form;

///////column 1
$sql_form1 = "SELECT * FROM tbl_technical_form WHERE job_type ='{$row['job_type']}' AND product_type = '{$row['product_type']}' AND list_order BETWEEN '17' and '32'  ORDER BY list_order";
$result_form1  = mysqli_query($connect_db, $sql_form1);


//////////////remark///////////
$sql_remark = "SELECT remark FROM tbl_job_form_remark WHERE job_id = '$job_id'";
$result_remark  = mysqli_query($connect_db, $sql_remark);
$row_remark = mysqli_fetch_array($result_remark);

?>
<style>
    .boxline {
        width: 100%;
        background:
            linear-gradient(#000, #000) center bottom 5px /calc(100% - 10px) 1px no-repeat;
        border: 0;
        padding: 10px;
    }
</style>
<form action="" method="post" id="form-add_close_record" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>แบบบันทึกปิดงาน</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <input type="hidden" id="product_id" name="product_id" value="<?php echo $row['product_id'] ?>"></input>
        <input type="hidden" id="product_type" name="product_type" value="<?php echo $row['product_type'] ?>"></input>
        <input type="hidden" id="job_id" name="job_id" value="<?php echo $row['job_id'] ?>"></input>

        <div class="row">
            <div class='col-6 mb-3'>
                <div class="row">
                    <?php
                    $i = 1;
                    while ($row_form = mysqli_fetch_array($result_form)) {


                        $sql_val1 = "SELECT * FROM tbl_job_form WHERE job_id = '$job_id' AND form_id = '{$row_form['form_id']}'";
                        $result_val1  = mysqli_query($connect_db, $sql_val1);
                        $row_val1 = mysqli_fetch_array($result_val1);


                    ?>

                        <input type="hidden" id="form_id" name="form_id[]" value="<?php echo $row_form['form_id']; ?>"></input>
                        <?php if ($row_form['form_type'] == '1' && $row_form['have_remark'] == '0') {

                        ?>
                            <div class="col-6 mb-3">
                                <?php echo $row_form['list_order'] . "." . $row_form['form_name'] ?>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="input-group">
                                    <input type="radio" class="iradio_square-green" id="select_choice" name="select_choice<?php echo $i ?>" value="1" <?php if ($row_val1['select_choice'] == 1) {
                                                                                                                                                            echo "CHECKED";
                                                                                                                                                        } ?>><label style="font-size: 13px; padding-right: 10px;padding-left: 10px;"> <?php echo $row_form['choice1'] ?></label>
                                    <input type="radio" class="iradio_square-green" id="select_choice" name="select_choice<?php echo $i ?>" value="2" <?php if ($row_val1['select_choice'] == 2) {
                                                                                                                                                            echo "CHECKED";
                                                                                                                                                        } ?>><label style="font-size: 13px; padding-right: 10px;padding-left: 10px;"> <?php echo $row_form['choice2'] ?> </label>
                                </div>
                            </div>

                        <?php } else if ($row_form['form_type'] == '1' && $row_form['have_remark'] == '1') {

                        ?>

                            <div class="col-6 mb-3">
                                <?php echo $row_form['list_order'] . "." . $row_form['form_name'] ?>
                            </div>
                            <div class="col-6 mb-3">
                                <input type="radio" class="iradio_square-green" id="select_choice" name="select_choice<?php echo $i ?>" value="1" <?php if ($row_val1['select_choice'] == 1) {
                                                                                                                                                        echo "CHECKED";
                                                                                                                                                    } ?>><label style="font-size: 13px; padding-right: 10px;padding-left: 10px;"> <?php echo $row_form['choice1'] ?> </label><br>
                                <input type="radio" class="iradio_square-green" id="select_choice" name="select_choice<?php echo $i ?>" value="2" <?php if ($row_val1['select_choice'] == 2) {
                                                                                                                                                        echo "CHECKED";
                                                                                                                                                    } ?>><label style="font-size: 13px;padding-right: 10px;padding-left: 10px; "> <?php echo $row_form['choice2'] ?> </label>
                                <input type="text" class="boxline" style="padding-right: 10px;padding-left: 10px;" id="note" name="note<?php echo $i; ?>" value="<?php echo $row_val1['note'] ?>">
                            </div>

                        <?php  } else if ($row_form['form_type'] == '2') {

                        ?>
                            <div class="col-6 mb-3">
                                <?php echo $row_form['list_order'] . "." . $row_form['form_name'] ?>
                            </div>
                            <div class="col-6 mb-3">
                                <label style="font-size: 13px;"> <?php echo $row_form['choice1'] ?> </label><input type="text" class="boxline" style="padding-right: 10px;padding-left: 10px;" id="choice1_value" value="<?php echo $row_val1['choice1_value'] ?>" name="choice1_value<?php echo $i ?>">
                                <label style="font-size: 13px; "> <?php echo $row_form['choice2'] ?> </label><input type="text" class="boxline" style="padding-right: 10px;padding-left: 10px;" id="choice2_value" value="<?php echo $row_val1['choice2_value'] ?>" name="choice2_value<?php echo $i ?>">
                            </div>

                    <?php  }
                        $i++;
                    }
                    ?>
                </div>
            </div>
            <div class='col-6 mb-3'>
                <div class="row">
                    <?php
                    $i = 17;
                    while ($row_form1 = mysqli_fetch_array($result_form1)) {


                        $sql_val2 = "SELECT * FROM tbl_job_form WHERE job_id = '$job_id' AND form_id = '{$row_form1['form_id']}'";
                        $result_val2  = mysqli_query($connect_db, $sql_val2);
                        $row_val2 = mysqli_fetch_array($result_val2); ?>

                        <input type="hidden" id="form_id" name="form_id[]" value="<?php echo $row_form1['form_id']; ?>"></input>

                        <?php if ($row_form1['form_type'] == '1' && $row_form1['have_remark'] == '0') {

                        ?>
                            <div class="col-6 mb-3">
                                <?php echo $row_form1['list_order'] . "." . $row_form1['form_name'] ?>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="input-group">
                                    <input type="radio" class="iradio_square-green" id="select_choice" name="select_choice<?php echo $i ?>" value="1" <?php if ($row_val2['select_choice'] == 1) {
                                                                                                                                                            echo "CHECKED";
                                                                                                                                                        } ?>><label style="font-size: 13px; padding-right: 10px;padding-left: 10px;"> <?php echo $row_form1['choice1'] ?></label>
                                    <input type="radio" class="iradio_square-green" id="select_choice" name="select_choice<?php echo $i ?>" value="2" <?php if ($row_val2['select_choice'] == 2) {
                                                                                                                                                            echo "CHECKED";
                                                                                                                                                        } ?>><label style="font-size: 13px; padding-right: 10px;padding-left: 10px;"> <?php echo $row_form1['choice2'] ?> </label>
                                </div>
                            </div>

                        <?php } else if ($row_form1['form_type'] == '1' && $row_form1['have_remark'] == '1') {

                        ?>

                            <div class="col-6 mb-3">
                                <?php echo $row_form1['list_order'] . "." . $row_form1['form_name'] ?>
                            </div>
                            <div class="col-6 mb-3">
                                <input type="radio" class="iradio_square-green" id="select_choice" name="select_choice<?php echo $i ?>" value="1" <?php if ($row_val2['select_choice'] == 1) {
                                                                                                                                                        echo "CHECKED";
                                                                                                                                                    } ?>><label style="font-size: 13px; padding-right: 10px;padding-left: 10px;"> <?php echo $row_form1['choice1'] ?> </label><br>
                                <input type="radio" class="iradio_square-green" id="select_choice" name="select_choice<?php echo $i ?>" value="2" <?php if ($row_val2['select_choice'] == 2) {
                                                                                                                                                        echo "CHECKED";
                                                                                                                                                    } ?>><label style="font-size: 13px;padding-right: 10px;padding-left: 10px; "> <?php echo $row_form1['choice2'] ?> </label>
                                <input type="text" class="boxline" style="padding-right: 10px;padding-left: 10px;" id="note" name="note<?php echo $i; ?>" value="<?php echo $row_val2['note'] ?>">
                            </div>

                        <?php  } else if ($row_form1['form_type'] == '2') {

                        ?>
                            <div class="col-6 mb-3">
                                <?php echo $row_form1['list_order'] . "." . $row_form1['form_name'] ?>
                            </div>
                            <div class="col-6 mb-3">
                                <label style="font-size: 13px;"> <?php echo $row_form1['choice1'] ?> </label><input type="text" class="boxline" style="padding-right: 10px;padding-left: 10px;" id="choice1_value" name="choice1_value<?php echo $i ?>" value="<?php echo $row_val2['choice1_value'] ?>">
                                <label style="font-size: 13px; "> <?php echo $row_form1['choice2'] ?> </label><input type="text" class="boxline" style="padding-right: 10px;padding-left: 10px;" id="choice2_value" name="choice2_value<?php echo $i ?>" value="<?php echo $row_val2['choice2_value'] ?>">
                            </div>

                    <?php  }
                        $i++;
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <br>หมายเหตุ
            </div>
            <div class="col-12">
                <textarea class="summernote" id="remark" name="remark"><?php echo $row_remark['remark'] ?></textarea>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <label>ประเมินความพึงพอใจ</label>
            </div>
            <!-- 1. -->
            <div class="col-12">
                <br>การแต่งกาย / กริยา / ความเต็มใจ / ความสะอาด
            </div>
            <div class="col-12">
                <input type="radio" class="iradio_square-green" id="choice_no32" name="choice_no32" value="3" <?php echo ($row['choice_no32'] == 3) ?  "checked" : "";  ?>><label style="font-size: 13px; padding-right: 10px;padding-left: 10px;"> &nbsp;มาก </label>
                <input type="radio" class="iradio_square-green" id="choice_no32" name="choice_no32" value="2" <?php echo ($row['choice_no32'] == 2) ?  "checked" : "";  ?>><label style="font-size: 13px; "> &nbsp;ปานกลาง </label>
                <input type="radio" class="iradio_square-green" id="choice_no32" name="choice_no32" value="1" <?php echo ($row['choice_no32'] == 1) ?  "checked" : "";  ?>><label style="font-size: 13px; "> &nbsp;ปรับปรุง </label>

            </div>

            <div class="col-12">
                <br>ความชัดเจนให้คำแนะนำ / การแจ้งผล
            </div>
            <div class="col-12">
                <input type="radio" class="iradio_square-green" id="choice_no33" name="choice_no33" value="3" <?php echo ($row['choice_no33'] == 3) ?  "checked" : "";  ?>><label style="font-size: 13px; padding-right: 10px;padding-left: 10px;"> &nbsp;มาก </label>
                <input type="radio" class="iradio_square-green" id="choice_no33" name="choice_no33" value="2" <?php echo ($row['choice_no33'] == 2) ?  "checked" : "";  ?>><label style="font-size: 13px; "> &nbsp;ปานกลาง </label>
                <input type="radio" class="iradio_square-green" id="choice_no33" name="choice_no33" value="1" <?php echo ($row['choice_no33'] == 1) ?  "checked" : "";  ?>><label style="font-size: 13px; "> &nbsp;ปรับปรุง </label>

            </div>

            <div class="col-12">
                <br>การให้บริการตามวันเวลาที่กำหนด
            </div>
            <div class="col-12">
                <input type="radio" class="iradio_square-green" id="choice_no34" name="choice_no34" value="3" <?php echo ($row['choice_no34'] == 3) ?  "checked" : "";  ?>><label style="font-size: 13px; padding-right: 10px;padding-left: 10px;"> &nbsp;มาก </label>
                <input type="radio" class="iradio_square-green" id="choice_no34" name="choice_no34" value="2" <?php echo ($row['choice_no34'] == 2) ?  "checked" : "";  ?>><label style="font-size: 13px; "> &nbsp;ปานกลาง </label>
                <input type="radio" class="iradio_square-green" id="choice_no34" name="choice_no34" value="1" <?php echo ($row['choice_no34'] == 1) ?  "checked" : "";  ?>><label style="font-size: 13px; "> &nbsp;ปรับปรุง </label>

            </div>

            <div class="col-12">
                <br>ความสามารถในการปฏิบัติงาน
            </div>
            <div class="col-12">
                <input type="radio" class="iradio_square-green" id="choice_no35" name="choice_no35" value="3" <?php echo ($row['choice_no35'] == 3) ?  "checked" : "";  ?>><label style="font-size: 13px; padding-right: 10px;padding-left: 10px;"> &nbsp;มาก </label>
                <input type="radio" class="iradio_square-green" id="choice_no35" name="choice_no35" value="2" <?php echo ($row['choice_no35'] == 2) ?  "checked" : "";  ?>><label style="font-size: 13px; "> &nbsp;ปานกลาง </label>
                <input type="radio" class="iradio_square-green" id="choice_no35" name="choice_no35" value="1" <?php echo ($row['choice_no35'] == 1) ?  "checked" : "";  ?>><label style="font-size: 13px; "> &nbsp;ปรับปรุง </label>

            </div>



        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary px-5" type="button" id="submit" onclick="Update_close_record()">บันทึก</button>
    </div>
</form>

<?php include('import_script.php'); ?>
<script>
    $(document).ready(function() {

        $(".select2").select2({});
    });


    $('.iradio_square-green').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });

    function Update_close_record() {

        var job_id = $('#job_id').val();


        var formData = new FormData($("#form-add_close_record")[0]);

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
                url: 'ajax/CM_view/close_record/Update.php',
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
                        $("#modal1").modal('hide');
                        $("#modal").modal('hide');

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
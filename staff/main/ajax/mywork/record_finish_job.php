<?php

include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
session_start();
$user_id = $_SESSION['user_id'];

$job_id = $_POST['job_id'];

$sql_job = "SELECT job_type,close_user_id FROM tbl_job WHERE job_id = '$job_id'";
$rs_job = mysqli_query($connect_db, $sql_job) or die($connect_db->error);
$row_job = mysqli_fetch_array($rs_job);

$sql = "SELECT * FROM tbl_job_form WHERE job_id = '$job_id'";
$rs = mysqli_query($connect_db, $sql) or die($connect_db->error);
$row = mysqli_fetch_array($rs);
$num_row = mysqli_num_rows($rs);
// echo $sql;
?>
<style>
    .border-black {
        border: 1px solid black;
    }
</style>

<div class="wrapper wrapper-content" style="padding: 15px 0px 0px 0px;">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">

                    <div class="ibox-content">
                        <?php if ($row_job['close_user_id'] == NULL) { ?>
                            <div class="row">

                                <?php
                                if ($row_job['job_type'] == 3) {

                                    $sql_product = "SELECT * FROM tbl_in_product a
                        LEFT JOIN tbl_product c ON a.product_id = c.product_id
                        LEFT JOIN tbl_product_model d ON c.model_id = d.model_id
                        WHERE job_id = '$job_id'";
                                    $result_product  = mysqli_query($connect_db, $sql_product);
                                    while ($row_product = mysqli_fetch_array($result_product)) {

                                        $product_id = $row_product['product_id'];
                                        $sql1 = "SELECT * FROM tbl_job_form WHERE product_id = '$product_id' AND job_id = '$job_id'";
                                        $rs1 = mysqli_query($connect_db, $sql1) or die($connect_db->error);
                                        $row1 = mysqli_fetch_array($rs1);
                                        $num_row1 = mysqli_num_rows($rs1);
                                        // echo $sql1;
                                ?>
                                        <div class="col-12 text-center mb-2">
                                            <?php if ($num_row1 == 0) { ?>
                                                <button class="btn btn-success btn-md " type="button" id="check" onclick="modal_finish_job('<?php echo $job_id ?>','<?php echo $product_id ?>')">บันทึกการปฏิบัติงาน เครื่อง - <?php echo $row_product['serial_no'] ?></button>
                                            <?php } else { ?>
                                                <div class="form-group">
                                                    <button class="btn btn-warning btn-md " type="button" onclick="modal_edit_finish('<?php echo $job_id ?>','<?php echo $product_id ?>')">แก้ไขบันทึกการปฏิบัติงาน เครื่อง - <?php echo $row_product['serial_no'] ?></button>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php }
                                } else { ?>

                                    <div class="col-12 text-center">
                                        <?php if ($num_row == 0) {
                                        ?>
                                            <button class="btn btn-success btn-md " type="button" id="check" onclick="modal_finish_job('<?php echo $job_id ?>')">บันทึกการปฏิบัติงาน</button>
                                        <?php
                                        } else {
                                        ?>
                                            <div class="form-group">
                                                <button class="btn btn-warning btn-md " type="button" onclick="modal_edit_finish('<?php echo $job_id ?>')">แก้ไขบันทึกการปฏิบัติงาน</button>
                                            </div>

                                            <div class="form-group">
                                                <!-- <button class="btn btn-success btn-md " type="button" onclick="print_finish_form('<?php echo $job_id ?>')">พิมพ์ใบบันทึก</button> -->
                                            </div>
                                        <?php
                                        } ?>
                                    </div>
                                <?php  } ?>
                            </div>
                        <?php } ?>

                        <?php if ($num_row != 0) { ?>
                            <div class="text-center">
                                <button class="btn btn-info btn-md " type="button" id="" onclick="">พิมพ์บันทึกการปฏิบัติงาน</button>
                            </div>
                        <?php } ?>
                    </div>

                    <!-- <input type="checkbox"> -->

                    <!-- <div class="ibox-content">

                    </div> -->

                </div>
            </div>
        </div>
    </div>
</div>

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

    $('table').DataTable({
        pageLength: 10,
        responsive: true,
        // sorting: disable
    });


    function modal_finish_job(job_id, product_id) {
        $.ajax({
            type: "post",
            url: "ajax/mywork/record_finish_job/modal_record_finish_job.php",
            data: {
                job_id: job_id,
                product_id: product_id
            },
            dataType: "html",
            success: function(response) {
                $('#modal .modal-content').html(response);
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
                $('.iradio_square-green').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });
            }
        });


    }

    function modal_edit_finish(form_id, product_id) {
        // console.log(form_id);

        $.ajax({
            type: "post",
            url: "ajax/mywork/record_finish_job/modal_edit_record_finish_job.php",
            data: {
                form_id: form_id,
                product_id: product_id
            },
            dataType: "html",
            success: function(response) {
                $('#modal .modal-content').html(response);
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
                $('.iradio_square-green').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });
            }
        });

    }
</script>
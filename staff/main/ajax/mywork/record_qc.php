<?php

include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
session_start();
$user_id = $_SESSION['user_id'];

$job_id = $_POST['job_id'];

$sql = "SELECT * FROM tbl_job WHERE job_id = '$job_id'";
$rs = mysqli_query($connect_db, $sql) or die($connect_db->error);
$row = mysqli_fetch_array($rs);

$product_id = $row['product_id'];

$sql_qc = "SELECT * FROM tbl_technical_form WHERE  job_type = '4'";
$rs_qc = mysqli_query($connect_db, $sql_qc) or die($connect_db->error);
$row_qc = mysqli_fetch_array($rs_qc);



$sql = "SELECT * FROM tbl_job_form WHERE job_id = '$job_id'";
$rs = mysqli_query($connect_db, $sql) or die($connect_db->error);
$row = mysqli_fetch_array($rs);
$num_row = mysqli_num_rows($rs);

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

                    <?php if ($product_id != "") { ?>

                        <div class="ibox-content">

                            <button class="btn btn-primary btn-md btn-block" type="button" id="check" onclick="modal_qc('<?php echo $job_id ?>')"> บันทึกงาน </button>

                            <button class="btn btn-warning btn-md btn-block" type="button" id="check" onclick="modal_edit_pickup('<?php echo $row_gs['form_id'] ?>')"> แก้ไขบันทึก</button>

                        </div>

                    <?php } else { ?>

                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <br><br>
                                    <h2>ไม่พบเครื่องทดแทน ในงานนี้</h2><br>
                                </div>
                            </div>
                        </div>

                    <?php } ?>
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


    function modal_qc(job_id) {
        $.ajax({
            type: "post",
            url: "ajax/mywork/record_qc/modal_qc.php",
            data: {
                job_id: job_id
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



    function modal_edit_qc(form_id) {
        $.ajax({
            type: "post",
            url: "ajax/mywork/record_qc/modal_edit_qc.php",
            data: {
                form_id: form_id
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
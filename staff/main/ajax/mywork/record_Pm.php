<?php

include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
session_start();
$user_id = $_SESSION['user_id'];

$job_id = $_POST['job_id'];

$sql = "SELECT img_id,pm_image FROM tbl_pm_image WHERE job_id = '$job_id' ORDER BY list_order";
$rs = mysqli_query($connect_db, $sql);

$sql_job = "SELECT close_user_id FROM tbl_job WHERE job_id = '$job_id'";
$rs_job = mysqli_query($connect_db, $sql_job);
$row_job = mysqli_fetch_array($rs_job);

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
                        <div class="row">
                            <?php if ($row_job['close_user_id'] == NULL) { ?>
                                <div class="col-4 text-right">
                                    <button class="btn btn-success btn-md " type="button" id="check" onclick="modal_pm('<?php echo $job_id ?>');">บันทึกรูปรายละเอียดงาน</button>
                                </div>
                            <?php } ?>  
                        </div>
                    </div>


                    <div class="ibox-content">
                        <div class="row">
                            <?php while ($row = mysqli_fetch_assoc($rs)) { ?>
                                <div class="col-12 mb-2 text-center">
                                    <a target="_blank" href="https://peabery-upload.s3.ap-southeast-1.amazonaws.com/<?php echo $row['pm_image']; ?>" data-lity>
                                        <img class="mb-3" loading="lazy" src="https://peabery-upload.s3.ap-southeast-1.amazonaws.com/<?php echo $row['pm_image']; ?>" width="220px" height="220px" />
                                    </a>


                                    <div class="form-group ">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="delete_pm_img('<?php echo $row['img_id'] ?>')">ลบ</button>
                                    </div>

                                </div>
                            <?php } ?>
                        </div>

                    </div>

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


    function modal_pm(job_id) {
        $.ajax({
            type: "post",
            url: "ajax/mywork/Pm_work/Modal_Pm.php",
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

    function delete_pm_img(img_id) {

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

                url: 'ajax/mywork/Pm_work/delete_img.php',

                data: {

                    img_id: img_id

                },

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
                            text: '',
                            type: 'warning'
                        });
                        return false;
                    }
                }

            });
        });


    }
</script>
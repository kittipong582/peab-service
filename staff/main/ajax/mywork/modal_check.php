<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$user_id = $_SESSION['user_id'];

$job_id = $_POST['job_id'];
$type = $_POST['type'];
?>

<div class="modal-header">
    <h4 class="modal-title" id="exampleModalLabel">บันทึกเข้างาน</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>

<form id="frm_checkin" method="POST" enctype="multipart/form-data">
    <div class="modal-body" style="padding-bottom: 0;">

        <input type="hidden" name="job_id" value="<?php echo $job_id ?>">
        <input type="hidden" name="type" value="<?php echo $type ?>">

        <div class="row">
            <div class="col-md-12 form-group">
                <label><strong>หลักฐานการบันทึกเข้างาน </strong>
                    <font class="text-danger">**</font>
                </label>
                <div class="custom-file">
                    <input type="file" class="form-control" id="anyfile" name="anyfile" onchange="readURL2(this),submit_checkin();">
                </div>
            </div>
        </div>

    </div>
</form>

<!-- <form action="ajax/mywork/check_in.php" method="post" enctype="multipart/form-data">
        <h2>PHP Upload File</h2>
        <label for="file_name">Filename:</label>
        <input type="file" name="anyfile" id="anyfile">
        <input type="submit" name="submit" value="Upload">
        <p><strong>Note:</strong> Only .jpg, .jpeg, .gif, .png formats allowed to a max size of 5 MB.</p>
    </form> -->

<div class="modal-footer">
    <button type="button" class="btn btn-danger  btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> ปิด</button>
    <!-- <button type="button" class="btn btn-primary btn-sm" onchange="submit_checkin();"><i class="fa fa-check"></i>
        ยืนยัน</button> -->
</div>

<script>
    $(".select2").select2({
        width: "100%"
    });

    function readURL2(input) {
        if (input.files && input.files[0]) {
            var reader2 = new FileReader();

            reader2.onload = function(e) {
                $('#file_name').attr('src', e.target.result);
            }

            reader2.readAsDataURL(input.files[0]);
        }
    }


    // function submit_checkout() {

    //     var job_id = $('#job_id').val();
    //     var formData = new FormData($("#frm_checkin")[0]);

    //     // if (file_name == "") {
    //     //     swal({
    //     //         title: 'เกิดข้อผิดพลาด',
    //     //         text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
    //     //         type: 'error'
    //     //     });
    //     //     return false;
    //     // }

    //     swal({
    //         title: 'กรุณายืนยันเพื่อทำรายการ',
    //         type: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         cancelButtonText: 'ยกเลิก',
    //         confirmButtonText: 'ยืนยัน',
    //         closeOnConfirm: false
    //     }, function() {

    //         $.ajax({
    //             type: 'POST',
    //             url: 'ajax/mywork/check_out.php',
    //             data: formData,
    //             processData: false,
    //             contentType: false,
    //             dataType: 'json',
    //             success: function(data) {
    //                 if (data.result == 0) {
    //                     swal({
    //                         title: "เกิดข้อผิดพลาด",
    //                         text: "ไฟล์ผิด Format หรือข้อมูลไม่ถูกต้อง กรุณาลองอีกครั้ง",
    //                         type: "error",
    //                     });
    //                 }
    //                 if (data.result == 1) {
    //                     $('#modal').modal('hide');
    //                     swal({
    //                         title: "ดำเนินการสำเร็จ!",
    //                         text: "ทำการบันทึกรายการ เรียบร้อย",
    //                         type: "success",
    //                     }, function() {
    //                         location.reload(true);
    //                     });
    //                 }
    //                 if (data.result == 2) {
    //                     swal({
    //                         title: "เกิดข้อผิดพลาด",
    //                         text: "บันทึกผิดพลาด",
    //                         type: "error",
    //                     });
    //                 }
    //             }
    //         })
    //     });
    // }

    function submit_checkin() {

        var job_id = $('#job_id').val();
        var formData = new FormData($("#frm_checkin")[0]);

        var file_name = $('#anyfile').val();

        if (file_name == "") {
            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                type: 'error'
            });
            return false;
        }


        swal({
            title: "Loading",
            text: "Loading...",
            showCancelButton: false,
            showConfirmButton: false
            //icon: "success"
        });

        $.ajax({
            type: 'POST',
            url: 'ajax/mywork/check_in.php',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',

            success: function(data) {
                if (data.result == 0) {
                    swal({
                        title: "เกิดข้อผิดพลาด",
                        text: "ไฟล์ผิด Format หรือข้อมูลไม่ถูกต้อง กรุณาลองอีกครั้ง",
                        type: "error",
                    });
                }
                if (data.result == 1) {
                    $('#modal').modal('hide');
                    swal({
                        title: "กำลังเริ่มงาน !",
                        text: "ทำการบันทึกรายการสำเร็จ เริ่มเวลาเข้างาน",
                        type: "success",
                    }, function() {
                        location.reload(true);
                    });
                }
                if (data.result == 2) {
                    swal({
                        title: "เกิดข้อผิดพลาด",
                        text: "บันทึกผิดพลาด",
                        type: "error",
                    });
                }
            }
        })
    }
</script>
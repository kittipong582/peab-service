<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];
$sql_user = "SELECT * FROM tbl_user WHERE active_status = 1 and user_level = 2";
$result_user  = mysqli_query($connect_db, $sql_user);

?>
<form action="" method="post" id="form-add_close_app" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>ส่งอนุมัติ</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <input id="job_id" name="job_id" value="<?php echo $job_id ?>" type="hidden">
            <input id="quotation_approve_id" type="hidden" name="quotation_approve_id" value="<?php echo getRandomID(10, 'tbl_job_quotation_approve', 'quotation_approve_id') ?>">
            <div class="col-6 mb-3">
                <label>
                    ผู้อนุมัติ
                </label>
                <font color="red"> **</font><br>
                <select class="form-control select2" name="approve_id" id="approve_id">
                    <option value="">กรุณาเลือกผู้อนุมัติ</option>
                    <?php while ($row_user = mysqli_fetch_array($result_user)) { ?>
                        <option value="<?php echo $row_user['user_id'] ?>"><?php echo $row_user['fullname'] ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-12 mb-3">
                <textarea class="summernote" id="send_remark" name="send_remark"></textarea>
            </div>



        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary px-5" type="button" id="submit" onclick="Submit_qt()">บันทึก</button>
    </div>
</form>

<?php include('import_script.php'); ?>
<script>
    $(document).ready(function() {

        $(".select2").select2({});
    });


    function Submit_qt() {


        var approve_id = $('#approve_id').val();


        var formData = new FormData($("#form-add_close_app")[0]);

        if (approve_id == "") {
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
                url: 'ajax/CM_view/quotation/Add_approve.php',
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


                        // $(".tab_head").removeClass("active");
                        // $(".tab_head h4").removeClass("font-weight-bold");
                        // $(".tab_head h4").addClass("text-muted");
                        // $(".tab-pane").removeClass("show");
                        // $(".tab-pane").removeClass("active");
                        // $("#tab_head_4").children("h4").removeClass("text-muted");
                        // $("#tab_head_4").children("h4").addClass("font-weight-bold");
                        // $("#tab_head_4").addClass("active");

                        // current_fs = $(".active");

                        // // next_fs = $(this).attr('id');
                        // // next_fs = "#" + next_fs + "1";


                        // $('#tab-4').addClass("active");

                        // current_fs.animate({}, {
                        //     step: function() {
                        //         current_fs.css({
                        //             'display': 'none',
                        //             'position': 'relative'
                        //         });
                        //         next_fs.css({
                        //             'display': 'block'
                        //         });
                        //     }
                        // });

                        if (data.customer_job_type == 2) {

                            // swal({
                            //     title: 'เพิ่มลูกค้าใหม่หรือไม่',
                            //     type: 'warning',
                            //     showCancelButton: true,
                            //     confirmButtonColor: '#3085d6',
                            //     cancelButtonColor: '#d33',
                            //     cancelButtonText: 'ยกเลิก',
                            //     confirmButtonText: 'ยืนยัน',
                            //     closeOnConfirm: false
                            // }, function() {
                            //     Modal_new_customer(data.job_id);
                            // });
                        }
                    } else {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'ชื่อผู้ใช้ซ้ำ กรุณากรอกใหม่ !!',
                            type: 'warning'
                        });
                        return false;
                    }


                }
            });

        });
    }
</script>
<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$quotation_approve_id = $_POST['quotation_approve_id'];

?>
<form action="" method="post" id="form-add_close_app" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>การอนุมัติ</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">

            <input id="quotation_approve_id" name="quotation_approve_id" value="<?php echo $quotation_approve_id ?>" type="hidden">
            <div class="col-12 mb-3">
                <textarea class="summernote" id="approve_remark" name="approve_remark"></textarea>
            </div>

            <div class="col-3 mb-3 " style="padding-left: 10px;">
                  <input type="radio" id="apply" name="apply" value="1"><label style="font-size: 14px;">อนุมัติ</label><br>
                  <input type="radio" id="apply" name="apply" value="2"><label style="font-size: 14px;">ไม่อนุมัติ</label><br>


            </div>



        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary btn-md " type="button" onclick="APP_qt()">บันทึก</button>
        <button type="button" class="btn btn-danger btn-md " data-dismiss="modal">ปิด</button>
    </div>
</form>

<?php include('import_script.php'); ?>
<script>
    $(document).ready(function() {

        $(".select2").select2({});

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

    });


    function APP_qt() {


        var formData = new FormData($("#form-add_close_app")[0]);


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
                url: 'ajax/CM_view/job_quotation_approve/Add_approve.php',
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
                        window.location.reload();
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
                        window.location.reload();

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
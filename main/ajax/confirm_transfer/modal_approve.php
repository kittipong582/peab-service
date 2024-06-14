<?php
include('header.php');
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$transfer_id = $_POST['transfer_id'];
$result = $_POST['result'];

?>

<div class="modal-header">
    <h4 class="modal-title" id="exampleModalLabel">ยืนยันการโอนย้าย</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>

<form id="frm_confirm" method="POST" enctype="multipart/form-data" novalidate>
    <div class="modal-body" style="padding-bottom: 0;">

        <input type="hidden" name="transfer_id" id="transfer_id" value="<?php echo $transfer_id ?>">
        <input type="hidden" name="result" id="result" value="<?php echo $result ?>">

        <div class="row" style="margin-bottom:10px;">

            <div class="col-md-12">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group ">
                            <label>หมายเหตุ</label>
                            <textarea class="form-control summernote" rows="20" name="remark" id="remark"></textarea>
                        </div>
                    </div>
                </div>


            </div>


        </div>

        <div class="row">
            <div class="col-12" style="text-align:right;">
                <button class="btn btn-success btn-md" type="button" onclick="submit_approve();">ยืนยัน</button>
            </div>
        </div><br>

    </div>
</form>


<script>
    $(document).ready(function() {


        $(".datepicker").datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            format: 'dd/mm/yyyy',
            autoclose: true
        });

        $(".select2").select2({});

    });

    $('.summernote').summernote({
        toolbar: false,
    });



    function submit_approve() {

        var transfer_id = $('#transfer_id').val();
        var remark = $('#remark').val();


        var formData = new FormData($("#frm_confirm")[0]);

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
                url: 'ajax/confirm_transfer/update_transfer.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    if (data.result == 0) {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'ไม่สามารถเพิ่มข้อมูลได้',
                            type: 'warning'
                        });
                        return false;
                    }
                    if (data.result == 1) {

                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1000
                        });
                        $('#Modal').modal('hide');

                        location.reload();
                    }
                }
            })
        });
    }
</script>
<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$province_id = $_POST['province_id'];

?>
<form action="" method="post" id="form-add" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มแขวง/ตำบล</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <input type="hidden" value="<?php echo $province_id  ?>" id="province_id" name="province_id">
            <div class="col-12 mb-3">
                <label for="model_id">
                    ชื่อเขต/อำเภอ (TH)
                </label>
                <font color="red">**</font>
                <input type="text" class="form-control mb-3" id="amphoe_name_th" name="amphoe_name_th">
            </div>
            <div class="col-12 mb-3">
                <label for="model_id">
                    ชื่อเขต/อำเภอ (EN)
                </label>
                <font color="red">**</font>
                <input type="text" class="form-control mb-3" id="amphoe_name_en" name="amphoe_name_en">
            </div>
        </div>


    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="Add();">บันทึก</button>
    </div>
</form>
<?php include('import_script.php'); ?>
<script>
    $(document).ready(function() {


        $('#chkbox').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        }).on('ifChanged', function(e) {
            if ($('#chkbox').is(':checked') == true) {
                $('#place_type').val('1');
            } else {
                $('#place_type').val('2');
            }
        });


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

    });



    function Add() {


        var amphoe_name_en = $('#amphoe_name_en').val();
        var amphoe_name_th = $('#amphoe_name_th').val();
        var province_id = $('#province_id').val();




        if (amphoe_name_en == "" || amphoe_name_th == "" || province_id == "") {
            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                type: 'error'
            });
            return false;
        }

        swal({
            title: "",
            text: "กรุณายืนยันการทำรายการ",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#00FF00",
            confirmButtonText: "ยืนยัน",
            cancelButtonColor: "#DD6B55",
            cancelButtonText: "ยกเลิก",
            closeOnConfirm: false
        }, function() {

            let myForm = document.getElementById('form-add');
            let formData = new FormData(myForm);

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "ajax/setting_amphoe/Add_Amphoe.php",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.result == 1) {
                        swal({
                            title: "",
                            text: "ดำเนินการสำเร็จ",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1000
                        }, function() {
                            swal.close();
                            $("#modal").modal('hide');
                            GetTable();

                        });
                    } else {
                        swal("", "ไม่สามารถทำรายการได้" +
                            response.error_type, "error");
                    }

                }
            });

        });
    }
</script>
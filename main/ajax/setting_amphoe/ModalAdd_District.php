<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$amphoe_id = $_POST['amphoe_id'];

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
            <input type="hidden" value="<?php echo $amphoe_id  ?>" id="amphoe_id" name="amphoe_id">
            <div class="col-12 mb-3">
                <label for="model_id">
                    ชื่อแขวง/ตำบล (TH)
                </label>
                <font color="red">**</font>
                <input type="text" class="form-control mb-3" id="district_name_th" name="district_name_th">
            </div>
            <div class="col-12 mb-3">
                <label for="model_id">
                    ชื่อแขวง/ตำบล (EN)
                </label>
                <font color="red">**</font>
                <input type="text" class="form-control mb-3" id="district_name_en" name="district_name_en">
            </div>
            <div class="col-12 mb-3">
                <label for="serial_no">
                    รหัสไปรษณีย์
                </label>
                <font color="red">**</font>
                <input type="text" class="form-control mb-3" id="district_zipcode" name="district_zipcode">
            </div>
            <div class="col-12 mb-3">

                <input class="icheckbox_square-green" type="checkbox" name="chkbox" id="chkbox" value="chkbox"> <label> ภายในกรุงเทพ</label>
                <input type="hidden" id="place_type" name="place_type" value="2" style="position: absolute; opacity: 0;">

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

        var district_zipcode = $('#district_zipcode').val();
        var district_name_en = $('#district_name_en').val();
        var district_name_th = $('#district_name_th').val();
        var amphoe_id = $('#amphoe_id').val();




        if (district_zipcode == "" || district_name_en == "" || district_name_th == "" || amphoe_id == "") {
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
                url: "ajax/setting_amphoe/Add_District.php",
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
<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$district_id = $_POST['district_id'];

$sql = "SELECT district_name_th,district_name_en,district_zipcode,district_zipcode,place_type,ref_amphoe FROM tbl_district WHERE district_id = '$district_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

?>
<form action="" method="post" id="form-update" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">เเก้ไขแขวง/ตำบล</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <input type="hidden" value="<?php echo $district_id  ?>" id="district_id" name="district_id">
            <input type="hidden" value="<?php echo $row['ref_amphoe']  ?>" id="ref_amphoe" name="ref_amphoe">

            <div class="col-12 mb-3">
                <label for="model_id">
                    ชื่อแขวง/ตำบล (TH)
                </label>
                <font color="red">**</font>
                <input type="text" class="form-control mb-3" id="district_name_th" value="<?php echo $row['district_name_th']  ?>" name="district_name_th">
            </div>
            <div class="col-12 mb-3">
                <label for="model_id">
                    ชื่อแขวง/ตำบล (EN)
                </label>
                <font color="red">**</font>
                <input type="text" class="form-control mb-3" id="district_name_en" value="<?php echo $row['district_name_en']  ?>" name="district_name_en">
            </div>
            <div class="col-12 mb-3">
                <label for="serial_no">
                    รหัสไปรษณีย์
                </label>
                <font color="red">**</font>
                <input type="text" class="form-control mb-3" id="district_zipcode" value="<?php echo $row['district_zipcode']  ?>" name="district_zipcode">
            </div>
            <div class="col-12 mb-3">

                <input class="icheckbox_square-green" <?php echo ($row['place_type'] == 1) ? 'CHECKED' : ''; ?> type="checkbox" name="chkbox" id="chkbox" value="chkbox"> <label> ภายในกรุงเทพ</label>
                <input type="hidden" id="place_type" name="place_type" value="<?php echo $row['place_type']  ?>" style="position: absolute; opacity: 0;">

            </div>

        </div>







    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="Update();">บันทึก</button>
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



    function Update() {

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

            let myForm = document.getElementById('form-update');
            let formData = new FormData(myForm);

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "ajax/setting_amphoe/Update_District.php",
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
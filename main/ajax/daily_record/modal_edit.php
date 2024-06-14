<?php 
 session_start(); 
 include("../../../config/main_function.php");
 $connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$daily_id = $_POST['daily_id'];

$sql = "SELECT * FROM tbl_customer_daily_record WHERE daily_id = '$daily_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

?>

<style>
.hide {
    display: none;
}
</style>

<div class="modal-header">
    <h3>เพิ่มบันทึก</h3>
</div>
<form id="frm_record" method="POST" enctype="multipart/form-data">
    <div class="modal-body">

        <input type="hidden" id="daily_id" name="daily_id"
            value="<?php echo $daily_id ?>">


        <div class="col-lg-12 col-xs-12 col-sm-12">
            <div class="row">

                <div class="col-md-12 col-xs-12 col-sm-12">
                    <div class="form-group">
                        <label>หัวข้อการบันทึก</label>
                        <font color="red">**</font>
                        <input type="text" id="title" name="title" class="form-control" placeholder=""
                            autocomplete="off" value="<?php echo $row['record_title'] ?>">
                    </div>
                </div>


            </div>

            <div class="row">

                <div class="col-md-12 col-xs-12 col-sm-4">
                    <div class="form-group">
                        <label>รายละเอียดการบันทึก</label>
                        <font color="red">**</font>
                        <textarea class="form-control summernote" rows="5" name="record_text"
                            id="record_text"><?php echo $row['record_text'] ?></textarea>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label>เอกสารประกอบการบันทึก <strong>สามารถเพิ่มได้ภายหลังในเมนูแก้ไข</strong>
                        <font class="text-danger">**</font>
                    </label>
                    <div class="custom-file">
                        <input type="file" class="form-control" id="file_name" name="file_name"
                            onchange="readURL2(this);">
                    </div>
                </div>
            </div>


        </div>




    </div>
</form>


<div class="modal-footer">
    <button type="button" class="btn btn-danger btn-md" data-dismiss="modal">ปิด</button>
    <button type="button" class="btn btn-success btn-md" onclick="submit_edit();">ยืนยัน </button>
</div>


<script>
$(document).ready(function() {

});

$(".select2").select2({
    width: "100%"
});

$('#summernote').summernote({
    toolbar: false,
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

function submit_edit() {

    var title = $('#title').val();
    var record_text = $('#record_text').val();
    var daily_id = $('#daily_id').val();

    var formData = new FormData($("#frm_record")[0]);

    if (title == "") {
        swal({
            title: 'เกิดข้อผิดพลาด',
            text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
            type: 'error'
        });
        return false;
    }
    if (record_text == "") {
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
            url: 'ajax/daily_record/edit_record.php',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(data) {
                if (data.result == 0) {
                    swal({
                        title: 'ผิดพลาด!',
                        text: 'กรุณาลองใหม่อีกครั้ง',
                        type: 'warning'
                    });
                    return false;
                }
                if (data.result == 1) {
                    $('#modal').modal('hide');
                    swal({
                        title: "ดำเนินการสำเร็จ!",
                        text: "ทำการบันทึกรายการ เรียบร้อย",
                        type: "success",
                        showConfirmButton: false,
                        timer: 1000
                    });
                    location.reload();
                }
            }
        })
    });
}
</script>
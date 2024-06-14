<?php
session_start();
include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];
$sql_symp = "SELECT * FROM tbl_symptom_type WHERE active_status = 1";
$rs_symp = mysqli_query($connect_db, $sql_symp) or die($connect_db->error);

$sql_rea = "SELECT * FROM tbl_reason_type WHERE active_status = 1";
$rs_rea = mysqli_query($connect_db, $sql_rea) or die($connect_db->error);

?>
<style>
.select2-dropdown {
    z-index: 9999999;
}
</style>


<form action="" method="post" id="form-add_fiexd" enctype="multipart/form-data">

    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>รายการเพิ่ม</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">

        <div class="row">
            <input id="job_id" name="job_id" value="<?php echo $job_id ?>" type="hidden">
            <input id="fixed_id" name="fixed_id" value="<?php echo getRandomID(5, 'tbl_fixed', 'fixed_id'); ?>"
                type="hidden">
            <div class="col-6 mb-3">
                <label>ระบุอาการเสีย </label>
                <font style="color: red;"> **</font>
                <select class="form-control select2" style="width: 100%;" id="symptom_type_id" name="symptom_type_id">
                    <option value="">--ระบุอาการ--</option>
                    <?php while ($row_symp = mysqli_fetch_assoc($rs_symp)) { ?>
                    <option value="<?php echo $row_symp['symptom_type_id'] ?>"><?php echo $row_symp['type_name'] ?>
                    </option>
                    <?php } ?>
                </select>

            </div>
            <div class="col-6 mb-3">
                <label>แจ้งปัญหา </label>
                <font style="color: red;"> **</font>
                <select class="form-control select2" style="width: 100%;" id="reason_type_id" name="reason_type_id">
                    <option value="">--กรุณาเลือก--</option>
                    <?php while ($row_rea = mysqli_fetch_assoc($rs_rea)) { ?>
                    <option value="<?php echo $row_rea['reason_type_id'] ?>"><?php echo $row_rea['type_name'] ?>
                    </option>
                    <?php } ?>
                </select>

            </div>

            <div class="col-12 mb-3">
                <label>หมายเหตุ </label>
                <textarea class="form-control summernote" id="remark" name="remark"></textarea>

            </div>

            <div class="col-md-12 mb-3">

                <label><strong>ภาพการซ่อม</strong></label>
            </div>


            <div class="col-md-12 mb-3" id="form_upload">
                <div class="BroweForFile">

                    <div id="show_image">
                        <label for="upload_file">
                            <a>
                                <img id="blah" src="upload/upload.png" width="220" height="220" />
                            </a>
                        </label>
                    </div><br />
                    <input type="file" id="upload_file" name="image[]" multiple onchange="ImageReadURL(this,value);"
                        style="display: none;">
                </div>

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary px-5" type="button" id="submit" onclick="Submit_fixed()">บันทึก</button>
    </div>

</form>

<?php include('import_script.php'); ?>
<script>
$(document).ready(function() {

    $(".select2").select2({});
});

function ImageReadURL(input, value, show_position) {
    var fty = ["jpg", "jpeg", "png", "JPG", "JPEG", "PNG"];
    var permiss = 0;
    var file_type = value.split('.');
    file_type = file_type[file_type.length - 1];
    if (jQuery.inArray(file_type, fty) !== -1) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#blah').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    } else if (value == "") {
        $('#blah').attr('src', 'upload/upload.png');
        $(input).val("");
    } else {
        swal({
            title: "เกิดข้อผิดพลาด!",
            text: "อัพโหลดได้เฉพาะไฟล์นามสกุล (.jpg .jpeg .png) เท่านั้น!",
            type: "warning"
        });
        $('#blah').attr('src', 'upload/upload.png');
        $(input).val("");
        return false;
    }
}
</script>
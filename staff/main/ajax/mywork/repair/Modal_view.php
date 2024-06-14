<?php
session_start();
include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$fixed_id = $_POST['fixed_id'];
$sql_img = "SELECT * FROM tbl_job_process_image WHERE fixed_id = '$fixed_id'";
$rs_img = mysqli_query($connect_db, $sql_img) or die($connect_db->error);

?>





<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLongTitle"><strong>ภาพการซ่อม</strong></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="row">
        <?php while ($row_img = mysqli_fetch_assoc($rs_img)) { ?>

            <div class="col-12 mb-3">
                <div class="form-group text-center img_show" id="img_show">
                    <a target="_blank" href="https://peabery-upload.s3.ap-southeast-1.amazonaws.com/<?php echo $row_img['image_path']; ?>" data-lity>
                        <img class="mb-3" loading="lazy" src="https://peabery-upload.s3.ap-southeast-1.amazonaws.com/<?php echo $row_img['image_path'] ?>" width="220px" height="220px" />
                    </a><br>
                    <div class="form-group ">

                        <button type="button" class="btn btn-danger btn-sm" onclick="delete_img_repair('<?php echo $row_img['image_id'] ?>','<?php echo $fixed_id ?>')">ลบ</button>
                    </div>
                </div>
            </div>

        <?php } ?>
        <div class="col-12 mb-3 ">
            <form action="" method="post" id="form-add_fiexd_pic" enctype="multipart/form-data">
                <input type="hidden" id="fixed_id" name="fixed_id" value="<?php echo $fixed_id ?>">


                <div class="BroweForFile text-center">

                    <div id="show_image" >
                        <label for="upload_file">
                            <a>
                                <img id="blah" src="upload/upload.png" width="150px" height="200px" />
                            </a>
                        </label>
                    </div><br />
                    <input type="file" id="upload_file" name="image[]" multiple onchange="ImageReadURL(this,value);" style="display: none;">
                </div>


            </form>
        </div>
    </div>
</div>
<div class="modal-footer">

</div>



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

            var formData = new FormData($("#form-add_fiexd_pic")[0]);

            $.ajax({
                type: 'POST',
                url: 'ajax/mywork/repair/UploadImage.php',
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
                            showConfirmButton: true
                        });
                        view_detail(data.fixed_id);

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
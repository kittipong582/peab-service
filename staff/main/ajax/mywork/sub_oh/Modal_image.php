<?php
session_start();
include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];
$sub_job_id = $_POST['sub_job_id'];


$sql = "SELECT * FROM tbl_job_image WHERE job_id = '$job_id' and sub_job_id = '$sub_job_id' ORDER BY list_order";
$result  = mysqli_query($connect_db, $sql);


?>



<form action="" method="post" id="form-add_sub" enctype="multipart/form-data">

    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>รายการรูปงาน </strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">

        <div class="row">
            <input id="job_id" name="job_id" value="<?php echo $job_id ?>" type="hidden">
            <input id="sub_job_id" name="sub_job_id" value="<?php echo $sub_job_id ?>" type="hidden">
            <div class="col-md-12 mb-3">

                <label><strong>ภาพการทำงาน</strong></label>
            </div>

            <div class="col-md-12 mb-3" id="form_upload">
                <div class="BroweForFile">

                    <div id="show_image" class="text-center">
                        <label for="upload_file">
                            <a>
                                <img id="blah" src="upload/upload.png" width="220" height="220" />
                            </a>
                        </label>
                    </div><br />
                    <input type="file" id="upload_file" name="image[]" multiple onchange="ImageReadURL(this,value);" style="display: none;">
                </div>

            </div>
        </div>
        <div class="row">
            <?php while ($row = mysqli_fetch_array($result)) { ?>
                <div class="col-12">
                    <div class="form-group text-center img_show" id="img_show">
                        <a target="_blank" href="../../../../../main/upload/job_image/<?php echo $row['image_name']; ?>" data-lity>
                            <img class="mb-3" loading="lazy" src="../../../../../main/upload/<?php echo ($row['image_name'] == "") ? "No-Image.png" : "job_image/" . $row['image_name']; ?>" width="220px" height="220px" />
                        </a><br>

                        <div class="form-group ">

                            <button type="button" class="btn btn-danger btn-sm" onclick="delete_img('<?php echo $row['job_image_id'] ?>','<?php echo $row['job_image_id'] ?>')">ลบ</button>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary px-5" type="button" id="submit" onclick="Submit_Pm()">บันทึก</button>
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


    function Submit_Pm() {

        var image = $('image').val();


        var formData = new FormData($("#form-add_sub")[0]);

        if (image == "") {
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
                url: 'ajax/mywork/sub_oh/Add_image.php',

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


    function delete_img(job_image_id)
    {

        var job_id = $('#job_id').val();
        var sub_job_id = $('#sub_job_id').val();
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
                url: 'ajax/mywork/sub_oh/delete_image.php',
                data: {
                    job_image_id: job_image_id
                },
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
                        modal_image(sub_job_id);
                    } else {
                        swal({
                            title: 'ผิดพลาด!',
                            text: '',
                            type: 'warning'
                        });
                        return false;
                    }
                }
            });
        });

    }
</script>
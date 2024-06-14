<?php

include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$model_id = mysqli_real_escape_string($connect_db, $_POST['model_id']);
?>

<form action="" method="post" id="form-add" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">เพิ่ม Manual</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <input type="hidden" id="model_id" name="model_id" value="<?php echo $model_id; ?>">
            <div class="col-12 text-center">
                <div class="BroweForFile">
                    <div id="show_image">
                      
                        <label for="upload_file">

                            <a>
                                <img id="blahs" src="upload/upload.png" width="220" height="220" />
                            </a>
                        </label>
                    </div><br />
                </div>
            </div>
            <div class="col-12">
                <label for="manaul_name">
                    ไฟล์ jpg , png , pdf
                </label>
                <input type="file" id="upload_file" name="image" class="form-control mb-3" multiple onchange="ImageReadURL(this,value);">
            </div>
            <div class="col-12">
                <label for="manaul_name">
                    ชื่อ
                </label>
                <input type="text" class="form-control mb-3" id="manaul_name" name="manaul_name">
            </div>

            <div class="col-12">

                <label for="description">
                    รายละเอียด
                </label>
                <textarea type="text" class="form-control mb-3 summernote" id="description" name="description"></textarea>
            </div>
        </div>

    </div>


    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="Add();">บันทึก</button>
    </div>
</form>

<script>
    function ImageReadURL(input, value, show_position) {
        var fty = ["jpg", "jpeg", "png", "JPG", "JPEG", "PNG", "pdf"];
        var permiss = 0;
        var file_type = value.split('.');
        file_type = file_type[file_type.length - 1];
        if (jQuery.inArray(file_type, fty) !== -1) {
            var reader = new FileReader();
            reader.onload = function(e) {
                if (file_type == 'pdf') {
                    $('#blahs').attr('src', 'upload/pdf_icon.jpg');
                }else{
                    $('#blahs').attr('src', e.target.result);
                }
            }
            reader.readAsDataURL(input.files[0]);
        } else if (value == "") {
            $('#blahs').attr('src', 'upload/upload.png');
            $(input).val("");
        } else {
            swal({
                title: "เกิดข้อผิดพลาด!",
                text: "อัพโหลดได้เฉพาะไฟล์นามสกุล (.jpg .jpeg .png) เท่านั้น!",
                type: "warning"
            });
            $('#blahs').attr('src', 'upload/upload.png');
            $(input).val("");
            return false;
        }
    }

</script>
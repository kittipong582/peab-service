<?php

include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$manual_id = mysqli_real_escape_string($connect_db, $_POST['manual_id']);

$sql = "SELECT * FROM tbl_product_model_manual WHERE manual_id = '$manual_id'";
$rs = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_assoc($rs);
?>

<form action="" method="post" id="form-edit" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">แก้ไข Manual</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <input type="hidden" id="manual_id" name="manual_id" value="<?php echo $manual_id; ?>">
            <div class="col-12 text-center">
                <div class="BroweForFile">
                    <div id="show_image">
                        <label for="upload_file">
                            <!-- <a target="_blank" href="https://peabery-upload.s3.ap-southeast-1.amazonaws.com/<?php echo $row['manual_image']; ?>" data-lity> -->
                            <?php
                            $file_type = explode('.', $row['manual_image']);
                            if ($file_type[1] == 'pdf') {
                            ?>
                                <img class="mb-3" loading="lazy" id="blahs" src="upload/pdf_icon.jpg" width="220px" height="220px" />
                            <?php } else { ?>
                                <img class="mb-3" loading="lazy" id="blahs" src="https://peabery-upload.s3.ap-southeast-1.amazonaws.com/<?php echo $row['manual_image']; ?>" width="220px" height="220px" />
                            <?php } ?>
                            <!-- </a> -->
                        </label>
                    </div><br />
                </div>
            </div>
            <div class="col-12">
                <label for="manaul_name">
                    ไฟล์ jpg , png , pdf
                </label>
                <input type="file" id="upload_file" name="image" class="form-control mb-3" multiple onchange="ImageReadURL(this,value);" value="<?php echo $row['manual_image'] ?>">
            </div>
            <div class="col-12">
                <label for="manaul_name">
                    ชื่อ
                </label>
                <input type="text" class="form-control mb-3" id="manaul_name" name="manaul_name" value="<?php echo $row['manaul_name']; ?>">
            </div>

            <div class="col-12">

                <label for="description">
                    รายละเอียด
                </label>
                <textarea type="text" class="form-control mb-3 summernote" id="description" name="description"><?php echo $row['description'] ?></textarea>
            </div>
        </div>

    </div>


    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="Update();">บันทึก</button>
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
                } else {
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
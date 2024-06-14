<?php

include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$manual_sub_id = mysqli_real_escape_string($connect_db, $_POST['manual_sub_id']);
$sql = "SELECT * FROM tbl_spare_part_manual_sub WHERE manual_sub_id = '$manual_sub_id'";
$rs = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_assoc($rs);
?>

<form action="" method="post" id="form-edit" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มคู่มือ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <input type="hidden" id="manual_sub_id" name="manual_sub_id" value='<?php echo $manual_sub_id ?>'>
            <div class="col-6">
                <label for="model_name">
                    หัวข้อ
                    <font color="red">**</font>
                </label>
                <input type="text" class="form-control mb-3" id="manual_name" name="manual_name" value='<?php echo $row['manual_sub_name'] ?>'>
            </div>

            <div class="col-6">
                <label for="model_name">
                    <br>
                </label>
                <input type="file" class="form-control mb-3" id="file_name" name="file_name">
            </div>

            <div class="col-12">
                <label for="model_name">
                    หมายเหตุ
                </label>
                <textarea class='form-control summernote' name="remark" id='remark'><?php echo $row['remark'] ?> </textarea>
            </div>
        </div>

    </div>

    <!-- <label for="model_name">
            ชื่ออะไหล่ <font class="text-danger">*</font>
        </label> -->

    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="Update();">บันทึก</button>
    </div>
</form>
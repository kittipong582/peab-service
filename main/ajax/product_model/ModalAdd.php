<?php

include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$brand_id = mysqli_real_escape_string($connect_db, $_POST['brand_id']);
?>

<form action="" method="post" id="form-add" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มรุ่น</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-6">
                <input type="text" hidden name="brand_id" value="<?php echo $brand_id; ?>">
                <label for="model_name">
                    รหัสรุ่น
                </label>
                <input type="text" class="form-control mb-3" id="model_code" name="model_code">
            </div>

            <div class="col-6">
                <input type="text" hidden name="brand_id" value="<?php echo $brand_id; ?>">
                <label for="model_name">
                    ชื่อรุ่น
                </label>
                <input type="text" class="form-control mb-3" id="model_name" name="model_name">
            </div>
        </div>

    </div>

    <!-- <label for="model_name">
            ชื่ออะไหล่ <font class="text-danger">*</font>
        </label> -->

    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="Add();">บันทึก</button>
    </div>
</form>
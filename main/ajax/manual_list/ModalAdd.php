<?php

include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

?>

<form action="" method="post" id="form-add" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มคู่มือ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <input type="hidden" class="form-control mb-3" id="manual_id" name="manual_id" value="<?php echo getRandomID(10, 'tbl_manual', 'manual_id'); ?>">
            <div class="col-12">
                <label for="model_name">
                    หัวข้อ
                    <font color="red">**</font>
                </label>
                <input type="text" class="form-control mb-3" id="manual_name" name="manual_name">
            </div>
            <div class="col-12">
                <label for="model_name">
                    หมายเหตุ
                </label>
                <textarea class='form-control summernote' name="remark" id='remark'> </textarea>
            </div>
        </div>

    </div>


    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="Add();">บันทึก</button>
    </div>
</form>
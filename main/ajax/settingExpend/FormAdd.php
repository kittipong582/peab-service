<?php
    session_start();
    include("../../../config/main_function.php");
    date_default_timezone_set("Asia/Bangkok");

    $secure = "LM=VjfQ{6rsm&/h`";
    $connection = connectDB($secure);
?>

<div class="modal-header">
    <h4 class="modal-title">เพิ่มประเภทค่าใช้จ่าย</h4>
</div>
<div class="modal-body">
    <form id="form_add" method="post" enctype="multipart/form-data">
        <div class="row">

        <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                    <label><strong>รหัส</strong> <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="expend_code" id="expend_code">
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                    <label><strong>ประเภทค่าใช้จ่าย</strong> <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="expend_type_name" id="expend_type_name">
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                    <label><strong>หมายเหตุ</strong> </label>
                    <textarea rows="3" cols="80"  class="form-control" name="description"  id="description"></textarea>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white" data-dismiss="modal">ปิด</button>
    <button type="button" class="btn btn-success" id="AddFormSubmit">บันทึก</button>
</div>

<?php mysqli_close($connection); ?>
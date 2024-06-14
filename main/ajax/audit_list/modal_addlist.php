<?php
include("../../../config/main_function.php");

?>
<div class="modal-header">
    <h4 class="modal-title">เพิ่ม</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
    <form id="form-add" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <div class="row">
                <div class="col-6">
                    <label class="font-normal">หัวข้อ</label>
                    <input type="text" class="form-control" id="audit_name" name="audit_name" placeholder="">
                </div>
                <div class="col-6">
                    <label class="font-normal">รายละเอียด</label>
                    <input type="text" class="form-control" id="description" name="description" placeholder="">
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="SubmitAudit()"><i
                    class="fa fa-check"></i>&nbsp;บันทึก</button>
            <button type="button" class="btn btn-white" data-dismiss="modal">ปิด</button>
        </div>
    </form>
</div>

<?php include("import_script.php") ?>

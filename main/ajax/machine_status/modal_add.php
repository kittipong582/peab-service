<?php
include("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");
$status_id = getRandomID(10, 'tbl_machine_status', 'status_id');
?>
<div class="modal-header">
    <h4 class="modal-title">เพิ่ม</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
    <form id="form-add" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="status_id" id="status_id" value="<?php echo $status_id; ?>">

        <div class="form-group">
            <div class="row">
                <div class="col-12">
                    <label class="font-normal">ชื่อสถานะ</label>
                    <input type="text" class="form-control" id="status_name" name="status_name" placeholder="">
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="SubmitStatus()"><i class="fa fa-check"></i>&nbsp;บันทึก</button>
            <button type="button" class="btn btn-white" data-dismiss="modal">ปิด</button>
        </div>
    </form>
</div>

<?php include("import_script.php") ?>
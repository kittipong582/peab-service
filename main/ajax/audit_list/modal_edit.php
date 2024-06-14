<?php
include("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");
$audit_id = mysqli_real_escape_string($connection, $_POST['audit_id']);
$score_id = mysqli_real_escape_string($connection, $_POST['score_id']);

$sql = "SELECT * FROM tbl_audit_form WHERE audit_id = '$audit_id'";
$res = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($res);

?>
<style>
    .dragging-over {
        border: 2px dashed #ccc;
        opacity: 0.5;
    }
</style>

<div class="modal-header">
    <h4 class="modal-title">แก้ไข</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
    <form id="form-edit" method="POST" enctype="multipart/form-data">
        <input type="hidden" id="audit_id" name="audit_id" value="<?php echo $audit_id ?>">

        <div class="form-group">
            <div class="row">
                <div class="col-6">
                    <label class="font-normal">หัวข้อ</label>
                    <input type="text" class="form-control" id="audit_name" name="audit_name"
                        value="<?php echo $row['audit_name'] ?>">
                </div>
                <div class="col-6">
                    <label class="font-normal">รายละเอียด</label>
                    <input type="text" class="form-control" id="description" name="description"
                        value="<?php echo $row['description'] ?>">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="Update()"><i
                    class="fa fa-check"></i>&nbsp;บันทึก</button>
            <button type="button" class="btn btn-white" data-dismiss="modal">ปิด</button>
        </div>
    </form>
</div>
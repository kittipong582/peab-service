<?php
include("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

$audit_id = $_POST['audit_id'];



$sql = "SELECT * FROM tbl_audit_topic WHERE audit_id = '$audit_id'";
$res = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($res);

?>
<div class="modal-header">
    <h4 class="modal-title">เพิ่มไขหัวข้อ</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
    <div class="form-group">
    <input type="text" hidden class="form-control" value="<?php echo $audit_id ?>" id="audit_id"
                name="audit_id">
        <label class="font-normal">ชื่อหัวข้อ</label>
        <input type="text" class="form-control" id="topic_datail" name="topic_datail">
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" onclick="SubmitAddList()"><i class="fa fa-check"></i>&nbsp;บันทึก</button>
    <button type="button" class="btn btn-white" data-dismiss="modal">ปิด</button>
</div>
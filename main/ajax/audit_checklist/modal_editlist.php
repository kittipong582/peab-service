<?php
include("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

$topic_id = mysqli_real_escape_string($connection, $_POST['topic_id']);

$sql = "SELECT * FROM tbl_audit_topic WHERE topic_id = '$topic_id'";
$res = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($res);

?>
<div class="modal-header">
    <h4 class="modal-title">แก้ไขหัวข้อ</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
    <div class="form-group">
        <label class="font-normal">ชื่อหัวข้อ</label>
        <input type="text" class="form-control" id="update_topic_datail" name="update_topic_datail" value="<?php echo $row['topic_datail']; ?>">
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" onclick="UpdateList('<?php echo $topic_id ?>')"><i class="fa fa-check"></i>&nbsp;บันทึก</button>
    <button type="button" class="btn btn-white" data-dismiss="modal">ปิด</button>
</div>
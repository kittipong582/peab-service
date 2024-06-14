<?php
include("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

$topic_qc_id = mysqli_real_escape_string($connection, $_POST['topic_qc_id']);

$sql = "SELECT * FROM tbl_qc_topic WHERE topic_qc_id = '$topic_qc_id'";
$res = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($res);

?>
<div class="modal-header">
    <h4 class="modal-title">แก้ไขQc</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
    <div class="form-group">
        <label class="font-normal">ชื่อ Qc</label>
        <input type="text" class="form-control" id="topic_detail" name="topic_detail" value="<?php echo $row['topic_detail']; ?>">
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" onclick="UpdateList('<?php echo $topic_qc_id ?>')"><i class="fa fa-check"></i>&nbsp;บันทึก</button>
    <button type="button" class="btn btn-white" data-dismiss="modal">ปิด</button>
</div>
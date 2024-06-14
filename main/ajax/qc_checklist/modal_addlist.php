<?php
include("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

// $qc_id = $_POST['qc_id'];
$qc_id = mysqli_real_escape_string($connection, $_POST['qc_id']);


?>
<div class="modal-header">
    <h4 class="modal-title">เพิ่ม Qc</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
    <div class="form-group">
    <input type="text" hidden name="qc_id" id="qc_id" value="<?php echo $qc_id ?>">
        <label class="font-normal">ชื่อ Qc</label>
        <input type="text" class="form-control" id="topic_detail" name="topic_detail">
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" onclick="SubmitAddList()"><i class="fa fa-check"></i>&nbsp;บันทึก</button>
    <button type="button" class="btn btn-white" data-dismiss="modal">ปิด</button>
</div>
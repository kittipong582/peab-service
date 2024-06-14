<?php
include("../../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");
$group_id = mysqli_real_escape_string($connection, $_POST['group_id']);
?>
<div class="modal-header">
    <h4 class="modal-title">ปิดงาน</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">

    <input type="hidden" name="sig_validate" id="sig_validate" value="0">
    <div class="row sig_pad">
        <div class="col-md-12 mb-2" id="signature_box"></div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" onclick="SubmitColseJob('<?php echo $group_id; ?>')"><i class="fa fa-check"></i>&nbsp;บันทึก</button>
    <button type="button" class="btn btn-white" data-dismiss="modal">ปิด</button>
</div>
<script>
    $(document).ready(function() {
        Signature()
    });

    // SigPad($("#sig_validate").val())
</script>
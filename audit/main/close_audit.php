<?php
include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$group_id = mysqli_real_escape_string($connect_db, $_POST['group_id']);
?>
<div class="modal-header">
    <h4 class="modal-title">ปิดงาน</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">

    <input type="" name="sig_validate" id="sig_validate" value="0">

    <div class="row mt-3 mb-2 sig_pad">
        <div class="col-md-12 mb-2" id="signature_box"></div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" onclick="SubmitColseJob('<?php echo $group_id; ?>')"><i class="fa fa-check"></i>&nbsp;บันทึก</button>
    <button type="button" class="btn btn-white" data-dismiss="modal">ปิด</button>
</div>

<?php include 'footer.php'; ?>
<script>
    $(document).ready(function() {
        Signature()
    });

    function Signature() {
        $("#signature_box").load("signature.php");
    }
    // SigPad($("#sig_validate").val())
</script>
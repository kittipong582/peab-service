<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$contract_id = $_POST['contract_id'];

?>
<form action="" method="post" id="form-cancel" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>ยกเลิกสัญญา</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <input type="hidden" name="contract_id" name="contract_id" value="<?php echo $contract_id ?>">
            <div class="col-md-12 mb-3">
                <label>หมายเหตุ</label>
                <textarea class="summernote" id="cancel_remark" name="cancel_remark"></textarea>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-md" data-dismiss="modal">ปิด</button>
        <button class="btn btn-primary btn-md" type="button" onclick="cancel();">บันทึก</button>
    </div>
</form>

<?php include('import_script.php'); ?>
<script>



</script>
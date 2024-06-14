<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$user_id = $_SESSION['user_id'];

$job_id = $_POST['job_id'];
$type = $_POST['type'];
?>

<div class="modal-header">
    <h4 class="modal-title" id="exampleModalLabel">หมายเหตุหยุดงาน</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>

<form id="frm_checkin" method="POST" enctype="multipart/form-data">
    <div class="modal-body" style="padding-bottom: 0;">

        <input type="hidden" name="job_id" value="<?php echo $job_id ?>">
        <input type="hidden" name="type" value="<?php echo $type ?>">

        <div class="row">
            <div class="col-md-12 form-group">
                <textarea class="summernote" id="remark" name="remark"></textarea>
            </div>
        </div>

    </div>
</form>

<div class="modal-footer">
    <button type="button" class="btn btn-danger  btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> ปิด</button>
    <button type="button" class="btn btn-primary btn-sm" onclick="hold_status('<?php echo $job_id ?>','on');"><i class="fa fa-check"></i>
        ยืนยัน</button>
</div>

<script>
  
</script>
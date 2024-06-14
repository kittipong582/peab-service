<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];

?>
<form action="" method="post" id="form_planPm" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>รายการปิดงาน</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <input id="job_id" name="job_id" value="<?php echo $job_id ?>" type="hidden">

            <div class="col-12 mb-6 text-center">

                <button class="btn btn-success px-5" type="button" onclick="Get_formPm('<?php echo $job_id; ?>','2')">เปิดงานต่อ</button>
                <button class="btn btn-danger px-5" type="button" onclick="Get_formPm('<?php echo $job_id; ?>','1')">ปิดงาน</button>

            </div>

            <div class="col-12 mt-3" id="form_point_close">

            </div>

        </div>
    </div>
    <div class="modal-footer">

        <div class="col-12 text-right" id="btn_sumbit_point" style="display: none;">
            <button class="btn btn-primary px-5" type="button" onclick="PM_plan_Submit()">บันทึก</button>
        </div>
        <div class="col-12 text-right" id="btn_close_point" style="display: none;">
            <button class="btn btn-primary px-5" type="button" onclick="close_job('<?php echo $job_id; ?>')">บันทึก</button>
        </div>
    </div>
</form>

<?php include('import_script.php'); ?>
<script>
    $(document).ready(function() {

        $(".select2").select2({});
    });
</script>
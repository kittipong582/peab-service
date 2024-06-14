<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];

?>
<form action="" method="post" id="form-add_close_app" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>รายการปิดงาน</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <input id="job_id" name="job_id" value="<?php echo $job_id ?>" type="hidden">

            <div class="col-12 mb-3">
                <textarea class="summernote" id="close_note" name="close_note"></textarea>
            </div>



        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary px-5" type="button" id="submit" onclick="close_job('<?php echo $job_id; ?>')">บันทึก</button>
    </div>
</form>

<?php include('import_script.php'); ?>
<script>
    $(document).ready(function() {

        $(".select2").select2({});
    });
</script>
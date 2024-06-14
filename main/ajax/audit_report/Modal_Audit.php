<?php
include("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

$job_id = $_POST['job_id'];

$sql = "SELECT * FROM tbl_audit_form;";
$res = mysqli_query($connection, $sql);


?>
<div class="modal-header">
    <h4 class="modal-title">รายละเอียด</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
    <input type="" hidden id="job_id" name="job_id" value="<?php echo $job_id ?>">
</div>
<div class="modal-body">
    <?php while ($row = mysqli_fetch_assoc($res)) { ?>
        <div class="row">
            <div class="col-12">
                <a href="audit_evaluation.php?audit_id=<?php echo $row['audit_id']; ?>&job_id=<?php echo $job_id; ?>"
                    class="btn btn-info btn-xs w-100 mb-2">
                    <?php echo $row['audit_name'] ?>
                </a>
            </div>

        </div>
    <?php } ?>
</div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white" data-dismiss="modal">ปิด</button>
</div>
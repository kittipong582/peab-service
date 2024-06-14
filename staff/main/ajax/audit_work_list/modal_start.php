<?php
include("../../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

$group_id = mysqli_real_escape_string($connection, $_POST['group_id']);

$sql = "SELECT a.*,b.audit_name FROM tbl_job_audit a
JOIN tbl_audit_form b ON a.audit_id = b.audit_id
WHERE a.group_id ='$group_id'";
$res = mysqli_query($connection, $sql);

?>
<div class="modal-header">
    <h4 class="modal-title">รายละเอียด</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
    <div class="row">
        <?php while ($row = mysqli_fetch_assoc($res)) {

            if ($row['start_audit'] == "") {
                $status = 'info';
            } else if ($row['start_audit'] != "" && $row['close_audit'] == "") {
                $status = 'warning';
            } else if ($row['close_audit'] != "") {
                $status = 'secondary " disabled';
            }
        ?>

            <button class="btn w-100 mb-2 btn-<?php echo $status; ?> " onclick="Start_Audit('<?php echo $row['job_id'] ?>','<?php echo $row['audit_id'] ?>','<?php echo $group_id ?>',)">
                <?php echo $row['audit_name'] ?>
            </button>
        <?php } ?>
        <button class="btn w-100 mb-2 btn-danger" onclick="ModalClose('<?php echo $group_id; ?>')">
            ปิดงาน
        </button>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-white" data-dismiss="modal">ปิด</button>
</div>
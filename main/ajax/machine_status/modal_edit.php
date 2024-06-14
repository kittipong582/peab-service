<?php
include("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");
$status_id = mysqli_real_escape_string($connection, $_POST['status_id']);

$sql = "SELECT * FROM tbl_machine_status WHERE status_id = '$status_id'";
$res = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($res);

?>
<style>
    .dragging-over {
        border: 2px dashed #ccc;
        opacity: 0.5;
    }
</style>

<div class="modal-header">
    <h4 class="modal-title">แก้ไข</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
    <form id="form-edit" method="POST" enctype="multipart/form-data">
        <input type="hidden" id="status_id" name="status_id" value="<?php echo $status_id ?>">

        <div class="form-group">
            <div class="row">
                <div class="col-12">
                    <label class="font-normal">ชื่อสถานะ</label>
                    <input type="text" class="form-control" id="status_name" name="status_name"
                        value="<?php echo $row['status_name'] ?>">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="Update()"><i
                    class="fa fa-check"></i>&nbsp;บันทึก</button>
            <button type="button" class="btn btn-white" data-dismiss="modal">ปิด</button>
        </div>
    </form>
</div>
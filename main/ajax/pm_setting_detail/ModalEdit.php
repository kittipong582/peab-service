<?php

include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$pm_setting_detail_id = mysqli_escape_string($connect_db, $_POST['pm_setting_detail_id']);

$sql = "SELECT * FROM tbl_pm_setting_detail WHERE pm_setting_detail_id = '$pm_setting_detail_id'";
$result = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);
// echo "$sql";
?>

<form action="" method="post" id="form-edit" enctype="multipart/form-data">

    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">แก้ไขรายละเอียด</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <input type="hidden"  name="pm_setting_detail_id" value="<?php echo $pm_setting_detail_id; ?>">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                    <label><strong>รายละเอียด</strong> <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="detail" id="detail" cols="30" rows="5"><?php echo  $row['detail'];  ?></textarea>
                </div>
                <div class="form-group">
                    <label><strong>หมายเหตุ</strong></label>
                    <textarea class="form-control" name="remark" id="remark" cols="30" rows="5"><?php echo  $row['remark'];  ?></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
            <button type="button" class="btn btn-primary btn-sm" onclick="Update();">บันทึก</button>
        </div>
</form>
<?php include('import_script.php'); ?>
<?php
    session_start();
    include("../../../config/main_function.php");
    date_default_timezone_set("Asia/Bangkok");

    $secure = "LM=VjfQ{6rsm&/h`";
    $connection = connectDB($secure);

    $expend_type_id = $_POST["expend_type_id"];

    $sql = "SELECT et.* FROM tbl_expend_type et WHERE et.expend_type_id = '$expend_type_id'";
    $rs = mysqli_query($connection, $sql);
    $row = mysqli_fetch_array($rs);
?>

<div class="modal-header">
    <h4 class="modal-title">แก้ไขประเภทค่าใช้จ่าย</h4>
</div>
<div class="modal-body">
    <form id="form_edit" method="post" enctype="multipart/form-data">
        <input type="hidden" name="expend_type_id" id="expend_type_id" value="<?php echo $expend_type_id; ?>">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                    <label><strong>ประเภทค่าใช้จ่าย</strong> <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="expend_type_name" id="expend_type_name" value="<?php echo $row['expend_type_name']; ?>">
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                    <label><strong>หมายเหตุ</strong> </label>
                    <textarea rows="3" cols="80"  class="form-control" name="description"  id="description"><?php echo $row['description']; ?></textarea>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white" data-dismiss="modal">ปิด</button>
    <button type="button" class="btn btn-success" id="EditFormSubmit">บันทึก</button>
</div>

<?php mysqli_close($connection); ?>
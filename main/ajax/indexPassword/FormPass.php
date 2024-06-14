<?php
    session_start();
    include("../../../config/main_function.php");
    date_default_timezone_set("Asia/Bangkok");

    $secure = "LM=VjfQ{6rsm&/h`";
    $connection = connectDB($secure);

    $user_id = $_SESSION['user_id'];

    $sql = "SELECT u.*
        FROM tbl_user u
        WHERE u.user_id = '$user_id'";
    $rs = mysqli_query($connection, $sql);
    $row = mysqli_fetch_array($rs);

?>

<div class="modal-header">
    <h4 class="modal-title">ตั้งค่าเปลี่ยนรหัสผ่าน</h4>
</div>
<div class="modal-body">
    <form id="form_pass" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                    <label><strong>รหัสผ่านเดิม <span class="text-danger">*</span></strong></label>
                    <input type="text" name="old_pass" id="old_pass" class="form-control">
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                    <label><strong>รหัสผ่านใหม่ <span class="text-danger">*</span></strong></label>
                    <input type="text" name="new_pass" id="new_pass" class="form-control">
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                    <label><strong>รหัสผ่านใหม่ (อีกครั้ง) <span class="text-danger">*</span></strong></label>
                    <input type="text" name="confirm_pass" id="confirm_pass" class="form-control">
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
    <button type="button" class="btn btn-success" id="FormSubmitEdit">บันทึก</button>
</div>
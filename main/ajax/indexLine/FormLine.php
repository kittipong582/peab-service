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
    <h4 class="modal-title">ตั้งค่าแจ้งเตือน Line</h4>
</div>
<div class="modal-body">
    <form id="form_edit" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input type="checkbox" class="custom-control-input" id="line_active" name="line_active" value="1" onchange="SetVisibleLine();" <?php if($row['line_active'] == "1"){ echo "checked"; } ?>>
                        <label class="custom-control-label" for="line_active">เปิดการแจ้งเตือน ไปยัง LINE</label>
                    </div>
                    <!--<div class="float-right">
                        <a href="#">คู่มือการตั้งค่า</a>
                    </div>-->
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 <?php if($row['line_active'] == "1"){ echo "visible"; }else{ echo "invisible"; } ?>" id="line_show">
                <div class="form-group">
                    <label><strong>Line Token <span class="text-danger">*</span></strong></label>
                    <input type="text" name="line_token" id="line_token" class="form-control" value="<?php echo $row['line_token']; ?>">
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
    <button type="button" class="btn btn-success" id="FormSubmitEdit">บันทึก</button>
</div>
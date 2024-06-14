<?php
    session_start();
    include("../../../config/main_function.php");
    date_default_timezone_set("Asia/Bangkok");

    $secure = "LM=VjfQ{6rsm&/h`";
    $connection = connectDB($secure);
    // $bank_id = mysqli_real_escape_string($connect_db, $_POST['bank_id']);
    $bank_id = $_POST["bank_id"];

    $sql = "SELECT * FROM tbl_bank  WHERE bank_id = '$bank_id'";
    $rs = mysqli_query($connection, $sql);
    $row = mysqli_fetch_array($rs);

?>
 
<div class="modal-header">
    <h4 class="modal-title">แก้ไขธนาคาร</h4>
</div>
<div class="modal-body">
    <form id="form_edit" method="post" enctype="multipart/form-data">
        <input type="hidden" name="bank_id" id="bank_id" value="<?php echo $bank_id; ?>">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                    <label><strong>ธนาคาร</strong> <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="bank_name" id="bank_name" value="<?php echo $row['bank_name']; ?>">
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
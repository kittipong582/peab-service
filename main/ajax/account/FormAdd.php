<?php
session_start();
include("../../../config/main_function.php");
date_default_timezone_set("Asia/Bangkok");

$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$sql = "SELECT * FROM tbl_bank WHERE active_status = 1";
$result  = mysqli_query($connection, $sql);

?>

<div class="modal-header">
    <h4 class="modal-title">เพิ่มบัญชีธนาคาร</h4>
</div>
<div class="modal-body">
    <form id="form_add" method="post" enctype="multipart/form-data">
        <div class="row">

            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="form-group">
                    <label><strong>ธนาคาร</strong>
                        <select class="form-control select2" name="bank_id" id="bank_id" style="width: 100%;">
                            <option value="">กรุณาเลือกธนาคาร</option>
                            <?php while ($row = mysqli_fetch_array($result)) { ?>
                                <option value="<?php echo $row['bank_id'] ?>"><?php echo $row['bank_name'] ?></option>
                            <?php     } ?>
                        </select>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="form-group">
                    <label><strong>ประเภทบัญชี</strong>
                        <select class="form-control select2" name="account_type" id="account_type" style="width: 100%;">
                            <option value="">กรุณาเลือกประเภท</option>
                            <option value="1">บัญชี PTT</option>
                            <option value="2">บัญชีทั่วไป</option>
                        </select>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                    <label><strong>เลขบัญชี</strong> <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="account_no" id="account_no">
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                    <label><strong>ชื่อบัญชี</strong> </label>
                    <input type="text" class="form-control" name="account_name" id="account_name">
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                    <label><strong>ชื่อสาขาธนาคาร</strong> </label>
                    <input type="text" class="form-control" name="bank_branch_name" id="bank_branch_name">
                </div>
            </div>
        </div>
</div>
</form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white" data-dismiss="modal">ปิด</button>
    <button type="button" class="btn btn-success" id="AddFormSubmit">บันทึก</button>
</div>

<?php include('import_script.php'); ?>
<Script>
    $(document).ready(function() {

        $(".select2").select2({});
    });
</Script>
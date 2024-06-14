<?php
session_start();
include("../../../config/main_function.php");
date_default_timezone_set("Asia/Bangkok");

$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$account_id = $_POST["account_id"];

$sql1 = "SELECT * FROM tbl_account  WHERE account_id = '$account_id'";
$rs1 = mysqli_query($connection, $sql1);
$row1 = mysqli_fetch_array($rs1);

?>

<div class="modal-header">
    <h4 class="modal-title">แก้ไขบัญชีธนาคาร</h4>
</div>
<div class="modal-body">
    <form id="form_edit" method="post" enctype="multipart/form-data">
        <input type="hidden" id="account_id" name="account_id" value="<?php echo $account_id; ?>">
        <div class="row">

            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="form-group">
                    <label><strong>ธนาคาร</strong>
                        <select class="form-control select2" name="bank_id" id="bank_id" style="width: 100%;">
                            <option value="">กรุณาเลือกธนาคาร</option>
                            <?php $sql = "SELECT * FROM tbl_bank WHERE active_status = 1";
                            $result  = mysqli_query($connection, $sql);
                            while ($row = mysqli_fetch_array($result)) { ?>
                                <option value="<?php echo $row['bank_id'] ?>" <?php if ($row['bank_id'] == $row1['bank_id']) {
                                                                                    echo 'selected';
                                                                                } ?>>
                                    <?php echo $row['bank_name'] ?></option>
                            <?php     } ?>
                        </select>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="form-group">
                    <label><strong>ประเภทบัญชี</strong>
                        <select class="form-control select2" name="account_type" id="account_type" style="width: 100%;">
                            <option value="">กรุณาเลือกประเภท</option>
                            <option value="1"<?php if ($row1['account_type'] == 1) {
                                                                                    echo 'selected';
                                                                                } ?>>บัญชี PTT</option>
                            <option value="2"<?php if ($row1['account_type'] == 2) {
                                                                                    echo 'selected';
                                                                                } ?>>บัญชีทั่วไป</option>
                        </select>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                    <label><strong>เลขบัญชี</strong> <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="account_no" id="account_no" value="<?php echo $row1['account_no']; ?>">
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                    <label><strong>ชื่อบัญชี</strong> </label>
                    <input type="text" class="form-control" name="account_name" id="account_name" value="<?php echo $row1['account_name']; ?>">
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                    <label><strong>ชื่อสาขาธนาคาร</strong> </label>
                    <input type="text" class="form-control" name="bank_branch_name" id="bank_branch_name" value="<?php echo $row1['bank_branch_name']; ?>">
                </div>
            </div>
        </div>
</div>
</form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white" data-dismiss="modal">ปิด</button>
    <button type="button" class="btn btn-success" onclick="Update();">บันทึก</button>
</div>

<?php include('import_script.php'); ?>
<script>
    $(document).ready(function() {

        $(".select2").select2({});
    });
</script>
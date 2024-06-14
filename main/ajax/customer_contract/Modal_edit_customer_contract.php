<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$contract_id = $_POST['contract_id'];


$sql = "SELECT * FROM tbl_customer_contract WHERE contract_id = '$contract_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

?>
<form action="" method="post" id="form-add_contract" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>แก้ไขสัญญา</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <input type="hidden" name="contract_id" name="contract_id" value="<?php echo $contract_id ?>">
            <div class="col-md-4 mb-3">
                <label>เลขที่สัญญา</label>
                <font color="red">**</font>
                <input type="text" class="form-control" readonly id="contract_number" value="<?php echo $row['contract_number'] ?>" name="contract_number">
            </div>

            <div class="col-md-4 mb-3">
                <label>วันที่เริ่มสัญญา</label>
                <font color="red">**</font>
                <div class="input-group date">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <input type="text" id="start_contract_date" name="start_contract_date" class="form-control datepicker" value="<?php echo date('d-m-Y', strtotime($row['start_contract_date'])) ?>" autocomplete="off">
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <label>วันที่หมดสัญญา</label>
                <font color="red">**</font>
                <div class="input-group date">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <input type="text" id="end_contract_date" name="end_contract_date" class="form-control datepicker" value="<?php echo date('d-m-Y', strtotime($row['end_contract_date'])) ?>" autocomplete="off">
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <label>หมายเหตุ</label>
                <textarea class="summernote" id="remark" name="remark"><?php echo $row['remark'] ?></textarea>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-md" data-dismiss="modal">ปิด</button>
        <button class="btn btn-primary btn-md" type="button" onclick="Update();">บันทึก</button>
    </div>
</form>

<?php include('import_script.php'); ?>
<script>



</script>
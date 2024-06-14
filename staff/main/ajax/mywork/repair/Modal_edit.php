<?php
session_start();
include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$fixed_id = $_POST['fixed_id'];

$sql_fixed = "SELECT * FROM tbl_fixed WHERE fixed_id = '$fixed_id'";
$rs_fixed = mysqli_query($connect_db, $sql_fixed) or die($connect_db->error);
$row_fixed = mysqli_fetch_assoc($rs_fixed);



$sql_symp = "SELECT * FROM tbl_symptom_type WHERE active_status = 1";
$rs_symp = mysqli_query($connect_db, $sql_symp) or die($connect_db->error);

$sql_rea = "SELECT * FROM tbl_reason_type WHERE active_status = 1";
$rs_rea = mysqli_query($connect_db, $sql_rea) or die($connect_db->error);

?>

<style>
.border-black {
    border: 1px solid black;
}

.select2-dropdown {
    z-index: 9999999;
}
</style>

<form action="" method="post" id="form-edit_fiexd" enctype="multipart/form-data">

    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>รายการเพิ่ม</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">

        <div class="row">
            <input id="fixed_id" name="fixed_id" value="<?php echo $fixed_id ?>" type="hidden">

            <div class="col-6 mb-3">
                <label>ระบุอาการเสีย </label>
                <font style="color: red;"> **</font>
                <select class="form-control select2" style="width: 100%;" id="symptom_type_id" name="symptom_type_id">
                    <option value="">--ระบุอาการ--</option>
                    <?php while ($row_symp = mysqli_fetch_assoc($rs_symp)) { ?>
                    <option value="<?php echo $row_symp['symptom_type_id'] ?>" <?php if ($row_fixed['symptom_type_id'] == $row_symp['symptom_type_id']) {
                                                                                        echo "SELECTED";
                                                                                    } ?>>
                        <?php echo $row_symp['type_name'] ?></option>
                    <?php } ?>
                </select>

            </div>
            <div class="col-6 mb-3">
                <label>แจ้งปัญหา </label>
                <font style="color: red;"> **</font>
                <select class="form-control select2" style="width: 100%;" id="reason_type_id" name="reason_type_id">
                    <option value="">--กรุณาเลือก--</option>
                    <?php while ($row_rea = mysqli_fetch_assoc($rs_rea)) { ?>
                    <option value="<?php echo $row_rea['reason_type_id'] ?>" <?php if ($row_fixed['reason_type_id'] == $row_rea['reason_type_id']) {
                                                                                        echo "SELECTED";
                                                                                    } ?>>
                        <?php echo $row_rea['type_name'] ?></option>
                    <?php } ?>
                </select>

            </div>

            <div class="col-12 mb-3">
                <label>หมายเหตุ </label>
                <textarea class="form-control summernote" id="remark"
                    name="remark"><?php echo $row_fixed['remark'] ?></textarea>

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary px-5" type="button" id="submit" onclick="Update_fixed()">บันทึก</button>
    </div>

</form>

<?php include('import_script.php'); ?>
<script>
$(document).ready(function() {

    $(".select2").select2({});
});
</script>
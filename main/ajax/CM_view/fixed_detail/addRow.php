<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];
$sql_symp = "SELECT * FROM tbl_symptom_type WHERE active_status = 1";
$rs_symp = mysqli_query($connect_db, $sql_symp) or die($connect_db->error);

$sql_rea = "SELECT * FROM tbl_reason_type WHERE active_status = 1";
$rs_rea = mysqli_query($connect_db, $sql_rea) or die($connect_db->error);
?>



<div class="col-6 mb-3">
    <label>ระบุอาการ </label>
    <select class="form-control select2" id="symptom_type_id" name="symptom_type_id">
        <option value="">--ระบุอาการ--</option>
        <?php while ($row_symp = mysqli_fetch_assoc($rs_symp)) { ?>
            <option value="<?php echo $row_symp['symptom_type_id'] ?>"><?php echo $row_symp['type_name'] ?></option>
        <?php } ?>
    </select>

</div>
<div class="col-6 mb-3">
    <label>แจ้งปัญหา </label>
    <select class="form-control select2" id="symptom_type_id" name="symptom_type_id">
        <option value="">--กรุณาเลือก--</option>
        <?php while ($row_rea = mysqli_fetch_assoc($rs_rea)) { ?>
            <option value="<?php echo $row_rea['reason_type_id'] ?>"><?php echo $row_rea['type_name'] ?></option>
        <?php } ?>
    </select>

</div>

<div class="col-12 mb-3">
    <label>หมายเหตุ </label>
    <textarea class="form-control summernote" id="remark" name="remark"></textarea>

</div>
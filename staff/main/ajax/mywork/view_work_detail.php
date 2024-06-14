<?php

include 'header.php';
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
session_start();



$job_id = $_POST['job_id'];
$type = $_POST['type'];

$sql = "SELECT a.*,b.branch_name,b.district_id FROM tbl_job a  
LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id 
WHERE a.job_id = '$job_id' ;";
// echo $sql;
$rs  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($rs);

?>

<div class="ibox mb-3 d-block">
    <div class="ibox-title">
        <h2><?php echo $row['job_no'] ?></h2>
        <font color="gray">
            <h4><?php echo $row['branch_name'] ?></h4>
        </font>
        <div class="ibox-tools"><br>
            <?php echo $status ?>
        </div>
    </div>
</div>

<input type="text" id="job_id" name="job_id" value="<?php echo $job_id ?>" hidden>

<div class="p-1">
    <div class="col-lg-12">

        <div class="form-group">
            <label>รายการ</label>
            <select class="form-control select2" id="menu" name="menu" data-width="100%" onchange="Getdata();">
                <option value="1" selected>รายละเอียด </option>
                <?php if ($row['hold_status'] == 0) { ?>
                    <?php if ($row['job_type'] == 4) { ?>
                        <option value="11">งานย่อย Overhaul </option>
                    <?php } ?>
                    <?php if ($row['job_type'] == 2 || $row['job_type'] == 3 || $row['job_type'] == 1) { ?>
                        <option value="7">บันทึกการปฏิบัติงาน </option>
                    <?php } ?>

                    <?php if ($row['job_type'] == 1 || $row['job_type'] == 4) { ?>
                        <option value="3">เครื่องทดแทน </option>
                    <?php } ?>
                    <?php if ($row['job_type'] == 1) { ?>
                        <option value="9">บันทึกการซ่อม </option>
                    <?php } ?>
                    <?php if ($row['job_type'] == 2||$row['job_type'] == 3||$row['job_type'] == 4||$row['job_type'] == 5) { ?>
                        <option value="13">บันทึกรูป </option>
                    <?php } ?>
                    <option value="2">อะไหล่และบริการ </option>
                    <option value="6">การเก็บเงิน </option>
                    <option value="10">ภาพรวม </option>
                    <option value="5">ค่าใช้จ่าย </option>

                    <option value="4">บันทึกประจำวัน </option>


                    <!-- <?php if ($row['type'] == 2) { ?>
                            <option value="8">บันทึก OH </option>
                        <?php } ?> -->

                        <option value="12">ลายเซ็น </option>
                <?php } ?>
            </select>
        </div>

    </div>

    <div id="show_data"></div>

</div>
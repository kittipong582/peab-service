<?php

include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
session_start();
$user_id = $_SESSION['user_id'];

$job_id = $_POST['job_id'];



$sql = "SELECT a.*,b.branch_name AS cus_branch_name,b.google_map_link,c.serial_no,c.warranty_start_date,c.warranty_expire_date,d.brand_name,g.model_name,b.address AS baddress,b.address2 AS baddress2 FROM tbl_job a 
LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id
LEFT JOIN tbl_product c ON a.product_id = c.product_id
LEFT JOIN tbl_product_brand d ON c.brand_id = d.brand_id
LEFT JOIN tbl_product_model g ON c.model_id = g.model_id
WHERE a.job_id = '$job_id' ;";
$result  = mysqli_query($connect_db, $sql);
$num_row = mysqli_num_rows($result);
$row = mysqli_fetch_array($result);
// echo $sql;


//////////////////////////////////////////////////////////////////////////////////////////////////////

$sql_spare = "SELECT IFNULL(SUM(unit_price),0) AS totall,IFNULL(SUM(quantity),0) AS sum_spare FROM tbl_job_spare_used WHERE job_id = '$job_id'";
$result_spare  = mysqli_query($connect_db, $sql_spare);
$row_spare = mysqli_fetch_array($result_spare);

$sql_income = "SELECT * FROM tbl_job_income WHERE job_id = '$job_id'";
$result_income  = mysqli_query($connect_db, $sql_income);
while ($row_income = mysqli_fetch_array($result_income)) {

    $income_total += $row_income['quantity'] * $row_income['income_amount'];
}

$service_total = $income_total;

$start = new DateTime($row['appointment_time_start']);
$end = new DateTime($row['appointment_time_end']);

$time = $start->diff($end);
$diffInMinutes = $time->i; //นาที;
$diffInHours   = $time->h; //ชั่วโมง;

$minute = $diffInMinutes;
$hour = $diffInHours;

$count_minute = strlen($minute);
if ($count_minute == 1) {
    $minute = "0" . $diffInMinutes;
}

$count_hour = strlen($hour);
if ($count_hour == 1) {
    $hour = "0" . $diffInHours;
}

$total_time = $hour . " : " . $minute;
//////////////////////////////////////////////////////////////////////////////////////////////////////

$warranty_start_date = date('d-M-Y', strtotime($row['warranty_start_date']));
$warranty_expire_date = date('d-M-Y', strtotime($row['warranty_expire_date']));
$today = date("d-M-Y");
$today_time = strtotime($today);
// $expire_time = strtotime($expire);


if ($today_time < $warranty_expire_date && $warranty_expire_date != "") {
    $chk_date = "";
} else if ($today_time > $warranty_expire_date && $warranty_expire_date != "") {
    $chk_date = '<font color="red">(หมดประกัน)</font>';
} else {
    $chk_date = '<font color="red">ไม่ระบุ</font>';
}


////////////////////อะไหล่//////////////////
$sql_spare2 = "SELECT * FROM tbl_job_spare_used a 
LEFT JOIN tbl_spare_part b ON a.spare_part_id = b.spare_part_id
WHERE a.job_id = '$job_id' ORDER BY b.spare_part_code DESC";
$result_spare2  = mysqli_query($connect_db, $sql_spare2);
$num_spare2 = mysqli_num_rows($result_spare2);

///////////////ซ่อม////////////////
$sql_fix = "SELECT a.*,b.type_name AS sym_name ,c.type_name AS reason_name FROM tbl_fixed a 
LEFT JOIN tbl_symptom_type b ON a.symptom_type_id = b.symptom_type_id
LEFT JOIN tbl_reason_type c ON a.reason_type_id = c.reason_type_id
WHERE a.job_id = '$job_id'";
$result_fix  = mysqli_query($connect_db, $sql_fix);
$row_fix = mysqli_fetch_array($result_fix);
$num_fix = mysqli_num_rows($result_fix);

////////////////////ค่าใช้จ่าย//////////////////
$sql_expend = "SELECT * FROM tbl_job_expend a 
LEFT JOIN tbl_expend_type b ON a.expend_type_id = b.expend_type_id
WHERE a.job_id = '$job_id'";
$result_expend  = mysqli_query($connect_db, $sql_expend);
$num_expend = mysqli_num_rows($result_expend);


?>
<div class="col-lg-12">
    <div class="row">
        <div class="col-6">
            <div class="widget style1 navy-bg">
                <div class="row">
                    <!-- <div class="col-4">
                        <i class="fa fa-money fa-4x"></i>
                    </div> -->
                    <div class="col-12 text-center">
                        <span> ค่าบริการ </span>
                        <h3 class="font-bold" id="total_service"><?php echo number_format($service_total); ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="widget style1 red-bg">
                <div class="row">
                    <!-- <div class="col-4">
                        <i class="fa fa-list-ul fa-4x"></i>
                    </div> -->
                    <div class="col-12 text-center">
                        <span> ค่าใช้จ่าย </span>
                        <h3 class="font-bold"><?php echo number_format($row_spare['totall']); ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<br>

<div class="ibox mb-1 d-block">
    <br>

    <div class="ibox-content">

        <?php if ($num_fix > 0) { ?>
            <div class="row mb-1">

                <div class="col-12">
                    <label style="font-size: 15px;"><b>รายละเอียดการซ่อม</b></label>
                    <div class="row">
                        <div class="col-6 mb-1">
                            <label><b>อาการ</b></label><br>
                            <label><?php echo $row_fix['sym_name']; ?></label>
                        </div>
                        <div class="col-6 mb-1">
                            <label><b>วิธีแก้</b></label><br>
                            <label><?php echo $row_fix['reason_name']; ?></label>
                        </div>
                        <div class="col-12 mb-1">
                            <label><b>หมายเหตุ</b></label><br>
                            <label><?php echo $row_fix['remark']; ?></label>
                        </div>
                    </div>

                </div>

            </div>
        <?php } ?>


        <?php if ($num_spare2 > 0) { ?>
            <div class="row mb-1">

                <div class="col-12 mb-1">
                    <label style="font-size: 15px;"><b>อะไหล่</b></label>
                    <div class="row">
                        <?php
                        while ($row_spare2 = mysqli_fetch_array($result_spare2)) {
                        ?>
                            <div class="col-6 mb-1">

                                <label><?php echo $row_spare2['spare_part_code'] . " " . $row_spare2['spare_part_name'] ?></label>
                            </div>
                            <div class="col-6 mb-1">

                                <label><?php echo " x " . $row_spare2['quantity'] ?></label>
                            </div>
                        <?php } ?>
                    </div>
                </div>

            </div>
        <?php } ?>

        <?php if ($num_expend > 0) { ?>
            <div class="row mb-1">
                <div class="col-12">
                    <label style="font-size: 15px;"><b>บันทึกค่าใช่จ่าย</b></label>
                    <div class="row">
                        <?php while ($row_expend = mysqli_fetch_array($result_expend)) { ?>
                            <div class="col-6 mb-1">
                                <label><?php echo $row_expend['expend_code'] . " " . $row_expend['expend_type_name'] ?></label>
                            </div>
                            <div class="col-6 mb-1">
                                <label><?php echo $row_expend['expend_amount'] ?></label>
                            </div>

                        <?php } ?>
                    </div>
                </div>
            </div>

        <?php } ?>
        
        <div class="row">

            <div class="col-6">
                <label><b>S/N</b></label> <br><?php echo $row['serial_no'] ?>
            </div>

            <div class="col-6">
                <label><b>การรับประกัน</b></label> <br>ซื้อจากบริษัท
            </div>

        </div>

        <br>
        <div class="row">

            <div class="col-6">
                <label><b>รุ่น</b></label> <br><?php echo $row['model_name']; ?>(<?php echo $row['brand_name']; ?>)
            </div>

            <div class="col-6">
                <label><b>วันหมดประกัน</b></label>
                <br><?php echo ($row['warranty_expire_date'] == "") ? "-" : date('d-M-Y', strtotime($row['warranty_expire_date'])) ?>
                <?php echo $chk_date; ?>
            </div>

        </div>

        <br>
        <div class="row">

            <div class="col-6">
                <label><b>วันที่สร้างรายการ</b></label>
                <br><?php echo date('d-M-Y', strtotime($row['create_datetime'])); ?>
            </div>

            <div class="col-6">
                <label><b>วันที่นัดหมาย</b></label>
                <br><?php echo date('d-M-Y H:i', strtotime($row['appointment_date'])); ?>
            </div>

        </div>

        <?php if ($row['job_type'] == 1) { ?>
            <br>
            <div class="row">

                <div class="col-6">
                    <label><b>อาการเสียเบื้องต้น</b></label>
                    <br><?php echo $row['initial_symptoms']; ?>
                </div>


            </div>
        <?php } ?>

        <!-- <br>
        <div class="row">

            <div class="col-12">
                <label><b>วันเวลาที่เข้าออกงาน</b></label>
                <br><?php echo date('d-M-Y', strtotime($row['appointment_date'])); ?> [
                <?php echo date('H : i', strtotime($row['appointment_time_start'])); ?> -
                <?php echo date('H : i', strtotime($row['appointment_time_end'])); ?> ]
            </div>

        </div> -->


    </div>
</div>

<script>
    $(document).ready(function() {

    });

    $(".select2").select2({});

    $('.date').datepicker({
        // startView: 0,
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true,
        format: "dd/mm/yyyy",

    })
</script>
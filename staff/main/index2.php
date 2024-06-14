<?php

@session_start();
include 'header2.php';
// include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$user_id = $_SESSION['user_id'];
$audit_status = $_SESSION['audit_status'];
$admin_status = $_SESSION['admin_status'];

$date = date('Y-m-d');
$sql = "SELECT COUNT(job_id) AS c_job FROM tbl_job WHERE responsible_user_id = '$user_id' AND appointment_date = '$date' ;";
// echo $sql;
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);


$sql_blacklog = "SELECT COUNT(*) AS c_job_blacklog  FROM tbl_job a 
LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id
LEFT JOIN tbl_product c ON a.product_id = c.product_id
LEFT JOIN tbl_product_model d ON c.model_id = d.model_id
LEFT JOIN tbl_sub_job_type k ON k.sub_job_type_id = a.sub_job_type_id
WHERE a.responsible_user_id = '$user_id'  AND close_datetime IS NULL AND a.cancel_datetime IS NULL AND a.appointment_date <= '$date'";
$res_blacklog = mysqli_query($connect_db, $sql_blacklog);
$row_blacklog = mysqli_fetch_assoc($res_blacklog);
$num_blacklog = mysqli_num_rows($res_blacklog);

$sql_blacklog_group = "SELECT COUNT(*) AS c_job_blacklog_group FROM tbl_group_pm
WHERE group_pm_id IN (select group_pm_id from tbl_group_pm_detail c 
LEFT JOIN tbl_job a ON a.job_id = c.job_id 
LEFT JOIN tbl_branch e ON a.care_branch_id = e.branch_id
LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id 
WHERE a.responsible_user_id = '$user_id' AND close_datetime IS NULL AND a.appointment_date <= '$date')";
$res_blacklog_group = mysqli_query($connect_db, $sql_blacklog_group);
$row_blacklog_group = mysqli_fetch_assoc($res_blacklog_group);

$total_blacklog = $row_blacklog['c_job_blacklog'] + $row_blacklog_group['c_job_blacklog_group'] ;

?>
<div class="row m-0 p-1">
    <?php
    if ($admin_status == '9' && $audit_status == '1') {
    ?>
        <div class="col-4 p-2">
            <a href="audit_work.php" class="ibox pointer box-menu">
                <div class="ibox-content text-center">
                    <span><i class="fa fa-cube"></i></span><br>
                    เปิดงาน Audit
                </div>
            </a>
        </div>
        <div class="col-4 p-2">
            <a href="audit_work_list.php" class="ibox pointer box-menu">
                <div class="ibox-content text-center">
                    <span><i class="fa fa-cube"></i></span><br>
                    รายการ Audit
                </div>
            </a>
        </div>
    <?php
    } else {
    ?>
        <div class="col-12 p-2">
            <a href="my_work2.php" class="widget style1 bg-success m-0 block">
                <div class="row">
                    <div class="col-4">
                        <i class="fa fa-cloud fa-5x"></i>
                    </div>
                    <div class="col-8 text-right">
                        <span> งานวันนี้ </span>
                        <h2 class="font-bold"><?php echo $row['c_job'] ?></h2>
                    </div>
                </div>
            </a>
        </div>
        <?php if ($num_blacklog > 0) { ?>
            <div class="col-12 p-2">
                <a href="blacklog.php" class="widget style1 bg-warning m-0 block">
                    <div class="row">
                        <div class="col-4">
                            <i class="fa fa-tasks fa-5x"></i>
                        </div>
                        <div class="col-8 text-right">
                            <span> งานค้างทั้งหมด </span>
                            <h2 class="font-bold"><?php echo $total_blacklog ?></h2>
                        </div>
                    </div>
                </a>
            </div>
        <?php } ?>
        <div class="col-4 p-2">
            <a href="my_work2.php" class="ibox pointer box-menu">
                <div class="ibox-content text-center">
                    <span><i class="fa fa-tasks"></i></span><br>
                    งานของฉัน
                </div>
            </a>
        </div>

        <div class="col-4 p-2">
            <a href="calendar_plan.php" class="ibox pointer box-menu">
                <div class="ibox-content text-center">
                    <span><i class="fa fa-calendar"></i></span><br>
                    ปฏิทินงาน
                </div>
            </a>
        </div>

        <div class="col-4 p-2">
            <a href="on_hand.php" class="ibox pointer box-menu">
                <div class="ibox-content text-center">
                    <span><i class="fa fa-cubes"></i></span><br>
                    คลังอุปกรณ์
                </div>
            </a>
        </div>

        <div class="col-4 p-2">
            <a href="confirm_import.php" class="ibox pointer box-menu">
                <div class="ibox-content text-center">
                    <span><i class="fa fa-cube"></i></span><br>
                    ยืนยันรับ
                </div>
            </a>
        </div>

        <div class="col-4 p-2">
            <a href="transfer.php" class="ibox pointer box-menu">
                <div class="ibox-content text-center">
                    <span><i class="fa fa-cube"></i></span><br>
                    โอนย้าย
                </div>
            </a>
        </div>

        <div class="col-4 p-2">
            <a href="confirm_transfer.php" class="ibox pointer box-menu">
                <div class="ibox-content text-center">
                    <span><i class="fa fa-cube"></i></span><br>
                    รับโอนย้าย
                </div>
            </a>
        </div>

        <div class="col-4 p-2">
            <a href="adjust_stock.php" class="ibox pointer box-menu">
                <div class="ibox-content text-center">
                    <span><i class="fa fa-cube"></i></span><br>
                    ปรับสต๊อก
                </div>
            </a>
        </div>


        <div class="col-4 p-2">
            <a href="transfer_notice.php" class="ibox pointer box-menu">
                <div class="ibox-content text-center">
                    <span><i class="fa fa-cube"></i></span><br>
                    แจ้งโอน
                </div>
            </a>
        </div>

        <div class="col-4 p-2">
            <a href="manual.php" class="ibox pointer box-menu">
                <div class="ibox-content text-center">
                    <span><i class="fa fa-cube"></i></span><br>
                    คู่มือ
                </div>
            </a>
        </div>

        <div class="col-4 p-2">
            <a href="work_list.php" class="ibox pointer box-menu">
                <div class="ibox-content text-center">
                    <span><i class="fa fa-cube"></i></span><br>
                    รายการงาน(IP)
                </div>
            </a>
        </div>

        <!-- <div class="col-4 p-2">
        <a href="qc_work_list.php" class="ibox pointer box-menu">
            <div class="ibox-content text-center">
                <span><i class="fa fa-cube"></i></span><br>
                งาน QC
            </div>
        </a>
    </div> -->

        <div class="col-4 p-2">
            <a href="#" class="ibox pointer box-menu">
                <div class="ibox-content text-center">
                    <span><i class="fa fa-cog"></i></span><br>
                    ตั้งค่า
                </div>
            </a>
        </div>
    <?php
    }
    ?>

    <div class="col-4 p-2">
        <a href="#" class="ibox pointer box-menu" onclick="SetNewPass();">
            <div class="ibox-content text-center">
                <span><i class="fa fa-key"></i></span><br>
                แก้ไขรหัสผ่าน
            </div>
        </a>
    </div>

    <div class="col-4 p-2">
        <a onclick="LogoutConfirm();" class="ibox pointer box-menu">
            <div class="ibox-content text-center">
                <span><i class="fa fa-sign-out"></i></span><br>
                ออกจากระบบ
            </div>
        </a>
    </div>




</div>
<?php include 'footer.php'; ?>

<script>
    function LogoutConfirm() {
        swal({
            title: "คุณต้องการออกจากระบบ ?",
            showCancelButton: true,
            confirmButtonColor: "#3244a8",
            confirmButtonText: "ยืนยัน",
            cancelButtonText: "ยังไม่ใช่ตอนนี้",
            closeOnConfirm: false
        }, function() {

            window.location.href = 'logout.php';


        })


    }
</script>
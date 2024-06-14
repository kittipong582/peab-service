<?php

session_start();
include("../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);
// 1 = CM , 2 = PM , 3 = Installation , 4 = overhaul,5 = oth,6=quotation

$sql_cm = "SELECT COUNT(*) AS total FROM `tbl_job` WHERE job_type = '1' AND open_datetime IS NULL AND close_datetime IS NULL;";
$res_cm = mysqli_query($connection, $sql_cm);
$row_cm = mysqli_fetch_assoc($res_cm);

$sql_pm = "SELECT COUNT(*) AS total FROM `tbl_job` WHERE job_type = '2' AND open_datetime IS NULL AND close_datetime IS NULL;";
$res_pm = mysqli_query($connection, $sql_pm);
$row_pm = mysqli_fetch_assoc($res_pm);

$sql_in = "SELECT COUNT(*) AS total FROM `tbl_job` WHERE job_type = '3' AND open_datetime IS NULL AND close_datetime IS NULL;";
$res_in = mysqli_query($connection, $sql_in);
$row_in = mysqli_fetch_assoc($res_in);

$sql_oh = "SELECT COUNT(*) AS total FROM `tbl_job` WHERE job_type = '4' AND open_datetime IS NULL AND close_datetime IS NULL;";
$res_oh = mysqli_query($connection, $sql_oh);
$row_oh = mysqli_fetch_assoc($res_oh);

$sql_oth = "SELECT COUNT(*) AS total FROM `tbl_job` WHERE job_type = '5' AND open_datetime IS NULL AND close_datetime IS NULL;";
$res_oth = mysqli_query($connection, $sql_oth);
$row_oth = mysqli_fetch_assoc($res_oth);

?>
<div class="row">
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <!-- <span class="label label-success float-right">Monthly</span> -->
                <h5>งานค้าง CM</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"><?php echo $row_cm['total']; ?></h1>
                <!-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> -->
                <small>งาน</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <!-- <span class="label label-info float-right">Annual</span> -->
                <h5>งานค้าง PM</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"><?php echo $row_pm['total']; ?></h1>
                <!-- <div class="stat-percent font-bold text-info">20% <i class="fa fa-level-up"></i></div> -->
                <small>งาน</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <!-- <span class="label label-info float-right">Annual</span> -->
                <h5>งานค้าง IN</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"><?php echo $row_in['total']; ?></h1>
                <!-- <div class="stat-percent font-bold text-info">20% <i class="fa fa-level-up"></i></div> -->
                <small>งาน</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <!-- <span class="label label-info float-right">Annual</span> -->
                <h5>งานค้าง OH</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"><?php echo $row_oh['total']; ?></h1>
                <!-- <div class="stat-percent font-bold text-info">20% <i class="fa fa-level-up"></i></div> -->
                <small>งาน</small>
            </div>
        </div>
    </div>
    <!-- <div class="col-lg-4">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Monthly income</h5>
                    <div class="ibox-tools">
                        <span class="label label-primary">Updated 12.2015</span>
                    </div>
                </div>
                <div class="ibox-content no-padding">
                    <div class="flot-chart m-t-lg" style="height: 55px;">
                        <div class="flot-chart-content" id="flot-chart1"></div>
                    </div>
                </div>

            </div>
        </div> -->
</div>
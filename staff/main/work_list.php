<?php
include 'header2.php';
// include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

// session_start();
// $user_id = $_SESSION['user_id'];
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <center>
            <h2>รายการงาน</h2>
        </center>

    </div>
</div>
<div class="row row m-0 p-1">
    <div class="col-6 p-2 ">
        <a href="work_stuck.php" class="ibox pointer box-menu">
            <div class="ibox-content text-center">
                <span><i class="fa fa-cube"></i></span><br>
                งานค้าง
            </div>
        </a>
    </div>
    <div class="col-6 p-2 ">
        <a href="work_today.php" class="ibox pointer box-menu">
            <div class="ibox-content text-center">
                <span><i class="fa fa-cube"></i></span><br>
                งานวันนี้
            </div>
        </a>
    </div>
</div>
<?php include('header.php');
session_start();
include("../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);
$user_id = $_GET['id'];
$pagename = basename($_SERVER['PHP_SELF']);

$sql = "SELECT * FROM tbl_user WHERE user_id = '$user_id'";
$result  = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($result);



$level = "";
if ($row['user_level'] == 1) {
    $level = "ทีมงานทั่วไป";
} else if ($row['user_level'] == 2) {
    $level = "หัวหน้าทีม";
} else if ($row['user_level'] == 3) {
    $level = "หัวหน้าเขต";
} else if ($row['user_level'] == 4) {
    $level = "ส่วนกลาง";
}


$place = "";
if ($row['user_level'] == 1 || $row['user_level'] == 2) {

    $branch_id = $row['branch_id'];
    $sql_sub = "SELECT * FROM tbl_branch WHERE branch_id = '$branch_id' and active_status = 1";
    $result_sub  = mysqli_query($connection, $sql_sub);
    $row_sub = mysqli_fetch_array($result_sub);

    $place = $row_sub['branch_name'];
} else if ($row['user_level'] == 3) {


    $zone_id = $row['zone_id'];
    $sql_sub = "SELECT * FROM tbl_zone WHERE zone_id = '$zone_id' and active_status = 1";
    $result_sub  = mysqli_query($connection, $sql_sub);
    $row_sub = mysqli_fetch_array($result_sub);

    $place = $row_sub['zone_name'];
}


?>
<style>
    .box-input {
        min-height: 90px;
    }

    /* tr {
        color: #676a6c;
    } */
    .classmodal1 {
        max-width: 1200px;
        margin: auto;
    }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo "ผู้ใช้ " . $row['fullname'] ?></h2>
        <ol class="breadcrumb">

            <li class="breadcrumb-item">
                <?php echo $row['fullname'] ?>
            </li>
            <li class="breadcrumb-item">
                ภาพรวม
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInUp">


                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-2">
                            <br>
                            <a href="view_vender.php?id=<?php echo $user_id ?>"><button type="button" class="btn btn-block dim <?php if ($pagename == 'view_vender.php') echo ' btn-secondary';
                                                                                                                                else {
                                                                                                                                    echo 'btn-info';
                                                                                                                                } ?>">ภาพรวม</button></a>
                        </div>
                        <div class="col-md-2">
                            <br>
                            <a href="view_job_vender.php?id=<?php echo $user_id ?>"><button type="button" class="btn btn-block dim <?php if ($pagename == 'view_job_vender.php') echo ' btn-secondary';
                                                                                                                                    else {
                                                                                                                                        echo 'btn-info';
                                                                                                                                    } ?>">ประวัติงาน</button></a>
                        </div>

                        <div class="col-md-2">
                            <br>
                            <a href="view_onhand_vender.php?id=<?php echo $user_id ?>"><button type="button" class="btn btn-block dim <?php if ($pagename == 'view_onhand_vender.php') echo ' btn-secondary';
                                                                                                                                    else {
                                                                                                                                        echo 'btn-info';
                                                                                                                                    } ?>">On Hand</button></a>
                        </div>

                    </div>
                </div>
                <br>

                <div class="ibox">
                    <div class="ibox-content">

                        <br>
                        <div class="row">

                            <div class="col-lg-6">
                                <dl class="row mb-0">
                                    <div class="col-sm-4 text-sm-left">
                                        <dt>ชื่อ :</dt>
                                    </div>
                                    <div class="col-sm-8 text-sm-left">
                                        <dd class="mb-1"><?php echo $row['fullname']; ?></dd>
                                    </div>
                                </dl>
                                <dl class="row mb-0">
                                    <div class="col-sm-4 text-sm-left">
                                        <dt>เบอร์มือถือ :</dt>
                                    </div>
                                    <div class="col-sm-8 text-sm-left">
                                        <dd class="mb-1"><?php echo $row['mobile_phone']; ?>
                                        </dd>
                                    </div>
                                </dl>
                                <dl class="row mb-0">
                                    <div class="col-sm-4 text-sm-left">
                                        <dt>เบอร์สำนักงาน :</dt>
                                    </div>
                                    <div class="col-sm-8 text-sm-left">
                                        <dd class="mb-1"><?php echo $row['office_phone'] ?></dd>
                                    </div>
                                </dl>
                                <dl class="row mb-0">
                                    <div class="col-sm-4 text-sm-left">
                                        <dt>email :</dt>
                                    </div>
                                    <div class="col-sm-8 text-sm-left">
                                        <dd class="mb-1">
                                            <?php echo $row['email']; ?>
                                        </dd>
                                    </div>
                                </dl>
                                <dl class="row mb-0">
                                    <div class="col-sm-4 text-sm-left">
                                        <dt>Line ID :</dt>
                                    </div>
                                    <div class="col-sm-8 text-sm-left">
                                        <dd class="mb-1"><?php echo $row['line_id']; ?> </dd>
                                    </div>
                                </dl>
                                <dl class="row mb-0">
                                    <div class="col-sm-4 text-sm-left">
                                        <dt>สถานะ :</dt>

                                    </div>
                                    <div class="col-sm-8 text-sm-left">
                                        <dd class="mb-1"><?php if ($row['active_status'] == 1) { ?>
                                                <span class="badge badge-primary">ใช้งาน</span>
                                            <?php } else { ?>

                                                <span class="badge badge-danger">ไม่ใช่งาน</span>

                                            <?php  } ?>
                                        </dd>
                                    </div>
                                </dl>

                            </div>
                            <div class="col-lg-6" id="cluster_info">

                                <dl class="row mb-0">
                                    <div class="col-sm-4 text-sm-left">
                                        <dt>ทีม/ศูนย์ :</dt>
                                    </div>
                                    <div class="col-sm-8 text-sm-left">
                                        <dd class="mb-1">
                                            <?php echo $place; ?></dd>
                                    </div>

                                </dl>

                                <dl class="row mb-0">
                                    <div class="col-sm-4 text-sm-left">
                                        <dt>วันที่นัดหมาย :</dt>
                                    </div>
                                    <div class="col-sm-8 text-sm-left">
                                        <dd class="mb-1">
                                            <?php
                                            if ($row['appointment_date'] != null) {
                                                echo date('d-M-Y', strtotime($row['appointment_date']));
                                            } else {
                                                echo "-";
                                            }; ?></dd>
                                    </div>
                                </dl>
                                <dl class="row mb-0">
                                    <div class="col-sm-4 text-sm-left">
                                        <dt>วันที่เข้า-ออกงาน :</dt>
                                    </div>
                                    <div class="col-sm-8 text-sm-left">
                                        <dd class="mb-1">
                                            <?php if ($row['start_service_time'] != null) {
                                                echo date('d-M-Y', strtotime($row['start_service_time']));
                                            } else {
                                                echo "-" . "</br>";
                                            } ?>
                                        </dd>
                                    </div>
                                </dl>
                                <dl class="row mb-0">
                                    <div class="col-sm-4 text-sm-left">
                                        <dt>เวลาที่เข้างาน :</dt>
                                    </div>
                                    <div class="col-sm-8 text-sm-left">
                                        <dd class="mb-1">
                                            <?php if ($row['start_service_time'] != null) {
                                                echo date('H : i', strtotime($row['start_service_time']));
                                            } else {
                                                echo "-" . "</br>";
                                            } ?>
                                        </dd>
                                    </div>
                                </dl>
                                <dl class="row mb-0">
                                    <div class="col-sm-4 text-sm-left">
                                        <dt>เวลาที่ออกงาน :</dt>
                                    </div>
                                    <div class="col-sm-8 text-sm-left">
                                        <dd class="mb-1">
                                            <?php if ($row['finish_service_time'] != null) {
                                                echo  date('H : i', strtotime($row['finish_service_time']));
                                            } else {
                                                echo "-" . "</br>";
                                            } ?>
                                        </dd>
                                    </div>
                                </dl>


                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>

    </div>
</div>


<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>

<div class="modal fade" id="modal1">
    <div class="modal-dialog modal-lg modal-dialog-centered classmodal1" id="modal1" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>



<?php include('import_script.php'); ?>
<script>

</script>
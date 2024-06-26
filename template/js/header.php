<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Peaberry</title>

    <link href="../../template/css/bootstrap.min.css" rel="stylesheet">

    <link href="../../template/font-awesome/css/font-awesome.css" rel="stylesheet">



    <!-- Toastr style -->

    <link href="../../template/css/plugins/toastr/toastr.min.css" rel="stylesheet">



    <!-- Gritter -->

    <link href="../../template/js/plugins/gritter/jquery.gritter.css" rel="stylesheet">



    <link href="../../template/css/plugins/iCheck/custom.css" rel="stylesheet">

    <link href="../../template/css/plugins/chosen/bootstrap-chosen.css" rel="stylesheet">



    <link href="../../template/css/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">



    <link href="../../template/css/plugins/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet">



    <!-- <link href="../template/css/plugins/cropper/cropper.min.css" rel="stylesheet"> -->



    <link href="../../template/css/plugins/switchery/switchery.css" rel="stylesheet">


    <link href="../../template/css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">


    <link href="../../template/css/plugins/nouslider/jquery.nouislider.css" rel="stylesheet">


    <link href="../../template/css/plugins/datapicker/datepicker3.css" rel="stylesheet">


    <link href="../../template/css/plugins/ionRangeSlider/ion.rangeSlider.css" rel="stylesheet">


    <link href="../../template/css/plugins/ionRangeSlider/ion.rangeSlider.skinFlat.css" rel="stylesheet">


    <link href="../../template/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">


    <link href="../../template/css/plugins/clockpicker/clockpicker.css" rel="stylesheet">


    <link href="../../template/css/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet">


    <link href="../../template/css/plugins/select2/select2.min.css" rel="stylesheet">


    <!-- <link href="../template/css/plugins/select2/select2-bootstrap.min.css" rel="stylesheet"> -->


    <link href="../../template/css/plugins/touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">


    <link href="../../template/css/plugins/dualListbox/bootstrap-duallistbox.min.css" rel="stylesheet">


    <link href="../../template/css/animate.css" rel="stylesheet">

    <link href="../../template/css/plugins/summernote/summernote-bs4.css" rel="stylesheet">

    <link href="../../template/css/style.css" rel="stylesheet">

    <link href="../../template/css/plugins/dataTables/datatables.min.css" rel="stylesheet">

    <!-- <link rel="stylesheet" href="../vendor/jquery.Thailand.js/dist/jquery.Thailand.min.css"> -->



    <!-- Sweet Alert -->

    <link href="../../template/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">



    <!-- Drop Zone -->

    <link href="../../template/css/plugins/dropzone/basic.css" rel="stylesheet">

    <link href="../../template/css/plugins/dropzone/dropzone.css" rel="stylesheet">

    <link href="../../template/css/plugins/codemirror/codemirror.css" rel="stylesheet">



    <link href="../../template/css/plugins/blueimp/css/blueimp-gallery.min.css" rel="stylesheet">

    <link href="../../template/css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">

    <!-- C3 -->

    <link href="../../template/css/plugins/c3/c3.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,300;0,500;0,700;1,300;1,500;1,700&display=swap" rel="stylesheet">
    <style>
        html,
        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        small,
        strong,
        a,
        button,
        ul,
        li {
            font-family: 'Prompt', sans-serif !important;
            font-weight: 300;
        }
    </style>
    <style>
        html,
        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        small,
        strong,
        a,
        button,
        ul,
        li {
            font-family: 'Prompt', sans-serif !important;
            font-weight: 300;
        }

        .line-vertical {
            border-left: 1px solid rgba(0, 0, 0, .1);
            ;
            height: 90%;
            position: absolute;
            left: 50%;

        }

        .hidden-color {
            display: none;
        }
    </style>

    <style>
        .select2-dropdown {

            z-index: 9999999;

        }

        .note-editor.note-airframe,
        .note-editor.note-frame {
            border: 1px solid #a9a9a9;
        }

        .clockpicker {
            z-index: 9999999;
        }

        table {
            font-size: 13px !important;
        }
    </style>
</head>
<script>
    function LogoutConfirm() {
        window.location.href = 'logout.php';
    }
</script>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('../config/check_session.php');

$user_level = $_SESSION['user_level'];
$user_id = $_SESSION['user_id'];
$admin_status = $_SESSION['admin_status'];

?>

<?php


$sql_user = "SELECT fullname FROM tbl_user WHERE user_id = '$user_id' ;";
$rs_user  = mysqli_query($connection, $sql_user);
$row_user = mysqli_fetch_array($rs_user);
$pagename = basename($_SERVER['PHP_SELF']);

$sql_status = "SELECT * FROM tbl_user Where user_id = '$user_id'";
$rs_status = mysqli_query($connection, $sql_status);
$row_status = mysqli_fetch_array($rs_status);
?>

<!-- <body class="mini-navbar"> -->

<body>

    <div id="wrapper">

        <nav class="navbar-default navbar-static-side" role="navigation">

            <div class="sidebar-collapse">

                <ul class="nav metismenu" id="side-menu">

                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <img alt="image" class="rounded-circle" src="upload/user icon.png" width="50px" height="50px" />
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="block m-t-xs font-bold">David Williams</span>
                                <span class="text-muted text-xs block">Art Director <b class="caret"></b></span>
                            </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a class="dropdown-item" href="profile.html">Profile</a></li>
                                <li><a class="dropdown-item" href="contacts.html">Contacts</a></li>
                                <li><a class="dropdown-item" href="mailbox.html">Mailbox</a></li>
                                <li class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="login.html">Logout</a></li>
                            </ul>
                        </div>
                        <div class="logo-element">
                            IN+
                        </div>
                    </li>

                    <li <?php if ($pagename == 'index.php') {
                            echo 'class="active"';
                        } ?>>

                        <a href="index.php"><i class="fa fa-home"></i> <span class="nav-label">หน้าหลัก</span></a>

                    </li>



                    <li <?php if ($pagename == 'customer_list.php' || $pagename == "customer_form_new.php" || $pagename == 'customer_branch_list.php' || $pagename == 'branch_view_detail.php' || $pagename == 'daily_record.php' || $pagename == 'product.php' || $pagename == 'product_view_detail.php') {
                            echo 'class="active"';
                        } ?>>


                        <a href="javascript:void(0);"><i class="fa fa-database"></i> <span class="nav-label">ลูกค้า</span><span class="fa arrow"></span></a>


                        <ul class="nav nav-second-level collapse">
                            <li class="<?php if ($pagename == 'customer_list.php' || $pagename == "customer_form_new.php") {
                                            echo 'active';
                                        } ?>">
                                <a href="customer_list.php"><i class="fa fa-list"></i> ลูกค้ารวม </a>
                            </li>
                            <li class="<?php if ($pagename == 'customer_branch_list.php' || $pagename == 'branch_view_detail.php' || $pagename == 'daily_record.php' || $pagename == 'product.php' || $pagename == 'product_view_detail.php') {
                                            echo 'active';
                                        } ?>">
                                <a href="customer_branch_list.php"><i class="fa fa-list"></i> ลูกค้าแยกสาขา </a>
                            </li>
                            <li class="<?php if ($pagename == '#') {
                                            echo 'active';
                                        } ?>"><a href="#"><i class="fa fa-list"></i> กลุ่มลูกค้า (IP)</a></li>
                        </ul>

                    </li>

                    <li <?php if ($pagename == 'work_list.php' || $pagename == 'form_add_job.php' || $pagename == 'job_list.php' || $pagename == 'view_cm.php' || $pagename == 'from_edit_job.php') {
                            echo 'class="active"';
                        } ?>>


                        <a href="javascript:void(0);"><i class="fa fa-database"></i> <span class="nav-label">รายการงาน</span><span class="fa arrow"></span></a>


                        <ul class="nav nav-second-level collapse">
                            <li class="<?php if ($pagename == 'job_list.php' || $pagename == 'view_cm.php') {
                                            echo 'active';
                                        } ?>">
                                <a href="job_list.php"><i class="fa fa-list"></i> รายการงาน </a>
                            </li>
                            <li class="<?php if ($pagename == 'form_add_job.php') {
                                            echo 'active';
                                        } ?>">
                                <a href="form_add_job.php"><i class="fa fa-list"></i> เพิ่มงาน </a>
                            </li>

                        </ul>

                    </li>

                    <li <?php if ($pagename == 'product_list.php') {
                            echo 'class="active"';
                        } ?>>

                        <a href="product_list.php"><i class="fa fa-home"></i> <span class="nav-label">รายการสินค้า</span></a>

                    </li>




                    <li <?php if ($pagename == 'job_IN_approved.php') {
                            echo 'class="active"';
                        } ?>>

                        <a href="job_IN_approved.php"><i class="fa fa-home"></i> <span class="nav-label">งานติดตั้ง</span></a>

                    </li>

                    <!-- <li <?php if ($pagename == 'job_QT_approved.php') {
                                    echo 'class="active"';
                                } ?>>

                        <a href="job_QT_approved.php"><i class="fa fa-home"></i> <span class="nav-label">งานเสนอราคา</span></a>

                    </li> -->


                    <li <?php if (
                            $pagename == 'on_hand.php' || $pagename == "import_from_ax.php" || $pagename == "adjust_stock.php" || $pagename == "new_ax_import.php" || $pagename == "new_adjust.php" || $pagename == "confirm_import.php" || $pagename == "transfer.php" || $pagename == "confirm_transfer.php" || $pagename == "new_transfer.php"
                            || $pagename == 'overhaul_list.php' || $pagename == 'view_overhaul.php'
                        ) {
                            echo 'class="active"';
                        } ?>>


                        <a href="javascript:void(0);"><i class="fa fa-database"></i> <span class="nav-label">ระบบคลัง</span><span class="fa arrow"></span></a>


                        <ul class="nav nav-second-level collapse">
                            <li class="<?php if ($pagename == 'on_hand.php') {
                                            echo 'active';
                                        } ?>">
                                <a href="on_hand.php"><i class="fa fa-cube"></i> On-Hand </a>
                            </li>

                            <?php if ($admin_status == 9) { ?>
                                <li class="<?php if ($pagename == 'import_from_ax.php' || $pagename == 'new_ax_import.php') {
                                                echo 'active';
                                            } ?>">
                                    <a href="import_from_ax.php"><i class="fa fa-download"></i> Import From AX</a>
                                </li>
                            <?php } ?>
                            <li class="<?php if ($pagename == 'confirm_import.php') {
                                            echo 'active';
                                        } ?>">
                                <a href="confirm_import.php"><i class="fa fa-check"></i><i class="fa fa-download"></i>
                                    Confirm Import</a>
                            </li>
                            <li class="<?php if ($pagename == 'transfer.php' || $pagename == 'new_transfer.php') {
                                            echo 'active';
                                        } ?>">
                                <a href="transfer.php"><i class="fa fa-exchange"></i> โอนย้าย</a>
                            </li>
                            <li class="<?php if ($pagename == 'confirm_transfer.php') {
                                            echo 'active';
                                        } ?>">
                                <a href="confirm_transfer.php"><i class="fa fa-check"></i><i class="fa fa-exchange"></i>
                                    รับโอน</a>
                            </li>
                            <li class="<?php if ($pagename == 'adjust_stock.php' || $pagename == 'new_adjust.php') {
                                            echo 'active';
                                        } ?>">
                                <a href="adjust_stock.php"><i class="fa fa-upload"></i> ปรับ Stock</a>
                            </li>
                            <li class="<?php if ($pagename == 'overhaul_list.php' || $pagename == 'view_overhaul.php') {
                                            echo 'active';
                                        } ?>"><a href="overhaul_list.php"><i class="fa fa-list"></i> เครื่องทดแทน</a></li>


                        </ul>

                    </li>






                    <li <?php if ($pagename == 'spare_type_list.php' || $pagename == 'spare_part_list.php' || $pagename == 'product_brand.php') {
                            echo 'class="active"';
                        } ?>>


                        <a href="javascript:void(0);"><i class="fa fa-database"></i> <span class="nav-label">ฐานข้อมูล</span><span class="fa arrow"></span></a>


                        <ul class="nav nav-second-level collapse">
                            <li class="<?php if ($pagename == 'spare_part_list.php') {
                                            echo 'active';
                                        } ?>"><a href="spare_part_list.php"><i class="fa fa-list"></i> รายการอะไหล่</a></li>
                            <li class="<?php if ($pagename == 'spare_type_list.php') {
                                            echo 'active';
                                        } ?>"><a href="spare_type_list.php"><i class="fa fa-list"></i> ประเภทอะไหล่</a></li>
                            <li class="<?php if ($pagename == 'product_brand.php') {
                                            echo 'active';
                                        } ?>"><a href="product_brand.php"><i class="fa fa-list"></i> ยี่ห้อ</a></li>
                        </ul>

                    </li>

                    <li <?php if ($pagename == 'report_overall.php' || $pagename == 'report_overall.php' || $pagename == 'report_overhaul.php' || $pagename == 'report_problem.php' || $pagename == 'report_plan.php' || $pagename == 'report_performance.php') {
                            echo 'class="active"';
                        } ?>>


                        <a href="javascript:void(0);"><i class="fa fa-book"></i> <span class="nav-label">รายงาน</span><span class="fa arrow"></span></a>


                        <ul class="nav nav-second-level collapse">
                            <li class="<?php if ($pagename == 'report_overall.php') {
                                            echo 'active';
                                        } ?>"><a href="report_overall.php"><i class="fa fa-list"></i> รายงานภาพรวม</a></li>
                            <li class="<?php if ($pagename == 'report_spare.php') {
                                            echo 'active';
                                        } ?>"><a href="report_spare.php"><i class="fa fa-list"></i> รายงานการใช้อะไหล่</a></li>
                            <li class="<?php if ($pagename == 'report_performance.php') {
                                            echo 'active';
                                        } ?>"><a href="report_performance.php"><i class="fa fa-list"></i> รายงานการปฏิบัติงาน</a></li>
                            <li class="<?php if ($pagename == 'report_overhaul.php') {
                                            echo 'active';
                                        } ?>"><a href="report_overhaul.php"><i class="fa fa-list"></i> รายงาน Overhaul</a></li>
                            <li class="<?php if ($pagename == 'report_problem.php') {
                                            echo 'active';
                                        } ?>"><a href="report_problem.php"><i class="fa fa-list"></i> รายงานอาการเสีย</a></li>
                            <li class="<?php if ($pagename == 'report_plan.php') {
                                            echo 'active';
                                        } ?>"><a href="report_plan.php"><i class="fa fa-list"></i> รายงานแผนงาน</a></li>
                        </ul>

                    </li>




                    <li <?php if ($pagename == 'index_user.php') {
                            echo 'class="active"';
                        } ?>>



                        <a href="index_user.php"><i class="fa fa-users"></i> <span class="nav-label">ผู้ใช้งานระบบ</span></a>
                    </li>


                    <li <?php if (
                            $pagename == 'branch_setting.php' || $pagename == 'amphoe_setting.php' || $pagename == 'expend_type_setting.php' || $pagename == 'income_type_setting.php'
                            || $pagename == 'brand&model_setting.php' || $pagename == 'sub_job_type.php' || $pagename == 'open_jop_service.php'  || $pagename == 'account.php' ||
                            $pagename == 'oth_job_type.php' || $pagename == 'symptom_type.php' || $pagename == 'reason_type.php'
                        ) {
                            echo 'class="active"';
                        } ?>>


                        <a href="javascript:void(0);"><i class="fa fa-cubes"></i> <span class="nav-label">ตั้งค่า</span><span class="fa arrow"></span></a>


                        <ul class="nav nav-second-level collapse">
                            <li class="<?php if ($pagename == 'account.php') {
                                            echo 'active';
                                        } ?>"><a href="account.php"><i class="fa fa-list"></i> บัญชีธนาคาร</a></li>
                            <li class="<?php if ($pagename == 'branch_setting.php') {
                                            echo 'active';
                                        } ?>"><a href="branch_setting.php"><i class="fa fa-list"></i> ทีมงาน</a></li>
                            <li class="<?php if ($pagename == 'amphoe_setting.php') {
                                            echo 'active';
                                        } ?>"><a href="amphoe_setting.php"><i class="fa fa-list"></i> อำเภอ</a></li>
                            <li class="<?php if ($pagename == 'zone_setting.php') {
                                            echo 'active';
                                        } ?>"><a href="zone_setting.php"><i class="fa fa-list"></i> เขต</a></li>

                            <li class="<?php if ($pagename == 'product_type_setting.php') {
                                            echo 'active';
                                        } ?>"><a href="product_type_setting.php"><i class="fa fa-list"></i> ประเภทเครื่อง</a></li>

                            <li class="<?php if ($pagename == 'expend_type_setting.php') {
                                            echo 'active';
                                        } ?>"><a href="expend_type_setting.php"><i class="fa fa-list"></i> ประเภทค่าใช้จ่าย</a></li>
                            <li class="<?php if ($pagename == 'income_type_setting.php') {
                                            echo 'active';
                                        } ?>"><a href="income_type_setting.php"><i class="fa fa-list"></i> ประเภทรายได้</a></li>

                            <li class="<?php if ($pagename == 'open_jop_service.php') {
                                            echo 'active';
                                        } ?>"><a href="open_jop_service.php"><i class="fa fa-list"></i> ประเภทบริการ</a></li>

                            <!-- <li class="<?php if ($pagename == 'brand&model_setting.php') {
                                                echo 'active';
                                            } ?>"><a
                                    href="brand&model_setting.php"><i class="fa fa-list"></i> รุ่นและยี่ห้อ</a></li> -->
                            <li class="<?php if ($pagename == 'sub_job_type.php') {
                                            echo 'active';
                                        } ?>"><a href="sub_job_type.php"><i class="fa fa-list"></i> ประเภทงานย่อย</a></li>

                            <li class="<?php if ($pagename == 'oth_job_type.php') {
                                            echo 'active';
                                        } ?>"><a href="oth_job_type.php"><i class="fa fa-list"></i> ประเภทงานอื่นๆ</a></li>
                            <li class="<?php if ($pagename == 'symptom_type.php') {
                                            echo 'active';
                                        } ?>"><a href="symptom_type.php"><i class="fa fa-list"></i> ประเภทอาการเสีย</a></li>

                            <li class="<?php if ($pagename == 'reason_type.php') {
                                            echo 'active';
                                        } ?>"><a href="reason_type.php"><i class="fa fa-list"></i> ประเภทการแจ้งเหตุ</a></li>

                            <li class="<?php if ($pagename == 'quotation_setting.php') {
                                            echo 'active';
                                        } ?>"><a href="quotation_setting.php"><i class="fa fa-list"></i> ตั้งค่าใบเสนอราคา</a></li>



                        </ul>

                    </li>

                </ul>

            </div>

        </nav>

        <div id="page-wrapper" class="gray-bg dashbard-1">

            <div class="row border-bottom">

                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">

                    <div class="navbar-header">

                        <!-- <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a> -->

                        <form class="navbar-form-custom" id="form_search" action="search_result.php">

                            <div class="form-group">

                                <!-- <input type="text" placeholder="" class="form-control" name="search_text" id="search_text"> -->

                            </div>

                        </form>

                    </div>

                    <ul class="nav navbar-top-links navbar-right">

                        <li style="padding: 20px;font-size: 14px">

                            <span class="m-r-sm text-muted welcome-message">ยินดีต้อนรับ
                                <?php echo $row_user['fullname'] ?></span>
                        </li>


                        <li style="font-size: 14px">
                            <a class="btn btn-sm" onclick="setting('<?php echo $user_id ?>');" aria-label="Settings">
                                <i class="fa fa-cog" aria-hidden="true"> </i>ตั้งค่าบัญชีผู้ใช้
                            </a>
                        </li>

                        <li style="font-size: 14px">
                            <a class="btn btn-sm" onclick="SetLine('<?php echo $user_id ?>');" aria-label="Settings">
                                <i class="fa fa-bell" aria-hidden="true"> </i>การแจ้งเตือน
                            </a>
                        </li>
                        <li style="font-size: 14px">
                            <a class="btn btn-sm" onclick="SetNewPass('<?php echo $user_id ?>');" aria-label="Settings">
                                <i class="fa fa-key" aria-hidden="true"> </i>เปลี่ยนรหัสผ่าน
                            </a>
                        </li>

                        <li>
                            <a onclick="LogoutConfirm();">
                                <i class="fa fa-sign-out"></i> ออกจากระบบ
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            <?php include('import_script.php') ?>



            <script>
            </script>
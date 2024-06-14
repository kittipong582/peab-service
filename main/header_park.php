<?php

include('../config/check_session.php');

?>
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

    <style>
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

$user_id = $_SESSION['user_id'];
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

                    <li <?php if ($pagename == 'index.php') {
                            echo 'class="active"';
                        } ?>>

                        <a href="index.php"><i class="fa fa-home"></i> <span class="nav-label">หน้าหลัก</span></a>

                    </li>

            
					
					<li <?php if ($pagename == 'customer_list.php' || $pagename == "customer_form_new.php"||$pagename == 'customer_view_detail.php') {
                            echo 'class="active"';
                        } ?>>


                        <a href="javascript:void(0);"><i class="fa fa-database"></i> <span class="nav-label">ลูกค้า</span><span class="fa arrow"></span></a>


                        <ul class="nav nav-second-level collapse">
                            <li class="<?php if ($pagename == 'customer_list.php' || $pagename == "customer_form_new.php") { echo 'active'; } ?>"><a href="customer_list.php"><i class="fa fa-list"></i> ลูกค้ารวม </a></li>
							<li class="<?php if ($pagename == '#') { echo 'active'; } ?>"><a href="#"><i class="fa fa-list"></i> ลูกค้าแยกสาขา (IP)</a></li>
                            <li class="<?php if ($pagename == '#') { echo 'active'; } ?>"><a href="#"><i class="fa fa-list"></i> กลุ่มลูกค้า (IP)</a></li>
                        </ul>

                    </li>

					<li <?php if ($pagename == 'spare_type_list.php' ||$pagename == 'spare_part_list.php') {
                            echo 'class="active"';
                        } ?>>


                        <a href="javascript:void(0);"><i class="fa fa-database"></i> <span class="nav-label">ฐานข้อมูล</span><span class="fa arrow"></span></a>


                        <ul class="nav nav-second-level collapse">
                            <li class="<?php if ($pagename == 'spare_part_list.php') { echo 'active'; } ?>"><a href="spare_part_list.php"><i class="fa fa-list"></i> รายการอะไหล่</a></li>
                            <li class="<?php if ($pagename == 'spare_type_list.php') { echo 'active'; } ?>"><a href="spare_type_list.php"><i class="fa fa-list"></i> ประเภทอะไหล่</a></li>
                        </ul>

                    </li>



                    <li <?php if ($pagename == 'index_user.php') {
                            echo 'class="active"';
                        } ?>>



                        <a href="index_user.php"><i class="fa fa-users"></i> <span class="nav-label">ผู้ใช้งานระบบ</span></a>
                    </li>

					
					 <li <?php if ($pagename == 'branch_setting.php' || $pagename == 'amphoe_setting.php' || $pagename == 'expend_type_setting.php' || $pagename == 'income_type_setting.php') {
                            echo 'class="active"';
                        } ?>>


                        <a href="javascript:void(0);"><i class="fa fa-cubes"></i> <span class="nav-label">ตั้งค่า</span><span class="fa arrow"></span></a>


                        <ul class="nav nav-second-level collapse">
                            <li class="<?php if ($pagename == 'branch_setting.php') { echo 'active'; } ?>"><a href="branch_setting.php"><i class="fa fa-list"></i> สาขา</a></li>
                            <li class="<?php if ($pagename == 'amphoe_setting.php') { echo 'active'; } ?>"><a href="amphoe_setting.php"><i class="fa fa-list"></i> อำเภอ</a></li>
                            <li class="<?php if ($pagename == 'expend_type_setting.php') { echo 'active'; } ?>"><a href="expend_type_setting.php"><i class="fa fa-list"></i> ประเภทค่าใช้จ่าย</a></li>
                            <li class="<?php if ($pagename == 'income_type_setting.php') { echo 'active'; } ?>"><a href="income_type_setting.php"><i class="fa fa-list"></i> ประเภทรายได้</a></li>
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
                                <i class="fa fa-cog" aria-hidden="true"> ตั้งค่าบัญชีผู้ใช้</i>
                            </a>
                        </li>

                        <li style="font-size: 14px">
                            <a class="btn btn-sm" onclick="SetLine('<?php echo $user_id ?>');" aria-label="Settings">
                                <i class="fa fa-bell" aria-hidden="true"> การแจ้งเตือน</i>
                            </a>
                        </li>
                        <li style="font-size: 14px">
                            <a class="btn btn-sm" onclick="SetNewPass('<?php echo $user_id ?>');" aria-label="Settings">
                                <i class="fa fa-key" aria-hidden="true"> เปลี่ยนรหัสผ่าน</i>
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
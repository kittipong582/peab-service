<?php
session_start();
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
if (empty($_SESSION['user_id'])) {
    include("logout.php");
}

$user_id = $_SESSION['user_id'];

$user_level = $_SESSION['user_level'];
$admin_status = $_SESSION['admin_status'];
$branch_id = $_SESSION['branch_id'];

$sql = "SELECT * FROM tbl_user a LEFT JOIN tbl_branch b ON a.branch_id = b.branch_id
WHERE a.user_id = '$user_id';";
// echo $sql;
$result = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Peaberry</title>

    <link href="../../template/css/bootstrap.min.css" rel="stylesheet">

    <link href="../../template/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="../../template/css/plugins/steps/jquery.steps.css" rel="stylesheet">

    <!-- Toastr style -->

    <link href="../../template/css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <!-- Gritter -->

    <link href="../../template/js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <script src="../../template/js/bezier.js"></script>

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

    <!-- <script src="../../template/js/jquery.signaturepad.js"></script> -->
    <!-- C3 -->

    <link href="../../template/css/plugins/c3/c3.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,300;0,500;0,700;1,300;1,500;1,700&display=swap" rel="stylesheet">



</head>
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
    strong {
        font-family: 'Prompt', sans-serif !important;
        font-weight: 300;
    }

    .pointer {
        cursor: pointer;
    }

    .box-menu {
        font-size: 36px;
        border-radius: 5px;
        overflow: hidden;
    }

    .box-menu .ibox-content {
        background-color: #1ab394 !important;
        color: #ffffff;
        border-radius: 5px;
    }

    .box-menu span {
        font-size: 48px;
    }

    .box-menu .ibox-content {
        padding: 32px 0px;
        margin-bottom: 18px;
        height: 200px;
    }

    .box-header {
        font-size: 32px;
    }

    .box-header .ibox-title {
        padding: 15px;
    }

    .hide-md {
        display: none;
    }

    .set-footer {
        position: fixed;
        width: 100%;
        bottom: 0;
        left: 0;
        margin: 0;
    }

    body {
        padding-bottom: 200px;
    }

    @media (max-width:500px) {
        .box-header {
            font-size: 18px !important;
        }

        .box-menu {
            font-size: 16px;
        }

        .box-menu span {
            font-size: 66px;
        }

        .hide-md {
            display: block !important;
        }

        .box-menu .ibox-content {
            padding: 0px;
            height: 140px;
            margin-bottom: 0px;
        }
    }

    .border-cm {
        border: 1px solid red;
    }

    .border-pm {
        border: 1px solid green;
    }

    .border-install {
        border: 1px solid blue;
    }

    .border-overhaul {
        border: 1px solid yellow;
    }

    .border-oth {
        border: 1px solid purple;
    }
</style>

<?php ?>

<body class="top-navigation">

    <div id="wrapper">
        <div id="page-wrapper" class="gray-bg p-0">
            <div class="wrapper wrapper-content p-0">
                <div class="" style="padding-bottom: 6rem!important;">
                    <div class="ibox box-header m-0">
                        <div class="ibox-title p-2">
                            <div class="row">
                                <div class="col-6">
                                    <a href="../../staff/main/index2.php"><img src="../asset/peaberry.jpg" alt=""
                                            style="height: 54px;"></a>
                                </div>
                                <div class="col-6 text-right py-2" style="line-height: 1;">
                                    <?php echo $row['fullname'] ?> <br>
                                    <font style="font-size: 12px;">
                                        <?php echo $row['branch_name'] ?>
                                    </font>
                                </div>
                            </div>
                        </div>
                    </div>
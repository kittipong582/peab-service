<?php
include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


?>

<!-- <style>
.modal-dialog {
    max-width: 1250px;
}
</style> -->

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>รายงาน Overhaul</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="report_performance.php">รายงาน Overhaul</a>
            </li>

        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content">

    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">

                    <div class="ibox-title">
                        <h3><b>รายละเอียดรายงาน</b></h3>
                    </div>

                    <div class="ibox-content">

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>อ้างอิงจาก</label>
                                    <select class="form-control select2" id="type_date" name="type_date"
                                        data-width="100%">
                                        <option value="1" selected>วันที่สร้างรายการ </option>
                                        <option value="2">วันที่นัดหมาย </option>
                                        <option value="3">วันที่ดำเนินการ </option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label>วันที่</label>

                                <div class="input-group date">

                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input class="form-control datepicker" type="text" name="start_date" id="start_date"
                                        value="<?php echo date('d/m/Y',strtotime('-1 month')); ?>">
                                </div>

                            </div>

                            <div class="col-md-4">
                                <label> ถึงวันที่</label>
                                <div class="input-group date">

                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input class="form-control datepicker" type="text" name="end_date" id="end_date"
                                        value="<?php echo date('d/m/Y'); ?>">
                                </div>

                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-2 text-center">
                                <input class="btn btn-md btn-info btn-block" type="button" onclick="export_overall();"
                                    value="สร้างรายการ">
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- addmodal -->
    <div class="modal hide fade in" id="modal" role="dialog" data-keyboard="false" data-backdrop="static"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div id="show_modal"></div>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>

    <script>
    $(document).ready(function() {

    });

    $(".datepicker").datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: false,
        format: 'dd/mm/yyyy',
        thaiyear: false,
        language: 'th', //Set เป็นปี พ.ศ.
        autoclose: true
    });


    $(".select2").select2({
        width: "75%"
    });

    $('.summernote').summernote({
        toolbar: false,
        height: 100,
    });

    $.extend({
        redirectPost: function(location, args) {
            var form = '';
            $.each(args, function(key, value) {
                form += '<input type="hidden" name="' + key + '" value="' + value + '">';
            });
            $('<form action="' + location + '" method="POST">' + form + '</form>').appendTo('body')
        .submit();
        }
    });



    function export_overall() {


        var type_date = $('#type_date').val();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();


        var redirect = 'ajax/report/overhaul/export_overhaul.php';

        $.redirectPost(redirect, 
        {

            type_date: type_date,
            start_date: start_date,
            end_date: end_date

        });
    }

    </script>
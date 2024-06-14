<?php
include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


?>


<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>รายการงาน Audit</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="audit_report.php">รายการงาน Audit</a>
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
                    <div class="ibox-title" style="padding: 15px 15px 8px 15px;">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>ตั้งแต่</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input class="form-control datepicker" type="text" name="start_date" id="start_date" value="<?php echo date('d/m/Y', strtotime('-1 month')); ?>">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label> ถึงวันที่</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input class="form-control datepicker" type="text" name="end_date" id="end_date" value="<?php echo date('d/m/Y'); ?>">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <label> &nbsp;&nbsp;&nbsp;</label><br>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary" onclick="GetTable()">ค้นหา</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-tools">
                            <div>
                                <label> &nbsp;&nbsp;&nbsp;</label><br>
                                <button class="btn btn-primary" onclick="export_evaluate()"><i class="fa fa-file-excel-o"></i> Excel</button>
                            </div>
                        </div>
                    </div>

                    <div class="ibox-content">
                        <div id="Loading">
                            <div class="spiner-example">
                                <div class="sk-spinner sk-spinner-wave">
                                    <div class="sk-rect1"></div>
                                    <div class="sk-rect2"></div>
                                    <div class="sk-rect3"></div>
                                    <div class="sk-rect4"></div>
                                    <div class="sk-rect5"></div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div id="showTable"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content animated fadeIn">
            <div id="showModal"></div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>

<script>
    $(document).ready(function() {
        GetTable()
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


    function GetTable() {
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();

        $.ajax({
            type: "POST",
            url: "ajax/audit_report/GetTable.php",
            data: {
                start_date: start_date,
                end_date: end_date
            },
            datatype: "html",
            success: function(response) {
                $("#showTable").html(response);
                $('table').DataTable({
                    pageLength: 25,
                    responsive: true
                });
                $('#Loading').hide();
            }
        });
    }

    function GetModalDetail(job_id) {
        console.log(job_id)
        $.ajax({
            type: "POST",
            url: "ajax/audit_report/Modal_Audit.php",
            dataType: "html",
            data: {
                job_id: job_id
            },
            success: function(response) {
                $("#myModal .modal-content").html(response);
                $("#myModal").modal('show');
                $(".select2").select2({
                    width: "100%"
                });

            }
        });
    }

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

    function export_evaluate() {

        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();

        // var redirect = 'ajax/audit_report/export_excel_test.php';
        var redirect = 'ajax/audit_report/export_excel.php';

        $.redirectPost(redirect, {
            start_date: start_date,
            end_date: end_date
        });
    }
</script>
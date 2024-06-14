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
        <h2>รายงาน การปฏิบัติงาน</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="report_performance.php">รายงาน การปฏิบัติงาน</a>
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
                                    <label>ประเภทงาน</label>
                                    <select class="form-control select2" id="job_type" name="job_type" data-width="100%" onchange="Getsubjob(this.value)">
                                        <option value="x" selected>ทั้งหมด </option>
                                        <option value="1">CM </option>
                                        <option value="2">PM </option>
                                        <option value="3">Installation </option>
                                        <option value="4">overhaul </option>
                                        <option value="5">oth </option>
                                        <option value="6">quotation </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4" id="getsubjob">
                                <div class="form-group">
                                    <label>ประเภทงานย่อย</label>
                                    <select class="form-control select2" id="subjob_type" name="subjob_type" data-width="100%">
                                        <option value="x" selected>ทั้งหมด </option>

                                    </select>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <label>ค้นหาลูกค้า</label>
                                <div class="input-group">
                                    <input type="text" id="name_customer" name="name_customer" class="form-control">
                                    <span class="input-group-append"><button type="button" onclick="get_form_search();" id="btn_ref" name="btn_ref" class="btn btn-success">ค้นหา</button></span>

                                </div>
                            </div>
                        </div>

                        <div id="search_point">


                        </div>

                        <br>

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>ประเภทงาน</label>
                                    <select class="form-control select2" id="type_date" name="type_date" data-width="100%">
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
                                    <input class="form-control datepicker" type="text" name="start_date" id="start_date" value="<?php echo date('d/m/Y', strtotime('-1 month')); ?>">
                                </div>

                            </div>

                            <div class="col-md-4">
                                <label> ถึงวันที่</label>
                                <div class="input-group date">

                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input class="form-control datepicker" type="text" name="end_date" id="end_date" value="<?php echo date('d/m/Y'); ?>">
                                </div>

                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-2 text-center">
                                <input class="btn btn-md btn-info btn-block" type="button" onclick="export_overall();" value="สร้างรายการ">
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- addmodal -->
    <div class="modal hide fade in" id="modal" role="dialog" data-keyboard="false" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
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


        function get_form_search() {
            var text = $('#name_customer').val();

            $.ajax({
                type: 'POST',
                url: 'ajax/report/form_search_customer.php',
                data: {
                    text: text
                },
                dataType: 'html',
                success: function(response) {
                    $('#search_point').html(response);
                    $("#cus_branch").select2();
                    $("#team").select2();
                    $("#staff").select2();
                    $("#customer").select2();

                }
            });

        }


        function Getsubjob(job_type) {

            $.ajax({
                type: 'POST',
                url: 'ajax/report/performance/Getsubjob.php',
                data: {
                    job_type: job_type
                },
                dataType: 'html',
                success: function(response) {
                    $('#getsubjob').html(response);
                    $("#subjob_type").select2();

                }
            });

        }

        function Getcusbranch(customer_id) {

            $.ajax({
                type: 'POST',
                url: 'ajax/report/performance/Getcusbranch.php',
                data: {
                    customer_id: customer_id
                },
                dataType: 'html',
                success: function(response) {
                    $('#getcusbranch').html(response);
                    $("#cus_branch").select2();

                }
            });

        }

        function Getteam(cus_branch) {

            var customer = $('#customer').val();
            $.ajax({
                type: 'POST',
                url: 'ajax/report/performance/Getteam.php',
                data: {
                    cus_branch: cus_branch,
                    customer: customer
                },
                dataType: 'html',
                success: function(response) {
                    $('#getteam').html(response);
                    $("#team").select2();

                }
            });

        }

        function Getstaff(team) {

            $.ajax({
                type: 'POST',
                url: 'ajax/report/performance/Getstaff.php',
                data: {
                    team: team
                },
                dataType: 'html',
                success: function(response) {
                    $('#getstaff').html(response);
                    $("#staff").select2();

                }
            });

        }





        function export_overall() {

            var job_type = $('#job_type').val();
            var subjob_type = $('#subjob_type').val();
            var customer = $('#customer').val();
            var cus_branch = $('#cus_branch').val();
            var team = $('#team').val();
            var staff = $('#staff').val();
            var type_date = $('#type_date').val();
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();


            var redirect = 'ajax/report/performance/export_performance.php';

            $.redirectPost(redirect, {
                job_type: job_type,
                subjob_type: subjob_type,
                customer: customer,
                cus_branch: cus_branch,
                team: team,
                staff: staff,
                type_date: type_date,
                start_date: start_date,
                end_date: end_date

            });
        }
    </script>
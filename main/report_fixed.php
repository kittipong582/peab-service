<?php
include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$today = date("Y-m-d");

$current_year = date('Y');
$range = range($current_year, 2022);
$arr_years = array_combine($range, $range);

$arr_month = array("01" => "มกราคม", "02" => "กุมภาพันธ์", "03" => "มีนาคม", "04" => "เมษายน", "05" => "พฤษภาคม", "06" => "มิถุนายน", "07" => "กรกฎาคม", "08" => "สิงหาคม", "09" => "กันยายน", "10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม");

?>


<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>รายงานการซ่อม</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="report_fixed.php">รายงานการซ่อม</a>
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

                    </div>

                    <div class="ibox-content">
                        <div class="row">


                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>ประเภทตัวเลือก</label>
                                    <select class="form-control select2" id="type_select" onchange="search_type()"
                                        name="type_select" data-width="100%">

                                        <option value="1" selected>รายวัน</option>
                                        <option value="2">รายเดือน</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-4" id="startdate" style="display: block;">
                                <label>วันที่</label>

                                <div class="input-group date">

                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input class="form-control datepicker" onchange="GetProduct1()" type="text"
                                        name="start_date" id="start_date"
                                        value="<?php echo date('d/m/Y', strtotime('today')); ?>">
                                </div>

                            </div>

                            <div class="col-md-3" id="enddate" style="display: block;">
                                <label> ถึงวันที่</label>
                                <div class="input-group date">

                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input class="form-control datepicker" onchange="GetProduct1()" type="text"
                                        name="end_date" id="end_date"
                                        value="<?php echo date('d/m/Y', strtotime('+ 7 days')); ?>">
                                </div>

                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>สถานะ</label>
                                    <select class="form-control select2" id="status" name="status" data-width="100%">
                                        <option value="x" selected>ทั้งหมด </option>
                                        <option value="1">เปิดงาน</option>
                                        <option value="2">อยู่ระหว่างดำเนินการ</option>
                                        <option value="3">หยุดงานชั่วคราว</option>
                                        <option value="4">รอปิดงาน</option>
                                        <option value="5">ปิดงานแล้ว</option>
                                        <option value="6">งานค้าง</option>
                                    </select>
                                </div>

                            </div>

                            <div class="col-md-3" id="point_product" style="display: none;">

                            </div>


                            <div class="col-md-4" id="year_select" style="display: none;">
                                <label>ปี</label>

                                <select class="form-control select2" id="year_data" name="year_data" data-width="100%">

                                    <?php foreach ($arr_years as $key => $value) { ?>
                                        <option value="<?php echo $key; ?>" <?php if (date('Y') == $key) {
                                               echo "selected";
                                           } ?>><?php echo ($value + 543); ?></option>
                                    <?php } ?>
                                </select>

                            </div>



                            <div class="col-md-4" id="month_select" style="display: none;">
                                <label>เดือน</label>

                                <select class="form-control select2" id="month_data" name="month_data"
                                    data-width="100%">

                                    <?php foreach ($arr_month as $key => $value) { ?>
                                        <option value="<?php echo $key; ?>">
                                            <?php echo $value; ?>
                                        </option>
                                    <?php } ?>
                                </select>

                            </div>





                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-2 text-center">
                                <input class="btn btn-md btn-info btn-block" type="button" onclick="export_fixed();"
                                    value="รายงาน">
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
        $(document).ready(function () {

            search_type();
            GetProduct1();
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


        function search_type() {

            var type_select = $('#type_select').val();

            if (type_select == 2) {
                document.getElementById("month_select").style.display = "block";
                document.getElementById("year_select").style.display = "block";
                document.getElementById("startdate").style.display = "none";
                document.getElementById("enddate").style.display = "none";
                document.getElementById("point_product").style.display = "none";

            } else {
                document.getElementById("enddate").style.display = "block";
                document.getElementById("startdate").style.display = "block";
                document.getElementById("month_select").style.display = "none";
                document.getElementById("year_select").style.display = "none";

            }

        }




        function GetProduct1() {

            document.getElementById("point_product").style.display = "block";
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();

            $.ajax({
                type: 'POST',
                url: 'ajax/report/fixed/GetProduct.php',
                data: {
                    start_date: start_date,
                    end_date: end_date
                },
                dataType: 'html',
                success: function (response) {
                    // $('#point_product').html(response);
                    // $("#product_select").select2();

                }
            });

        }


        $.extend({
            redirectPost: function (location, args) {
                var form = '';
                $.each(args, function (key, value) {
                    form += '<input type="hidden" name="' + key + '" value="' + value + '">';
                });
                $('<form action="' + location + '" method="POST">' + form + '</form>').appendTo('body')
                    .submit();
            }
        });



        function export_fixed() {

            var product_select = 'x';
            var type_select = $('#type_select').val();
            if (type_select == 1) {


                appointment_date = [];
                var start_date = $('#start_date').val();
                var end_date = $('#end_date').val();
                product_select = $('#product_select').val();
                appointment_date.push(start_date, end_date);

            } else {
                var appointment_date = $('#month_data').val() + '/' + $('#year_data').val();
            }

            var redirect = 'ajax/report/fixed/export_fixed.php';

            $.redirectPost(redirect, {

                type_select: type_select,
                appointment_date: appointment_date,
                product_select: product_select

            });
        }
    </script>
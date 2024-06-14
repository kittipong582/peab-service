<?php
include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$today = date("Y-m-d");

$current_year = date('Y');
$range = range($current_year, 2022);
$arr_years = array_combine($range, $range);

$arr_month = array("01" => "มกราคม", "02" => "กุมภาพันธ์", "03" => "มีนาคม", "04" => "เมษายน", "05" => "พฤษภาคม", "06" => "มิถุนายน", "07" => "กรกฎาคม", "08" => "สิงหาคม", "09" => "กันยายน", "10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม");

$sql = "SELECT * FROM tbl_customer WHERE active_status = '1'";
$res = mysqli_query($connection, $sql);

?>


<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>รายงานการการประเมิน</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="report_fixed.php">รายงานการการประเมิน</a>
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
                                    <label>ประเภทงาน</label>
                                    <select class="form-control select2" id="type_select" name="type_select" data-width="100%">
                                        <option value="x" selected>ทั้งหมด</option>
                                        <option value="1">CM</option>
                                        <option value="2">PM</option>
                                        <option value="3">Installation</option>
                                        <option value="4">overhaul</option>
                                        <option value="5">oth</option>
                                        <option value="6">quotation</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>ลูกค้า</label>
                                    <select class="form-control select2" id="customer_id" name="customer_id" data-width="100%">
                                        <option value="x" selected>ทั้งหมด</option>
                                        <?php while ($row = mysqli_fetch_assoc($res)) { ?>
                                            <option value="<?php echo $row['customer_id']; ?>"><?php echo $row['customer_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-2 text-center">
                                <input class="btn btn-md btn-info btn-block" type="button" onclick="export_evaluate();" value="รายงาน">
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

        function export_evaluate() {

            var customer_id = $("#customer_id").val();
            var type_select = $('#type_select').val();

            var redirect = 'ajax/report/report_evaluate/get_data.php';

            $.redirectPost(redirect, {

                customer_id: customer_id,
                type_select: type_select

            });
        }
    </script>
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
        <h2>รายงาน แผนงาน</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="report_overall.php">รายงาน แผนงาน</a>
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

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>ลูกค้า</label>
                                    <select class="form-control select2" id="customer" name="customer" data-width="100%"
                                        onchange="Getcusbranch(this.value)">
                                        <option value="x" selected>ทั้งหมด </option>

                                        <?php 
                                                        
                                                        $sql_c = "SELECT customer_id,customer_name FROM tbl_customer ;";
                                                        $rs_c = mysqli_query($connect_db, $sql_c);
                                                        while($row_c = mysqli_fetch_assoc($rs_c)){
                                                        
                                                        ?>

                                        <option value="<?php echo $row_c['customer_id'] ?>">
                                            <?php echo $row_c['customer_name'] ?></option>


                                        <?php } ?>

                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6" id="getcusbranch">
                                <div class="form-group">
                                    <label>สาขา</label>
                                    <select class="form-control select2" id="cus_branch" name="cus_branch"
                                        data-width="100%" onchange="Getteam(this.value)">
                                        <option value="x" selected>ทั้งหมด </option>

                                        <?php 
                                                        
                                                        $sql_cb = "SELECT customer_branch_id,branch_name  FROM tbl_customer_branch ;";
                                                        $rs_cb = mysqli_query($connect_db, $sql_cb);
                                                        while($row_cb = mysqli_fetch_assoc($rs_cb)){
                                                        
                                                        ?>

                                        <option value="<?php echo $row_cb['customer_branch_id'] ?>">
                                            <?php echo $row_cb['branch_name'] ?></option>


                                        <?php } ?>

                                    </select>
                                </div>
                            </div>



                        </div>

                        <br>

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

                            <!-- <div class="col-md-4">
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

                            </div> -->
                            <div class="col-md-2">
                                <label> ตั้งแต่ เดือน</label><br>
                                <select class="form-control select2" id="month" name="month">
                                    <!-- <option value="">เลือกปี</option> -->
                                    <?php for ($m = 01; $m <= 12; $m++) { ?>
                                    <option value="<?php echo $m; ?>">
                                        <?php echo $m; ?></option>
                                    <?php } ?>
                                </select>

                            </div>

                            <div class="col-md-2">
                                <label> ปี</label><br>
                                <select class="form-control select2" id="year" name="year">
                                    <!-- <option value="">เลือกปี</option> -->
                                    <?php for ($i = date('Y'); $i >= date('Y' , strtotime('-9year')); $i--) { ?>
                                    <option value="<?php echo $i; ?>" <?php if($i == date('Y')){ echo 'selected';}?>>
                                        <?php echo $i; ?></option>
                                    <?php } ?>
                                </select>

                            </div>

                            <div class="col-md-2">
                                <label> ถึง เดือน</label><br>
                                <select class="form-control select2" id="month2" name="month2">
                                    <!-- <option value="">เลือกปี</option> -->
                                    <?php for ($m = 01; $m <= 12; $m++) { ?>
                                    <option value="<?php echo $m; ?>">
                                        <?php echo $m; ?></option>
                                    <?php } ?>
                                </select>

                            </div>

                            <div class="col-md-2">
                                <label> ปี</label><br>
                                <select class="form-control select2" id="year2" name="year2">
                                    <!-- <option value="">เลือกปี</option> -->
                                    <?php for ($i = date('Y'); $i >= date('Y' , strtotime('-9year')); $i--) { ?>
                                    <option value="<?php echo $i; ?>" <?php if($i == date('Y')){ echo 'selected';}?>>
                                        <?php echo $i; ?></option>
                                    <?php } ?>
                                </select>

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

    $(".select2").select2({
        width: "75%"
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


    function Getcusbranch(customer_id) {

        $.ajax({
            type: 'POST',
            url: 'ajax/report/plan/Getcusbranch.php',
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

    function export_overall() {


        var customer = $('#customer').val();
        var cus_branch = $('#cus_branch').val();
        var type_date = $('#type_date').val();
        // var start_date = $('#start_date').val();
        // var end_date = $('#end_date').val();
        var month = $('#month').val();
        var month2 = $('#month2').val();
        var year = $('#year').val();
        var year2 = $('#year2').val();

        var redirect = 'ajax/report/plan/export_plan.php';

        $.redirectPost(redirect, {
            customer: customer,
            cus_branch: cus_branch,
            type_date: type_date,
            month: month,
            month2: month2,
            year: year,
            year2: year2

        });
    }
    </script>
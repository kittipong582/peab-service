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
        <h2>รายงาน ภาพรวม(DEMO)</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="report_overall.php">รายงาน ภาพรวม(DEMO)</a>
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

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>ประเภทงาน</label>
                                    <select class="form-control select2" id="job_type" name="job_type" data-width="100%">
                                        <option value="x" selected>ทั้งหมด </option>
                                        <option value="1">CM </option>
                                        <option value="2">PM </option>
                                        <option value="3">Installation </option>
                                        <option value="4">Overhaul </option>
                                        <option value="5">OTH </option>
                                        <option value="6">Quotation </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3" id="getteam">
                                <div class="form-group">
                                    <label>ประเภทเครื่อง</label>
                                    <select class="form-control select2" id="product_type" name="product_type" data-width="100%">
                                        <option value="x" selected>ทั้งหมด </option>
                                        <?php
                                        $sql_t = "SELECT type_code,type_name,type_id FROM tbl_product_type ORDER BY type_code;";
                                        $rs_t = mysqli_query($connect_db, $sql_t);
                                        while ($row_t = mysqli_fetch_assoc($rs_t)) {
                                        ?>
                                            <option value="<?php echo $row_t['type_id'] ?>">
                                                <?php echo $row_t['type_code'] . " - " . $row_t['type_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3" id="getteam">
                                <div class="form-group">
                                    <label>ทีมงาน</label>
                                    <select class="form-control select2" id="team" name="team" data-width="100%" onchange="Getstaff(this.value)">
                                        <option value="x" selected>ทั้งหมด </option>
                                        <?php
                                        $sql_b = "SELECT branch_id,branch_name FROM tbl_branch  ORDER BY team_number;";
                                        $rs_b = mysqli_query($connect_db, $sql_b);
                                        while ($row_b = mysqli_fetch_assoc($rs_b)) {
                                        ?>
                                            <option value="<?php echo $row_b['branch_id'] ?>">
                                                <?php echo $row_b['branch_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3" id="getstaff">
                                <div class="form-group">
                                    <label>ช่างผู้ดูแล</label>
                                    <select class="form-control select2" id="staff" name="staff" data-width="100%">
                                        <option value="x" selected>ทั้งหมด </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3" id="getcusbranch">
                                <div class="form-group">
                                    <label>สถานะ</label>
                                    <select class="form-control select2" id="status" name="status" data-width="100%">
                                        <option value="x" selected>ทั้งหมด </option>
                                        <option value="1">เปิดงาน</option>
                                        <option value="2">อยู่ระหว่างดำเนินการ</option>
                                        <option value="3">หยุดงานชั่วคราว</option>
                                        <option value="4">รอปิดงาน</option>
                                        <option value="5">ปิดงานแล้ว</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>อ้างอิงจาก</label>
                                    <select class="form-control select2" id="type_date" name="type_date" data-width="100%">
                                        <option value="1" selected>วันที่ดำเนินการ </option>
                                        <option value="2">วันที่เปิดงาน </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label>วันที่</label>
                                <div class="input-group date">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input class="form-control datepicker" type="text" name="start_date" id="start_date" value="<?php echo date('d/m/Y', strtotime('-1 week')); ?>">
                                </div>
                            </div>

                            <div class="col-md-3">
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
                                <input class="btn btn-md btn-info btn-block" type="button" onclick="export_overalltest();" value="สร้างรายการ(DEMO)">
                            </div>
                            <div class="col-md-2 text-center">
                                <input class="btn btn-md btn-info btn-block" type="button" onclick="export_overall3();" value="สร้างรายการเเยกเครื่อง">
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



        function Getstaff(team) {

            $.ajax({
                type: 'POST',
                url: 'ajax/report/overall/Getstaff.php',
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





        function export_overalltest() {

            var job_type = $('#job_type').val();
            var product_type = $('#product_type').val();
            var status = $('#status').val();
            var team = $('#team').val();
            var staff = $('#staff').val();
            var type_date = $('#type_date').val();
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();


            var redirect = 'ajax/report/overall/export_overall4.php';

            $.redirectPost(redirect, {
                job_type: job_type,

                status: status,
                team: team,
                staff: staff,
                type_date: type_date,
                start_date: start_date,
                end_date: end_date,
                product_type: product_type

            });
        }


        function export_overall3() {

            var job_type = $('#job_type').val();
            var product_type = $('#product_type').val();
            var status = $('#status').val();
            var team = $('#team').val();
            var staff = $('#staff').val();
            var type_date = $('#type_date').val();
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();


            var redirect = 'ajax/report/overall/export_overall3.php';

            $.redirectPost(redirect, {
                job_type: job_type,

                status: status,
                team: team,
                staff: staff,
                type_date: type_date,
                start_date: start_date,
                end_date: end_date,
                product_type: product_type

            });
        }
    </script>
<?php
include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


?>


<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>รายงานการใช้อะไหล่</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="report_spare_used.php">รายงานการใช้อะไหล่</a>
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


                            <div class="col-md-3" id="getteam">
                                <div class="form-group">
                                    <label>รูปแบบรายงาย</label>
                                    <select class="form-control select2" id="report_type" name="report_type" onchange="get_supfilter(this.value)" data-width="100%">
                                        <option value="1" selected>รายวัน</option>
                                        <option value="3">รายเดือน </option>
                                        <option value="4">รายไตรมาตร </option>
                                        <option value="5">ราย6เดือน </option>
                                        <option value="6">รายปี </option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3" id="sup_point" style="display: none;">

                            </div>

                            <div class="col-md-3" id="startdate" style="display: block;">
                                <label>ตั้งแต่</label>

                                <div class="input-group date">

                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input class="form-control datepicker" type="text" name="start_date" id="start_date" value="<?php echo date('d/m/Y', strtotime('-1 day')); ?>">
                                </div>

                            </div>

                            <div class="col-md-3" id="enddate" style="display: block;">
                                <label> ถึงวันที่</label>
                                <div class="input-group date">

                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input class="form-control datepicker" type="text" name="end_date" id="end_date" value="<?php echo date('d/m/Y'); ?>">
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
                                        while ($row_b = mysqli_fetch_assoc($rs_b)) { ?>
                                            <option value="<?php echo $row_b['branch_id'] ?>">
                                                <?php echo $row_b['branch_name'] ?></option>

                                        <?php } ?>

                                    </select>
                                </div>
                            </div>


                            <div class="col-md-3" id="getstaff">
                            </div>



                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-2 text-center">
                                <input class="btn btn-md btn-info btn-block" type="button" onclick="export_spare_used();" value="รายงาน">
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


        function get_supfilter(value) {

            if (value == 2 || value == 1) {
                document.getElementById("startdate").style.display = "";
                document.getElementById("enddate").style.display = "";
            } else {

                document.getElementById("startdate").style.display = "none";
                document.getElementById("enddate").style.display = "none";
            }

            if (value == 3 || value == 4 || value == 5) {
                document.getElementById("sup_point").style.display = "";
            } else {
                document.getElementById("sup_point").style.display = "none";
            }

            $.ajax({
                type: 'POST',
                url: 'ajax/report/spare_used/supfiter.php',
                data: {
                    value: value
                },
                dataType: 'html',
                success: function(response) {
                    $('#sup_point').html(response);
                    $(".supfliter").select2();

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


        function export_spare_used() {

            var report_type = $('#report_type').val();
            var quarter = $('#quarter').val();
            var select_year = $('#select_year').val();
            var month = $('#month').val();
            var user_id = $('#staff').val();
            var team = $('#team').val();
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();


            var redirect = 'ajax/report/spare_used/export_spare_used.php';

            $.redirectPost(redirect, {
                report_type: report_type,
                month: month,
                quarter: quarter,
                select_year: select_year,
                user_id: user_id,
                team: team,
                end_date: end_date,
                start_date: start_date
            });
        }
    </script>
<?php
include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


?>


<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>รายงาน ซ่อมซ้ำ</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="report_repeat_repair.php">รายงาน ซ่อมซ้ำ</a>
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
                                    <label>ประเภทวัน</label>
                                    <select class="form-control select2" onchange="get_date_lenght()" id="time_type" name="time_type" data-width="100%">

                                        <option value="30" selected>30 วัน </option>
                                        <option value="105">105 วัน </option>
                                        <option value="1">แบบเลือกวันที่</option>
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

                        <div class="row" id="date_lenght">

                        </div>

                        <br>
                        <div class="row">
                            <div class="col-md-2 text-center">
                                <input class="btn btn-md btn-info btn-block" type="button" onclick="export_repeat_repair();" value="สร้างรายการ">
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


        function get_date_lenght() {

            var time_type = $('#time_type').val();

            if (time_type == 1) {
                $.ajax({
                    type: 'POST',
                    url: 'ajax/report/repeat_repair/Get_dateLength.php',
                    dataType: 'html',
                    success: function(response) {
                        $('#date_lenght').html(response);
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
                    }
                });
            } else {
                $('#date_lenght').html('');
            }


        }


        function export_repeat_repair() {

            var redirect = 'ajax/report/repeat_repair/export_repeat_repair.php';

            var time_type = $('#time_type').val();
            var team = $('#team').val();
            var staff = $('#staff').val();


            if (time_type == 1) {

                var start_date = $('#start_date').val();
                var end_date = $('#end_date').val();

                $.redirectPost(redirect, {
                    staff: staff,
                    team: team,
                    time_type: time_type,
                    end_date: end_date,
                    start_date: start_date
                });

            } else {
                $.redirectPost(redirect, {
                    staff: staff,
                    team: team,
                    time_type: time_type
                });
            }
        }
    </script>
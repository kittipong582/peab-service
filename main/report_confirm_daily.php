<?php
include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


?>


<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>รายงานช่าง</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="report_user.php">รายงานช่าง</a>
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
                                    <label>ทีมงาน <font class="text-danger">*</font></label>
                                    <select class="form-control select2" id="team" name="team" data-width="100%" onchange="Getstaff(this.value)">
                                        <option value="" selected>กรุณาเลือกทีม </option>

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
                                    <label>ช่าง <font class="text-danger">*</font></label>
                                    <select class="form-control select2" id="staff" name="staff" data-width="100%">
                                        <option value="" selected>กรุณาเลือกช่าง</option>


                                    </select>
                                </div>
                            </div>


                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-2 text-center">
                                <input class="btn btn-md btn-info btn-block" target="_blank" type="button" onclick="export_user();" value="รายงาน">
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
                url: 'ajax/report/user/Getstaff.php',
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



        function export_user() {

            var team = $('#team').val();
            var staff = $('#staff').val();

            if (team == "" || staff == "") {
                swal({
                    title: 'เกิดข้อผิดพลาด',
                    text: 'กรุณาเลือกข้อมูลให้ครบถ้วน',
                    type: 'error'
                });
                return false;
            }


            // var redirect = '../print/report_user_daily.php';
            window.open("../print/report_user_daily.php?user_id=" + staff, '_blank');

          
        }
    </script>
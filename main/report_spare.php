<?php
include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


?>


<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>รายงาน แผนงาน</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="report_spare.php">รายงาน แผนงาน</a>
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
                                    <label>ประเภทอะไหล่</label>
                                    <select class="form-control select2" id="spare_type" name="spare_type"
                                        data-width="100%" onchange="Getsparepart(this.value)">
                                        <option value="x" selected>ทั้งหมด </option>

                                        <?php 
                                                        
                                                        $sql_st = "SELECT spare_type_id,spare_type_name FROM tbl_spare_type ;";
                                                        $rs_st = mysqli_query($connect_db, $sql_st);
                                                        while($row_st = mysqli_fetch_assoc($rs_st)){
                                                        
                                                        ?>

                                        <option value="<?php echo $row_st['spare_type_id'] ?>">
                                            <?php echo $row_st['spare_type_name'] ?></option>


                                        <?php } ?>

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6" id="getsparepart">
                                <div class="form-group">
                                    <label>ชนิดอะไหล่</label>
                                    <select class="form-control select2" id="spare_part" name="spare_part"
                                        data-width="100%">
                                        <option value="x" selected>ทั้งหมด </option>

                                        <?php 
                                                        
                                                        $sql_sp = "SELECT spare_part_id,spare_part_name FROM tbl_spare_part ;";
                                                        $rs_sp = mysqli_query($connect_db, $sql_sp);
                                                        while($row_sp = mysqli_fetch_assoc($rs_sp)){
                                                        
                                                        ?>

                                        <option value="<?php echo $row_sp['spare_part_id'] ?>">
                                            <?php echo $row_sp['spare_part_name'] ?></option>


                                        <?php } ?>

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>ประเภทงาน</label>
                                    <select class="form-control select2" id="job_type" name="job_type" data-width="100%"
                                        onchange="Getsubjob(this.value)">
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



                            <div class="col-md-6" id="getsubjob">
                                <div class="form-group">
                                    <label>ประเภทงานย่อย</label>
                                    <select class="form-control select2" id="subjob_type" name="subjob_type"
                                        data-width="100%">
                                        <option value="x" selected>ทั้งหมด </option>

                                        <?php 
                                                        
                                                        $sql_sj = "SELECT sub_job_type_id,sub_type_name FROM tbl_sub_job_type ORDER BY job_type ASC;";
                                                        $rs_sj = mysqli_query($connect_db, $sql_sj);
                                                        while($row_sj = mysqli_fetch_assoc($rs_sj)){
                                                        
                                                        ?>

                                        <option value="<?php echo $row_sj['sub_job_type_id'] ?>">
                                            <?php echo $row_sj['sub_type_name'] ?></option>


                                        <?php } ?>

                                    </select>
                                </div>
                            </div>



                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>ลูกค้า</label>
                                    <select class="form-control select2" id="customer" name="customer" data-width="100%"
                                        onchange="Getcusbranch(this.value),Getteam(this.value);">
                                        <option value="x" selected>ทั้งหมด </option>

                                        <?php 
                                                        
                                                        $sql_c = "SELECT customer_id,customer_name  FROM tbl_customer ;";
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


                            <div class="col-md-6" id="getteam">
                                <div class="form-group">
                                    <label>ทีมงาน</label>
                                    <select class="form-control select2" id="team" name="team" data-width="100%"
                                        onchange="Getstaff(this.value)">
                                        <option value="x" selected>ทั้งหมด </option>

                                        <?php 
                                                        
                                                        $sql_b = "SELECT branch_id,branch_name FROM tbl_branch ;";
                                                        $rs_b = mysqli_query($connect_db, $sql_b);
                                                        while($row_b = mysqli_fetch_assoc($rs_b)){
                                                        
                                                        ?>

                                        <option value="<?php echo $row_b['branch_id'] ?>">
                                            <?php echo $row_b['branch_name'] ?></option>


                                        <?php } ?>

                                    </select>
                                </div>
                            </div>



                            <div class="col-md-6" id="getstaff">
                                <div class="form-group">
                                    <label>ช่างผู้ดูแล</label>
                                    <select class="form-control select2" id="staff" name="staff" data-width="100%">
                                        <option value="x" selected>ทั้งหมด </option>

                                        <?php 
                                                        
                                                        $sql_u = "SELECT user_id,fullname  FROM tbl_user ;";
                                                        $rs_u = mysqli_query($connect_db, $sql_u);
                                                        while($row_u = mysqli_fetch_assoc($rs_u)){
                                                        
                                                        ?>

                                        <option value="<?php echo $row_u['user_id'] ?>">
                                            <?php echo $row_u['fullname'] ?></option>


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
                        <br>
                        <div class="row">
                            <div class="col-md-2 text-center">
                                <input class="btn btn-md btn-info btn-block" type="button" onclick="export_spare();"
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

    function Getsparepart(spare_type_id) {

        $.ajax({
            type: 'POST',
            url: 'ajax/report/sparepart/Getsparepart.php',
            data: {
                spare_type_id: spare_type_id
            },
            dataType: 'html',
            success: function(response) {
                $('#getsparepart').html(response);
                $("#spare_part").select2();

            }
        });

    }


    function Getsubjob(job_type) {

        $.ajax({
            type: 'POST',
            url: 'ajax/report/sparepart/Getsubjob.php',
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
            url: 'ajax/report/sparepart/Getcusbranch.php',
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

    function Getteam(cus_branch, customer) {

        $.ajax({
            type: 'POST',
            url: 'ajax/report/sparepart/Getteam.php',
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
            url: 'ajax/report/sparepart/Getstaff.php',
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





    function export_spare() {

        var spare_type = $('#spare_type').val();
        var spare_part = $('#spare_part').val();
        var job_type = $('#job_type').val();
        var subjob_type = $('#subjob_type').val();
        var customer = $('#customer').val();
        var cus_branch = $('#cus_branch').val();
        var team = $('#team').val();
        var staff = $('#staff').val();
        var type_date = $('#type_date').val();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();


        var redirect = 'ajax/report/sparepart/export_sparepart.php';

        $.redirectPost(redirect, {

            spare_type: spare_type,
            spare_part: spare_part,
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
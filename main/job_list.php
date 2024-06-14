<?php

include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$sql_team = "SELECT * FROM tbl_branch WHERE active_status = 1";
$result_team  = mysqli_query($connect_db, $sql_team);

$sql_create = "SELECT * FROM tbl_user WHERE admin_status = 9";
$result_create  = mysqli_query($connect_db, $sql_create);

$sql_brand = "SELECT * FROM tbl_product_brand WHERE active_status = 1";
$result_brand = mysqli_query($connect_db, $sql_brand);

?>


<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>รายการงาน</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="job_list.php">รายการงาน</a>
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
                                    <div class="form-group">
                                        <label>ค้นหาโดย</label>
                                        <select class="form-control select2" id="search_status" name="search_status" data-width="100%">
                                            <option value="1">วันที่นัดหมาย </option>
                                            <option value="2" selected>วันที่ทำรายการ </option>
                                            <option value="3">วันที่ดำเนินการ </option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <label>ตั้งแต่</label>

                                    <div class="input-group date">

                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input class="form-control datepicker" type="text" name="start_date" id="start_date" value="<?php echo date('d/m/Y', strtotime('-1 day')); ?>">
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


                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>ชนิดงาน</label>
                                        <select class="form-control select2" id="job_type" name="job_type" onchange="get_sub(this.value)" data-width="100%">
                                            <option value="x">ทั้งหมด </option>
                                            <option value="1">CM </option>
                                            <option value="2">PM </option>
                                            <option value="3">Installation </option>
                                            <option value="4">Overhaul </option>
                                            <option value="5">งานอื่นๆ </option>
                                            <option value="6">งานเสนอราคา </option>

                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-2" id="sub_title_point">
                                    <div class="form-group">
                                        <label>ชื่องาน</label>
                                        <select class="form-control select2" id="sub_title" name="sub_title" data-width="100%">
                                            <option value="x">ทั้งหมด </option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-2">
                                    <br>
                                    <input class="icheckbox_square-green" type="checkbox" name="chkbox" id="chkbox" value="chkbox">
                                    <input type="hidden" id="insurance_status" name="insurance_status" value="0" style="position: absolute; opacity: 0;">
                                    <label>ไม่ระบุช่วงเวลา</label>
                                </div>


                                <div class="col-md-2 col-sm-12">
                                    <label>สถานะ</label><br>
                                    <select class="form-control select2" id="job_status" name="job_status" data-width="100%">
                                        <option value="x">ทั้งหมด </option>
                                        <option value="1">เปิดงาน </option>
                                        <option value="2">กำลังดำเนินการ </option>
                                        <option value="3">รอปิดงาน </option>
                                        <option value="4">ปิดงาน </option>
                                        <option value="5">งานยกเลิก </option>
                                    </select>

                                </div>



                                <!-- <div class="col-md-2 col-sm-12">
                                    <label>สิทธิ์</label><br>
                                    <select class="form-control select2" id="user_status" name="user_status" onchange="get_user(this.value)" data-width="100%">
                                        <option value="x">ทั้งหมด </option>
                                        <option value="1">ช่าง </option>
                                        <option value="2">หัวหน้าช่าง </option>
                                        <option value="3">หัวหน้าเขต </option>
                                        <option value="4">ส่วนกลาง </option>

                                    </select>

                                </div> -->

                                <div class="col-md-2 col-sm-12">
                                    <label>ทีม</label><br>
                                    <select class="form-control select2" id="team_id" name="team_id" onchange="get_user(this.value)" data-width="100%">
                                        <option value="x">ทั้งหมด </option>
                                        <?php while ($row_team = mysqli_fetch_array($result_team)) { ?>
                                            <option value="<?php echo $row_team['branch_id'] ?>"><?php echo $row_team['team_number'] . " - " . $row_team['branch_name'] ?></option>
                                        <?php } ?>

                                    </select>

                                </div>


                                <div class="col-md-2 col-sm-12" id="point_user">
                                    <label>ช่าง</label><br>
                                    <select class="form-control select2" id="user_point" name="user_point" data-width="100%">
                                        <option value="x">ทั้งหมด </option>
                                    </select>
                                </div>

                                <div class="col-md-2 col-sm-12" id="point_user">
                                    <label>ผู้ทำรายการ</label><br>
                                    <select class="form-control select2" id="create_user" name="create_user" data-width="100%">
                                        <option value="x">ทั้งหมด </option>
                                        <?php while ($row_create = mysqli_fetch_array($result_create)) { ?>
                                            <option value="<?php echo $row_create['user_id'] ?>" <?php if ($row_create['user_id'] == $_SESSION['user_id']) {
                                                                                                        echo "SELECTED";
                                                                                                    } ?>><?php echo $row_create['fullname']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-md-2 col-sm-12">
                                    <label>เลขที่ใบงาน</label><br>
                                    <input type="text" id="search_text" name="search_text" class="form-control">
                                </div>

                                <div class="col-md-2 col-sm-12">
                                    <label>ชื่อสาขา/รหัสสาขา</label><br>
                                    <input type="text" id="customer_branch_text" name="customer_branch_text" class="form-control">
                                </div>


                                <div class="col-md-2 col-sm-12">
                                    <label>ยี่ห้อ</label><br>
                                    <select class="form-control select2" id="brand_id" name="brand_id" onchange="GetModel(this.value)" data-width="100%">
                                        <option value="x">ทั้งหมด</option>
                                        <?php while ($row_brand = mysqli_fetch_array($result_brand)) { ?>
                                            <option value="<?php echo $row_brand['brand_id'] ?>"><?php echo $row_brand['brand_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-md-2 col-sm-12">
                                    <label>รุ่น</label><br>
                                    <select class="form-control select2" id="model_id" name="model_id" data-width="100%">
                                        <option value="x">ทั้งหมด</option>

                                    </select>
                                </div>


                                <div class="col-md-2 col-sm-12">
                                    <label> &nbsp;&nbsp;&nbsp;</label><br>
                                    <input class="btn btn-sm btn-info btn-block" type="button" onclick="GetTable();" value="แสดงข้อมูล">
                                </div>

                            </div>
                        </div>


                    </div>

                    <div class="ibox-content">
                        <!-- <div id="Loading">
                            <div class="spiner-example">
                                <div class="sk-spinner sk-spinner-wave">
                                    <div class="sk-rect1"></div>
                                    <div class="sk-rect2"></div>
                                    <div class="sk-rect3"></div>
                                    <div class="sk-rect4"></div>
                                    <div class="sk-rect5"></div>
                                </div>
                            </div>
                        </div> -->
                        <br>
                        <div id="show_data"></div>

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
            // GetTable();
            $('#chkbox').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            }).on('ifChanged', function(e) {
                if ($('#chkbox').is(':checked') == true) {
                    $('#insurance_status').val('1');
                } else {
                    $('#insurance_status').val('0');
                }
            });
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

        function GetTable() {
            $('#Loading').show();
            $("#show_data").html('');

            var search_status = $("#search_status").val();
            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();
            var job_status = $("#job_status").val();
            var job_type = $("#job_type").val();
            var sub_title = $('#sub_title').val();
            var insurance_status = $("#insurance_status").val();
            var team_id = $('#team_id').val();
            var search_text = $('#search_text').val();
            var user_point = $("#user_point").val();
            var customer_branch_text = $('#customer_branch_text').val();
            var create_user = $('#create_user').val();
            var brand_id = $('#brand_id').val();
            var model_id = $('#model_id').val();


            $.ajax({
                type: 'POST',
                url: "ajax/job_list/GetTable.php",
                data: {
                    search_status: search_status,
                    start_date: start_date,
                    end_date: end_date,
                    insurance_status: insurance_status,
                    job_type: job_type,
                    job_status: job_status,
                    user_point: user_point,
                    sub_title: sub_title,
                    team_id: team_id,
                    search_text: search_text,
                    customer_branch_text: customer_branch_text,
                    create_user: create_user,
                    brand_id: brand_id,
                    model_id: model_id
                },
                dataType: "html",
                success: function(response) {
                    $("#show_data").html(response);
                    $('#table_job1').DataTable({
                        pageLength: 25,
                        responsive: true,
                        "ordering": false,
                    });
                    $('#Loading').hide();
                }
            });
        }


        function Group_pm(job_id) {

            $.ajax({
                type: "post",
                url: "ajax/job_list/ModalGroup.php",
                data: {
                    job_id: job_id
                },
                dataType: "html",
                success: function(response) {
                    $("#show_modal").html(response);
                    $("#modal").modal('show');
                    $('.summernote').summernote({
                        toolbar: false,
                        height: 100,
                    });
                    $(".select2").select2({});
                    $(".datepicker").datepicker({
                        todayBtn: "linked",
                        keyboardNavigation: false,
                        format: 'dd-mm-yyyy',
                        autoclose: true,
                    });
                }
            });


        }


        function So_modal(job_id) {

            $.ajax({
                type: "post",
                url: "ajax/job_list/Modal_so.php",
                data: {
                    job_id: job_id
                },
                dataType: "html",
                success: function(response) {
                    $("#show_modal").html(response);
                    $("#modal").modal('show');
                }
            });


        }

        function get_user(team_id) {
            $.ajax({
                type: 'POST',
                url: "ajax/job_list/Get_user.php",
                data: {
                    team_id: team_id,
                },
                dataType: "html",
                success: function(response) {
                    $("#point_user").html(response);
                    $(".select2").select2({});
                }
            });

        }



        function get_sub(job_type) {
            $.ajax({
                type: 'POST',
                url: "ajax/job_list/Get_sub.php",
                data: {
                    job_type: job_type,
                },
                dataType: "html",
                success: function(response) {
                    $("#sub_title_point").html(response);
                    $(".select2").select2({});
                }
            });

        }

        function GetModel(brand_id) {
            $.ajax({
                type: "POST",
                url: "ajax/job_list/Get_Model.php",
                data: {
                    brand_id: brand_id
                },
                dataType: "html",
                success: function(response) {
                    console.log(response);
                    $("#model_id").html(response);
                    $(".select2").select2();
                }
            });
        }

        function delete_job(job_id, type) {

            swal({
                title: 'กรุณายืนยันเพื่อทำรายการ',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'ยกเลิก',
                confirmButtonText: 'ยืนยัน',
                closeOnConfirm: false
            }, function() {
                $.ajax({
                    type: 'POST',
                    url: 'ajax/job_list/delete_job.php',
                    data: {
                        job_id: job_id,
                        type: type
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.result == 1) {
                            swal({
                                title: "ดำเนินการสำเร็จ!",
                                text: "ทำการลบรายการ เรียบร้อย",
                                type: "success",
                                showConfirmButton: false
                            });
                            setTimeout(function() {
                                swal.close();
                            }, 500);
                            GetTable();
                        } else {
                            swal({
                                title: 'ผิดพลาด!',
                                text: '',
                                type: 'warning'
                            });
                            return false;
                        }
                    }

                });
            });

        }
    </script>
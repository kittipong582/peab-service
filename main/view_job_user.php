<?php include('header.php');
session_start();
include("../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);
$user_id = $_GET['id'];
$pagename = basename($_SERVER['PHP_SELF']);

$sql = "SELECT * FROM tbl_user WHERE user_id = '$user_id'";
$result  = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($result);



$level = "";
if ($row['user_level'] == 1) {
    $level = "ทีมงานทั่วไป";
} else if ($row['user_level'] == 2) {
    $level = "หัวหน้าทีม";
} else if ($row['user_level'] == 3) {
    $level = "หัวหน้าเขต";
} else if ($row['user_level'] == 4) {
    $level = "ส่วนกลาง";
}


$place = "";
if ($row['user_level'] == 1 || $row['user_level'] == 2) {

    $branch_id = $row['branch_id'];
    $sql_sub = "SELECT * FROM tbl_branch WHERE branch_id = '$branch_id' and active_status = 1";
    $result_sub  = mysqli_query($connection, $sql_sub);
    $row_sub = mysqli_fetch_array($result_sub);

    $place = $row_sub['branch_name'];
} else if ($row['user_level'] == 3) {


    $zone_id = $row['zone_id'];
    $sql_sub = "SELECT * FROM tbl_zone WHERE zone_id = '$zone_id' and active_status = 1";
    $result_sub  = mysqli_query($connection, $sql_sub);
    $row_sub = mysqli_fetch_array($result_sub);

    $place = $row_sub['zone_name'];
}


?>
<style>
    .box-input {
        min-height: 90px;
    }

    /* tr {
        color: #676a6c;
    } */
    .classmodal1 {
        max-width: 1200px;
        margin: auto;
    }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo "ผู้ใช้ " . $row['fullname'] ?></h2>
        <ol class="breadcrumb">

            <li class="breadcrumb-item">
                <?php echo $row['fullname'] ?>
            </li>
            <li class="breadcrumb-item">
                ภาพรวม
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInUp">


                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-2">
                            <br>
                            <a href="view_user.php?id=<?php echo $user_id ?>"><button type="button" class="btn btn-block dim <?php if ($pagename == 'view_user.php') echo ' btn-secondary';
                                                                                                                                else {
                                                                                                                                    echo 'btn-info';
                                                                                                                                } ?>">ภาพรวม</button></a>
                        </div>
                        <div class="col-md-2">
                            <br>
                            <a href="view_job_user.php?id=<?php echo $user_id ?>"><button type="button" class="btn btn-block dim <?php if ($pagename == 'view_job_user.php') echo ' btn-secondary';
                                                                                                                                    else {
                                                                                                                                        echo 'btn-info';
                                                                                                                                    } ?>">ประวัติงาน</button></a>
                        </div>

                        <div class="col-md-2">
                            <br>
                            <a href="view_onhand_user.php?id=<?php echo $user_id ?>"><button type="button" class="btn btn-block dim <?php if ($pagename == 'view_onhand_user.php') echo ' btn-secondary';
                                                                                                                                    else {
                                                                                                                                        echo 'btn-info';
                                                                                                                                    } ?>">On Hand</button></a>
                        </div>

                    </div>
                </div>
                <br>

                <div class="ibox">
                    <div class="ibox-title" style="padding: 15px 15px 8px 15px;">

                        <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id ?>">

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
                                        <input class="form-control datepicker" type="text" name="start_date" id="start_date" value="<?php echo date('d/m/Y', strtotime('-1 month')); ?>">
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
                                        <select class="form-control select2" id="job_type" name="job_type" data-width="100%">
                                            <option value="x" selected>ทั้งหมด </option>
                                            <option value="1">CM </option>
                                            <option value="2">PM </option>
                                            <option value="3">Installation </option>
                                            <option value="4">Overhaul </option>
                                            <option value="5">งานอื่นๆ </option>
                                            <option value="6">งานเสนอราคา </option>


                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <br>
                                    <input class="icheckbox_square-green" type="checkbox" name="chkbox" id="chkbox" value="chkbox">
                                    <input type="hidden" id="insurance_status" name="insurance_status" value="0" style="position: absolute; opacity: 0;">
                                    <label>ไม่ระบุช่วงเวลา</label>
                                    <!-- <div class="form-group">
                                        <label>ทีมงาน</label>
                                        <select class="form-control select2" id="branch" name="branch" data-width="100%"
                                            onchange="GetUser2(this.value)">
                                            <option value="x" selected>ทั้งหมด </option>

                                            <?php

                                            $sql_b = "SELECT branch_id,branch_name  FROM tbl_branch ;";
                                            $rs_b = mysqli_query($connection, $sql_b);
                                            while ($row_b = mysqli_fetch_assoc($rs_b)) {

                                            ?>

                                            <option value="<?php echo $row_b['branch_id'] ?>">
                                                <?php echo $row_b['branch_name'] ?></option>


                                            <?php } ?>

                                        </select>
                                    </div> -->
                                </div>



                                <div class="col-md-2 col-sm-12">
                                    <label> &nbsp;&nbsp;&nbsp;</label><br>
                                    <input class="btn btn-sm btn-info btn-block" type="button" onclick="GetTable();" value="แสดงข้อมูล">
                                </div>


                                <!-- <div class="col-md-1">
                                </div> -->

                                <!-- <div class="col-lg-1">
                                    <div class="form-group text-right">
                                        <a href="new_ax_import.php"
                                            class="btn btn-outline-primary btn-sm ">เพิ่มการนำเข้า</a>
                                    </div>

                                </div> -->

                            </div>
                        </div>


                    </div>

                    <div class="ibox-content">
                        <div id="Loading">
                            <div class="spiner-example">
                                <div class="sk-spinner sk-spinner-wave">
                                    <div class="sk-rect1"></div>
                                    <div class="sk-rect2"></div>
                                    <div class="sk-rect3"></div>
                                    <div class="sk-rect4"></div>
                                    <div class="sk-rect5"></div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div id="show_data"></div>

                    </div>
                </div>


            </div>
        </div>

    </div>
</div>


<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>

<div class="modal fade" id="modal1">
    <div class="modal-dialog modal-lg modal-dialog-centered classmodal1" id="modal1" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>



<?php include('import_script.php'); ?>
<script>
    $(document).ready(function() {
        GetTable();

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

        var search_status = $("#search_status").val();
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();
        var user_id = $("#user_id").val();
        var job_type = $("#job_type").val();
        var insurance_status = $("#insurance_status").val();

        $.ajax({
            type: 'POST',
            url: "ajax/view_user/GetTable_job.php",
            data: {
                search_status: search_status,
                start_date: start_date,
                end_date: end_date,
                user_id: user_id,
                insurance_status: insurance_status,
                job_type: job_type
            },
            dataType: "html",
            success: function(response) {
                $("#show_data").html(response);
                $('table').DataTable({
                    pageLength: 25,
                    responsive: true,
                    "ordering": false,
                });
                $('#Loading').hide();
            }
        });
    }
</script>
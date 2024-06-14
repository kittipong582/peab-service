<?php
session_start();
include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$sql_admin = "SELECT user_id FROM tbl_user WHERE admin_status = 9 ;";
$result_admin  = mysqli_query($connect_db, $sql_admin);
$row_admin = mysqli_fetch_array($result_admin);

$admin = $row_admin['user_id'];

$user_id = $_SESSION['user_id'];

// $user_condition = "";
// if($user_id != $admin){
//     $user_condition .="AND a.to_user_id = '$user_id' ";
// }

?>


<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>โอนย้าย</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="transfer.php">โอนย้าย</a>
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

                                <div class="col-md-3">
                                    <label>วันที่</label>

                                    <div class="input-group date">

                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input class="form-control datepicker" type="text" name="start_date" id="start_date" value="<?php echo date('d/m/Y', strtotime('-1 month')); ?>">
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

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>สาขาผู้รับ</label>
                                        <select class="form-control select2" id="branch" name="branch" data-width="100%">
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
                                    </div>
                                </div>


                                <div class="col-md-2 col-sm-12">
                                    <label> &nbsp;&nbsp;&nbsp;</label><br>
                                    <input class="btn btn-sm btn-info btn-block" type="button" onclick="GetTable();" value="แสดงข้อมูล">
                                </div>

                               






                                <div class="col-md-1">
                                </div>

                                <div class="col-lg-1">
                                    <div class="form-group text-right">
                                        <a href="new_transfer.php" class="btn btn-outline-primary btn-sm ">โอนย้าย</a>
                                    </div>

                                </div>

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
            GetTable();
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

        function GetUser(branch_id) {

            $.ajax({
                type: 'POST',
                url: 'ajax/transfer/GetUser.php',
                data: {
                    branch_id: branch_id
                },
                dataType: 'html',
                success: function(response) {
                    $('#get_user').html(response);
                    $("#user").select2();

                }
            });

        }

        function GetTable() {

            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();
            var branch = $("#branch").val();
            var user = $("#user").val();

            $.ajax({
                type: 'POST',
                url: "ajax/transfer/GetTable.php",
                data: {
                    start_date: start_date,
                    end_date: end_date,
                    branch: branch,
                    user: user
                },
                dataType: "html",
                success: function(response) {
                    $("#show_data").html(response);
                    $('table').DataTable({
                        pageLength: 25,
                        responsive: true
                        // sorting: disable
                    });
                    $('#Loading').hide();
                }
            });
        }
    </script>
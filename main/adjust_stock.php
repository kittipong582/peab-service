<?php
include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


?>
<style>
    .classmodal1 {
        max-width: 1200px;
        margin: auto;
    }
</style>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>ปรับ Stock</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="adjust.php">ปรับ Stock</a>
            </li>

        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>

<!-- <input type="hidden" name="customer_branch_id" id="customer_branch_id" value="<?php echo $customer_branch_id ?>"> -->

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
                                        <label>ทีม</label>
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

                                <div class="col-md-3">
                                    <label>ตั้งแต่</label>

                                    <div class="input-group date">

                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input class="form-control datepicker" type="text" name="start_date" id="start_date" value="<?php echo date('d/m/Y', strtotime('-1 day')); ?>">
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
                                <div class="col-md-2 col-sm-12">
                                    <label> &nbsp;&nbsp;&nbsp;</label><br>
                                    <input class="btn btn-sm btn-info btn-block" type="button" onclick="GetTable();" value="แสดงข้อมูล">
                                </div>


                                <div class="col-lg-2 " style="padding: 0px 0px 0px 0px;">
                                    <div class="form-group text-right">
                                        <a href="new_adjust.php" class="btn btn-outline-primary btn-sm">ปรับ Stock</a>
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


    <div class="modal fade" id="modal1">
        <div class="modal-dialog modal-lg modal-dialog-centered classmodal1" id="modal1" role="document">
            <div class="modal-content">

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

        function GetUser2(branch_id) {

            $.ajax({
                type: 'POST',
                url: 'ajax/adjust_stock/GetUser2.php',
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

        function GetPart(spare_type_id) {

            $.ajax({
                type: 'POST',
                url: 'ajax/adjust_stock/GetPart.php',
                data: {
                    spare_type_id: spare_type_id
                },
                dataType: 'html',
                success: function(response) {
                    $('#get_part').html(response);
                    $("#spare_part").select2();

                }
            });

        }

        function GetTable() {

            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();
            var spare_part = $("#spare_part").val();
            var spare_type = $("#spare_type").val();
            var branch = $("#branch").val();
            var user = $("#user").val();

            $.ajax({
                type: 'POST',
                url: "ajax/adjust_stock/GetTable.php",
                data: {
                    spare_part: spare_part,
                    spare_type: spare_type,
                    branch: branch,
                    user: user,
                    end_date: end_date,
                    start_date: start_date
                },
                dataType: "html",
                success: function(response) {
                    $("#show_data").html(response);
                    $('#table_adjust').DataTable({
                        pageLength: 25,
                        responsive: true,
                        // sorting: disable
                    });
                    $('#Loading').hide();
                }
            });
        }


        function modal_approve(adjust_id, result) {
            swal({
                title: "",
                text: "กรุณายืนยันการทำรายการ",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#00FF00",
                confirmButtonText: "ยืนยัน",
                cancelButtonColor: "#DD6B55",
                cancelButtonText: "ยกเลิก",
                closeOnConfirm: false
            }, function() {

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "ajax/adjust_stock/approve.php",
                    data: {
                        adjust_id: adjust_id,
                        result: result
                    },
                    success: function(response) {

                        if (response.result == 1) {
                            swal({
                                title: "",
                                text: "ดำเนินการสำเร็จ",
                                type: "success",
                                showConfirmButton: false,
                                timer: 500
                            }, function() {
                                swal.close();
                                window.location.reload();
                            });
                        } else {
                            swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                        }

                    }
                });

            });
        }


        function modal_detail(adjust_id) {

            $.ajax({
                type: "post",
                url: "ajax/adjust_stock/modal_detail.php",
                data: {
                    adjust_id: adjust_id
                },
                dataType: "html",
                success: function(response) {
                    $("#modal1 .modal-content").html(response);
                    $("#modal1").modal('show');
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
    </script>
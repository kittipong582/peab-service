<?php
include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


?>


<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>รายการงานติดตั้ง</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>รายการงานติดตั้ง</strong>
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
            // language: 'th', //Set เป็นปี พ.ศ.
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


            $.ajax({
                type: 'POST',
                url: "ajax/job_IN/approved/GetTable.php",
                dataType: "html",
                success: function(response) {
                    $("#show_data").html(response);
                    $('table').DataTable({
                        pageLength: 25,
                        responsive: true,
                        // sorting: disable
                    });
                    $('#Loading').hide();
                }
            });
        }


        function ConfirmStatus(job_id, status) {
            if (status == 2) {
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
                        type: "post",
                        url: "ajax/job_IN/approved/ConfirmStatus.php",
                        data: {
                            status: status,
                            job_id: job_id
                        },
                        dataType: "json",
                        success: function(response) {

                            if (response.result == 1) {

                                if (response.status == 1) {

                                    window.location.href = "Form_IN_PM.php?id=" + job_id;
                                } else if (response.status == 0) {
                                    GetTable();
                                }

                            } else {
                                swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                            }

                        }
                    });
                });
            } else {

                window.location.href = "Form_IN_PM.php?id=" + job_id;

            }
        }
    </script>
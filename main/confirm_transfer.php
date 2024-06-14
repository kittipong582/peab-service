<?php
include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

?>
<style>
    .modal-dialog {
        max-width: 1250px;
    }
</style>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>รับโอน</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="confirm_transfer.php">รับโอน</a>
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
                    <div class="ibox-title" style="padding: 10px 15px 15px 15px;">


                        <div class="col-lg-12">
                            <div class="row">

                                <div class="col-md-2 col-xs-6 col-sm-6" style="padding: 15px 15px 15px 15px;">
                                    <label> <input type="checkbox" class="i-checks" id="chk" name="chk" value="x">
                                        แสดงทั้งหมด
                                    </label>
                                </div>

                                <div class="col-md-3" id="get_start_date">
                                    <label>วันที่</label>

                                    <div class="input-group date">

                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input class="form-control datepicker" type="text" name="start_date" id="start_date" value="<?php echo date('d/m/Y', strtotime('-1 month')); ?>">
                                    </div>

                                </div>

                                <div class="col-md-3" id="get_end_date">
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


                                <!-- <div class="col-md-1">
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
            $('#get_start_date').hide();
            $('#get_end_date').hide();
            // Getdate();
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


        $('#chk').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        }).on('ifChanged', function(e) {
            if ($('#chk').is(':checked') == true) {
                var num_chk = 1;
                $('#get_start_date').show();
                $('#get_end_date').show();
                $("#chk").val(num_chk);
            } else {
                var num_chk = 'x';
                $('#get_start_date').hide();
                $('#get_end_date').hide();
                $("#chk").val(num_chk);
            }
        });


        $(".select2").select2({
            width: "75%"
        });

        $('.summernote').summernote({
            toolbar: false,
            height: 100,
        });

        function modal_approve(transfer_id, result) {
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
                    url: "ajax/confirm_transfer/approve.php",
                    data: {
                        transfer_id: transfer_id,
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

        // function modal_cancel(transfer_id) {
        //     $('#modal').modal('show');
        //     $('#show_modal').load("ajax/confirm_transfer/modal_cancel.php", {
        //         transfer_id: transfer_id
        //     });
        // }

        function modal_detail(transfer_id) {

            $.ajax({
                type: "post",
                url: "ajax/confirm_transfer/modal_detail.php",
                data: {
                    transfer_id: transfer_id
                },
                dataType: "html",
                success: function(response) {
                    $("#modal .modal-content").html(response);
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


        function submit_approve() {

            var transfer_id = $('#transfer_id').val();
            var remark = $('#remark').val();

            var formData = new FormData($("#frm_confirm")[0]);

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
                    url: 'ajax/confirm_transfer/update_transfer.php',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(data) {
                        if (data.result == 0) {
                            swal({
                                title: 'ผิดพลาด!',
                                text: 'ไม่สามารถเพิ่มข้อมูลได้',
                                type: 'warning'
                            });
                            return false;
                        }
                        if (data.result == 1) {

                            swal({
                                title: "ดำเนินการสำเร็จ!",
                                text: "ทำการบันทึกรายการ เรียบร้อย",
                                type: "success",
                                showConfirmButton: false,
                                timer: 1000
                            });
                            ('#Modal').modal('hide');
                            GetTable();
                            // location.reload();
                        }
                    }
                })
            });
        }

        // function Getdate() {

        //     $("#chk").val(function() {
        //         if (this.checked) {
        //             $('#get_start_date').show();
        //             $('#get_end_date').show();
        //         } else {
        //             $('#get_start_date').hide();
        //             $('#get_end_date').hide();
        //         }
        //     });

        // }

        function GetTable() {

            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();
            var branch = $("#branch").val();
            var user = $("#user").val();
            var chk = $("#chk").val();


            var chk = $("#chk").val();
            // alert(chk);

            $.ajax({
                type: 'POST',
                url: "ajax/confirm_transfer/GetTable.php",
                data: {
                    start_date: start_date,
                    end_date: end_date,
                    chk: chk
                },
                dataType: "html",
                success: function(response) {
                    $("#show_data").html(response);
                    $('table').DataTable({
                        destroy: true,
                        pageLength: 25,
                        responsive: true
                        // sorting: disable
                    });
                    $('#Loading').hide();
                }
            });
        }
    </script>
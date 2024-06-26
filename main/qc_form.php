<?php
include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");



?>


<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>ตั้งค่า QC</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item">
                <a href="audit_list.php">ตั้งค่า QC</a>
            </li>
            <!-- <li class="breadcrumb-item active">
                ตั้งค่าAudit
            </li> -->
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
                            <!-- <div class="row" style="margin-left: 8px;"> -->
                            <input style=" width: 50px; height: 20px;" id="show_all" name="show_all" type="checkbox"
                                value="1" class="js-switch" onchange="LoadTable();" checked>
                            <label style="margin-top: 7px; margin-left: 10px;"> แสดงเฉพาะใช้งาน </label>
                        </div>
                        <div class="ibox-tools">
                            <button class="btn btn-sm btn-primary" onclick="GetModalQc()"><i class="fa fa-plus"></i>
                                เพิ่ม</button>
                        </div>
                        <!-- <div class="">
                            <button class="btn btn-sm btn-warning"
                                onclick="activateDrag()">เปิดใช้งานการย้ายตำแหน่ง</button>
                        </div> -->


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

    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content animated fadeIn">
                <div id="showModal"></div>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>

    <script>
        $(document).ready(function () {
            LoadTable();
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

        var elem = document.querySelector('.js-switch');
        var switchery = new Switchery(elem, {
            color: '#1AB394'
        });


        function LoadTable() {
            $.ajax({
                type: 'POST',
                url: "ajax/qc_form/GetTable.php",
                data: {
                    status: ($("#show_all").is(':checked')) ? '1' : '0'
                },
                dataType: "html",
                success: function (response) {
                    $("#show_data").html(response);
                    $('table').DataTable({
                        pageLength: 25,
                        responsive: true,
                        "ordering": false
                    });
                    $('#Loading').hide();
                }
            });
        }


        function GetModalQc() {
            $("#modal").modal("show");
            $("#showModal").load("ajax/qc_form/modal_add.php");
        }

    
        function SubmitQc() {

            var qc_name = $("#qc_name").val();

            if (qc_name == "") {
                swal({
                    title: 'เกิดข้อผิดพลาด',
                    text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                    type: 'error'
                });
                return false;
            }
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
            }, function () {

                let myForm = document.getElementById('form-add');
                let formData = new FormData(myForm);

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "ajax/qc_form/add.php",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {

                        console.log(response);

                        if (response.result == 1) {
                            swal({
                                title: "",
                                text: "ดำเนินการสำเร็จ",
                                type: "success",
                                showConfirmButton: false,
                                timer: 1000
                            }, function () {
                                swal.close();
                                LoadTable();
                                $("#modal").modal('hide');
                            });
                        } else {
                            swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                        }

                    }
                });

            });
        }


        function Update() {
            var audit_name = $("#audit_name").val();


            if (audit_name == "") {
                swal({
                    title: 'เกิดข้อผิดพลาด',
                    text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                    type: 'error'
                });
                return false;
            }
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
            }, function () {

                let myForm = document.getElementById('form-edit');
                let formData = new FormData(myForm);

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "ajax/audit_list/update_list.php",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {

                        console.log(response);

                        if (response.result == 1) {
                            swal({
                                title: "",
                                text: "ดำเนินการสำเร็จ",
                                type: "success",
                                showConfirmButton: false,
                                timer: 1000
                            }, function () {
                                swal.close();
                                LoadTable();
                                $("#modal").modal('hide');
                            });
                        } else {
                            swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                        }

                    }
                });

            });
        }


        function GetModalEdit(qc_id) {
            $("#modal").modal("show");
            $("#showModal").load("ajax/qc_form/modal_edit.php", {
                qc_id: qc_id,

            });
        }

        function DeleteList(qc_id) {
            swal({
                title: 'กรุณายืนยันเพื่อทำรายการ',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'ยกเลิก',
                confirmButtonText: 'ยืนยัน',
                closeOnConfirm: false
            }, function () {
                $.ajax({
                    type: "POST",
                    url: "ajax/qc_form/delete.php",
                    data: {
                        qc_id: qc_id
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.result == 1) {
                            swal({
                                title: 'ลบข้อมูลสำเร็จ',
                                type: 'success',
                                showConfirmButton: false,
                                timer: 1500
                            }, function () {
                                LoadTable();
                                swal.close();
                                $("#modal").modal('hide');
                            });
                        } else if (data.result == 0) {
                            swal({
                                title: 'แจ้งเตือน',
                                text: 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง',
                                type: 'warning',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else if (data.result == 9) {
                            swal({
                                title: 'แจ้งเตือน',
                                text: 'ไม่สามารถติดต่อเซิฟเวอร์ได้ กรุณาลองใหม่อีกครั้ง',
                                type: 'warning',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    }
                });
            })
        }

       
        function ChangeStatus(button, audit_id) {
            $.ajax({
                type: "post",
                url: "ajax/audit_list/change_status.php",
                data: {
                    audit_id: audit_id
                },
                dataType: "json",
                success: function (response) {

                    if (response.result == 1) {
                        if (response.status == 1) {
                            $(button).addClass('btn-primary').removeClass('btn-danger').html('ใช้งาน');
                        } else if (response.status == 0) {
                            $(button).addClass('btn-danger').removeClass('btn-primary').html('ไม่ใช้งาน');
                            if ($("#show_all").is(':checked')) {
                                $('#tr_' + audit_id).fadeOut(700);
                            } else {

                            }
                        }
                    } else {
                        swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                    }
                    $('#Loading').hide();
                    LoadTable()
                }
            });
        }

       
    </script>